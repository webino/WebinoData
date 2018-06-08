<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Store;

use ArrayObject;
use WebinoData\Event\DataEvent;
use WebinoData\Exception;
use WebinoData\Select;
use Zend\Db\Sql;
use Zend\InputFilter\Factory as InputFilterFactory;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\BaseInputFilter;

/**
 * Trait InputTrait
 */
trait InputTrait
{
    use TraitBase;

    /**
     * @var InputFilterFactory
     */
    protected $inputFilterFactory;

    /**
     * @var InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var array
     */
    protected $validValues = [];

    /**
     * @var array
     */
    protected $inputMessages = [];

    /**
     * Returns valid input names
     *
     * @return array
     */
    public function getInputs()
    {
        $config = $this->getConfig();
        if (empty($config['input_filter'])) {
            return [];
        }

        $spec = $config['input_filter'];
        unset($spec['type']);
        return array_column($spec, 'name', 'name');
    }

    /**
     * @return array
     */
    public function getValidValues()
    {
        return $this->validValues;
    }

    /**
     * @return int
     */
    public function getLastInsertValue()
    {
        return $this->getTable()->getLastInsertValue();
    }

    /**
     * @return array|\string[]
     */
    public function getInputMessages()
    {
        return $this->inputMessages;
    }

    /**
     * @return InputFilterFactory
     */
    protected function getInputFilterFactory()
    {
        if (null === $this->inputFilterFactory) {
            $this->setInputFilterFactory(new InputFilterFactory);
        }
        return $this->inputFilterFactory;
    }

    /**
     * @param InputFilterFactory $factory
     * @return $this
     */
    public function setInputFilterFactory(InputFilterFactory $factory)
    {
        $this->inputFilterFactory = $factory;
        return $this;
    }

    /**
     * @return InputFilterInterface|\WebinoData\InputFilter\InputFilter
     */
    public function getInputFilter()
    {
        $config = $this->getConfig();

        if (null === $this->inputFilter) {
            $this->setInputFilter(
                $this->getInputFilterFactory()
                     ->createInputFilter($config['input_filter'])
            );
        }

        return $this->inputFilter;
    }

    /**
     * @param InputFilterInterface $inputFilter
     * @return $this
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        if (!method_exists($inputFilter, 'validate')) {
            // todo: interface, better exception
            throw new \InvalidArgumentException(
                'Expects inputFilter validate() method for: ' . $this->getTableName()
            );
        }
        $this->inputFilter = $inputFilter;
        return $this;
    }

    /**
     * Remove null values that are no required
     *
     * @param array $data
     * @param array &$validData
     * @return $this
     */
    protected function filterNonexistentNullValues(array $data, array &$validData)
    {
        foreach ($validData as $key => $value) {
            if (null === $value && 'id' !== $key && !array_key_exists($key, $data)) {
                unset($validData[$key]);
            }
        }

        return $this;
    }

    /**
     * Filter inputs by data
     *
     * @param array $data
     * @param BaseInputFilter $inputFilter
     * @return $this
     */
    public function filterInputFilter(array $data, BaseInputFilter $inputFilter)
    {
        foreach ($inputFilter->getInputs() as $input) {
            $inputName = $input->getName();

            array_key_exists($inputName, $data)
                or $inputFilter->remove($inputName);
        }

        return $this;
    }

    /**
     * Merges other input filter
     *
     * @param BaseInputFilter $inputFilter
     * @return $this
     */
    public function mergeInputFilter(BaseInputFilter $inputFilter)
    {
        $this->filterInputFilter($this->getInputs(), $inputFilter);
        $this->getInputFilter()->merge($inputFilter);
        return $this;
    }

    /**
     * @return $this
     */
    protected function resetInputState()
    {
        $this->validValues   = [];
        $this->inputMessages = [];

        return $this;
    }

    /**
     * @return $this
     */
    protected function resetInputFilter()
    {
        $this->validValues   = $this->inputFilter->getValues();
        $this->inputMessages = $this->inputFilter->getMessages();
        $this->inputFilter   = null;

        return $this;
    }

    /**
     * Stores data
     *
     * @deprecated use exchange() instead
     * @TODO remove
     * @param array $array
     * @return int Affected rows
     */
    public function exchangeArray(array $array)
    {
        return $this->exchange($array);
    }

    /**
     * Stores data
     *
     * @param array $array
     * @return int Affected rows
     */
    public function exchange(array $array)
    {
        $this->resetInputState();

        if (empty($array)) {
            // TODO exception
            throw new \InvalidArgumentException('Expected data but empty');
        }

        $this->init();

        $event = $this->getEvent();
        $event->setUpdate(!empty($array['id']));

        // update where
        $updateWhere = null;
        if ($event->isUpdate()) {
            if ($array['id'] instanceof Select) {
                $updateWhere = [new Sql\Predicate\In('id', $array['id']->getSqlSelect())];
                unset($array['id']);

            } elseif (is_array($array['id'])
                || $array['id'] instanceof Sql\Where
                || $array['id'] instanceof \Closure
            ) {
                $updateWhere = $array['id'];
                unset($array['id']);

            } else {
                $updateWhere = ['id=?' => $array['id']];
            }
        }
        $event->setParam('updateWhere', $updateWhere);
        // /update where

        $data = new ArrayObject($array);

        $event->setData($data);
        $inputFilter = $this->getInputFilter();

        $event->isUpdate()
            and $this->filterInputFilter($array, $inputFilter);

        $events = $this->getEventManager();

        $events->attach(
            $event::EVENT_EXCHANGE_PRE,
            function () use ($data, $inputFilter) {

                $inputFilter->getValidInput()
                    or $inputFilter->validate($data->getArrayCopy());
            },
            250
        );

        $events->attach(
            $event::EVENT_EXCHANGE_PRE,
            function (DataEvent $event) use ($data, $inputFilter, $events) {
                if ($inputFilter->getInvalidInput()) {
                    $events->trigger($event::EVENT_EXCHANGE_INVALID, $event);

                    // post invalid validation
                    if (!$inputFilter->validate($data->getArrayCopy())) {
                        $this->resetInputFilter();

                        throw new Exception\RuntimeException(
                            sprintf(
                                'Expected valid data for table %s: %s %s',
                                $this->getTableName(),
                                print_r($inputFilter->getMessages(), true),
                                print_r($data, true)
                            )
                        );
                    }
                }
            },
            200
        );

        $validData = new ArrayObject;
        $events->attach(
            $event::EVENT_EXCHANGE_PRE,
            function (DataEvent $event) use ($validData, $inputFilter) {
                $validData->exchangeArray($inputFilter->getValues());
                $event->setValidData($validData);
            },
            100
        );

        $events->trigger($event::EVENT_EXCHANGE_PRE, $event);
        $validDataArray = $validData->getArrayCopy();
        $isEmpty = empty($validDataArray);

        $affectedRows = 0;
        if (!$isEmpty) {
            $this->filterNonexistentNullValues($array, $validDataArray);

            try {

                $affectedRows = $event->isUpdate()
                    ? $this->getTable()->update($validDataArray, $updateWhere)
                    : $this->getTable()->insert($validDataArray);

            } catch (\Exception $exc) {
                // TODO better exception
                $msg = $exc->getPrevious() ? $exc->getPrevious()->getMessage() : $exc->getMessage();
                throw new Exception\RuntimeException(
                        sprintf(
                            'Statement could not be executed for the service table `%s`; %s',
                            $this->getTableName(),
                            $msg
                        ),
                        $exc->getCode(),
                        $exc
                );
            }
        }

        $this->resetInputFilter();

        // make sure we have an id
        isset($data['id']) && is_numeric($data['id'])
            or $data['id'] = $this->getLastInsertValue();

        // trigger event
        $event->setAffectedRows($affectedRows);
        $isEmpty or $events->trigger($event::EVENT_EXCHANGE_POST, $event);

        return $event->getAffectedRows();
    }
}

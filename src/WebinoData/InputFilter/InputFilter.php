<?php

namespace WebinoData\InputFilter;

use Zend\InputFilter\BaseInputFilter;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Zend\Validator\Db\AbstractDb;

/**
 * Class InputFilter
 */
class InputFilter extends ZendInputFilter
{
    /**
     * Merge another input filter into
     *
     * @param BaseInputFilter $inputFilter
     * @return self
     */
    public function merge(BaseInputFilter $inputFilter)
    {
        foreach ($inputFilter->getInputs() as $input) {
            $this->add($input);
        }
        return $this;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function validate(array $data)
    {
        // prepare input filter
        foreach ($this->getInputs() as $input) {

            if ($input instanceof BaseInputFilter) {
                foreach ($input->getInputs() as $subInput) {
                    $this->prepareInputValidators($subInput, $data);
                }
            }

            if (!($input instanceof Input)) {
                continue;
            }

            $this->prepareInputValidators($input, $data);

            // clear fallback value
            if (false === $input->getFallbackValue()) {
                $input->clearFallbackValue();
            }
        }

        $this->setData($data);
        return $this->isValid();
    }

    /**
     * @param array $data
     * @return $this
     */
    public function excludeInputs(array $data)
    {
        foreach ($this->getInputs() as $input) {
            $key = $input->getName();
            array_key_exists($key, $data) or $this->remove($key);
        }
        return $this;
    }

    /**
     * Excludes undefined inputs from data
     *
     * @param array $data
     * @return array
     */
    public function excludeData(array $data)
    {
        $newData = [];
        foreach ($this->getInputs() as $input) {
            $key = $input->getName();
            array_key_exists($key, $data) and $newData[$key] = $data[$key];
        }
        return $newData;
    }

    /**
     * @param Input $input
     * @param array $data
     * @return $this
     */
    protected function prepareInputValidators(Input $input, array $data)
    {
        empty($data['id']) and $data['id'] = 0;
        $data['inputName'] = $input->getName();

        foreach ($input->getValidatorChain()->getValidators() as $validator) {
            // Db validator
            if ($validator['instance'] instanceof AbstractDb) {
                $exclude = $validator['instance']->getExclude();

                if (is_array($exclude)) {
                    $exclude['value'] = !empty($data[$exclude['value']])
                        ? $data[$exclude['value']]
                        : $exclude['value'];
                }

                is_string($exclude) and $exclude = $this->translateExclude($exclude, $data);
                $validator['instance']->setExclude($exclude);
            }
        }

        return $this;
    }

    /**
     * @param string $exclude
     * @param array $data
     * @return string
     */
    protected function translateExclude($exclude, array $data)
    {
        $translation = [];

        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $translation['{$' . $key . '}'] = $value;
                continue;
            }
            foreach ($value as $subKey => $subValue) {
                is_array($subValue) or $translation['{$' . $key . '[' . $subKey . ']}'] = $subValue;
            }
        }

        return strtr($exclude, $translation);
    }
}

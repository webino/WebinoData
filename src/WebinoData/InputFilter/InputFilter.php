<?php

namespace WebinoData\InputFilter;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter as BaseInputFilter;

class InputFilter extends BaseInputFilter
{
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
        }

        $this->setData($data);
        return $this->isValid();
    }

    protected function prepareInputValidators(Input $input, array $data)
    {
        !empty($data['id']) or
            $data['id'] = 0;

        $data['inputName'] = $input->getName();

        foreach ($input->getValidatorChain()->getValidators() as $validator) {

            // Db validator
            if ($validator['instance'] instanceof \Zend\Validator\Db\AbstractDb) {

                $exclude = $validator['instance']->getExclude();

                !is_array($exclude) or
                    $exclude['value'] = !empty($data[$exclude['value']]) ? $data[$exclude['value']] : $exclude['value'];

                !is_string($exclude) or
                    $exclude = $this->translateExclude($exclude, $data);

                $validator['instance']->setExclude($exclude);
            }
        }

        return $this;
    }

    protected function translateExclude($exclude, array $data)
    {
        $translation = array();

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subKey => $subValue) {
                    $translation['{$' . $key . '[' . $subKey . ']}'] = $subValue;
                }
                continue;
            }
            $translation['{$' . $key . '}'] = $value;
        }

        return strtr($exclude, $translation);
    }
}

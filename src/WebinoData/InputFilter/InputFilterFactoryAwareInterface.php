<?php

namespace WebinoData\InputFilter;

use Zend\InputFilter\Factory as InputFilterFactory;

interface InputFilterFactoryAwareInterface
{
    /**
     * @param InputFilterFactory $inputFilter
     */
    public function setInputFilterFactory(InputFilterFactory $inputFilter);

    /**
     * @return InputFilterFactory
     */
    public function getInputFilter();
}

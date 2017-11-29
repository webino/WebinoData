<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\InputFilter;

use Zend\InputFilter\Factory as InputFilterFactory;

/**
 * Interface InputFilterFactoryAwareInterface
 */
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

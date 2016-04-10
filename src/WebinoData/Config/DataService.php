<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Config;

use WebinoData\InputFilter\InputFilter as DataInputFilter;

/**
 * Data service configurator
 */
class DataService extends AbstractDataService
{
    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->setOptions($options);
    }

    /**
     * @return array
     */
    protected function getSpec()
    {
        return [
            'parameters' => [
                'config' => [
                    'input_filter' => ['type' => DataInputFilter::class],
                ],
            ],
        ];
    }
}

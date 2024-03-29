<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2012-2016 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Config\InputFilter\Input;

/**
 * Adds ability to value range
 */
trait RangedTrait
{
    /**
     * @param int $min
     * @param int $max
     * @return $this
     */
    public function setBetween($min, $max)
    {
        $this->spec['validators'] = [
            'between' => [
                'name'    => 'Between',
                'options' => ['min' => $min, 'max' => $max],
            ],
        ];

        return $this;
    }
}

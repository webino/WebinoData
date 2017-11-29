<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Filter;

use Zend\Filter\DateTimeFormatter as BaseDateTimeFormatter;

/**
 * Class DateTimeFormatter
 */
class DateTimeFormatter extends BaseDateTimeFormatter
{
    /**
     * SQL compatible datetime
     *
     * @var string
     */
    protected $format = 'Y-m-d H:i:s';
}

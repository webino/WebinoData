<?php

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

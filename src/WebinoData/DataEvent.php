<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2016 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoData;

use WebinoData\Event\DataEventInterface;
use Zend\EventManager\Event;

/**
 * Class DataEvent
 * @deprecated use Event\DataEvent instead
 */
class DataEvent extends Event implements DataEventInterface
{

}

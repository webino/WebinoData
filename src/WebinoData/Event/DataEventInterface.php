<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoData\Event;

/**
 * Interface DataEventInterface
 */
interface DataEventInterface
{
    const EVENT_SELECT = 'data.select';
    const EVENT_SELECT_COLUMNS = 'data.select.columns';
    const EVENT_SELECT_WHERE = 'data.select.where';
    const EVENT_SELECT_JOIN = 'data.select.join';
    const EVENT_DELETE = 'data.delete';
    const EVENT_DELETE_POST = 'data.delete.post';
    const EVENT_EXCHANGE_INVALID = 'data.exchange.invalid';
    const EVENT_EXCHANGE_PRE = 'data.exchange.pre';
    const EVENT_EXCHANGE_POST = 'data.exchange.post';
    const EVENT_FETCH_WITH = 'data.fetch.with';
    const EVENT_FETCH_PRE = 'data.fetch.pre';
    const EVENT_FETCH_POST = 'data.fetch.post';
    const EVENT_FETCH_CACHE = 'data.fetch.cache';
    const EVENT_EXPORT = 'data.export';
    const EVENT_IMPORT = 'data.import';
    const EVENT_TOGGLE = 'data.toggle';
    const EVENT_TOGGLE_POST = 'data.toggle.post';
    const EVENT_INCREMENT = 'data.increment';
    const EVENT_INCREMENT_POST = 'data.increment.post';
    const EVENT_DECREMENT = 'data.decrement';
    const EVENT_DECREMENT_POST = 'data.decrement.post';

    // TODO add interface methods
}

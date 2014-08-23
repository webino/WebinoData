<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Config;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use Zend\Filter\Word\DashToCamelCase;

/**
 *
 */
class InstanceConfigAutoloader
{
    const DATA_DIR_NAME = '/data';
    const DATA_SUFFIX   = '.data.php';

    protected $dir;
    protected $merge = [];

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    public function merge(array $subject)
    {
        $this->merge = array_replace_recursive($this->merge, $subject);
        return $this;
    }

    public function toArray()
    {
        $dir         = $this->dir . self::DATA_DIR_NAME;
        $dashToCamel = new DashToCamelCase;
        $config      = [];

        foreach ($this->createDirIterator($dir) as $path) {

            $relPath   = substr($path[0], strlen($dir) + 1);
            $namespace = explode('/', $relPath)[0];
            $finfo     = pathinfo($path[0]);

            $itemPath = join(
                ' ',
                array_filter([
                    trim(dirname(substr($relPath, strlen($namespace))), '/'),
                    '_',
                    ucfirst($finfo['filename']),
                ])
            );

            $namePart   = str_replace(' ', '', ucwords(strtr($itemPath, ['-' => ' ', '.' => ' '])));
            $index      = $dashToCamel->filter($namespace) . ltrim($namePart, '_');
            $itemName   = str_replace('-', '_', explode('.', $finfo['filename'], 2)[0]);
            $tableIndex = substr($index, 0, strlen($index) - 4) . 'Table';

            $config['alias'][$tableIndex] = 'Zend\Db\TableGateway\TableGateway';
            $config['alias'][$index]      = 'WebinoData\DataService';

            $config[$tableIndex] = [
                'parameters' => [
                    'table'   => $itemName,
                    'adapter' => 'Zend\Db\Adapter\Adapter',
                ],
            ];

            $config[$index] = require $path[0];
        }

        return array_replace_recursive($config, $this->merge);
    }

    /**
     * @param string $dir
     * @return RegexIterator
     */
    private function createDirIterator($dir)
    {
        return new RegexIterator(
            new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)),
            '/^.+' . preg_quote(self::DATA_SUFFIX) . '$/i',
            RegexIterator::GET_MATCH
        );
    }
}

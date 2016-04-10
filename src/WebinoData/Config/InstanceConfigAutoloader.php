<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2012-2016 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Config;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use WebinoData\DataService;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Filter\Word\DashToCamelCase;
use Zend\Stdlib\ArrayUtils;

/**
 * Class InstanceConfigAutoloader
 * @TODO redesign to not use the DI
 */
class InstanceConfigAutoloader
{
    const DATA_DIR_NAME = '/data';
    const DATA_SUFFIX   = '.data.php';

    /**
     * @var string
     */
    protected $dir;

    /**
     * @var array
     */
    protected $merge = [];

    /**
     * @param $dir
     */
    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    /**
     * @param array $subject
     * @return $this
     */
    public function merge(array $subject)
    {
        $this->merge = ArrayUtils::merge($this->merge, $subject);
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $dir = $this->dir . self::DATA_DIR_NAME;
        if (!file_exists($dir)) {
            return $this->merge;
        }

        $config = [];
        $dashToCamel = new DashToCamelCase;
        foreach ($this->createDirIterator($dir) as $path) {

            $relPath   = substr($path[0], strlen($dir) + 1);
            $namespace = explode('/', $relPath)[0];
            $fInfo     = pathinfo($path[0]);

            $itemPath = join(
                ' ',
                array_filter([
                    trim(dirname(substr($relPath, strlen($namespace))), '/'),
                    '_',
                    ucfirst($fInfo['filename']),
                ])
            );

            $namePart   = str_replace(' ', '', ucwords(strtr($itemPath, ['-' => ' ', '.' => ' '])));
            $index      = $dashToCamel->filter($namespace) . ltrim($namePart, '_');
            $itemName   = str_replace('-', '_', explode('.', $fInfo['filename'], 2)[0]);
            $tableIndex = substr($index, 0, strlen($index) - 4) . 'Table';

            $config['alias'][$tableIndex] = TableGateway::class;
            $config['alias'][$index]      = DataService::class;

            $config[$tableIndex] = [
                'parameters' => [
                    'table'   => $itemName,
                    'adapter' => Adapter::class,
                ],
            ];

            /** @noinspection PhpIncludeInspection */
            $dataConfig = require $path[0];
            $config[$index] = is_array($dataConfig) ? $dataConfig : $dataConfig->toArray();

            // set default table
            empty($config[$index]['parameters']['tableGateway'])
                and $config[$index]['parameters']['tableGateway'] = $tableIndex;
        }

        return array_replace_recursive($config, $this->merge);
    }

    /**
     * @param string $dir
     * @return RegexIterator
     * @TODO common
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

<?php

namespace WebinoData\Debugger;

use BjyProfiler\Db\Profiler\Query;
use WebinoDebug\Debugger\AbstractPanel;
use WebinoDebug\Debugger\PanelInitInterface;
use WebinoDebug\Debugger\PanelInterface;
use Zend\Db\Adapter\Profiler\ProfilerAwareInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Class DbPanel
 */
class DbPanel extends AbstractPanel implements
    PanelInterface,
    PanelInitInterface
{
    /**
     * {@inheritdoc}
     */
    protected $dir = __DIR__;

    /**
     * {@inheritdoc}
     */
    protected $title = 'Database profiler';

    /**
     * @var \BjyProfiler\Db\Profiler\Profiler
     */
    protected $profiler;

    /**
     * @param ServiceManager $services
     */
    public function init(ServiceManager $services)
    {
        /** @var \Zend\Db\Adapter\Adapter $db */
        $db = $services->get('Zend\Db\Adapter\Adapter');

        if ($db instanceof ProfilerAwareInterface) {
            /** @var \BjyProfiler\Db\Profiler\Profiler $profiler */
            $this->profiler = $db->getProfiler();
        }
    }

    /**
     * @param Query $query
     * @return array
     */
    protected function createCallStack(Query $query) : array
    {
        $stack    = [];
        $continue = true;

        foreach (array_reverse($query->getCallStack()) as $line) {
            if ($continue) {
                if (empty($line['class']) || 'WebinoData' !== substr($line['class'], 0, 10)) {
                    continue;
                }
            }

            $stack[]  = $line;
            $continue = false;
        }

        array_pop($stack);
        array_pop($stack);

        return $stack;
    }

    /**
     * {@inheritdoc}
     */
    public function getTab()
    {
        if (!$this->profiler || !count($this->profiler->getQueryProfiles())) {
            return '';
        }

        return $this->createIcon('db');
    }

    /**
     * @return string|void
     */
    public function getPanel()
    {
        return $this->renderTemplate('db.panel');
    }
}

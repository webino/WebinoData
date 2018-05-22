<?php

namespace WebinoData\Debugger\Bar;

use WebinoDebug\Debugger\Bar\AbstractPanel;
use WebinoDebug\Debugger\Bar\PanelInitInterface;
use WebinoDebug\Debugger\Bar\PanelInterface;
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

        if ($db instanceof \Zend\Db\Adapter\Profiler\ProfilerAwareInterface) {
            /** @var \BjyProfiler\Db\Profiler\Profiler $profiler */
            $this->profiler = $db->getProfiler();
        }
    }

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

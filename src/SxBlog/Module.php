<?php

namespace SxBlog;

use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements
ServiceProviderInterface, ViewHelperProviderInterface, ConfigProviderInterface, ControllerProviderInterface
{

    /**
     * {@InheritDoc}
     */
    public function getConfig()
    {
        $config      = array();
        $configFiles = array(
            'module.config.php',
            'routes.config.php',
        );
        foreach ($configFiles as $configFile) {
            $config = \Zend\Stdlib\ArrayUtils::merge($config, include __DIR__ . '/../../config/' . $configFile);
        }

        return $config;
    }

    /**
     * {@InheritDoc}
     */
    public function getServiceConfig()
    {
        return include __DIR__ . '/../../config/services.config.php';
    }

    /**
     * {@InheritDoc}
     */
    public function getViewHelperConfig()
    {
        return include __DIR__ . '/../../config/view-helpers.config.php';
    }

    /**
     * {@InheritDoc}
     */
    public function getControllerConfig()
    {
        return include __DIR__ . '/../../config/controllers.config.php';
    }

    /**
     * {@InheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

}

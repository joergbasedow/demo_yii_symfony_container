<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\Config\ConfigCache;

class CachedContainerLoader
{
    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Initializes the service container.
     *
     * The cached version of the service container is used when fresh, otherwise the container is built.
     *
     * @param bool $forceCacheRefresh
     *
     * @return YiiContainerComponent
     */
    public function getContainer($forceCacheRefresh = false)
    {
        $class = 'CachedContainer';
        $cache = new ConfigCache(Yii::app()->basePath.'/runtime/'.$class.'.php', YII_DEBUG);

        if (!$cache->isFresh() || $forceCacheRefresh) {
            $container = new YiiContainerComponent();
            $container->setConfiguration($this->config);
            $container->init();

            $this->dumpContainer($cache, $container, $class, 'YiiContainerComponent');
        }

        /** @noinspection PhpIncludeInspection */
        require_once $cache->getPath();
        /* @var $container YiiContainerComponent */
        $container = new $class();

        // set synthetic services
        $container->set('db', Yii::app()->db);

        $container->setIsInitialized(); // prevent reinitialisation

        return $container;
    }

    /**
     * Dumps the service container to PHP code in the cache.
     *
     * @param ConfigCache      $cache     The config cache.
     * @param ContainerBuilder $container The service container.
     * @param string           $class     The name of the class to generate.
     * @param string           $baseClass The name of the container's base class.
     */
    private function dumpContainer(ConfigCache $cache, ContainerBuilder $container, $class, $baseClass)
    {
        $dumper = new PhpDumper($container);

        $content = $dumper->dump(
            ['class' => $class, 'base_class' => $baseClass, 'file' => $cache->getPath()]
        );

        $cache->write($content, $container->getResources());
    }
}

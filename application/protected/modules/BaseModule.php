<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class BaseModule extends CWebModule
{
    public function loadServices(ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(Yii::app()->basePath.'/modules/'.$this->getName().'/config/')
        );

        foreach (['services'] as $aFile) { // TODO: Inject file names through Yii config.
            $loader->load($aFile.'.yml');
        }
     }
}

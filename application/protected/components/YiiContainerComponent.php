<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class YiiContainerComponent extends ContainerBuilder implements IApplicationComponent
{
    /**
     * @var bool
     */
    private $isInitialized = false;

    /**
     * @var array
     */
    private $configuration = [];

    public function setConfiguration(array $configuration) {
        $this->configuration = $configuration;
    }

    public function init()
    {
        $loader = new YamlFileLoader($this, new FileLocator(Yii::app()->basePath.'/config'));
        foreach ($this->configuration['files'] as $aFile) {
            $loader->load($aFile.'.yml');
        }

        $this->isInitialized = true;
    }

    /**
     * @return bool
     */
    public function getIsInitialized()
    {
        return $this->isInitialized;
    }
}

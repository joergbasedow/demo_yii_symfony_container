<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

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
        foreach ($this->configuration as $aServiceId => $aServiceConfiguration) {
            $definition = $this->register($aServiceId, $aServiceConfiguration['class']);

            foreach ($aServiceConfiguration['arguments'] as $anArgument) {
                if (strpos($anArgument, '@') === 0) {
                    $anArgument = new Reference(substr($anArgument, 1));
                }
                $definition->addArgument($anArgument);
            }
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

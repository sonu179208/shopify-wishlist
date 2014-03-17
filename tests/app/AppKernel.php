<?php

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    /**
     * @return array
     */
    public function registerBundles()
    {
        return array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle(),
            new Sensio\Bundle\DistributionBundle\SensioDistributionBundle(),
            new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Kurl\Bundle\ShopifyBundle\KurlShopifyBundle(),
        );
    }

    /**
     * @param Symfony\Component\Config\Loader\LoaderInterface $loader
     *
     * @return null
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return __DIR__ . '/../../build/cache';
    }

    /**
     * @return string
     */
    public function getLogDir()
    {
        return __DIR__ . '/../../build/logs';
    }

    protected function initializeContainer()
    {
        parent::initializeContainer();
        if (PHP_SAPI == 'cli') {
            $this->getContainer()->enterScope('request');
            $this->getContainer()->set('request', new \Symfony\Component\HttpFoundation\Request(), 'request');
        }
    }
}

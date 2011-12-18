<?php

namespace Symtoo\CKEditorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\Definition\Processor;

/**
 * Symtoo CKEditor extension
 *
 * @author GeLo <geloen.eric@gmail.com>
 * @author Miloslav Kmet <miloslav.kmet@gmail.com>
 */
class SymtooCKEditorExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        
        $config = $this->processConfiguration($configuration, $configs);
        
        $container->setParameter('twig.form.resources', array_merge(
            $container->getParameter('twig.form.resources'),
            array('SymtooCKEditorBundle:Form:ckeditor_widget.html.twig')        
        ));

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}

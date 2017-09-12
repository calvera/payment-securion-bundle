<?php

namespace Calvera\Payment\SecurionBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class CalveraPaymentSecurionExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('calvera_payment_securion.api_key', $config['api_key']);

        foreach($config['methods'] AS $method) {
            $this->addFormType($container, $method);
        }

        /**
         * When logging is disabled, remove logger and setLogger calls
         */
        if(false === $config['logger']) {
            $container->getDefinition('calvera_payment_securion.plugin.credit_card')->removeMethodCall('setLogger');
            $container->removeDefinition('monolog.logger.calvera_payment_securion');
        }
    }

    protected function addFormType(ContainerBuilder $container, $method)
    {
        $securionMethod = 'securion_' . $method;

        $definition = new Definition();
        if($container->hasParameter(sprintf('calvera_payment_securion.form.%s_type.class', $method))) {
            $definition->setClass(sprintf('%%calvera_payment_securion.form.%s_type.class%%', $method));
        } else {
            $definition->setClass('%calvera_payment_securion.form.securion_type.class%');
        }
        $definition->addArgument($securionMethod);

        $definition->addTag('payment.method_form_type');
        $definition->addTag('form.type', array(
            'alias' => $securionMethod
        ));

        $container->setDefinition(
            sprintf('calvera_payment_securion.form.%s_type', $method),
            $definition
        );
    }
}

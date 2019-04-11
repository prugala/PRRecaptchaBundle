<?php
declare(strict_types=1);

namespace PR\Bundle\RecaptchaBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class PRRecaptchaExtension extends Extension
{
    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('recaptcha', $config['pr_recaptcha']);

        $this->registerTemplate($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function registerTemplate(ContainerBuilder $container): void
    {
        $formResource = '@PRRecaptcha/Form/recaptcha.html.twig';

        $container->setParameter('twig.form.resources', array_merge(
            $container->getParameter('twig.form.resources') ?? [],
            [$formResource]
        ));
    }
}

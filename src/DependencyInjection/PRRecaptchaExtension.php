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

        foreach ($config as $key => $value) {
            $container->setParameter('pr_recaptcha.' . $key, $value);
        }

        $this->registerTemplate($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function registerTemplate(ContainerBuilder $container): void
    {
        $formThemesParam = 'twig.form_themes';
        $formThemes[] = '@PRRecaptcha/Form/recaptcha.html.twig';

        if ($container->hasParameter($formThemesParam)) {
            $formThemes = array_merge(
                $container->getParameter($formThemesParam),
                $formThemes
            );
        }
        $container->setParameter($formThemesParam, $formThemes);
    }
}

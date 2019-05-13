<?php
declare(strict_types=1);

namespace PR\Bundle\RecaptchaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('pr_recaptcha');

        $rootNode
            ->children()
                ->scalarNode('public_key')
                    ->isRequired()
                ->end()
                ->scalarNode('secret_key')
                    ->isRequired()
                ->end()
                ->booleanNode('enabled')
                    ->defaultValue(true)
                ->end()
                ->enumNode('version')
                    ->values([2, 3])
                    ->defaultValue(3)
                ->end()
                ->floatNode('score_threshhold')
                    ->defaultValue(0.5)
                ->end()
                ->booleanNode('hide_badge')
                    ->defaultValue(false)
                ->end()
                ->scalarNode('host')
                    ->defaultValue('www.google.com')
                ->end()
            ->end();

        return $treeBuilder;
    }
}

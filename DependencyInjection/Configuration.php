<?php
/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\ImagingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
  /**
   * {@inheritdoc}
   */
  public function getConfigTreeBuilder ()
  {
    $treeBuilder = new TreeBuilder();
    $rootNode = $treeBuilder->root('accurateweb_imaging');

    $rootNode
      ->addDefaultsIfNotSet()
      ->children()
        ->arrayNode('configuration')
          ->addDefaultsIfNotSet()
          ->children()
            ->scalarNode('library')->defaultValue('gd')->isRequired()->end()
          ->end()
        ->end()
      ->end();

    return $treeBuilder;
  }
}

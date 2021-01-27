<?php
/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\ImagingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
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
      ->children()
        ->arrayNode('library')
          ->children()
            ->defaultValue([
                'gd' => [
                  'aw_imaging.adapter' => 'aw_imaging.adapter.gd',
                  'aw_imaging.filter.factory' => 'aw_imaging.filter.factory.gd'
                ],
                'imagick' => [
                  'aw_imaging.adapter' => 'aw_imaging.adapter.imagick',
                  'aw_imaging.filter.factory' => 'aw_imaging.filter.factory.imagick'
                ]
              ])
          ->end()
        ->end()
      ->end();

    return $treeBuilder;
  }
}
<?php
/**
 *  (c) 2019 ИП Рагозин Денис Николаевич. Все права защищены.
 *
 *  Настоящий файл является частью программного продукта, разработанного ИП Рагозиным Денисом Николаевичем
 *  (ОГРНИП 315668300000095, ИНН 660902635476).
 *
 *  Алгоритм и исходные коды программного кода программного продукта являются коммерческой тайной
 *  ИП Рагозина Денис Николаевича. Любое их использование без согласия ИП Рагозина Денис Николаевича рассматривается,
 *  как нарушение его авторских прав.
 *   Ответственность за нарушение авторских прав наступает в соответствии с действующим законодательством РФ.
 */

namespace Accurateweb\LocationBundle\DependencyInjection\CompilerPass;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class LocationResolverCompilerPass implements CompilerPassInterface
{
  public function process (ContainerBuilder $container)
  {
    $location = $container->getDefinition('aw.location');
    $resolvers = $container->findTaggedServiceIds('aw.location.resolver');

    foreach ($resolvers as $id => $tags)
    {
      $priority = null;

      foreach ($tags as $tag)
      {
        $priority = isset($tag['priority'])?$tag['priority']:null;
      }

      $location->addMethodCall('addLocationResolver', [new Reference($id), $priority]);
    }
  }
}
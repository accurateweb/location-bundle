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

namespace Accurateweb\LocationBundle\DataCollector;

use Accurateweb\LocationBundle\Service\Location;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;

class LocationCollector implements DataCollectorInterface
{
  /**
   * @var \Accurateweb\LocationBundle\Model\ResolvedUserLocation
   */
  private $location;

  public function __construct (Location $location)
  {
    $this->location = $location->getResolvedLocation();
  }

  public function collect (Request $request, Response $response, \Exception $exception = null)
  {
  }

  public function getName ()
  {
    return 'aw.location.collector';
  }

  public function getLocation()
  {
    return $this->location;
  }

  public function reset ()
  {
    $this->location = null;
  }
}

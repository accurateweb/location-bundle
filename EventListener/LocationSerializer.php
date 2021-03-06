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

namespace Accurateweb\LocationBundle\EventListener;

use Accurateweb\LocationBundle\Service\Location;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class LocationSerializer
{
  private $location;

  public function __construct (Location $location)
  {
    $this->location = $location;
  }

  public function onKernelResponse(FilterResponseEvent $event)
  {
    if ($event->getRequestType() === HttpKernelInterface::MASTER_REQUEST)
    {
      $user_location = $this->location->getResolvedLocation();
      $session = $event->getRequest()->getSession();

      if ($session && $user_location)
      {
        $session->set('aw.location', serialize($user_location));
      }
    }
  }
}

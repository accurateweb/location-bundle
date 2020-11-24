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

namespace Accurateweb\LocationBundle\LocationResolver;

use Accurateweb\LocationBundle\Model\UserLocation;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionLocationResolver implements LocationResolverInterface
{
  private $session;

  public function __construct (SessionInterface $session)
  {
    $this->session = $session;
  }

  public function getUserLocation()
  {
    if (!$this->session->has('aw.location'))
    {
      return null;
    }

    $locationData = $this->session->get('aw.location');
    $location = unserialize($locationData);

    if (!$location instanceof UserLocation)
    {
      return null;
    }

    return $location;
  }
}
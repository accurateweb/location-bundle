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

use Accurateweb\LocationBundle\GeoLocation\GeoInterface;
use Accurateweb\LocationBundle\Model\ResolvedUserLocation;
use Doctrine\ORM\EntityRepository;

class GeoLocationResolver implements LocationResolverInterface
{
  private $geo;

  public function __construct (GeoInterface $geo)
  {
    $this->geo = $geo;
  }

  public function getUserLocation()
  {
    $cityName = $this->geo->getCityName();

    if (!$cityName)
    {
      return null;
    }

    $location = new ResolvedUserLocation();

    $location->setCityName($cityName);
    $location->setRegionName($this->geo->getRegionName());
    $location->setRegionIso($this->geo->getRegionIso());

    return $location;
  }
}

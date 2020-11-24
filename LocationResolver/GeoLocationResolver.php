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
use Accurateweb\LocationBundle\Model\UserLocation;
use Doctrine\ORM\EntityRepository;

class GeoLocationResolver implements LocationResolverInterface
{
  private $geo;
  private $cityRepository;

  public function __construct (GeoInterface $geo, EntityRepository $cityRepository)
  {
    $this->geo = $geo;
    $this->cityRepository = $cityRepository;
  }

  public function getUserLocation()
  {
    $cityName = $this->geo->getCityName();

    if (!$cityName)
    {
      return null;
    }

    /** @var CdekCity $city */
    $city = $this->cityRepository->findOneBy(['name' => $cityName]);
    $location = new UserLocation();
    $location->setCityName($cityName);

    if ($city)
    {
      $location
        ->setCityCode($city->getId())
        ->setCountryCode($city->getCountryCode());
      return $location;
    }

    return null;
//    return $location;
  }
}
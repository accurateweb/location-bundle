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

namespace Accurateweb\LocationBundle\GeoLocation;

use Symfony\Component\HttpFoundation\RequestStack;

class GeoLocationFactory
{
  private static $locations = [
    'ipgeo' => 'Accurateweb\\LocationBundle\\GeoLocation\\IpGeoBase',
    'sypex' => 'Accurateweb\\LocationBundle\\GeoLocation\\Sypexgeo',
  ];

  public static function getGeo(RequestStack $requestStack, $geo=null)
  {
    $request = $requestStack->getCurrentRequest();
    $ip = '127.0.0.1';

    if ($request)
    {
      $ip = $request->getClientIp();
    }

    $class = 'Accurateweb\\LocationBundle\\GeoLocation\\IpGeoBase';

    if (isset(self::$locations[$geo]))
    {
      $class = self::$locations[$geo];
    }

    return new $class($ip);
  }
}
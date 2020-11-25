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

class Sypexgeo implements GeoInterface
{
  private $ip;
  private $charset;

  private $data = null;

  public function __construct ($ip)
  {
    $this->ip = $ip;
    $this->charset = 'UTF-8';
  }

  public function getCountryIso()
  {
    $data = $this->getData();

    if (isset($data['country']))
    {
      return $data['country']['iso'];
    }

    return null;
  }

  public function getCityName()
  {
    $data = $this->getData();

    if (isset($data['city']))
    {
      return $data['city']['name_ru'];
    }

    return null;
  }

  public function getRegion()
  {
    return $this->getValue('region');
  }

  public function getRegionName()
  {
    $region = $this->getRegion();

    return $region ? $region['name_ru'] : null;
  }

  public function getRegionIso()
  {
    $region = $this->getRegion();

    return $region ? $region['iso'] : null;
  }

  /**
   * функция возвращет конкретное значение из полученного массива данных по ip
   *
   * @param string $key - ключ массива. Если интересует конкретное значение.
   * @return mixed
   *
   * Ключ может быть равным 'inetnum', 'country', 'city', 'region', 'district', 'lat', 'lng'
   */
  public function getValue ($key)
  {
    $data = $this->getData();

    return isset($data[$key]) ? $data[$key] : null;
  }

  public function getData()
  {
    if (!is_null($this->data))
    {
      return $this->data;
    }

    $this->data = $this->getGeobaseData();
    return $this->data;
  }

  /**
   * функция получает данные по ip.
   *
   * @return array - возвращает массив с данными
   */
  protected function getGeobaseData ()
  {
    // получаем данные по ip
    $link = 'http://api.sypexgeo.net/json/' . $this->ip;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    $string = curl_exec($ch);
    curl_close($ch);

    $this->data = @\json_decode($string, true);

    return $this->data;
  }
}

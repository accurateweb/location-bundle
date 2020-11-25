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

namespace Accurateweb\LocationBundle\Model;

class ResolvedUserLocation
{
  private $cityName;

  private $cityCode;

  private $regionName;

  private $regionIso;

  private $countryCode;


  /**
   * @return mixed
   */
  public function getCityName ()
  {
    return $this->cityName;
  }

  /**
   * @param mixed $cityName
   * @return $this
   */
  public function setCityName ($cityName)
  {
    $this->cityName = $cityName;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getCityCode ()
  {
    return $this->cityCode;
  }

  /**
   * @param mixed $cityCode
   * @return $this
   */
  public function setCityCode ($cityCode)
  {
    $this->cityCode = $cityCode;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getCountryCode ()
  {
    return $this->countryCode;
  }

  /**
   * @param mixed $countryCode
   * @return $this
   */
  public function setCountryCode ($countryCode)
  {
    $this->countryCode = $countryCode;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getRegionName()
  {
    return $this->regionName;
  }

  /**
   * @param mixed $regionName
   * @return ResolvedUserLocation
   */
  public function setRegionName($regionName)
  {
    $this->regionName = $regionName;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getRegionIso()
  {
    return $this->regionIso;
  }

  /**
   * @param mixed $regionIso
   * @return ResolvedUserLocation
   */
  public function setRegionIso($regionIso)
  {
    $this->regionIso = $regionIso;
    return $this;
  }


}

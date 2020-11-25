<?php
/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\LocationBundle\Model;


interface UserLocationInterface
{
  public function getLocationId();

  public function getLocationName();
}

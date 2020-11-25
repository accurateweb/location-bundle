<?php
/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\LocationBundle\Model;


interface UserLocationRepositoryInterface
{
  public function findByResolvedLocation(ResolvedUserLocation $resolvedUserLocation);
}

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

namespace Accurateweb\LocationBundle\Service;

use Accurateweb\LocationBundle\Exception\LocationNotFoundException;
use Accurateweb\LocationBundle\Exception\LocationNotResolvedException;
use Accurateweb\LocationBundle\LocationResolver\LocationResolverInterface;
use Accurateweb\LocationBundle\Model\ResolvedUserLocation;
use Accurateweb\LocationBundle\Model\UserLocationInterface;
use Accurateweb\LocationBundle\Model\UserLocationRepositoryInterface;

class Location
{
  private $resolvedLocation;
  private $foundLocation;

  private $userLocationRepository;

  private $locationResolvers;

  public function __construct(UserLocationRepositoryInterface $userLocationRepository)
  {
    $this->locationResolvers = array();
    $this->userLocationRepository = $userLocationRepository;
  }

  public function addLocationResolver(LocationResolverInterface $resolver, $priority=null)
  {
    if (null === $priority)
    {
      $priority = 0;
    }

    $this->locationResolvers[] = [
      'priority' => $priority,
      'resolver' => $resolver
    ];

    return $this;
  }

  /**
   * Returnes current user location. If no location has been set,
   * resolves user location with a configured set of resolvers first.
   *
   * @return UserLocationInterface
   * @throws LocationNotResolvedException
   * @throws LocationNotFoundException
   */
  public function getLocation()
  {
    if ($this->foundLocation)
    {
      return $this->foundLocation;
    }

    $resolvedLocation = $this->getResolvedLocation();

    if ($resolvedLocation)
    {
      $this->foundLocation = $this->userLocationRepository->findByResolvedLocation($this->foundLocation);

      if (!$this->foundLocation)
      {
        throw new LocationNotFoundException();
      }
    }

    return $this->foundLocation;
  }

  /**
   * @return ResolvedUserLocation
   * @throws LocationNotResolvedException
   */
  public function getResolvedLocation()
  {
    if (!$this->resolvedLocation)
    {
      $this->resolvedLocation = $this->resolveLocation();
    }

    return $this->resolvedLocation;
  }

  /**
   * @param ResolvedUserLocation $resolvedLocation
   * @return $this
   */
  public function setResolvedLocation(ResolvedUserLocation $resolvedLocation)
  {
    if ($this->resolvedLocation !== $resolvedLocation)
    {
      $this->resolvedLocation = $resolvedLocation;
      $this->foundLocation = null;
    }

    return $this;
  }

  /**
   * Resolves user location with a configured set of resolvers
   *
   * @return ResolvedUserLocation
   * @throws LocationNotResolvedException
   */
  protected function resolveLocation()
  {
    $location = null;
    usort($this->locationResolvers, function($a, $b){
      return $a['priority'] - $b['priority'];
    });

    /** @var LocationResolverInterface $resolver */
    foreach ($this->locationResolvers as $resolver)
    {
      $location = $resolver['resolver']->getUserLocation();

      if ($location)
      {
        break;
      }
    }

    if (!$location)
    {
      throw new LocationNotResolvedException();
    }

    return $location;
  }
}

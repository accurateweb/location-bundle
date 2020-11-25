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

    return $this->resolveLocation();
  }

  public function getResolvedLocation()
  {
    return $this->resolvedLocation;
  }

  public function setLocation(UserLocationInterface $location)
  {
    $this->foundLocation = $location;
    $this->resolvedLocation = $location->getResolvedLocation();
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
      $this->foundLocation = $this->userLocationRepository->findByResolvedLocation($resolvedLocation);

      if (!$this->foundLocation)
      {
        throw new LocationNotFoundException();
      }
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
    usort($this->locationResolvers, function($a, $b){
      return $b['priority'] - $a['priority'];
    });

    /** @var LocationResolverInterface $resolver */
    foreach ($this->locationResolvers as $resolver)
    {
      $resolvedLocation = $resolver['resolver']->getUserLocation();

      if ($resolvedLocation)
      {
        $foundLocation = $this->userLocationRepository->findByResolvedLocation($resolvedLocation);

        if ($foundLocation)
        {
          $this->resolvedLocation = $resolvedLocation;
          $this->foundLocation = $foundLocation;

          return $foundLocation;
        }
      }
    }

    throw new LocationNotResolvedException();
  }
}

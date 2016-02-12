<?php
/**
 * Entry point service file
 *
 * @copyright Copyright (c) 2016, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\RestApiEntryPointModule\Service;

use BadMethodCallException;
use Zend\Mvc\Router\Http\TreeRouteStack;
use Zend\Mvc\Router\RouteInterface;
use Zend\Mvc\Router\RouteMatch;

/**
 * Entry point service
 *
 * @package FinalGene\RestApiEntryPointModule\Service
 */
class EntryPointService
{
    /**
     * @var RouteInterface
     */
    protected $router;

    /**
     * Get router
     *
     * @throws BadMethodCallException
     *
     * @return RouteInterface
     */
    public function getRouter()
    {
        if (!$this->router instanceof RouteInterface) {
            throw new BadMethodCallException('Router not set');
        }

        return $this->router;
    }

    /**
     * Set router
     *
     * @param RouteInterface $router
     *
     * @return $this
     */
    public function setRouter(RouteInterface $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * Find route by name
     *
     * @param RouteInterface $router
     * @param string         $name
     *
     * @return RouteInterface
     */
    protected function findRoute(RouteInterface $router, $name)
    {
        if (!$router instanceof TreeRouteStack) {
            return null;
        }

        $names = explode('/', $name, 2);
        $route = $router->getRoute(array_shift($names));
        if (empty($names)) {
            return $route;
        }

        return $this->findRoute($route, array_shift($names));
    }

    /**
     * Find child route names of route match
     *
     * @param RouteMatch $routeMatch
     *
     * @return string[]
     */
    public function findChildRouteNames(RouteMatch $routeMatch)
    {
        $matchedName = $routeMatch->getMatchedRouteName();

        $route = $this->findRoute($this->getRouter(), $matchedName);
        if (!$route instanceof TreeRouteStack) {
            return [];
        }

        $names = [];
        foreach (array_keys(iterator_to_array($route->getRoutes())) as $childName) {
            $names[$childName] = $matchedName . '/' . $childName;
        }

        return $names;
    }
}

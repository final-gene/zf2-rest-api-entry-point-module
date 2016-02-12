<?php
/**
 * Entry point service factory file
 *
 * @copyright Copyright (c) 2016, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\RestApiEntryPointModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Entry point service factory
 *
 * @package FinalGene\RestApiEntryPointModule\Service
 */
class EntryPointServiceFactory implements FactoryInterface
{
    /**
     * Create entry point service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return EntryPointService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Zend\Mvc\Router\RouteInterface $router */
        $router = $serviceLocator->get('Router');

        $service = new EntryPointService();
        return $service
            ->setRouter($router);
    }
}

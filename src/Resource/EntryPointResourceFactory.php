<?php
/**
 * Entry point resource factory file
 *
 * @copyright Copyright (c) 2016, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\RestApiEntryPointModule\Resource;

use FinalGene\RestApiEntryPointModule\Service\EntryPointService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Entry point resource factory
 *
 * @package FinalGene\RestApiEntryPointModule\Resource
 */
class EntryPointResourceFactory implements FactoryInterface
{
    /**
     * Create entry point resource
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return EntryPointResource
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \FinalGene\RestApiEntryPointModule\Service\EntryPointService $entryPointService */
        $entryPointService = $serviceLocator->get(EntryPointService::class);

        $resource = new EntryPointResource();
        return $resource
            ->setEntryPointService($entryPointService);
    }
}

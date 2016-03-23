<?php
/**
 * Entry point resource factory file
 *
 * @copyright Copyright (c) 2016, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\RestApiEntryPointModule\Resource;

use FinalGene\RestApiEntryPointModule\Service\EntryPointService;
use FinalGene\UriTemplateModule\Service\UriTemplateService;
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
        /** @var EntryPointService $entryPointService */
        $entryPointService = $serviceLocator->get(EntryPointService::class);

        /** @var UriTemplateService $uriTemplateService */
        $uriTemplateService = $serviceLocator->get(UriTemplateService::class);

        $resource = new EntryPointResource();
        return $resource
            ->setEntryPointService($entryPointService)
            ->setUriTemplateService($uriTemplateService);
    }
}

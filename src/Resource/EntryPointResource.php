<?php
/**
 * Entry point resource file
 *
 * @copyright Copyright (c) 2016, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\RestApiEntryPointModule\Resource;

use BadMethodCallException;
use FinalGene\RestApiEntryPointModule\Service\EntryPointService;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;
use ZF\Rest\AbstractResourceListener;
use ZF\Rest\ResourceEvent;

/**
 * Entry point resource
 *
 * @package FinalGene\RestApiEntryPointModule\Resource
 */
class EntryPointResource extends AbstractResourceListener
{
    /**
     * Entry point service
     *
     * @var EntryPointService
     */
    protected $entryPointService;

    /**
     * Get entry point service
     *
     * @throws BadMethodCallException
     *
     * @return EntryPointService
     */
    public function getEntryPointService()
    {
        if (!$this->entryPointService instanceof EntryPointService) {
            throw new BadMethodCallException('Entry point service not set');
        }

        return $this->entryPointService;
    }

    /**
     * Set entry point service
     *
     * @param EntryPointService $entryPointService
     *
     * @return $this
     */
    public function setEntryPointService(EntryPointService $entryPointService)
    {
        $this->entryPointService = $entryPointService;
        return $this;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     *
     * @return \ZF\ApiProblem\ApiProblem|\ZF\Hal\Entity
     */
    public function fetchAll($params = [])
    {
        $entity = new Entity([]);

        $event = $this->getEvent();
        if (!$event instanceof ResourceEvent) {
            return $entity;
        }

        $links = $entity->getLinks();
        $names = $this->getEntryPointService()->findChildRouteNames($event->getRouteMatch());
        foreach ($names as $rel => $name) {
            $links->add(Link::factory([
                'rel' => $rel,
                'route' => [
                    'name' => $name
                ]
            ]));
        }

        return $entity;
    }
}

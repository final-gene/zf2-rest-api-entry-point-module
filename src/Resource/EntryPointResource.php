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
use FinalGene\UriTemplateModule\Service\UriTemplateService;
use Rize\UriTemplate\Parser;
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
    private $entryPointService;

    /**
     * @var UriTemplateService
     */
    private $uriTemplateService;

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
     * Get $uriTemplateService
     *
     * @return UriTemplateService
     */
    public function getUriTemplateService()
    {
        if (!$this->uriTemplateService instanceof UriTemplateService) {
            throw new BadMethodCallException('URI template service not set');
        }

        return $this->uriTemplateService;
    }

    /**
     * @param UriTemplateService $uriTemplateService
     * @return EntryPointResource
     */
    public function setUriTemplateService(UriTemplateService $uriTemplateService)
    {
        $this->uriTemplateService = $uriTemplateService;
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

        $uriTemplateService = $this->getUriTemplateService();
        $links = $entity->getLinks();
        $names = $this->getEntryPointService()->findChildRouteNames($event->getRouteMatch());
        foreach ($names as $rel => $name) {
            $url = $uriTemplateService->getFromRoute($name);
            $links->add(Link::factory([
                'rel' => $uriTemplateService->getCollectionNameFromRoute($name) ?: $rel,
                'url' => $url,
                'props' => [
                    'templated' => $this->isTemplated($url),
                ],
            ]));
        }

        return $entity;
    }

    /**
     * Check if url contains templated elements
     *
     * @param string $url
     *
     * @return bool
     */
    private function isTemplated($url)
    {
        $uriTemplateParser = new Parser();
        return 1 < count($uriTemplateParser->parse($url));
    }
}

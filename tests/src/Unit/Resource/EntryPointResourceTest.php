<?php
/**
 * Entry point resource test file
 *
 * @copyright Copyright (c) 2016, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\RestApiEntryPointModuleTest\Unit\Resource;
use FinalGene\RestApiEntryPointModule\Resource\EntryPointResource;
use FinalGene\RestApiEntryPointModule\Service\EntryPointService;
use Zend\Mvc\Router\RouteMatch;
use ZF\Hal\Entity;
use ZF\Rest\ResourceEvent;

/**
 * Entry point resource test
 *
 * @package FinalGene\RestApiEntryPointModuleTest\Unit\Resource
 */
class EntryPointResourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \FinalGene\RestApiEntryPointModule\Resource\EntryPointResource::fetchAll()
     */
    public function testFetchAllEntryPointResource()
    {
        $routeMatchMock = $this->getMockBuilder(RouteMatch::class)
            ->disableOriginalConstructor()
            ->getMock();

        $eventMock = $this->getMockBuilder(ResourceEvent::class)
            ->setConstructorArgs(['fetchAll'])
            ->setMethods(['getRouteMatch'])
            ->getMock();
        $eventMock->expects($this->once())
            ->method('getRouteMatch')
            ->willReturn($routeMatchMock);

        $entryPointServiceMock = $this->getMockBuilder(EntryPointService::class)
            ->setMethods(['findChildRouteNames'])
            ->getMock();
        $entryPointServiceMock->expects($this->once())
            ->method('findChildRouteNames')
            ->with($routeMatchMock)
            ->willReturn([]);

        $resourceMock = $this->getMockBuilder(EntryPointResource::class)
            ->setMethods(['getEvent', 'getEntryPointService'])
            ->getMock();
        $resourceMock->expects($this->once())
            ->method('getEvent')
            ->willReturn($eventMock);
        $resourceMock->expects($this->once())
            ->method('getEntryPointService')
            ->willReturn($entryPointServiceMock);

        /** @var EntryPointResource $resourceMock */
        $this->assertInstanceOf(Entity::class, $resourceMock->fetchAll());
    }
}

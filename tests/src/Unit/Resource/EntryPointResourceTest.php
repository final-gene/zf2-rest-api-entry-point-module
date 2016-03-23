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
use FinalGene\UriTemplateModule\Service\UriTemplateService;
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
     * @covers \FinalGene\RestApiEntryPointModule\Resource\EntryPointResource::setEntryPointService
     * @covers \FinalGene\RestApiEntryPointModule\Resource\EntryPointResource::getEntryPointService
     */
    public function testSetAndGetEntyPointService()
    {
        $expected = $this->getMockBuilder(EntryPointService::class)
            ->getMock();
        /** @var EntryPointService $expected */

        $resource = new EntryPointResource();
        $resource->setEntryPointService($expected);
        $this->assertEquals($expected, $resource->getEntryPointService());
    }

    /**
     * @covers \FinalGene\RestApiEntryPointModule\Resource\EntryPointResource::getEntryPointService
     * @expectedException \BadMethodCallException
     */
    public function testGetEntyPointServiceWillThrowException()
    {
        $resource = new EntryPointResource();
        $resource->getEntryPointService();
    }

    /**
     * @covers \FinalGene\RestApiEntryPointModule\Resource\EntryPointResource::setUriTemplateService
     * @covers \FinalGene\RestApiEntryPointModule\Resource\EntryPointResource::getUriTemplateService
     */
    public function testSetAndGetUriTemplateService()
    {
        $expected = $this->getMockBuilder(UriTemplateService::class)
            ->getMock();
        /** @var UriTemplateService $expected */

        $resource = new EntryPointResource();
        $resource->setUriTemplateService($expected);
        $this->assertEquals($expected, $resource->getUriTemplateService());
    }

    /**
     * @covers \FinalGene\RestApiEntryPointModule\Resource\EntryPointResource::getUriTemplateService
     * @expectedException \BadMethodCallException
     */
    public function testGetUriTemplateServiceWillThrowException()
    {
        $resource = new EntryPointResource();
        $resource->getUriTemplateService();
    }

    /**
     * @covers \FinalGene\RestApiEntryPointModule\Resource\EntryPointResource::fetchAll
     * @uses \FinalGene\RestApiEntryPointModule\Resource\EntryPointResource::getUriTemplateService
     */
    public function testFetchAllEntryPointResource()
    {
        $routeName = 'foo';

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
            ->willReturn([$routeName]);

        $uriTemplateServiceMock = $this->getMockBuilder(UriTemplateService::class)
            ->setMethods([
                'getFromRoute',
                'getCollectionNameFromRoute',
            ])
            ->getMock();
        $uriTemplateServiceMock->expects($this->once())
            ->method('getFromRoute')
            ->with($routeName)
            ->willReturn('/foo');
        $uriTemplateServiceMock->expects($this->once())
            ->method('getCollectionNameFromRoute')
            ->with($routeName)
            ->willReturn('bar:foo');

        $resourceMock = $this->getMockBuilder(EntryPointResource::class)
            ->setMethods(['getEvent', 'getEntryPointService', 'getUriTemplateService'])
            ->getMock();
        $resourceMock->expects($this->once())
            ->method('getEvent')
            ->willReturn($eventMock);
        $resourceMock->expects($this->once())
            ->method('getEntryPointService')
            ->willReturn($entryPointServiceMock);
        $resourceMock->expects($this->once())
            ->method('getUriTemplateService')
            ->willReturn($uriTemplateServiceMock);

        /** @var EntryPointResource $resourceMock */
        $this->assertInstanceOf(Entity::class, $resourceMock->fetchAll());
    }
}

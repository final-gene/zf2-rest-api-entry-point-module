<?php
/**
 * Entry point service test file
 *
 * @copyright Copyright (c) 2016, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\RestApiEntryPointModuleTest\Unit\Service;

use FinalGene\RestApiEntryPointModule\Service\EntryPointService;
use Zend\Mvc\Router\Http\TreeRouteStack;
use Zend\Mvc\Router\RouteInterface;
use Zend\Mvc\Router\RouteMatch;

/**
 * Entry point service test
 *
 * @package FinalGene\RestApiEntryPointModuleTest\Unit\Service
 */
class EntryPointServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \FinalGene\RestApiEntryPointModule\Service\EntryPointService::setRouter
     * @covers \FinalGene\RestApiEntryPointModule\Service\EntryPointService::getRouter
     */
    public function testSetAndGetRouter()
    {
        $expected = $this->getMockBuilder(RouteInterface::class)
            ->getMock();
        /** @var RouteInterface $expected */

        $service = new EntryPointService();
        $service->setRouter($expected);
        $this->assertEquals($expected, $service->getRouter());
    }

    /**
     * @covers \FinalGene\RestApiEntryPointModule\Service\EntryPointService::getRouter
     * @expectedException \BadMethodCallException
     */
    public function testGetRouterWillThrowException()
    {
        $service = new EntryPointService();
        $service->getRouter();
    }

    /**
     * @covers \FinalGene\RestApiEntryPointModule\Service\EntryPointService::findChildRouteNames
     * @uses   \FinalGene\RestApiEntryPointModule\Service\EntryPointService::getRouter
     * @uses   \FinalGene\RestApiEntryPointModule\Service\EntryPointService::setRouter
     * @uses   \FinalGene\RestApiEntryPointModule\Service\EntryPointService::findRoute
     */
    public function testFetchAllEntryPointServiceWithNonTreeRouteStack()
    {
        $routeMatchMock = $this->getMockBuilder(RouteMatch::class)
            ->disableOriginalConstructor()
            ->getMock();
        /** @var RouteMatch $routeMatchMock */

        $routerMock = $this->getMockBuilder(RouteInterface::class)
            ->getMock();
        /** @var RouteInterface $routerMock */

        $service = new EntryPointService();
        $service->setRouter($routerMock);

        $this->assertEquals([], $service->findChildRouteNames($routeMatchMock));
    }

    /**
     * @covers \FinalGene\RestApiEntryPointModule\Service\EntryPointService::findChildRouteNames
     * @uses   \FinalGene\RestApiEntryPointModule\Service\EntryPointService::getRouter
     * @uses   \FinalGene\RestApiEntryPointModule\Service\EntryPointService::setRouter
     * @uses   \FinalGene\RestApiEntryPointModule\Service\EntryPointService::findRoute
     */
    public function testFetchAllEntryPointServiceWithTreeRouteStack()
    {
        $routeMatchMock = $this->getMockBuilder(RouteMatch::class)
            ->disableOriginalConstructor()
            ->getMock();
        /** @var RouteMatch $routeMatchMock */

        $routerMock = $this->getMockBuilder(RouteInterface::class)
            ->getMock();

        $routeList = new \ArrayObject([
            'foo' => 'bar',
        ]);
        $routeStack = $this->getMockBuilder(TreeRouteStack::class)
            ->setMethods([
                'getRoutes',
            ])
            ->getMock();
        $routeStack
            ->expects($this->once())
            ->method('getRoutes')
            ->willReturn($routeList);

        $service = $this->getMockBuilder(EntryPointService::class)
            ->setMethods([
                'findRoute',
                'getRouter',
            ])
            ->getMock();
        $service
            ->expects($this->once())
            ->method('findRoute')
            ->willReturn($routeStack);
        $service
            ->expects($this->once())
            ->method('getRouter')
            ->willReturn($routerMock);
        /** @var EntryPointService $service */

        $expected = [
            'foo' => '/foo'
        ];
        $this->assertEquals($expected, $service->findChildRouteNames($routeMatchMock));
    }

    /**
     * @covers \FinalGene\RestApiEntryPointModule\Service\EntryPointService::findRoute
     */
    public function testFindRouteWillReturnNull()
    {
        $routerMock = $this->getMockBuilder(RouteInterface::class)
            ->getMock();

        $service = new EntryPointService();

        $method = $this->getMethod('findRoute');
        $result = $method->invokeArgs($service, [$routerMock, '']);

        $this->assertNull($result);
    }

    /**
     * @covers \FinalGene\RestApiEntryPointModule\Service\EntryPointService::findRoute
     */
    public function testFindRouteWithSingleRoute()
    {
        $routeMock = $this->getMockBuilder(TreeRouteStack::class)
            ->getMock();

        $routerMock = $this->getMockBuilder(TreeRouteStack::class)
            ->setMethods([
                'getRoute',
            ])
            ->getMock();
        $routerMock
            ->expects($this->once())
            ->method('getRoute')
            ->with('foo')
            ->willReturn($routeMock);

        $service = new EntryPointService();

        $method = $this->getMethod('findRoute');
        $result = $method->invokeArgs($service, [$routerMock, 'foo']);

        $this->assertEquals($routeMock, $result);
    }

    /**
     * @covers \FinalGene\RestApiEntryPointModule\Service\EntryPointService::findRoute
     */
    public function testFindRouteRecursiveCall()
    {
        $routeMock = $this->getMockBuilder(TreeRouteStack::class)
            ->getMock();

        $routerMock = $this->getMockBuilder(TreeRouteStack::class)
            ->setMethods([
                'getRoute',
            ])
            ->getMock();
        $routerMock
            ->expects($this->any())
            ->method('getRoute')
            ->withConsecutive(
                ['foo'],
                ['bar']
            )
            ->willReturnOnConsecutiveCalls(
                $routeMock,
                $routeMock
            );

        $service = new EntryPointService();

        $method = $this->getMethod('findRoute');
        $result = $method->invokeArgs($service, [$routerMock, 'foo/bar']);

        $this->assertNull($result);
    }

    /**
     * @param $name
     *
     * @return \ReflectionMethod
     */
    protected function getMethod($name)
    {
        $class = new \ReflectionClass(EntryPointService::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}

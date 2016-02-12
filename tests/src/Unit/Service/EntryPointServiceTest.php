<?php
/**
 * Entry point service test file
 *
 * @copyright Copyright (c) 2016, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\RestApiEntryPointModuleTest\Unit\Service;

use FinalGene\RestApiEntryPointModule\Service\EntryPointService;
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
     * @covers \FinalGene\RestApiEntryPointModule\Service\EntryPointService::findChildRouteNames()
     *
     * @uses   \FinalGene\RestApiEntryPointModule\Service\EntryPointService::getRouter()
     * @uses   \FinalGene\RestApiEntryPointModule\Service\EntryPointService::setRouter()
     * @uses   \FinalGene\RestApiEntryPointModule\Service\EntryPointService::findRoute()
     */
    public function testFetchAllEntryPointService()
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
}

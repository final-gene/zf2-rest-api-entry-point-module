<?php
/**
 * Entry point service factory test file
 *
 * @copyright Copyright (c) 2016, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\RestApiEntryPointModuleTest\Unit\Service;

use FinalGene\RestApiEntryPointModule\Service\EntryPointService;
use Zend\Test\Util\ModuleLoader;

/**
 * Class EntryPointResourceFactoryTest
 */
class EntryPointServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        /* @noinspection PhpIncludeInspection */
        $moduleLoader = new ModuleLoader(require 'config/application.config.php');
        $this->serviceManager = $moduleLoader->getServiceManager();
    }

    /**
     * Get the service manager
     *
     * @return \Zend\ServiceManager\ServiceManager
     */
    protected function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @covers \FinalGene\RestApiEntryPointModule\Service\EntryPointServiceFactory::createService
     * @uses \FinalGene\RestApiEntryPointModule\Service\EntryPointService
     * @uses \FinalGene\RestApiEntryPointModule\Module
     */
    public function testCreateService()
    {
        $this->assertInstanceOf(
            EntryPointService::class,
            $this->getServiceManager()->get(EntryPointService::class)
        );
    }
}

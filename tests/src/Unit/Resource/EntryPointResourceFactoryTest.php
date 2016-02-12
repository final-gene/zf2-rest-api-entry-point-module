<?php
/**
 * Entry point resource factory test file
 *
 * @copyright Copyright (c) 2016, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\RestApiEntryPointModuleTest\Unit\Service;

use FinalGene\RestApiEntryPointModule\Resource\EntryPointResource;
use Zend\Test\Util\ModuleLoader;

/**
 * Class EntryPointResourceFactoryTest
 */
class EntryPointResourceFactoryTest extends \PHPUnit_Framework_TestCase
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
     * @covers \FinalGene\RestApiEntryPointModule\Resource\EntryPointResourceFactory::createService
     * @uses \FinalGene\RestApiEntryPointModule\Resource\EntryPointResource
     * @uses \FinalGene\RestApiEntryPointModule\Service\EntryPointService
     * @uses \FinalGene\RestApiEntryPointModule\Service\EntryPointServiceFactory
     * @uses \FinalGene\RestApiEntryPointModule\Module
     */
    public function testCreateService()
    {
        $this->assertInstanceOf(
            EntryPointResource::class,
            $this->getServiceManager()->get(EntryPointResource::class)
        );
    }
}

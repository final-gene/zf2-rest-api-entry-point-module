<?php
/**
 * Entry point service factory test file
 *
 * @copyright Copyright (c) 2016, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\RestApiEntryPointModuleTest\Integration\Service;

use FinalGene\RestApiEntryPointModule\Service\EntryPointService;
use Zend\Test\Util\ModuleLoader;

/**
 * Entry point service factory test
 *
 * @package FinalGene\RestApiEntryPointModuleTest\Integration\Service
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
        $moduleLoader = new ModuleLoader(require 'resources/Integration/config/application.config.php');
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
     * Test if the entry point service can be created from the factory
     */
    public function testCreateEntryPointService()
    {
        $this->assertInstanceOf(
            EntryPointService::class,
            $this->getServiceManager()->get(EntryPointService::class)
        );
    }
}

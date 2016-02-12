<?php
/**
 * Entry point resource factory test file
 *
 * @copyright Copyright (c) 2016, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\RestApiEntryPointModuleTest\Integration\Resource;

use FinalGene\RestApiEntryPointModule\Resource\EntryPointResource;
use Zend\Test\Util\ModuleLoader;

/**
 * Entry point resource factory test
 *
 * @package FinalGene\RestApiEntryPointModuleTest\Integration\Resource
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
     * Test if the entry point resource can be created from the factory
     */
    public function testCreateEntryPointResource()
    {
        $this->assertInstanceOf(
            EntryPointResource::class,
            $this->getServiceManager()->get(EntryPointResource::class)
        );
    }
}

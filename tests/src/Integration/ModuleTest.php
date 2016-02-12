<?php
/**
 * Module test file
 *
 * @copyright Copyright (c) 2016, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\RestApiEntryPointModuleTest\Integration;

use FinalGene\RestApiEntryPointModule\Module;
use Zend\Test\Util\ModuleLoader;

/**
 * Module test
 *
 * @package FinalGene\RestApiEntryPointModuleTest
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The module loader
     *
     * @var ModuleLoader
     */
    protected $moduleLoader;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        /* @noinspection PhpIncludeInspection */
        $this->moduleLoader = new ModuleLoader(require 'config/application.config.php');
    }

    /**
     * Test if the module can be loaded
     */
    public function testModuleIsLoadable()
    {
        /** @var \Zend\ModuleManager\ModuleManager $moduleManager */
        $moduleManager = $this->moduleLoader->getModuleManager();

        $this->assertNotNull(
            $moduleManager->getModule('FinalGene\RestApiEntryPointModule'),
            'Module could not be initialized'
        );
        $this->assertInstanceOf(
            Module::class,
            $moduleManager->getModule('FinalGene\RestApiEntryPointModule')
        );
    }
}

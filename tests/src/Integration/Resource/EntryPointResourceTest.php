<?php
/**
 * Entry point resource test file
 *
 * @copyright Copyright (c) 2016, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\RestApiEntryPointModuleTest\Integration\Resource;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Entry point resource test
 *
 * @package FinalGene\RestApiEntryPointModuleTest\Integration\Resource
 */
class EntryPointResourceTest extends AbstractHttpControllerTestCase
{
    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        /* @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(require 'resources/Integration/config/application.config.php');

        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();
        $request->getHeaders()->addHeaderLine('Accept', 'application/hal+json');
    }

    /**
     * Test if all link of the entry point can be fetched
     */
    public function testFetchAllLinks()
    {
        $expectedJson = json_encode([
            '_links' => [
                'self' => [
                    'href' => 'http://phpunit.local/api/rest'
                ],
                'foo' => [
                    'href' => 'http://phpunit.local/api/rest/foo'
                ],
                'bar' => [
                    'href' => 'http://phpunit.local/api/rest/bar'
                ],
                'baz' => [
                    'href' => 'http://phpunit.local/api/rest/baz'
                ]
            ]
        ]);

        $this->dispatch('/api/rest');
        $this->assertResponseStatusCode(200);

        $actualJson = $this->getResponse()->getContent();
        $this->assertJson($actualJson);
        $this->assertJsonStringEqualsJsonString($expectedJson, $actualJson);
    }
}

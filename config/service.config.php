<?php
/**
 * Service manager config file
 *
 * @copyright Copyright (c) 2016, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\RestApiEntryPointModule;

return [
    'service_manager' => [
        'initializers' => [
        ],
        'invokables' => [
        ],
        'factories' => [
            Resource\EntryPointResource::class => Resource\EntryPointResourceFactory::class,
            Service\EntryPointService::class => Service\EntryPointServiceFactory::class,
        ],
    ],
];

<?php
/**
 * Application config file
 *
 * @copyright Copyright (c) 2016, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

return [
    'modules' => [
        'ZF\ApiProblem',
        'ZF\ContentNegotiation',
        'ZF\Hal',
        'ZF\Rest',
        'FinalGene\UriTemplateModule',
        'FinalGene\RestApiEntryPointModule',
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php',
        ],
        'check_dependencies' => true,
    ],
];

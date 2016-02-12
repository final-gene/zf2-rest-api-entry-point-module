# RestApiEntryPointModule

Provides a REST resource which represents an entry point of the API.

## Installation

After composer is available in your path you are ready to install this module.

```
composer require final-gene/rest-api-entry-point-module
```

Then add `FinalGene\RestApiEntryPointModule` to your application config file.

## Configuration

You may now configure a virtual entry point controller (e.g. `FinalGene\RestApiEntryPointModule\EntryPointController`)
which will actually map the `FinalGene\RestApiEntryPointModule\Resource\EntryPointResource` as listener.

Here is an example for a possible REST configuration:

```
return [
    'zf-rest' => [
        'FinalGene\RestApiEntryPointModule\EntryPointController' => [
            'listener' => FinalGene\RestApiEntryPointModule\Resource\EntryPointResource::class,
            'route_name' => 'api/rest',
            'collection_name' => null,
            'collection_http_methods' => [
                'GET',
            ],
        ],
    ],
];
```

A resulting router configuration could be the following one:

```
return [
    'router' => [
        'routes' => [
            'api' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/api',
                'child_routes' => [
                    'rest' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/rest',
                            'defaults' => [
                                'controller' => 'FinalGene\RestApiEntryPointModule\EntryPointController',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
```

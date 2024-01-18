<?php
return [
    'service_manager' => [
        'factories' => [
            \API\V1\Rest\Cotacao\CotacaoResource::class => \API\V1\Rest\Cotacao\CotacaoResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'api.rest.cotacao' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/cotacao[/:cotacao_id]',
                    'defaults' => [
                        'controller' => 'API\\V1\\Rest\\Cotacao\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'api.rest.cotacao',
        ],
    ],
    'api-tools-rest' => [
        'API\\V1\\Rest\\Cotacao\\Controller' => [
            'listener' => \API\V1\Rest\Cotacao\CotacaoResource::class,
            'route_name' => 'api.rest.cotacao',
            'route_identifier_name' => 'cotacao_id',
            'collection_name' => 'cotacao',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'id_usuario',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \API\V1\Rest\Cotacao\CotacaoEntity::class,
            'collection_class' => \API\V1\Rest\Cotacao\CotacaoCollection::class,
            'service_name' => 'cotacao',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'API\\V1\\Rest\\Cotacao\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'API\\V1\\Rest\\Cotacao\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'API\\V1\\Rest\\Cotacao\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \API\V1\Rest\Cotacao\CotacaoEntity::class => [
                'entity_identifier_name' => 'id_cotacao',
                'route_name' => 'api.rest.cotacao',
                'route_identifier_name' => 'cotacao_id',
                'hydrator' => \Laminas\Hydrator\ObjectPropertyHydrator::class,
            ],
            \API\V1\Rest\Cotacao\CotacaoCollection::class => [
                'entity_identifier_name' => 'id_cotacao',
                'route_name' => 'api.rest.cotacao',
                'route_identifier_name' => 'cotacao_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authorization' => [
            'API\\V1\\Rest\\Cotacao\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
];

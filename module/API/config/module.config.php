<?php
return [
    'service_manager' => [
        'factories' => [
            \API\V1\Rest\Cotacao\CotacaoResource::class => \API\V1\Rest\Cotacao\CotacaoResourceFactory::class,
            \API\V1\Rest\CalcularFrete\CalcularFreteResource::class => \API\V1\Rest\CalcularFrete\CalcularFreteResourceFactory::class,
            \API\V1\Rest\Auth\AuthResource::class => \API\V1\Rest\Auth\AuthResourceFactory::class,
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
            'api.rest.calcular-frete' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/calcular-frete[/:calcular_frete_id]',
                    'defaults' => [
                        'controller' => 'API\\V1\\Rest\\CalcularFrete\\Controller',
                    ],
                ],
            ],
            'api.rest.auth' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/auth[/:auth_id]',
                    'defaults' => [
                        'controller' => 'API\\V1\\Rest\\Auth\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'api.rest.cotacao',
            1 => 'api.rest.calcular-frete',
            2 => 'api.rest.auth',
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
        'API\\V1\\Rest\\CalcularFrete\\Controller' => [
            'listener' => \API\V1\Rest\CalcularFrete\CalcularFreteResource::class,
            'route_name' => 'api.rest.calcular-frete',
            'route_identifier_name' => 'calcular_frete_id',
            'collection_name' => 'calcular_frete',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'cep_origem',
                1 => 'cep_destino',
                2 => 'altura',
                3 => 'largura',
                4 => 'comprimento',
                5 => 'peso',
                6 => 'valor',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \API\V1\Rest\CalcularFrete\CalcularFreteEntity::class,
            'collection_class' => \API\V1\Rest\CalcularFrete\CalcularFreteCollection::class,
            'service_name' => 'CalcularFrete',
        ],
        'API\\V1\\Rest\\Auth\\Controller' => [
            'listener' => \API\V1\Rest\Auth\AuthResource::class,
            'route_name' => 'api.rest.auth',
            'route_identifier_name' => 'auth_id',
            'collection_name' => 'auth',
            'entity_http_methods' => [
                0 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \API\V1\Rest\Auth\AuthEntity::class,
            'collection_class' => \API\V1\Rest\Auth\AuthCollection::class,
            'service_name' => 'Auth',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'API\\V1\\Rest\\Cotacao\\Controller' => 'Json',
            'API\\V1\\Rest\\CalcularFrete\\Controller' => 'Json',
            'API\\V1\\Rest\\Auth\\Controller' => 'Json',
        ],
        'accept_whitelist' => [
            'API\\V1\\Rest\\Cotacao\\Controller' => [
                0 => 'application/json',
            ],
            'API\\V1\\Rest\\CalcularFrete\\Controller' => [
                0 => 'application/json',
            ],
            'API\\V1\\Rest\\Auth\\Controller' => [
                0 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'API\\V1\\Rest\\Cotacao\\Controller' => [
                0 => 'application/json',
            ],
            'API\\V1\\Rest\\CalcularFrete\\Controller' => [
                0 => 'application/json',
            ],
            'API\\V1\\Rest\\Auth\\Controller' => [
                0 => 'application/json',
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
            \API\V1\Rest\CalcularFrete\CalcularFreteEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.calcular-frete',
                'route_identifier_name' => 'calcular_frete_id',
                'hydrator' => \Laminas\Hydrator\ObjectPropertyHydrator::class,
            ],
            \API\V1\Rest\CalcularFrete\CalcularFreteCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.calcular-frete',
                'route_identifier_name' => 'calcular_frete_id',
                'is_collection' => true,
            ],
            \API\V1\Rest\Auth\AuthEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.auth',
                'route_identifier_name' => 'auth_id',
                'hydrator' => \Laminas\Hydrator\ObjectPropertyHydrator::class,
            ],
            \API\V1\Rest\Auth\AuthCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.auth',
                'route_identifier_name' => 'auth_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authorization' => [
            'API\\V1\\Rest\\Cotacao\\Controller' => [
                'collection' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
    'api-tools-content-validation' => [
        'API\\V1\\Rest\\CalcularFrete\\Controller' => [
            'input_filter' => 'API\\V1\\Rest\\CalcularFrete\\Validator',
        ],
        'API\\V1\\Rest\\Cotacao\\Controller' => [
            'input_filter' => 'API\\V1\\Rest\\Cotacao\\Validator',
        ],
        'API\\V1\\Rest\\Auth\\Controller' => [
            'input_filter' => 'API\\V1\\Rest\\Auth\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'API\\V1\\Rest\\CalcularFrete\\Validator' => [],
        'API\\V1\\Rest\\Cotacao\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'id_usuario',
                'error_message' => 'Informe o id do usuario',
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'id_servico',
                'error_message' => 'Informe o id do servico',
            ],
            2 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'valor',
                'error_message' => 'Informe o valor',
            ],
        ],
        'API\\V1\\Rest\\Auth\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'login',
                'error_message' => 'Informe o login',
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'senha',
                'error_message' => 'Informe a senha',
            ],
        ],
    ],
];

<?php
namespace API\V1\Rest\Cotacao;

class CotacaoResourceFactory
{
    public function __invoke($services)
    {
        return new CotacaoResource();
    }
}

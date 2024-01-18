<?php
namespace API\V1\Rest\CalcularFrete;

class CalcularFreteResourceFactory
{
    public function __invoke($services)
    {
        return new CalcularFreteResource();
    }
}

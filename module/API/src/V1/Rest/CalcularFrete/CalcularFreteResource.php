<?php
namespace API\V1\Rest\CalcularFrete;

use API\Utils\Utils;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;
use Laminas\Stdlib\Parameters;

class CalcularFreteResource extends AbstractResourceListener
{
    private $adapter;
    private $header;
    private $tokenValidate;

    public function __construct()
    {
        Utils::timezone();
        $this->adapter = Utils::DBConnection();
        $this->header = Utils::getHeader();
        $this->tokenValidate = Utils::validateToken();
    }
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array|Parameters $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        if($this->tokenValidate) {
            return new ApiProblem(400, $this->tokenValidate["detail"]);
        }

        if($this->emptyInputs($params)) {
            return $this->emptyInputs($params);
        }

        $pesoVolume = ($params["altura"] * $params["largura"] * $params["comprimento"]) / 5000;
        $pesoInicio = floatval(min($params["peso"],$pesoVolume));
        $pesoFim = floatval(max($params["peso"],$pesoVolume));

        $fretes = $this->adapter->query("select * from vtex_valores
        INNER JOIN servicos ON servicos.id_servico = vtex_valores.id_servico
        INNER JOIN transportadoras ON servicos.id_transportadora = transportadoras.id where
        cep_inicio = ? and cep_final = ? and valor <= ? and peso_inicial <= ? and peso_final <= ?",
            [
                $params["cep_origem"],
                $params["cep_destino"],
                $params["valor"],
                $pesoInicio,
                $pesoFim
            ]
        );
        if(count($fretes) == 0){
            return new ApiProblem(404,"Nenhum frete encontrado!");
        }

        $return = array();

        foreach ($fretes as $frete)
        {
            array_push($return,[
                "id" => $frete["id"],
                "prazo_entrega"=> $frete["prazo_entrega"],
                "peso_inicial"=> $frete["peso_inicial"],
                "peso_final"=> $frete["peso_final"],
                "valor"=> $frete["valor"],
                "cep_inicio"=> $frete["cep_inicio"],
                "cep_final"=> $frete["cep_final"],
                "valor" => $frete["valor"],
                "servico" => [
                    "id" => $frete["id_servico"],
                    "nome" => $frete["nm_servico"],
                    "transportadora" => [
                        "id" => $frete["id_transportadora"],
                        "nome" => $frete["nm_transportadora"]
                    ]
                ]
            ]);
        }
        return $return;
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }

    public function emptyInputs($params = []){
        if(!$params["altura"]) {
            return new ApiProblem(422, "Informe a altura");
        }
        if(!$params["largura"]) {
            return new ApiProblem(422, "Informe a largura");
        }
        if(!$params["comprimento"]) {
            return new ApiProblem(422, "Informe o comprimento");
        }
        if(!$params["peso"]) {
            return new ApiProblem(422, "Informe o peso");
        }
        if(!$params["valor"]) {
            return new ApiProblem(422, "Informe o valor");
        }
        return false;
    }
}

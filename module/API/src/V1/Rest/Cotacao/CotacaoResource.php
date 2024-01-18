<?php
namespace API\V1\Rest\Cotacao;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Db\Adapter\Adapter;
use Laminas\Stdlib\Parameters;
use Laminas\Db\Sql\Sql;

class CotacaoResource extends AbstractResourceListener
{
    private $adapter;

    public function __construct()
    {
        $this->adapter = new Adapter([
            'driver'   => 'PDO_Mysql',
            'database' => 'clube_envios',
            'username' => 'root',
            'password' => '',
        ]);
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $sql = new Sql($this->adapter);

        $insert = $sql->insert();
        $insert->into("cotacao");
        $insert->columns(["id_usuario","id_servico","valor"]);
        $insert->values([
            'id_usuario' => $data->id_usuario,
            'id_servico' => $data->id_servico,
            'valor' => $data->valor,
        ], $insert::VALUES_MERGE);
        $insertString = $sql->buildSqlString($insert);
        $results = $this->adapter->query($insertString, $this->adapter::QUERY_MODE_EXECUTE);

        $results->current();
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
        $sql = new Sql($this->adapter);

        $select = $sql->select();
        $select->from('cotacao');
        $select->columns(["id_cotacao","id_servico","valor"]);
        $select->where(['id_cotacao' => $id]);
        $select->join("usuarios","cotacao.id_usuario = usuarios.id",["id","nome"]);
        $select->join("servicos","cotacao.id_servico = servicos.id_servico",["id_servico","nm_servico","id_transportadora"]);
        $select->join("transportadoras","servicos.id_transportadora = transportadoras.id",["nm_transportadora"]);

        $selectString = $sql->buildSqlString($select);
        $results = $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE)->toArray();

        if(count($results) == 0){
            return new ApiProblem(404,"Essa cotação não existe!");
        }
        $return = array();


        foreach ($results as $result)
        {
            array_push($return,[
                "id_cotacao" => $result["id_cotacao"],
                "id_servico" => $result["id_servico"],
                "valor" => $result["valor"],
                "usuario" => [
                    "id"=> $result["id"],
                    "nome"=> $result["nome"],
                ],
                "servicos" => [
                    "id"=>$result["id_servico"],
                    "nome"=>$result["nm_servico"],
                    "transportadora" => [
                        "id" => $result["id_transportadora"],
                        "nome" => $result["nm_transportadora"]
                    ]
                ]
            ]);
        }

        return $return[0];
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array|Parameters $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('cotacao');
        $select->columns(["id_cotacao","id_servico","valor"]);
        $select->join("usuarios","cotacao.id_usuario = usuarios.id",["id","nome"]);
        $select->join("servicos","cotacao.id_servico = servicos.id_servico",["id_servico","nm_servico","id_transportadora"]);
        $select->join("transportadoras","servicos.id_transportadora = transportadoras.id",["nm_transportadora"]);

        if($params['id_usuario']) {
            $select->where(['id_usuario' => $params['id_usuario']]);

            $selectString = $sql->buildSqlString($select);
            $results = $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE)->toArray();

            if(count($results) == 0){
                return new ApiProblem(404,"Essa cotação não existe!");
            }
            $return = array();

            foreach ($results as $result)
            {
                array_push($return,[
                    "id_cotacao" => $result["id_cotacao"],
                    "id_servico" => $result["id_servico"],
                    "valor" => $result["valor"],
                    "usuario" => ["id"=>$result["id"],"nome"=>$result["nome"]],
                    "servicos" => [
                        "id"=>$result["id_servico"],
                        "nome"=>$result["nm_servico"],
                        "transportadora" => [
                            "id" => $result["id_transportadora"],
                            "nome" => $result["nm_transportadora"]
                        ]
                    ]
                ]);
            }

            return $return ;
        }
        $selectString = $sql->buildSqlString($select);
        $results = $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE)->toArray();

        if(count($results) == 0){
            return new ApiProblem(404,"Nenhuma cotação cadastrada!");
        }
        $return = array();

        foreach ($results as $result)
        {
            array_push($return,[
                "id_cotacao" => $result["id_cotacao"],
                "id_servico" => $result["id_servico"],
                "valor" => $result["valor"],
                "usuario" => ["id"=>$result["id"],"nome"=>$result["nome"]],
                "servicos" => ["id"=>$result["id_servico"],"nome"=>$result["nm_servico"]]
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
}

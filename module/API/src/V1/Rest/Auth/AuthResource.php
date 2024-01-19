<?php

declare(strict_types=1);

namespace API\V1\Rest\Auth;

use API\Utils\Utils;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Stdlib\Parameters;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;


class AuthResource extends AbstractResourceListener
{
    private $adapter;
    private $header;

    public function __construct()
    {
        $this->adapter = Utils::DBConnection();
        $this->header = Utils::getHeader();
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $sql    = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('usuarios');
        $select->where(['login' => $data->login]);
        $select->where(['senha' => $data->senha]);
        $selectString = $sql->buildSqlString($select);
        $results      = $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE)->toArray();

        if (count($results) == 0) {
            return new ApiProblem(401, 'Login ou senha inválidos');
        }
        $token = $sql->select();
        $token->from('access_token');
        $token->columns(["id_usuario"]);
        $token->where(['id_usuario' => $results[0]['id']]);
        $selectString = $sql->buildSqlString($token);
        $verifyToken  = $this->adapter->query($selectString, $this->adapter::QUERY_MODE_EXECUTE)->toArray();

        if (count($verifyToken) == 0) {
            $insert = $sql->insert();
            $insert->into("access_token");
            $insert->columns(["access_token", "id_usuario", "expires_in", "dt_criacao"]);
            $insert->values([
                'access_token' => md5($results[0]['login'].$results[0]['senha']),
                'id_usuario'   => $results[0]['id'],
                'expires_in'   => strtotime('+1 day', time()),
                'dt_criacao'   => date("Y-m-d H:i:s"),
            ], $insert::VALUES_MERGE);
            $insertString = $sql->buildSqlString($insert);
            $this->adapter->query($insertString, $this->adapter::QUERY_MODE_EXECUTE);

            return [
                "id_usuario"=>$results[0]['id'],
                "nome"=>$results[0]['nome'],
                "token"=>md5($results[0]['login'].$results[0]['senha'])
            ];
        } else {
            $update = $sql->update("access_token");
            $update->set([
                'access_token' => md5($results[0]['login'].$results[0]['senha']),
                'expires_in'   => strtotime('+1 day', time()),
                'dt_criacao'   => date("Y-m-d H:i:s"),
            ], $update::VALUES_MERGE);

            $updateString = $sql->buildSqlString($update);
            $this->adapter->query($updateString, $this->adapter::QUERY_MODE_EXECUTE);

            return [
                "id_usuario"=>$results[0]['id'],
                "nome"=>$results[0]['nome'],
                "token"=>md5($results[0]['login'].$results[0]['senha'])
            ];
        }
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
        return new ApiProblem(405, 'The GET method has not been defined for collections');
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

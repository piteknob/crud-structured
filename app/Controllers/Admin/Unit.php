<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use App\Controllers\Core\DataController;
use CodeIgniter\HTTP\ResponseInterface;

class Unit extends AuthController
{
    public function index()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $query['data'] = ['unit'];

        $query['select'] = [
            'unit_id' => 'id',
            'unit_name' => 'unit',
        ];

        $query['where_detail'] = [
            'WHERE unit_deleted_at IS NULL'
        ];

        $query['pagination'] = [
            'pagination' => false
        ];

        // $query['limit'] = [
        //     'limit' => 1,
        // ];

        $data = generateListData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Unit', $data);
    }

    public function insert()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $post = $this->request->getPost();
        $db = db_connect();


        $unit = htmlspecialchars($post['unit']);


        $sql = "INSERT INTO unit VALUES ('', '{$unit}', NULL)";
        $sql = $db->query($sql);
        $id = $db->insertID();

        $query['data'] = ['unit'];

        $query['select'] = [
            'unit_id' => 'id',
            'unit_name' => 'unit',
        ];

        $query['where_detail'] = [
            " WHERE unit_id = {$id}"
        ];

        $data = generateDetailData($this->request->getPost(), $query, $db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Added', $data);
    }


    public function update()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $db = db_connect();
        $post = $this->request->getPost();

        $id = $_GET;
        $id = $id['id'];

        $unit = htmlspecialchars($post['unit']);

        $sql = "UPDATE unit SET unit_name = '{$unit}' WHERE unit_id = {$id}";
        $sql = $db->query($sql);

        $updateStock = "UPDATE product_stock SET product_stock_unit_name = (SELECT unit_name FROM unit WHERE unit_id = {$id})";
        $db->query($updateStock);


        $query['data'] = ['unit'];

        $query['select'] = [
            'unit_id' => 'id',
            'unit_name' => 'unit',
        ];

        $query['where_detail'] = [
            " WHERE unit_id = {$id}"
        ];

        $data = generateDetailData($this->request->getVar(), $query, $db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Updated', $data);
    }

    public function softDelete()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $db = db_connect();

        $id = $this->request->getVar();
        foreach ($id as $key => $value) {
            $id = $value;
        }

        $query['data'] = ['unit'];

        $query['select'] = [
            'unit_id' => 'id',
            'unit_name' => 'unit',
        ];

        $query['where'] = [
            'unit_id' => $id
        ];

        $data = generateDetailData($this->request->getVar(), $query, $this->db);

        $sql = "UPDATE unit SET unit_deleted_at = NOW() WHERE unit_id = {$id}";

        $db->query($sql);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Deleted', $data);
    }

    public function restore()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $db = db_connect();

        $id = $this->request->getVar();
        foreach ($id as $key => $value) {
            $id = $value;
        }

        $query['data'] = ['unit'];

        $query['select'] = [
            'unit_id' => 'id',
            'unit_name' => 'unit',
        ];

        $query['where'] = [
            'unit_id' => $id
        ];

        $data = generateDetailData($this->request->getVar(), $query, $this->db);

        $sql = "UPDATE unit SET unit_deleted_at = NULL WHERE unit_id = {$id}";

        $db->query($sql);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Restored', $data);
    }

    public function delete($id = null)
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $db = db_connect();
        $id = $this->request->getVar();
        foreach ($id as $key => $value) {
            $id = $value;
        }

        $query['data'] = ['unit'];

        $query['select'] = [
            'unit_id' => 'id',
            'unit_name' => 'unit',
        ];

        $query['where_detail'] = [
            "WHERE unit_id = {$id}"
        ];

        $data = generateDetailData($this->request->getVar(), $query, $db);


        $sql = "DELETE FROM unit WHERE unit_id = {$id}";
        $sql = $db->query($sql);
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Permanently Deleted', $data);
    }
}

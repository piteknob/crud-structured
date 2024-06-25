<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use App\Controllers\Core\DataController;
use CodeIgniter\HTTP\ResponseInterface;
use Predis\Connection\Replication\ReplicationInterface;

class User extends AuthController
{
    public function index() 
    {
        $query['data'] = ['user'];
        $query['select'] = [
            'user_id' => 'id',
            'user_email' => 'email',
            'user_password' => 'password',
        ];
        $query['pagination'] = [
            'pagination' => true
        ];

        $data = generateListData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List User', $data);
    }
}
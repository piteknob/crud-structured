<?php

namespace App\Controllers;

use App\Controllers\Core\DataController;
use CodeIgniter\HTTP\ResponseInterface;

class Log extends DataController
{
    public function index()
    {
        $query['data'] = ['log_stock'];

        $query['select'] = [
            'log_stock_id' => 'stock_id',
            'log_stock_product_id' => 'product_id',
            'log_stock_product_name' => 'product',
            'log_stock_status' => 'status',
            'log_stock_value' => 'value',
            'log_stock_category_id' => 'category_id',
            'log_stock_category_name' => 'category',
            'log_stock_unit_id' => 'unit_id',
            'log_stock_unit_name' => 'unit',
            'log_stock_date' => 'date',
        ];

        $query['limit'] = [
            'limit' => 10
        ];

        $query['pagination'] = [
            'pagination' => true
        ];

        $data = generateListData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Log Data', $data);
    }
}

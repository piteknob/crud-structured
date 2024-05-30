<?php

namespace App\Controllers;

use App\Controllers\Core\DataController;
use CodeIgniter\HTTP\ResponseInterface;

class Stock extends DataController
{
    public function index()
    {
        $query['data'] = ['product_stock'];

        $query['select'] = [
            'product_stock_id' => 'id',
            'product_stock_product_id' => 'id_product',
            'product_stock_product_name' => 'product',
            'product_stock_unit_name' => 'unit',
            'product_stock_value' => 'stock',
            'product_stock_price_buy' => 'price_buy',
            'product_stock_price_sell' => 'price_sell',
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

    public function update()
    {
        $id = $this->request->getVar();
        $post = $this->request->getPost();
        $id = $id['id'];
        $db = db_connect();

        $stock = htmlspecialchars($post['stock']);
        $buy = htmlspecialchars($post['buy']);
        $sell = htmlspecialchars($post['sell']);

        $sql = "UPDATE product_stock SET
        product_stock_value = {$stock},
        product_stock_price_buy = {$buy},
        product_stock_price_sell = {$sell}
        WHERE product_stock_product_id = {$id};";

        $db->query($sql);

        $query['data'] = ['product_stock'];

        $query['select'] = [
            'product_stock_product_name' => 'product',
            'product_stock_value' => 'stock',
            'product_stock_price_buy' => 'buy',
            'product_stock_price_sell' => 'sell',
        ];

        $query['where_detail'] = [
            " WHERE product_stock_product_id = '{$id}'"
        ];

        $data = generateDetailData($this->request->getVar(), $query, $db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Stock Successfully Updated', $data);
    }

    public function reduce()
    {
        $db = db_connect();
        $id = $this->request->getVar();
        $post = $this->request->getPost();
        $id = $id['id'];

        $value = htmlspecialchars($post['value']);
        $category = htmlspecialchars($post['category']);
        $unit = htmlspecialchars($post['unit']);

        $query1['data'] = ['product_stock'];

        $query1['select'] = [
            'product_stock_product_name' => 'product',
            'product_stock_value' => 'value',
        ];

        $query1['where_detail'] = [
            " WHERE product_stock_product_id = '{$id}'"
        ];

        $data1 = generateDetailData($this->request->getVar(), $query1, $db);

        $sql = "UPDATE product_stock SET product_stock_value = product_stock_value - {$value} WHERE product_stock_product_id = '{$id}'";
        $db->query($sql);

        $log = "INSERT INTO log_stock (log_stock_product_id, log_stock_product_name, log_stock_status, log_stock_value, log_stock_category_id, log_stock_category_name, log_stock_unit_id, log_stock_unit_name, log_stock_date)
            SELECT product_id, product_name, 'reduce', {$value}, category_id, category_name, unit_id, unit_name, NOW()
            FROM product, category, unit
            WHERE product_id = '$id' AND category_id = '$category' AND unit_id = '$unit'";

        $db->query($log);

        $query2['data'] = ['product_stock'];

        $query2['select'] = [
            'product_stock_product_name' => 'product',
            'product_stock_value' => 'value',
        ];

        $query2['where_detail'] = [
            " WHERE product_stock_product_id = '{$id}'"
        ];

        $data2 = generateDetailData($this->request->getVar(), $query2, $db);

        $data = [
            'before' => $data1,
            'after' => $data2,
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Reduced', $data);
    }

    public function add()
    {
        $db = db_connect();
        $id = $this->request->getVar();
        $post = $this->request->getPost();
        $id = $id['id'];

        $value = htmlspecialchars($post['value']);
        $category = htmlspecialchars($post['category']);
        $unit = htmlspecialchars($post['unit']);

        $query1['data'] = ['product_stock'];

        $query1['select'] = [
            'product_stock_product_name' => 'product',
            'product_stock_value' => 'value',
        ];

        $query1['where_detail'] = [
            " WHERE product_stock_product_id = '{$id}'"
        ];

        $data1 = generateDetailData($this->request->getVar(), $query1, $db);

        $sql = "UPDATE product_stock SET product_stock_value = product_stock_value + {$value} WHERE product_stock_product_id = '{$id}'";
        $db->query($sql);

        $log = "INSERT INTO log_stock (log_stock_product_id, log_stock_product_name, log_stock_status, log_stock_value, log_stock_category_id, log_stock_category_name, log_stock_unit_id, log_stock_unit_name, log_stock_date)
            SELECT product_id, product_name, 'reduce', {$value}, category_id, category_name, unit_id, unit_name, NOW()
            FROM product, category, unit
            WHERE product_id = '$id' AND category_id = '$category' AND unit_id = '$unit'";

        $db->query($log);

        $query2['data'] = ['product_stock'];

        $query2['select'] = [
            'product_stock_product_name' => 'product',
            'product_stock_value' => 'value',
        ];

        $query2['where_detail'] = [
            " WHERE product_stock_product_id = '{$id}'"
        ];

        $data2 = generateDetailData($this->request->getVar(), $query2, $db);

        $data = [
            'before' => $data1,
            'after' => $data2,
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Added', $data);
    }

    public function moveStock()
    {
        $post = $this->request->getPost();
        $db = db_connect();

        $data = [];

        $idO = $post["product_origin"];
        $stockO = $post["stock_origin"];
        $categoryO = $post['category_origin'];
        $unitO = $post["unit_origin"];
        $idD = $post["product_destination"];
        $stockD = $post["stock_destination"];
        $categoryD = $post['category_destination'];
        $unitD = $post["unit_destination"];

        $queryLogO = "INSERT INTO log_stock (log_stock_product_id, log_stock_product_name, log_stock_status, log_stock_value, log_stock_category_id, log_stock_category_name, log_stock_unit_id, log_stock_unit_name, log_stock_date)
            SELECT product_id, product_name, 'reduce', $stockO, category_id, category_name, unit_id, unit_name, NOW()
            FROM product, category, unit
            WHERE product_id = '$idO' AND category_id = '$categoryO' AND unit_id = '$unitO'";

        $db->query($queryLogO);

        $idOrigin = $db->insertID();

        $queryLogD = "INSERT INTO log_stock (log_stock_product_id, log_stock_product_name, log_stock_status, log_stock_value, log_stock_category_id, log_stock_category_name, log_stock_unit_id, log_stock_unit_name, log_stock_date)
            SELECT product_id, product_name, 'add', $stockD, category_id, category_name, unit_id, unit_name, NOW()
            FROM product, category, unit
            WHERE product_id = '$idD' AND category_id = '$categoryD' AND unit_id = '$unitD'";

        $db->query($queryLogD);

        $idDestination = $db->insertID();

        $queryStock = "UPDATE product_stock 
            SET product_stock_out = product_stock_out + $stockO, 
                product_stock_value = product_stock_value - $stockO 
            WHERE product_stock_product_id = $idO AND product_stock_unit_id = $unitO";

        $db->query($queryStock);

        $queryMove = "UPDATE product_stock
            SET product_stock_value = product_stock_value + $stockD,
                product_stock_in = product_stock_in + $stockD
            WHERE product_stock_product_id = $idD AND product_stock_unit_id = $unitD";

        $db->query($queryMove);

        $dataOrigin['data'] = ['log_stock'];

        $dataOrigin['select'] = [
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

        $dataOrigin['where_detail'] = [
            " WHERE log_stock_id = '{$idOrigin}'"
        ];

        $resultOrigin = generateDetailData($this->request->getVar(), $dataOrigin, $db);


        $dataDestination['data'] = ['log_stock'];

        $dataDestination['select'] = [
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

        $dataDestination['where_detail'] = [
            " WHERE log_stock_id = '{$idDestination}'"
        ];

        $resultDestination = generateDetailData($this->request->getVar(), $dataDestination, $db);


        $data = [
            'origin' => $resultOrigin,
            'destination' => $resultDestination
        ];

        
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Moved', $data);
    }
}

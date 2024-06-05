<?php

namespace App\Controllers;

use App\Controllers\Core\AuthController;
use App\Controllers\Core\DataController;
use CodeIgniter\HTTP\ResponseInterface;

class Transaction extends AuthController
{
    public function select()
    {
        $json = $this->request->getJSON();
        $db = db_connect();
        

        // --------------------------- VALIDATION PRODUCT ---------------------------- //
        foreach ($json->product as $key) {
            $validator = \Config\Services::validation();
            $validator->setRules([
                'product_name' => 'required',
                'product_category_id' => 'required',
                'product_unit_id' => 'required'
            ]);

            if (!$validator->run((array)$key)) {
                $error = $validator->getErrors();
                if ($error) {
                    return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'error validation', $error);
                }
            }
        }


        // validation customer
        foreach ($json->customer as $key) {
            $validator = \Config\Services::validation();
            $validator->setRules([
                'name' => 'required',
                'no_handphone' => 'required|min_length[10]|max_length[20]',
                'address' => 'required'
            ]);

            if (!$validator->run((array)$key)) {
                $error = $validator->getErrors();
                if ($error) {
                    return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'error validation', $error);
                }
            }
        }

        // check customer & add 
        foreach ($json->customer as $json) {
            $name = htmlspecialchars($json->name);
            $hp = $json->no_handphone;
            $address = $json->address;
            $error = [];

            $check = "SELECT customer_no_handphone, customer_name
            FROM customer
            WHERE customer_no_handphone = '{$hp}' AND customer_name = '{$name}'
            ;";

            // search id customer
            $idCustomer = "SELECT customer_id FROM customer WHERE customer_no_handphone = '{$hp}' AND customer_name = '{$name}'";
            $idCustomer = $db->query($idCustomer)->getResultArray();
            $idCustomer = $idCustomer[0]['customer_id'];


            $error = $db->query($check)->getResultArray();

            if (empty($error)) {
                $sql = "INSERT INTO customer (customer_id, customer_name, customer_address, customer_no_handphone)
                    VALUES ('', '{$name}', '{$address}', '{$hp}')";
                $sql = $db->query($sql);
                $idCustomer = $db->insertID();
            }
        }

        //------------------------------- CHECK PENDING -------------------------------//
        $query = "SELECT sales_order_status FROM sales_order WHERE sales_order_customer_id = ?";
        $pending = $db->query($query, [$idCustomer])->getResultArray();

        foreach ($pending as $key => $value) {
            $status = $value; // status
        }

        $selectHarga = "SELECT sales_order_price FROM sales_order WHERE sales_order_customer_id = {$idCustomer}";
        $selectHarga = $db->query($selectHarga)->getResultArray();
        
        $totalHarga = 0;
        foreach ($selectHarga as $key => $value) {
            $totalHarga += $value['sales_order_price'];
        }

        $status = $status['sales_order_status'];

        $gas['data'] = ['sales_order'];

        $gas['select'] = [
            'sales_order_product_name' => 'product_name',
            'sales_order_category' => 'category',
            'sales_order_unit' => 'unit',
            'sales_order_value' => 'total',
            'sales_order_price' => 'price'
        ];

        $gas['pagination'] = [
            'pagination' => false
        ];

        $gas = generateListData($this->request->getPost(), $gas, $db);

        $comeplete = (object) [];
        $comeplete->product = [
            $gas
        ];
        $comeplete->payment = [
            'price_total' => $totalHarga,
            'payment_method' => 'transfer',
        ];

        if ($status == 'pending') {
            return $this->responseFail(ResponseInterface::HTTP_FAILED_DEPENDENCY, 'please complete ur last order', '', $comeplete);
        }
        

        // ------------------------------ INSERT INTO TRANSACTION ------------------------------- //
        $coba = $this->request->getJSON();
        foreach ($coba->product as $json) {
            $product = htmlspecialchars($json->product_name);
            $category = $json->product_category_id;
            $unit = $json->product_unit_id;
            $value = $json->value;

            $sql = "INSERT INTO sales_order (sales_order_status, sales_order_product_name, sales_order_category, sales_order_unit, sales_order_value, sales_order_customer_id, sales_order_date, sales_order_proof)
            SELECT 'pending', product_name, category_name, unit_name, {$value}, {$idCustomer}, NOW(), NULL
            FROM product, unit, category
            WHERE product_id = '{$product}' AND category_id = '{$category}' AND unit_id = '{$unit}'
            ";
            $sql = $db->query($sql);
            $idSales = $db->insertID();

            $harga = "SELECT product_stock_price_sell
            FROM product_stock
            WHERE product_stock_product_id = {$product}
              AND product_stock_unit_id = {$unit}
              AND product_stock_product_id IN (SELECT product_id FROM product WHERE product_category_id = {$category});
            ";

            $harga = $db->query($harga)->getResultArray();
            $harga = $harga[0]['product_stock_price_sell'];

            $total = $harga * $value;
            
            $sqlHarga = "UPDATE sales_order SET sales_order_price = {$total} WHERE sales_order_id = {$idSales}";
            $db->query($sqlHarga);
            
        }

        // --------------------------------------- CHECK HARGA --------------------------------------- //
        $selectHarga = "SELECT sales_order_price FROM sales_order WHERE sales_order_date = NOW() AND sales_order_customer_id = {$idCustomer}";
        $selectHarga = $db->query($selectHarga)->getResultArray();
        
        $totalHarga = 0;
        foreach ($selectHarga as $key => $value) {
            $totalHarga += $value['sales_order_price'];
        }

        

        $query['data'] = ['sales_order'];
        $query['select'] = [
            'sales_order_product_name' => 'product_name',
            'sales_order_category' => 'category',
            'sales_order_unit' => 'unit',
            'sales_order_value' => 'total',
            'sales_order_price' => 'price'
        ];

        $query['where_detail'] = [
            "WHERE sales_order_customer_id = $idCustomer AND sales_order_date = NOW()"
        ];

        $query['pagination'] = [
            'pagination' => false
        ];

        $list = generateListData($this->request->getPost(), $query, $db);

        $data = (object) [];
        $data->product = [
            $list
        ];
        $data->payment = [
            'price_total' => $totalHarga,
            'payment_method' => 'transfer',
        ];


        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Total price', $data);
    }

    public function payed()
    {
        $id = $this->request->getVar();
        $id = $id['id'];
        $photo = $this->request->getFile('upload');
        $db = db_connect();
        
        print_r($photo);
        die;

    }
    
}

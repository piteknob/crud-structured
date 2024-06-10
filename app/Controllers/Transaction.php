<?php

namespace App\Controllers;

use App\Controllers\Core\AuthController;
use App\Controllers\Core\DataController;
use CodeIgniter\HTTP\ResponseInterface;
use Predis\Connection\Replication\ReplicationInterface;

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




            $error = $db->query($check)->getResultArray();

            if (empty($error)) {
                $sql = "INSERT INTO customer (customer_id, customer_name, customer_address, customer_no_handphone)
                    VALUES ('', '{$name}', '{$address}', '{$hp}')";
                $sql = $db->query($sql);
                $idCustomer = $db->insertID();
            } else {
                // search id customer
                $idCustomer = "SELECT customer_id FROM customer WHERE customer_no_handphone = '{$hp}' AND customer_name = '{$name}'";
                $idCustomer = $db->query($idCustomer)->getResultArray();
                $idCustomer = $idCustomer[0]['customer_id'];    
            }
        }

        //------------------------------- CHECK PENDING -------------------------------//
        $query = "SELECT sales_order_status FROM sales_order WHERE sales_order_customer_id = ? AND  sales_order_status = 'pending'";

        $pending = $db->query($query, [$idCustomer])->getResultArray();

        if (empty($pending)){
                $status = false;
        } else {
            $status = 'pending';
        }

        $selectHarga = "SELECT sales_order_price FROM sales_order WHERE sales_order_customer_id = {$idCustomer} AND sales_order_status = 'pending'";
        $selectHarga = $db->query($selectHarga)->getResultArray();

        $totalHarga = 0;
        foreach ($selectHarga as $key => $value) {
            $totalHarga += $value['sales_order_price'];
        }

        $gas['data'] = ['sales_order'];

        $gas['select'] = [
            'sales_order_product_name' => 'product_name',
            'sales_order_category' => 'category',
            'sales_order_unit' => 'unit',
            'sales_order_value' => 'total',
            'sales_order_price' => 'price'
        ];

        $gas['where_detail'] = [
            "WHERE sales_order_status = 'pending' AND sales_order_customer_id = {$idCustomer}"
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


        $listData['data'] = ['sales_order'];
        $listData['select'] = [
            'sales_order_product_name' => 'product_name',
            'sales_order_category' => 'category',
            'sales_order_unit' => 'unit',
            'sales_order_value' => 'total',
            'sales_order_price' => 'price'
        ];

        $listData['where_detail'] = [
            "WHERE sales_order_customer_id = {$idCustomer} AND sales_order_date = NOW()"
        ];

        $listData['pagination'] = [
            'pagination' => false
        ];

        $list = generateListData($this->request->getPost(), $listData, $db);

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


    public function CustomerCancel()
    {   
        $post = $this->request->getPost();
        $id = $post['id'];

        $break = "UPDATE sales_order SET sales_order_status = 'break' WHERE sales_order_customer_id = {$id} AND sales_order_status = 'pending'";

        $this->db->query($break);

        $data['data'] = ['sales_order'];

        $data['select'] = [
            'sales_order_date' => 'date',
            'sales_order_product_name' => 'product',
            'sales_order_category' => 'category',
            'sales_order_unit' => 'unit',
            'sales_order_value' => 'value',
            'sales_order_price' => 'price',
        ];

        $data['where_detail'] = [
            "WHERE sales_order_customer_id = {$id} AND sales_order_status = 'break'"
        ];

        $data['pagination'] = [
            'pagination' => false
        ];

        $data = generateListData($this->request->getPost(), $data, $this->db);

        $sql = "UPDATE sales_order SET sales_order_status = 'customer_canceled' WHERE sales_order_customer_id = {$id} AND sales_order_status = 'break'";

        $this->db->query($sql);


        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Successfully Canceled', $data);
        
    }

    public function payed()
    {
        // ------------------- GET ID ------------------- //
        $id = $this->request->getVar();
        $id = $id['id'];

        // ------------------- GET FILE -------------------- //
        $photo = $this->request->getFile('upload');
        $db = db_connect();


        // --------------------- SET VALIDATION ------------------------ //
        $validator = \Config\Services::validation();
        $validator->setRules([
            'upload' => 'uploaded[upload]|max_size[upload, 2048]|is_image[upload]|mime_in[upload,image/jpg,image/jpeg,image/png]',
        ]);

        if (!$validator->run((array)$photo)) {
            $error = $validator->getErrors();
            if ($error) {
                return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'error validation', $error);
            }
        }
        $pure_name = $photo->getName();
        $name = "customer_" . "$id" . "_";
        $name .= $photo->getRandomName();
        // if ($photo->isValid() && !$photo->hasMoved()) {
        //     $pic = $photo->move("./upload/photo", "$id" . "_transfer_" . "$name." . $photo->getExtension());
        // }
        $photo->move('./upload/photo', $name);




        // ---------------------------------- UPDATE FROM 'PENDING' TO 'PAYED' ---------------------------------- //
        $sql = "UPDATE sales_order 
        SET sales_order_proof = '{$name}',
        sales_order_status = 'payed'
        WHERE sales_order_customer_id = {$id} AND sales_order_status = 'pending'";
        $db->query($sql);


        // -------------------------------- GET TOTAL HARGA --------------------------------- //
        $query['data'] = ['sales_order'];

        $query['select'] = [
            'sales_order_price' => 'price',
        ];

        $query['where_detail'] = [
            "WHERE sales_order_customer_id = {$id} AND sales_order_status = 'payed'"
        ];

        $query['pagination'] = [
            'pagination' => false
        ];


        $price = generateListData($this->request->getVar(), $query, $db);
        $totalHarga = 0;
        foreach ($price as $key => $value) {
            $totalHarga += $value['price'];
        }


        $data = [
            'total Payment' => $totalHarga,
            'image' => $pure_name,
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Sended', $data);
    }

    public function confirmed()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)){
            return $token;
        }


        $post = $this->request->getPost();

        $id = $post['id'];



        $query['data'] = ['sales_order'];

        $query['select'] = [
            'sales_order_product_name' => 'product',
            'sales_order_category' => 'category',
            'sales_order_unit' => 'unit',
            'sales_order_value' => 'value',
        ];

        $query['where_detail'] = [
            "WHERE sales_order_status = 'payed' AND sales_order_customer_id = {$id}"
        ];

        $query['pagination'] = [
            'pagination' => false
        ];

        $data = generateListData($this->request->getPost(), $query, $this->db);

        // -------------------- UPDATE FROM 'PAYED' TO 'CONFIRMED' ------------------------- //
        $sql = "UPDATE sales_order SET 
                sales_order_status = 'confirmed'
                WHERE sales_order_status = 'payed' AND sales_order_customer_id = {$id}";

        $this->db->query($sql);

        foreach ($data as $key => $value) {
            $product = $value['product'];
            $category = $value['category'];
            $unit = $value['unit'];
            $value = $value['value'];

            // --------- UPDATE product_stock --------- //
            $stock = "UPDATE product_stock
            SET product_stock_value = product_stock_value - {$value},
                product_stock_out = product_stock_out - {$value}
            WHERE product_stock_unit_name = '{$unit}'
              AND product_stock_product_name = '{$product}'
              AND product_stock_product_id IN (SELECT product_id FROM product WHERE product_category_name = '{$category}');
            ";

            $this->db->query($stock);

            // --------- INSERT INTO log_stock --------- //
            $log = "INSERT INTO log_stock (log_stock_product_id, log_stock_product_name, log_stock_status,log_stock_value, log_stock_category_id, log_stock_category_name, log_stock_unit_id, log_stock_unit_name,log_stock_date)
            SELECT product_id, product_name, 'reduce', '{$value}', category_id, category_name, unit_id, unit_name, NOW()
            FROM product, category, unit
            WHERE product_name = '{$product}' AND category_name = '{$category}' AND unit_name = '{$unit}'";

            $this->db->query($log);
        }


        $result = [
            'order_status' => 'confirmed',
            'order_id' => $id,
            'order_list' => [
                $data
            ]
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Order Successfully Confirmed', $result);
    }

    public function canceled()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)){
            return $token;
        }

        $post = $this->request->getPost();
        $db = db_connect();
        $id = $post['id'];

        $sql = "UPDATE sales_order SET sales_order_status = 'canceled' WHERE sales_order_customer_id = {$id} AND (sales_order_status = 'pending' OR sales_order_status = 'payed')";

        $db->query($sql);

        $data['data'] = ['sales_order'];

        $data['select'] = [
            'sales_order_status' => 'status',
            'sales_order_product_name' => 'product',
            'sales_order_category' => 'category',
            'sales_order_unit' => 'unit',
            'sales_order_date' => 'date',
        ];

        $data['where_detail'] = [
            "WHERE sales_order_customer_id = {$id} AND sales_order_status = 'canceled'"
        ];

        $data['pagination'] = [
            'pagination' => false
        ];

        $data = generateListData($this->request->getPost(), $data, $db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Canceled', $data);
    }

    public function listTableCustomer()
    {
        $id = $this->request->getVar();
        $id = $id['id'];
        

        $query['data'] = ['sales_order'];

        $query['select'] = [
            'sales_order_status' => 'status',
            'sales_order_product_name' => 'product',
            'sales_order_category' => 'category',
            'sales_order_unit' => 'unit',
            'sales_order_price' => 'price',
            'sales_order_value' => 'value',
            'sales_order_date' => 'date',
        ];

        $query['where_detail'] = [
            "WHERE sales_order_customer_id = {$id}"
        ];

        $query['pagination'] = 
        [
            'pagination' => true,
        ];

        $query['limit'] = [
            'limit' => 10,
        ];

        $query['search_data'] = [
            'sales_order_category',
            'sales_order_unit',
            'sales_order_product_name',
        ];

        $query['filter'] = [
            "sales_order_category",
            "sales_order_unit",
        ];

        $data = generateListData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Data Customer', $data);
    }

    public function report()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)){
            return $token;
        }


        $query['data'] = ['sales_order'];

        $query['select'] = [
            'sales_order_status' => 'status',
            'sales_order_product_name' => 'product',
            'sales_order_category' => 'category',
            'sales_order_unit' => 'unit',
            'sales_order_price' => 'price',
            'sales_order_value' => 'value',
            'sales_order_date' => 'date',
        ];

        $query['pagination'] = [
            'pagination' => true,
        ];

        $query['search_data'] = [
            'sales_order_category',
            'sales_order_unit',
            'sales_order_product_name',
        ];

        $query['filter'] = [
            "sales_order_category",
            "sales_order_unit",
        ];

        $query['limit'] = ['limit' => 10];

        $data = generateListData($this->request->getVar(), $query, $this->db);
        
        
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Report Order', $data);
    }
}

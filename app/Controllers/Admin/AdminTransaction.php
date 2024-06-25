<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminTransaction extends AuthController
{

    public function confirmed()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
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
        if (!empty($token)) {
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

    
    public function report()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)){
            return $token;
        }


        $query['data'] = ['customer'];

        $query['select'] = [
            'sales_order.sales_order_customer_id' => 'customer_id',
            'customer.customer_name' => 'customer_name',
            'sales_order.sales_order_status' => 'status',
            'sales_order.sales_order_product_name' => 'product',
            'sales_order.sales_order_category' => 'category',
            'sales_order.sales_order_unit' => 'unit',
            'sales_order.sales_order_price' => 'price',
            'sales_order.sales_order_value' => 'value',
            'sales_order.sales_order_date' => "'date'",
        ];

        $query['join'] = [
            'sales_order' => 'sales_order.sales_order_customer_id = customer.customer_id'
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

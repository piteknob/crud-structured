<?php 

namespace App\Controllers;

use App\Controllers\Core\DataController;
use CodeIgniter\HTTP\ResponseInterface;

class ListPublic extends DataController
{
    public function listProduct()
    {
        $query['data'] = ['product'];

        $query['select'] = [
            'product_id' => 'id',
            'product_name' => 'product',
            'product_category_name' => 'category',
            'product_stock_unit_name' => 'unit',
            'product_stock_price_sell' => 'price_sell',
            'product_stock_value' => 'stock',
        ];

        $query['join'] = [
            'product_stock' => 'product_stock.product_stock_product_id = product.product_id'
        ];

        $query['pagination'] = [
            'pagination' => true
        ];

        $query['limit'] = [
            'limit' => 5
        ];

        // $query['search_data'] = [
        //     'product_category_name',
        //     'product_name',
        //     'product_stock_unit_name',
        // ];

        // $query['filter'] = [
        //     "product_category_name",
        //     "product_stock_unit_name",
        // ];

        $query['filter_between'] = [
            'product_stock_price_sell'
        ];

        $data = generateListData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Product', $data);
    }

    public function detailProduct()
    {
        $id = $this->request->getVar();
        $id = $id['id'];
    
        $query['data'] = ['product'];

        $query['select'] = [
            'product_id' => 'id',
            'product_stock_id' => 'id_stock',
            'product_name' => 'product',
            'product_category_name' => 'category',
            'product_stock_unit_name' => 'unit',
            'product_stock_price_buy' => 'price_buy',
            'product_stock_price_sell' => 'price_sell',
            'product_stock_value' => 'stock',
            'product_stock_in' => 'stock_in',
            'product_stock_out' => 'stock_out',
            'product_created_at' => 'created_at',
            'product_updated_at' => 'updated_at',
        ];

        $query['join'] = [
            'product_stock' => 'product_stock.product_stock_product_id = product.product_id'
        ];
        
        $query['where_detail'] = [
            "WHERE product_id = $id" 
        ];

        $data = generateDetailData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Detail Product', $data);

    }

    public function listUnit()
    {
        $query['data'] = ['unit'];

        $query['select'] = [
            'unit_id' => 'id',
            'unit_name' => 'unit',
        ];

        $query['pagination'] = [
            'pagination' => true
        ];

        $query['limit'] = [
            'limit' => 2
        ];

        $data = generateListData($this->request->getVar(), $query, $this->db);
        
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Unit', $data);
    }

    public function listCategory()
    {
        $query['data'] = ['category'];

        $query['select'] = [
            'category_id' => 'id',
            'category_name' => 'category',
        ];

        $query['pagination'] = [
            'pagination' => true
        ];

        $query['limit'] = [
            'limit' => 2
        ];

        $data = generateListData($this->request->getVar(), $query, $this->db);
        
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Category', $data);
    }
}
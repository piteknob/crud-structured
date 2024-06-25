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

        $query['search_data'] = [
            'product_category_name',
            'product_name',
            'product_stock_unit_name',
        ];

        $query['filter'] = [
            "product_category_name",
            "product_stock_unit_name",
        ];

        $query['filter_between'] = [
            'product_stock_price_sell'
        ];

        $data = generateListData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Product', $data);
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
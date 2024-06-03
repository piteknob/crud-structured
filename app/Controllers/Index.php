<?php 

namespace App\Controllers;

use App\Controllers\Core\DataController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends DataController 
{
    public function index()
    {
        $query['data'] = ['product'];

        $query['select'] = [
            'product_id' => 'id',
            'product_stock_id' => 'stock_id',
            'product_name' => 'product',
            'product_category_name' => 'category',
            'product_stock_unit_name' => 'unit',
            'product_stock_price_sell' => 'price_sell',
            'product_stock_price_buy' => 'price_buy',
            'product_stock_value' => 'stock',
            'product_stock_in' => 'stock_in',
            'product_stock_out' => 'stock_out',
            'product_created_at' => 'created',
            'product_updated_at' => 'updated',
        ];

        $query['join'] = [
            'product_stock' => 'product_stock.product_stock_product_id = product.product_id'
        ];

        $query['pagination'] = [
            'pagination' => true
        ];

        $query['limit'] = [
            'limit' => 1
        ];

        $data = generateListData($this->request->getVar(), $query, $this->db);
        
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Product', $data);
    }
}
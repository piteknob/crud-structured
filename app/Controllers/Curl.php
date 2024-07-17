<?php

namespace App\Controllers;

use App\Controllers\Core\DataController;
use CodeIgniter\HTTP\ResponseInterface;

class Curl extends DataController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function kocak()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://pitekapi.000webhostapp.com/ListPublic/listproduct?page=1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // print_r($response);
        // die;

        $decode = json_decode($response);
        foreach ($decode as $key => $value) {
            $data = [
                'data' => $value
            ];
        }
        // $this->load->view('welcome_message', $data);
        return view('lol', $data);
    }

    public function get()
    {
        $curl['url'] = ['https://pitekapi.000webhostapp.com'];
        $curl['endpoint'] = ['listpublic/listproduct'];
        $curl['method'] = ['GET'];
        // $curl['params'] = [
        //     'search' => $page,
        // ];
        $curl['pagination'] = ['true'];
        $curl['max_redirect'] = [10];
        $curl['timeout'] = [1];
        $curl['follow_location'] = true;
        $curl['return_transfer'] = true;
        // $curl['http_header'] = [
        //     'Token' => 'dmlub0BnbWFpbC5jb20xMjM0NTY=',
        // ]; 
        $data = curlSetOptGet($curl);
        $data = json_decode($data, true);

        print_r($data);
        die;

        foreach ($data as $key => $value) {
            $data = [
                'data' => $value
            ];
        }

        return view('lol', $data);

        // return $this->responseSuccess(ResponseInterface::HTTP_OK, 'list data', $data);

    }

    public function post()
    {
        $curl['url'] = ['https://66723dcfe083e62ee43e707c.mockapi.io'];
        $curl['endpoint'] = ['ayam'];
        $curl['method'] = ['GET'];
        $curl['return_transfer'] = true;
        $curl['follow_location'] = true;
        $curl['max_redirect'] = [10];
        $curl['timeout'] = [0];
        // $curl['http_header'] = ['ceritane token']; 
        $curl['post_field'] = [
            'name' => 'vfvsfgfas',
            'email' => 'vfvsgfsgfsgfsgfsgfsgf'
        ];
        $dd = curlSetOptGet($curl);
        $dd = json_decode($dd);
        return $dd;
    }

    public function produk()
    {
        $curl['url'] = ['https://pitekapi.000webhostapp.com'];
        $curl['endpoint'] = ['listpublic/listproduct'];
        $curl['method'] = ['GET'];
        $curl['pagination'] = ['false'];
        $curl['follow_location'] = true;
        // $curl['http_header'] = [ 
        //     'Token' => 'dmlub0BnbWFpbC5jb20xMjM0NTY=', 
        // ];  
        $data = curlSetOptGet($curl);
        // print_r($data); 
        // die; 
        $get = $this->request->getGet();
        if (!empty($get['page'])) {
            $pagi = $get['page'];
            $curl_pagi['url'] = ['http://10.10.0.53/crud-structured/public'];
            $curl_pagi['endpoint'] = ['listpublic/listproduct'];
            $curl_pagi['params'] = [
                'page' => $pagi,
            ];
            $curl_pagi['pagination'] = ['true'];
            $curl_pagi['max_redirect'] = [10];
            $curl_pagi['timeout'] = [1];
            // $curl_pagi['http_header'] = [ 
            //     'Token' => 'dmlub0BnbWFpbC5jb20xMjM0NTY=', 
            // ];  
            $data_pagi = curlSetOptGet($curl_pagi);
        } else {
            $data_pagi = [];
        }
    
        return view(
            'Post',
            [
                'title' => 'Griya Bakpia | Produk',
                'data_edit' => $data,
                'data_page' => $data_pagi
            ]

        );
    }

    public function Admin()
    {
        $curl['url'] = ['https://pitekapi.000webhostapp.com'];
        $curl['endpoint'] = ['admin/product/detailproduct'];
        $curl['params'] = [
            'id' => 279,
        ];
        $curl['method'] = ['GET'];
        $curl['pagination'] = ['true'];
        $curl['max_redirect'] = [10];
        $curl['timeout'] = [1];;
        $curl['http_header'] = [
            'Token' => 'dmlub0BnbWFpbC5jb20xMjM0NTY=',
        ];
        $data = curlSetOptGet($curl);
        print_r($data);
        die;
        $default = [
            "status" => 200,
            "message" => "List Product",
            "error" => "",
            "result" => [
                [
                    "id" => "279",
                    "product" => "Mie Aceh",
                    "category" => "Makanan",
                    "unit" => "Piring",
                    "price_sell" => "350",
                    "stock" => "56"
                ],
                [
                    "id" => "280",
                    "product" => "Ayam Geprek",
                    "category" => "Makanan",
                    "unit" => "Piring",
                    "price_sell" => "700",
                    "stock" => "258"
                ],
                [
                    "id" => "282",
                    "product" => "Ayam Goreng",
                    "category" => "Makanan",
                    "unit" => "Piring",
                    "price_sell" => "700",
                    "stock" => "98"
                ],
                [
                    "id" => "283",
                    "product" => "Mie Rendang",
                    "category" => "Makanan",
                    "unit" => "Piring",
                    "price_sell" => "300",
                    "stock" => "498"
                ],
                [
                    "id" => "284",
                    "product" => "Mie Soto",
                    "category" => "Makanan",
                    "unit" => "Piring",
                    "price_sell" => "300",
                    "stock" => "498"
                ],
                [
                    "id" => "285",
                    "product" => "Ayam Rendang",
                    "category" => "Makanan",
                    "unit" => "Piring",
                    "price_sell" => "1000",
                    "stock" => "999"
                ],
                [
                    "id" => "289",
                    "product" => "Es Teh",
                    "category" => "Minuman",
                    "unit" => "Gelas",
                    "price_sell" => "800",
                    "stock" => "100"
                ],
                [
                    "id" => "290",
                    "product" => "Es Jeruk",
                    "category" => "Minuman",
                    "unit" => "Gelas",
                    "price_sell" => "800",
                    "stock" => "100"
                ],
                [
                    "id" => "291",
                    "product" => "Teh anget",
                    "category" => "Minuman",
                    "unit" => "Gelas",
                    "price_sell" => "800",
                    "stock" => "100"
                ],
                [
                    "id" => "292",
                    "product" => "Kelapa",
                    "category" => "Minuman",
                    "unit" => "Gelas",
                    "price_sell" => "800",
                    "stock" => "100"
                ]
            ]
        ];

        return view(
            'admin/product',
            [
                'title' => 'Griya Bakpia | Produk',
                'data_get' => $default
            ]
        );
    }

    public function editData(): string
    {
        $id = $_GET['id'];
        // print_r($id); 
        // die; 
        $curl['url'] = ['https://pitekapi.000webhostapp.com'];
        $curl['endpoint'] = ['admin/product/detailproduct'];
        $curl['method'] = ['GET'];
        $curl['params'] = [
            'id' => $id,
        ];
        $curl['pagination'] = ['false'];
        $curl['max_redirect'] = [10];
        $curl['timeout'] = [1];
        $curl['follow_location'] = true;
        $curl['return_transfer'] = true;
        $curl['http_header'] = [
            'Token' => 'dmlub0BnbWFpbC5jb20xMjM0NTY=',
        ];
        $data = curlSetOptGet($curl);


        $curl_c['url'] = ['https://pitekapi.000webhostapp.com'];
        $curl_c['endpoint'] = ['admin/category/index'];
        $curl_c['method'] = ['GET'];
        $curl_c['pagination'] = ['false'];
        $curl_c['max_redirect'] = [10];
        $curl_c['timeout'] = [1];
        $curl_c['follow_location'] = true;
        $curl_c['return_transfer'] = true;
        $curl_c['http_header'] = [
            'Token' => 'dmlub0BnbWFpbC5jb20xMjM0NTY=',
        ];
        $data_category = curlSetOptGet($curl_c);
        // print_r($data); 
        // print_r($data_category); 
        // die; 
        return view(
            'Post',
            [
                'title' => 'Griya Bakpia | Produk',
                'data_edit' => $data,
                'data_category' => $data_category
            ]

        );
    }


    public function postData()
    {
        $post = $this->request->getPost();

        $id = $post['id'];
        $name = $post['namaProduk'];
        $category = $post['category'];
        $unit = $post['unit'];
        $stock = $post['stock'];
        $buy = $post['buy'];
        $sell = $post['sell'];
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pitekapi.000webhostapp.com/admin/product/update?id={$id}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
            'product' => $name,
            'category' => $category,
            'buy' => $buy,
            'sell' => $sell,
            'stock' => $stock,
            'unit' => $unit
            ),
            CURLOPT_HTTPHEADER => array(
                "Token: dmlub0BnbWFpbC5jb20xMjM0NTY="
            ),
        ));
    
        $response = curl_exec($curl);
    
        curl_close($curl);
        echo $response;

        return view("niga");
    }
    
}

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
        $curl['max_redirect'] = [10]; 
        $curl['timeout'] = [1]; 
        $curl['follow_location'] = true; 
        $curl['return_transfer'] = true; 
        // $curl['http_header'] = [ 
        //     'Token' => 'dmlub0BnbWFpbC5jb20xMjM0NTY=', 
        // ];  
        $data = curlSetOptGet($curl); 
        $data = json_decode($data, true); 
        // print_r($data); 
        // die; 
        $get = $this->request->getGet(); 
        if (!empty($get['page'])) { 
            $pagi = $get['page']; 
            $curl_pagi['url'] = ['https://pitekapi.000webhostapp.com']; 
            $curl_pagi['endpoint'] = ['listpublic/listproduct']; 
            $curl_pagi['method'] = ['GET']; 
            $curl_pagi['params'] = [ 
                'page' => $pagi, 
            ]; 
            $curl_pagi['pagination'] = ['true']; 
            $curl_pagi['max_redirect'] = [10]; 
            $curl_pagi['timeout'] = [1]; 
            $curl_pagi['follow_location'] = true; 
            $curl_pagi['return_transfer'] = true; 
            // $curl_pagi['http_header'] = [ 
            //     'Token' => 'dmlub0BnbWFpbC5jb20xMjM0NTY=', 
            // ];  
            $data_pagi = curlSetOptGet($curl_pagi); 
            $data_pagi = json_decode($data_pagi, true); 
        }else{
            $data_pagi= [];
        }
        return view(  
            'tes',
            [
                'title' => 'Griya Bakpia | Produk',
                'data_get' => $data,
                'data_page' => $data_pagi
            ]
 
        );
    }
}

<?php

namespace App\Controllers;

use App\Controllers\Core\DataController;
use CodeIgniter\HTTP\ResponseInterface;

class Coba extends DataController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function kocak()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://pitekapi.000webhostapp.com/ListPublic/listproduct?page=2',
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
}

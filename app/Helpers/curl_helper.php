<?php

// OPT POST
function curlSetOptPost($curl)
{
    $url = isset($curl['url']) ?  $curl['url'] : '';
    $method = isset($curl['method']) ?  $curl['method'] : '';
    $endpoint = isset($curl['endpoint']) ?  $curl['endpoint'] : '';
    $return_transfer = isset($curl['return_transfer']) ?  $curl['return_transfer'] : '';
    $max_redirect = isset($curl['max_redirect']) ?  $curl['max_redirect'] : '';
    $timeout = isset($curl['timeout']) ?  $curl['timeout'] : '';
    $follow_location = isset($curl['follow_location']) ?  $curl['follow_location'] : '';
    $http_header = isset($curl['http_header']) ?  $curl['http_header'] : '';
    $post_field = isset($curl['post_field']) ?  $curl['post_field'] : '';



    if (!empty($url)) {
        $url = BaseUrlCurl($url);
        // print_r($url);
        // die;
    }

    if (!empty($method)) {
        $method = customRequest($method);
        // print_r($method);
        // die;
    }

    if (!empty($endpoint)) {
        $endpoint = endPoint($endpoint);
        // print_r($method);
        // die;
    }

    if (!empty($return_transfer)) {
        $return_transfer = returnTransfer($return_transfer);
        // print_r($return_transfer);
        // die;
    }

    if (!empty($max_redirect)) {
        $max_redirect = maxRedirect($max_redirect);
        // print_r($max_redirect);
        // die;
    }

    if (!empty($timeout)) {
        $timeout = timeOut($timeout);
        // print_r($timeout);
        // die;
    }

    if (!empty($follow_location)) {
        $follow_location = followLocation($follow_location);
        // print_r($follow_location);
        // die;
    }

    if (!empty($http_header)) {
        $http_header = httpHeader($http_header);
        // print_r($http_header);
        // die;
    }

    if (!empty($post_field)) {
        $post_field = postField($post_field);
        // print_r($post_field);
        // die;
    }

    // curl_setopt_array($curl, array(
    //     CURLOPT_URL => 'http://localhost:8080/LoginSystem/login',
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => '',
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 0,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => 'POST',
    //     CURLOPT_POSTFIELDS => array('email' => 'vino@gmail.com','password' => '123456'),
    //   ));


    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "{$url}/{$endpoint}",
        CURLOPT_RETURNTRANSFER => "{$return_transfer}",
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => "{$max_redirect}",
        CURLOPT_TIMEOUT => "{$timeout}",
        CURLOPT_FOLLOWLOCATION => "{$follow_location}",
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "{$method}",
        CURLOPT_HTTPHEADER => array(
            "'{$http_header}'"
        ),
        CURLOPT_POSTFIELDS => array(
            "'{$post_field}'"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return $response;
}
















// OPT GET
function curlSetOptGet($curl)
{
    $url = isset($curl['url']) ?  $curl['url'] : '';
    $method = isset($curl['method']) ?  $curl['method'] : '';
    $endpoint = isset($curl['endpoint']) ?  $curl['endpoint'] : '';
    $return_transfer = isset($curl['return_transfer']) ?  $curl['return_transfer'] : '';
    $max_redirect = isset($curl['max_redirect']) ?  $curl['max_redirect'] : '';
    $timeout = isset($curl['timeout']) ?  $curl['timeout'] : '';
    $follow_location = isset($curl['follow_location']) ?  $curl['follow_location'] : '';
    $http_header = isset($curl['http_header']) ?  $curl['http_header'] : '';
    $pagination = isset($curl['pagination']) ?  $curl['pagination'] : '';



    if (!empty($url)) {
        $url = BaseUrlCurl($url);
        // print_r($url);
        // die;
    }

    if (!empty($method)) {
        $method = customRequest($method);
        // print_r($method);
        // die;
    }

    if (!empty($endpoint)) {
        $endpoint = endPoint($endpoint);
        // print_r($method);
        // die;
    }

    if (!empty($return_transfer)) {
        $return_transfer = returnTransfer($return_transfer);
        // print_r($return_transfer);
        // die;
    }

    if (!empty($max_redirect)) {
        $max_redirect = maxRedirect($max_redirect);
        // print_r($max_redirect);
        // die;
    }

    if (!empty($timeout)) {
        $timeout = timeOut($timeout);
        // print_r($timeout);
        // die;
    }

    if (!empty($follow_location)) {
        $follow_location = followLocation($follow_location);
        // print_r($follow_location);
        // die;
    }

    if (!empty($http_header)) {
        $http_header = httpHeader($http_header);
        // print_r($http_header);
        // die;
    }

    if (!empty($pagination)) {
        $pagination = pagination($pagination);
        // print_r($pagination);
        // die;
    }



    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "{$url}/{$endpoint}{$pagination}",
        CURLOPT_RETURNTRANSFER => "{$return_transfer}",
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => "{$max_redirect}",
        CURLOPT_TIMEOUT => "{$timeout}",
        CURLOPT_FOLLOWLOCATION => "{$follow_location}",
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "{$method}",
        CURLOPT_HTTPHEADER => array(
            "'{$http_header}'"
        ),

    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return $response;
}



//-----------------printilan
function BaseUrlCurl($url)
{
    foreach ($url as $key => $value) {
        $url = $value;
        // print_r($url);
        // die;
        $curl = $url;
    }
    return $curl;
}

function endPoint($point)
{
    foreach ($point as $key => $value) {
        $ep = $value;
        // print_r($ep);
        // die;
    }
    return $ep;
}


function returnTransfer($transfer)
{
    if ($transfer > 0) {
        return 'true';
    } else {
        return 'false';
    }
}

function maxRedirect($direct)
{
    return $direct;
}

function timeOut($timeout)
{
    return $timeout;
}

function followLocation($location)
{
    if ($location > 0) {
        return 'true';
    } else {
        return 'false';
    }
}


function customRequest($cusReq)
{
    foreach ($cusReq as $key => $value) {
        $cusReq = $value;
        // print_r($cusReq);
        // die;
    }
    return $cusReq;
}

function httpHeader($httphead)
{
    foreach ($httphead as $key => $value) {
        $dd = $value;
    }
    return $dd;
}

function postField($post_field)
{
    $curl = '';
    foreach ($post_field as $key => $value) {
        $curl .= "'{$key}' => '{$value}',";
    }
    $curl = rtrim($curl, ', ');
    // print_r($curl);
    // die;

    return $post_field;
}

function pagination($pagination)
{
    foreach ($pagination as $key => $value) {
        $curl = "?{$key}={$value}";
    }
    return $curl;
}

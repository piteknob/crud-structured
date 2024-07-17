<?php


// OPT POST
function curlSetOptPost($curl)
{
    $url = isset($curl['url']) ?  $curl['url'] : '';
    $endpoint = isset($curl['endpoint']) ?  $curl['endpoint'] : '';
    $http_header = isset($curl['http_header']) ?  $curl['http_header'] : '';
    $post_field = isset($curl['post_field']) ?  $curl['post_field'] : '';
    $params = isset($curl['params']) ? $curl['params'] : '';

    if (!empty($url)) {
        $url = BaseUrlCurl($url);
    }

    if (!empty($endpoint)) {
        $endpoint = endPoint($endpoint);
    }

    if (!empty($params)) {
        $params = params($params);
        $paramStatus = true;
    } else {
        $paramStatus = false;
    }

    if (!empty($http_header)) {
        $http_header = httpHeader($http_header);
    }

    if (!empty($post_field)) {
        $post_field = postField($post_field);
    }

    print_r($http_header);
    die;
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "{$url}/{$endpoint}{$params}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 
            "$post_field"
        ,
        CURLOPT_HTTPHEADER => array(
            "{$http_header}"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;

    return $response;
}

// OPT GET
function curlSetOptGet($curl)
{
    $url = isset($curl['url']) ?  $curl['url'] : '';
    $endpoint = isset($curl['endpoint']) ?  $curl['endpoint'] : '';
    $http_header = isset($curl['http_header']) ?  $curl['http_header'] : '';
    $pagination = isset($curl['pagination']) ?  $curl['pagination'] : '';
    $params = isset($curl['params']) ? $curl['params'] : '';


    if (!empty($url)) {
        $url = BaseUrlCurl($url);
    }

    if (!empty($endpoint)) {
        $endpoint = endPoint($endpoint);
    }

    if (!empty($params)) {
        $params = params($params);
        $paramStatus = true;
    } else {
        $paramStatus = false;
    }

    if (!empty($pagination)) {
        $pagination = pagination($pagination, $paramStatus);
    }

    if (!empty($http_header)) {
        $http_header = httpHeader($http_header);
    }


    // ---------- set CurL ---------- //
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "{$url}/{$endpoint}{$params}{$pagination}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "{$http_header}"
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true); 
    return $data;
}




//----------------- PRINTILAN -----------------//
function BaseUrlCurl($url)
{
    foreach ($url as $key => $value) {
        $url = $value;
        $curl = $url;
    }
    return $curl;
}

function endPoint($point)
{
    $curl = '';
    foreach ($point as $key => $value) {
        $curl = $value;
    }
    return $curl;
}

function params($params)
{
    $curl = '?';
    foreach ($params as $key => $value) {
        $curl .= "{$key}={$value}&";
    }
    $curl = rtrim($curl, '& ');
    return $curl;
}

function pagination($pagination, $paramStatus)
{
    // get pagination value
    foreach ($pagination as $key => $value) {
        $pagination = $value;
    }

    if ($pagination == 'true') {
        if (!empty($paramStatus)) {
            $curl = "&pagination=true";
            return $curl;
        } else {
            $curl = "?pagination=true";
   
            return $curl;
        }
    } else {
        if (empty($paramStatus)) {
            $curl = "?pagination=false";
            return $curl;
        } else {
            $curl = "&pagination=false";
            return $curl;
        }
    }
}

function httpHeader($httphead)
{
    $curl = '';
    foreach ($httphead as $key => $value) {
        $curl = "{$key}: {$value},";
    }
    $curl = rtrim($curl, ', ');
    return $curl;
}

function postField($post_field)
{
    $curl = '';
    foreach ($post_field as $key => $value) {
        $curl .= "$key&$value,";
    }
    $curl = rtrim($curl, ', ');
    return $curl;
}

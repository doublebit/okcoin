<?php

namespace Doublebit\Okcoin;

class Okcoin
{

    public function sign($params, $secret_key)
    {
        ksort($params);
        $query = http_build_query($params) . '&secret_key=' . $secret_key;
        return md5($query);
    }

    public function __call($name, $arguments, $secret_key)
    {
        $pieces = preg_split('/(?=[A-Z])/', $name);
        $method = $pieces[0];
        unset($pieces[0]);
        $endpoint = strtolower(implode('_', $pieces)) . '.do';
        $signature = $this->sign($arguments, $secret_key);
        $query = http_build_query($arguments);
        $query .= '&sign=' . $signature;
        return $this->callApi(strtoupper($method), $endpoint, $query);
    }

    public function callApi($method, $endpoint, $query)
    {
        $client = new \GuzzleHttp\Client();
        $url = 'https://www.okcoin.com/api/' . Config::get('okcoin.api_version') . '/' . $endpoint . '?' . $query;
        $res = $client->request($method, $url);
        if ($res->getStatusCode() != 200) {
            return false;
        }
        return $res->getBody();
    }

}
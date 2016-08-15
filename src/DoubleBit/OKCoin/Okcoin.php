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

    public function __call($name, $arguments)
    {
        $pieces = preg_split('/(?=[A-Z])/', $name);
        $method = $pieces[0];
        unset($pieces[0]);
        $endpoint = strtolower(implode('_', $pieces)) . '.do';
        $signature = $this->sign($arguments[0], $arguments[1]);
        $query = http_build_query($arguments[0]);
        $query .= '&sign=' . $signature;
        $result = $this->callApi(strtoupper($method), $endpoint, $query);
        if (isset($arguments[2]) && is_callable($arguments[2])) {
            $strippedArgs = $arguments;
            unset($strippedArgs['api_key']);
            unset($strippedArgs['secret_key']);
            call_user_func_array($arguments[2], [$endpoint, $strippedArgs, $result]);
        }
        return $result;
    }

    public function callApi($method, $endpoint, $query)
    {
        $client = new \GuzzleHttp\Client();
        $url = 'https://www.okcoin.com/api/' . \Config::get('okcoin.api_version') . '/' . $endpoint . '?' . $query;
        $res = $client->request($method, $url);
        if ($res->getStatusCode() != 200) {
            return false;
        }
        return $res->getBody();
    }

}
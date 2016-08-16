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
        $endpoint = strtolower(implode('_', $pieces));
        
        $api_key = $arguments[0];
        $secret_key = $arguments[1];
        $params = $original_params = isset($arguments[2]) ? $arguments[2] : [];
        $callback = isset($arguments[3]) ? $arguments[3] : null;

        $params['api_key'] = $api_key;
        $signature = $this->sign($params, $secret_key);
        $query = http_build_query($params);
        $query .= '&sign=' . $signature;
        $result = $this->callApi(strtoupper($method), $endpoint, $query);
        if (is_callable($callback)) {
            call_user_func_array($callback, [$endpoint, $original_params, $result]);
        }
        return $result;
    }

    public function callApi($method, $endpoint, $query)
    {
        $client = new \GuzzleHttp\Client();
        $url = 'https://www.okcoin.com/api/' . \Config::get('okcoin.api_version') . '/' . $endpoint . '.do?' . $query;
        $res = $client->request($method, $url);
        if ($res->getStatusCode() != 200) {
            return false;
        }
        return $res->getBody();
    }

}
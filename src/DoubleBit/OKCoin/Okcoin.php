<?php

namespace Doublebit\Okcoin;

class Okcoin
{

    /**
     * @param $params array The parameters to
     * @param $secret_key string
     * @return string
     */
    public function sign($params, $secret_key)
    {
        ksort($params);
        $query = http_build_query($params) . '&secret_key=' . $secret_key;
        return strtoupper(md5($query));
    }

    public function __call($name, $arguments)
    {
        $pieces = preg_split('/(?=[A-Z])/', $name);
        $method = $pieces[0];
        unset($pieces[0]);
        $endpoint = strtolower(implode('_', $pieces));
        
        if (!isset($arguments[0]) || !is_string($arguments[0])) {
            $api_key = \Config::get('okcoin.api_key');
            $secret_key = \Config::get('okcoin.secret_key');
            $params = $original_params = isset($arguments[0]) ? $arguments[0] : [];
            $callback = isset($arguments[1]) ? $arguments[1] : null;
        } else {
            $api_key = $arguments[0];
            $secret_key = $arguments[1];
            $params = $original_params = isset($arguments[2]) ? $arguments[2] : [];
            $callback = isset($arguments[3]) ? $arguments[3] : null;
        }
        
        if ($api_key && $secret_key) {
            $params['api_key'] = $api_key;
            $signature = $this->sign($params, $secret_key);
            $query = http_build_query($params);
            $query .= '&sign=' . $signature;
        }  else {
            $query = http_build_query($params);
        }
        $result = $this->callApi(strtoupper($method), $endpoint, $query);
        if (is_callable($callback)) {
            call_user_func_array($callback, [$endpoint, $original_params, $result]);
        }
        $result = json_decode($result);
        return $result;
    }

    public function callApi($method, $endpoint, $query)
    {
        $client = new \GuzzleHttp\Client();
        $url = 'https://www.okcoin.com/api/' . \Config::get('okcoin.api_version') . '/' . $endpoint . '.do?' . $query;
        try {
            $res = $client->request($method, $url);
            if ($res->getStatusCode() != 200) {
                throw new OkcoinException(null, $res->getStatusCode());
            }
            $body = json_decode($res->getBody());
            if (!isset($body->result) || $body->result == false) {
                if (isset($body->error_code)) {
                    throw new OkcoinException(null, $body->error_cde);
                } else {
                    throw new OkcoinException(null, 0);
                }
            }
            return $res->getBody();
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            return false;
        }
    }

}
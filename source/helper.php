<?php

/**
 * Class helper
 * Common helper
 */
class helper
{
    /**
     * @param $method
     * @param $url
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * Helper of guzzle usage
     */
    static function setClient($method, $url, $body)
    {
        $body = $body ? ['json' => $body] : [];
        $client = new \GuzzleHttp\Client();
        return $client->request($method, $url, $body);
    }

    /**
     * @param $method
     * @param $url
     * @param $username
     * @param $key
     * @return mixed
     *
     * Helper to generate token
     */
    static function generateToken($method, $url, $username, $key)
    {
        $token = self::setClient($method, $url, [
            'auth' => [
                'apiKeyCredentials' => [
                    'username' => $username,
                    'apiKey' => $key
                ]
            ]
        ]);
        $token = json_decode($token);
        return $token['token'];
    }
}
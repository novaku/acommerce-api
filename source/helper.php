<?php

/**
 * Class helper
 * Common helper
 */
class helper
{
    /**
     * @param $header
     * @param $method
     * @param $url
     * @param $body
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * Helper of guzzle usage
     */
    static function setClient($header, $method, $url, $body)
    {
        $header_init = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache'
            ]
        ];
        $header = $header ? array_merge_recursive($header_init, $header) : $header_init;
        $body = $body ? ['json' => $body] : [];
        $client = new \GuzzleHttp\Client($header);
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
        $auth_json = [
            'auth' =>
                [
                    'apiKeyCredentials' =>
                        [
                            'username' => $username,
                            'apiKey' => $key
                        ]
                ]
        ];
        $res = self::setClient([], $method, $url, $auth_json);
        $response = json_decode($res->getBody(), true);

        return $response['token']['token_id'];
    }
}
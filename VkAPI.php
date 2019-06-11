<?php
namespace VK;
use Exception;

class VkAPI
{
    private $token;
    private $version;


    /**
     * VkAPI constructor.
     * @param String $token
     * @param String $version
     */
    public function __construct(String $token, String $version = "5.89")
    {
        $this->token  = $token;
        $this->version  = $version;
    }

    public function sendMessage($text, $peer_id, String $keyboard = null){
        $params = array(
            'peer_id' => $peer_id,
            'message' => $text
        );
        if($keyboard != null) $params["keyboard"] = $keyboard;
        $this->api('messages.send', $params);
    }


    private function api($method, $params) {
        $params['access_token'] = $this->token;
        $params['v'] = "5.89";
        $params['random_id'] = rand(0, 1000);
        $query = http_build_query($params);
        $url = 'https://api.vk.com/method/' . $method . '?' . $query;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        $error = curl_error($curl);
        if ($error) {
            error_log($error);
            throw new Exception("Failed {$method} request");
        }
        curl_close($curl);
        $response = json_decode($json, true);
        if (!$response || !isset($response['response'])) {
            var_dump($json);
            throw new Exception("Invalid response for {$method} request");
        }
        return $response['response'];
    }
}
<?php

/**
 * Classe qui gère la connexion à l'api de SMS
 */
namespace Services;

class SmsApi {
    private $server;
    private $toker;
    private $async;
    
    public function __construct ($token, $async = false, $server = "https://smsapi.dev-leoboyer.cf") {
        if(substr($server, -1) == "/") {
            $server = substr($server, 0, strlen($server)-1);
        }
        $this->server = $server;
        $this->token = $token;
        $this->async = $async;
    }
    
    public function send ($nbr, $msg) {
        return $this->async ? $this->sendAsync($nbr, $msg) : $this->sendSync($nbr, $msg);
    }
    
    public function sendAsync($nbr, $msg) {
        return $this->curl_post_async($this->server.'/sms/send', [
            "token" => $this->token,
            "nbr" => $nbr,
            "msg" => $msg
        ]);
    }
    
    public function sendSync($nbr, $msg) {
        return $this->post_sync($this->server.'/sms/send', [
            "token" => $this->token,
            "nbr" => $nbr,
            "msg" => $msg
        ]);
    }
    
    
    public function set_sync_mode($mode) {
        if ($mode === "async") $this->async = true;
        if ($mode === "sync") $this->async = false;
    }
    
    private function curl_post_async($url, $params) {
        foreach ($params as $key => &$val) {
          if (is_array($val)) $val = implode(',', $val);
            $post_params[] = $key.'='.urlencode($val);
        }
        $post_string = implode('&', $post_params);
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'curl');
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        $result = curl_exec($ch);
        curl_close($ch);
    }
    private function post_sync ($url, $data) {

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        return $result;
    }
}
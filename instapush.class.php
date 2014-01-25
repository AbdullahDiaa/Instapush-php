<?php
class instaPush
{
    private $appId ;
    private $appSecret ;
    private $apiURL ;
    private $push ;
    public $timeout = 0; 
    public $connectTimeout = 0;
    public $sslVerifypeer = 0; 
    
    public function __construct() {
        
    }
    
    /**
     * @param   string  $appId          PushBots Applciation Id.
     * @param   string  $appSecret  PushBots Application Secret.
     */
    public function App($appId, $appSecret) {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->apiURL = "api.instapush.im";
    }

    /**
     * sendRequest
     * @param   string  $host   PushBots API.
     * @param   string  $path   API Path.
     */


function curl_post_async($url, $params)
{
        foreach ($params as $key => &$val) {
      if (is_array($val)) $val = implode(',', $val);
        $post_params[] = $key.'='.urlencode($val);
    }
    $post_string = implode('&', $post_params);

    $parts=parse_url($url);

    $fp = fsockopen( $this->apiURL, 
        isset($parts['port'])?$parts['port']:443, 
        $errno, $errstr, 30);

    $out = "POST ".$parts['path']." HTTP/1.1\r\n";
    $out.= "Host: api.instapush.im\r\n";
    $out.= "X-INSTAPUSH-APPID: " . $this->appId ."\r\n";
    $out.= "X-INSTAPUSH-APPSECRET: " . $this->appSecret ."\r\n";
    $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
    $out.= "Content-Length: ".strlen($post_string)."\r\n";
    $out.= "Connection: Close\r\n\r\n";
    if (isset($post_string)) $out.= $post_string;
    fwrite($fp, $out);
    fclose($fp);
}

    
    /**
     * Push Notification 
     */
     
    public function Push() {

     //   $response = $this->sendRequest( 'POST' ,$this->apiURL, '/auth/notifyAmr/');
        $response = $this->curl_post_async("/php",$this->push);

        return $response;
    }
    
    public function trackers($tracker, $value) {
        $this->push[$tracker] = $value;
    }
    
    public function Event($event) {
        $this->push['event'] = $event;
    }
    
}

/*
$ip = new instaPush();
$ip->App("52977dee128773e93de23cf5", "2ee88fa5bb3ebd8d3a23530715b6ccb8");
$ip->trackers("email", "test@ss.cc");
$ip->Event("makan");
$ip->Push();*/

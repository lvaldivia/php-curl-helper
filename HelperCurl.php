<?php 

/**
 * Helper class
 *
 * @author lvaldivia
 * @version 1.0
 */


/**
 * GET, POST, DELETE, PUT.
 */
class HelperCurl {
    //public variable to store status code of each request
    public static $status_code;
    

    /**
     * Performs a get request on the giving link and the chosen parameters
     * in the array.
     *
     * @param string $url
     * @param array $params
     *
     * @return string returns the content of the given url
     */
    
    public static function get($url, $fields = array() , $headers = array()) {
        $ch = curl_init();
        //if there any fields we have to added to the url
        if(count($fields)>0){
            $url = $url."?". urldecode( http_build_query($fields));
        }
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => $headers,
            //we send the HTTP_USER_AGENT
            CURLOPT_USERAGENT => isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER['HTTP_USER_AGENT'] : "",
            CURLOPT_HEADER => false
        );
        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        //we get the status_code of the request we made
        self::$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $response;
    }

}

?>
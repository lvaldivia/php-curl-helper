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
            
            CURLOPT_USERAGENT => self::getUserAgent(),
            CURLOPT_HEADER => false
        );
        if(count($headers)>0){
            $options[CURLOPT_HTTPHEADER] = $headers;
        }
        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        //we get the status_code of the request we made
        self::$status_code = self::getStatusCode($ch);
        curl_close($ch);
        return $response;
    }

    private static getUserAgent(){
        return isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER['HTTP_USER_AGENT'] : "";
    }

    /**
     * Get the status code of the curl request
     *
     * @param curl object
     *
     * @return int returns the status code of the curl request
     */

    private static function getStatusCode($ch){
        return curl_getinfo($ch, CURLINFO_HTTP_CODE)
    }


    /**
     * Performs a post request on the chosen link and the chosen parameters
     * in the array.
     *
     * @param string $url
     * @param array $fields
     *
     * @return string returns the content of the given url after post
     */
    public static function post($url, $fields = array() ,$headers = array()) {
        $ch = curl_init();
        //$fields['iprequest'] = $_SERVER[""];
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 150,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => http_build_query($fields),
            CURLOPT_POST => true,
            CURLOPT_USERAGENT => self::getUserAgent(),
        );
        if(count($headers)>0){
            $options[CURLOPT_HTTPHEADER] = $headers;
        }
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        self::$status_code = self::getStatusCode();
        curl_close($ch);
        return $response;
    }


     /**
     * Performs a put request on the chosen link and the chosen parameters
     * in the array.
     *
     * @param string $url
     * @param array $fields
     *
     * @return string with the contents of the site
     */
    public static function put($url, $fields = array()) {
        $post_field_string = http_build_query($fields);
        $ch = curl_init($url);

        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => $post_field_string
        );
        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        self::$status_code = self::getStatusCode();
        curl_close($ch);

        return $response;
    }




     /**
     * Performs a delete request on the chosen link and the chosen parameters
     * in the array.
     *
     * @param string $url
     * @param array $headers
     * @param array $fields
     *
     * @return string with the contents of the site
     */


    public static function delete($url,$headers=array(),$fields=array())
    {
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 150,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_POSTFIELDS => http_build_query($fields),
            CURLOPT_POST => true,
            CURLOPT_USERAGENT => self::getUserAgent(),
        );
        if(count($headers)>0){
            $options[CURLOPT_HTTPHEADER] = $headers;
        }
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        self::$status_code = self::getStatusCode();
        curl_close($ch);
        return $response;
    }

}

?>
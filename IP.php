<?php
abstract class IP {
    
    /**
     * Get the user ip client
     * 
     * return String
     */
    public static function getUserIP()
    {
        // Get real visitor IP behind CloudFlare network
        // CF-Connecting-IP provides the client IP address connecting to Cloudflare to the origin web server.
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
        
        if (filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif (filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }
        
        return $ip;
    }
    
    /**
     * 
     * IP Geolocation API Free for non-commercial use, no API key required http://ip-api.com 
     * Easy to integrate, available in JSON, XML, CSV, Newline, PHP
     * Serving more than 1 billion requests per day, trusted by thousands of businesses
     * 
     * @param String $user_ip
     * 
     * @return array
     */
    public static function getCityByIP($user_ip) 
    {
        $ch = curl_init();

        $request_ip_location = "http://ip-api.com/json/".$user_ip;
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $request_ip_location);

        $result = json_decode(curl_exec($ch), true);

        return $result;
    }

}





<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\ServerSide\ActionSource;
use FacebookAds\Object\ServerSide\Content;
use FacebookAds\Object\ServerSide\CustomData;
use FacebookAds\Object\ServerSide\DeliveryCategory;
use FacebookAds\Object\ServerSide\Event;
use FacebookAds\Object\ServerSide\EventRequest;
use FacebookAds\Object\ServerSide\UserData;

class FacebookApi extends Model
{
    public function FacebookApiModel($evento, $url_actual, $em, $ph, $content_name, $value)
    {
    	$data = array( // main object
            "data" => array( // data array
                array(
                    "event_name" => $evento,
                    "event_id"=> "Píxel de Andamios Ligeros",
                    "action_source" => "website",
                    "event_source_url"  => $url_actual,
                    "event_time" => time(),
                    "user_data" => array(
                        "client_ip_address" => $_SERVER['REMOTE_ADDR'],
                        "client_user_agent" => $_SERVER['HTTP_USER_AGENT'],
                        "em" => $em,
                        "ph" => $ph
                    ),
                    "custom_data" => array(
                        "currency" => "MXN",
                        "value" => $value,
                        "content_name" => $content_name
                    ),
               ),
            ),
               "access_token" => env('FB_ACCESS_TOKEN', '')
            );  
            $dataString = json_encode($data);                                                                                                              
            $ch = curl_init('https://graph.facebook.com/v16.0/5243995428995951/events');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($dataString))
            );
            $response = curl_exec($ch);
            
            return $response;
    }
}


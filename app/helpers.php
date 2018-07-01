<?php

class Api
{




    public function order($data) { // add order
        $post = array_merge(array('key' => DB::table('infos')->get()[0]->api_key, 'action' => 'add'), $data);
        return json_decode($this->connect($post));
    }

    public function status($order_id) { // get order status
      //$api_info = DB::table('infos')->get();

        return json_decode($this->connect(array(
            'key' => DB::table('infos')->get()[0]->api_key,
            'action' => 'status',
            'order' => $order_id
        )));
    }

    public function services() { // get services
        return json_decode($this->connect(array(
            'key' => DB::table('infos')->get()[0]->api_key,
            'action' => 'services',
        )));
    }

    public function balance() { // get balance
        return json_decode($this->connect(array(
            'key' => DB::table('infos')->get()[0]->api_key,
            'action' => 'balance',
        )));
    }


    private function connect($post) {
        $_post = Array();
        if (is_array($post)) {
            foreach ($post as $name => $value) {
                $_post[] = $name.'='.urlencode($value);
            }
        }

        $ch = curl_init(DB::table('infos')->get()[0]->api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if (is_array($post)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_post));
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        $result = curl_exec($ch);
        if (curl_errno($ch) != 0 && empty($result)) {
            $result = false;
        }
        curl_close($ch);
        return $result;
    }
}

function apiservices(){
  $api = new Api();

  $services = $api->services();
  return $services;
}

function apibalance(){
  $api = new Api();

  $balance = $api->balance();
  return $balance;
}

function apiorderstatus($order_id){
  $api = new Api();

  $status = $api->status($order_id);
  return $status;
}

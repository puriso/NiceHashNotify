<?php
/*
 * BTC為替API
 * @memo Read here
 */
class BtcExchangeApi
{
    public $data;
    function __construct()
    {
        $api_url = "https://blockchain.info/api/exchange_rates_api";

        //curl実行
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        ));
        $this->data = curl_exec($ch);
        curl_close($ch);
    }

    function GetData()
    {
        return json_decode($this->data);
    }

}


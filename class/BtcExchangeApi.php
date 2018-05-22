<?php
/*
 * BTC為替API
 * @memo Read here
 */
class BtcExchangeApi
{
    function __construct()
    {
    }

    function GetData()
    {

        $api_url = "https://public.bitbank.cc/btc_jpy/ticker";

        //curl実行
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        ));
        $json = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($json);

        echo "------<br>";
        var_dump($data);
        echo "------<br>";

        return $data->data->last;
    }

}


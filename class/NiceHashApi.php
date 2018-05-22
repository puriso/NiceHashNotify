<?php

class NiceHashAPI
{
    public $base_url;

    function __construct()
    {
        $this->base_url = "https://api.nicehash.com/api?";
    }

    /*
     * STATUS取得
     */
    function FetchWorkerStatus()
    {
        $params = "method=stats.provider.workers&addr=" . BITCOIN_ADDRESS;
        return json_decode( $this->PostAPI($this->base_url.$params) );
    }
    /*
     * メッセージ用のテキストを作成
     */
    function MakeTextForMessage()
    {
        $status = $this->FetchWorkerStatus();


        $text = "Profitability:
Efficiency:
Workers:
Unpaid balance:

👷Active workers
* XXXX : ARG: / HP:


";

    }


    /*
     * APIへ送信
     * @param json
     * @param string
     * @return bool
     */
    function PostAPI($url)
    {
        //curl実行
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }


}

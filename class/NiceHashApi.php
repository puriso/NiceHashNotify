<?php
/*
 * NiceHash API
 * @memo Read nicehash's documents.
 * https://www.nicehash.com/doc-api
 */

require_once( dirname(__FILE__).DIRECTORY_SEPARATOR."BtcExchangeApi.php" );
class NiceHashAPI
{
    public $base_url;
    public $algorithms = [
        0  => "Scrypt",
        1  => "SHA256",
        2  => "ScryptNf",
        3  => "X11",
        4  => "X13",
        5  => "Keccak",
        6  => "X15",
        7  => "Nist5",
        8  => "NeoScrypt",
        9  => "Lyra2RE",
        10 => "WhirlpoolX",
        11 => "Qubit",
        12 => "Quark",
        13 => "Axiom",
        14 => "Lyra2REv2",
        15 => "ScryptJaneNf16",
        16 => "Blake256r8",
        17 => "Blake256r14",
        18 => "Blake256r8vnl",
        19 => "Hodl",
        20 => "DaggerHashimoto",
        21 => "Decred",
        22 => "CryptoNight",
        23 => "Lbry",
        24 => "Equihash",
        25 => "Pascal",
        26 => "X11Gost",
        27 => "Sia",
        28 => "Blake2s",
        29 => "Skunk",
        30 => "CryptoNightV7",
    ];
    private $btc_exchange_api;
    function __construct()
    {
        $this->base_url         = "https://api.nicehash.com/api?";
        $this->btc_exchange_api = new BtcExchangeApi;
    }

    /*
     * 採掘ステータス取得
     */
    function FetchMiningStatus()
    {
        $params = "method=stats.provider.ex&addr=" . BITCOIN_ADDRESS;
        return json_decode( $this->PostAPI($this->base_url.$params) );
    }

    /*
     * ワーカーステータス取得
     */
    function FetchWorkersStatus()
    {
        $params = "method=stats.provider.workers&addr=" . BITCOIN_ADDRESS;
        return json_decode( $this->PostAPI($this->base_url.$params) );
    }
    /*
     * Profitabilityの取得
     */
    function GetProfitability($status)
    {
        if(empty($status)) $status = $this->FetchMiningStatus();

        $profitability = 0;
        foreach($status->result->current as $c){
            $profitability +=  $c->profitability;
        }
        return $profitability;
    }

    /*
     * Unpaidの取得
     */
    function GetUnpaid($status)
    {
        if(empty($status)) $status = $this->FetchMiningStatus();

        $profitability = 0;
        $unpaind = 0;
        foreach($status->result->current as $c){
            $unpaind += $c->data[1];
        }
        return $unpaind;
    }

    /*
     * メッセージ用のテキストを作成
     */
    function MakeTextForMessage()
    {

        $mining_status = $this->FetchMiningStatus();
        $profitability = $this->GetProfitability($mining_status);
        $unpaind = $this->GetUnpaid($mining_status);

        $worker_status = $this->FetchWorkersStatus();

        /*
            "rigname", // name of the worker
            {"a":"11.02","rs":"0.54"}, // speed object
            15, // time connected (minutes)
            1, // 1 = xnsub enabled, 0 = xnsub disabled
            "0.1", // difficulty
            0, // connected to location (0 for EU, 1 for US, 2 for HK and 3 for JP)
         */
        $workers = $worker_status->result->workers;

        $workers_text = "";
        $worker_doing = [];
        foreach($workers as $w){
            $rigname       = $w[0];
            $algorithm     = $this->algorithms[$w[6]];
            $hashrate      = $w[1]->a;
            $workers_text .= " * $rigname : $algorithm / $hashrate"."\n";

            $worker_doing[$rigname] += 1;
        }
        $worker_count = count($worker_doing);
        $exchange_data = $this->btc_exchange_api->GetData;
        var_dump($exchange_data);
        $usd = $profitability * $exchange_data->USD["15m"];


        return "Profitability: {$profitability}BTC
Workers: {$worker_count}
Unpaid balance: {$unpaind}

👷Active workers
$workers_text ";

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

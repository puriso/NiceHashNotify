<?php

class LINE_API
{
    function __construct()
    {

    }

    /*
     * @param
     * @param (str)message
     * @return bool
     */
    function ReplayMessage($replay_token="",$message="Nothing message...")
    {
        $post_data = [
            "replyToken" => $replay_token,
            "messages" => [
                "type" => "text",
                "text" => $message
            ]
        ];
        return $this->PostAPI($post_data);
    }

    /*
     * ボタン選択付きメッセージ
     * @param (array)actions
     * @param (string)message
     * @param (string)title
     * @param (url)thumb URL
     * @return bool
     */
    function SelectMessages($actions=NULL,$message=NULL,$title=NULL,$thumbURL=NULL)
    {
        $post_data = [
            'type'     => 'template',
            'altText'  => '代替テキスト',
            'template' => [
                'type'              => 'buttons',
                'thumbnailImageUrl' => $thumbURL,
                'title'             => $title  ,
                'text'              => $message,
                'actions'           => $actions,
            ]
        ];
        return $this->PostAPI($post_data);
    }

    /*
     * APIへ送信
     * @param json
     * @param string
     * @return bool
     */
    function PostAPI($post_data,$access_token=ACCESS_TOKEN)
    {
        //curl実行
        $ch = curl_init("https://api.line.me/v2/bot/message/reply");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charser=UTF-8',
            'Authorization: Bearer ' . ACCESS_TOKEN
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }


}



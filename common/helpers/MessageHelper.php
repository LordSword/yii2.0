<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/8/10
 * Time: 23:07
 */
namespace common\helpers;

use Yii;

class MessageHelper{
    public static function sendSms($phone, $message, $smsServiceUse = 'smsService_1'){
        $apikey = Yii::$app->params['smsService_1'];
        $ch = curl_init();
        $url = "http://apis.baidu.com/sms_net/smsapi/smsapi?content={$message}%E6%AC%A2%E8%BF%8E%E9%AA%8C%E8%AF%81%E7%9F%AD%E4%BF%A1%E7%BD%91API%EF%BC%8C%E9%AA%8C%E8%AF%81%E7%A0%81%EF%BC%9A8888%EF%BC%81&mobile={$phone}";
        $header = array(
            $apikey,
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch , CURLOPT_URL , $url);
        $res = curl_exec($ch);
        $res = substr($res,0,1);
        return $res;
    }
}

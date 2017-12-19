<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/8/10
 * Time: 22:59
 */
namespace common\services;

use Yii;
use yii\base\Object;

class smsService extends Object{

    public function send(){
        $params = Yii::$app->params['smsService'];
    }
}
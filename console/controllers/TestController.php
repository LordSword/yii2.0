<?php
/**
 * Created by PhpStorm.
 * User: pengshuai
 * Date: 2017/9/6
 * Time: 下午11:42
 */
namespace console\controllers;


use backend\models\UserBackend;

class TestController extends \yii\console\Controller{

    public function init(){
        parent::init();
        echo "11111\n";
    }
    public function setaa($v){
        echo $v;
    }
    public function actionAaa(){
        $a = strncmp('/', '@', 1);
        var_dump($a);
    }
}
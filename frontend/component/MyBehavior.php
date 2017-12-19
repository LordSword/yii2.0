<?php
/**
 * Created by PhpStorm.
 * User: pengshuai
 * Date: 2017/9/21
 * Time: 下午11:08
 */
class MyBehavior extends \yii\base\Behavior
{
    public $property1 = 'This is property in MyBehavior.';

    public function method1()
    {
        echo '111111';
    }
}
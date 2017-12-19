<?php
namespace common\components;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\base\UserException;
/**
 * Base controller
 * 
 * @property \yii\web\Request $request The request component.
 * @property \yii\web\Response $response The response component.
 * @property common\models\Client $client The Client model.
 */
abstract class BaseController extends Controller
{
	/**
	 * 获得请求对象
	 */
	public function getRequest()
	{
		return Yii::$app->getRequest();
	}
	
	/**
	 * 获得返回对象
	 */
	public function getResponse()
	{
		return Yii::$app->getResponse();
	}
	
	/**
	 * 获得请求客户端信息
	 * 从request中获得，便于调试，有默认值
	 */
	public function getClient()
	{
		return Yii::$app->getRequest()->getClient();
	}

    public function params()
    {
        return array_merge($_GET, $_POST);
    }
    /**
     * 判断是否是app打开
     * @return boolean
     */
    public function isFromApp(){
		return $this->isFromXjk() || $this->isFromProxyApp();
    }
    /**
     * @return bool
     * 判断是否是极速钱包app
     */
    public function isFromXqb(){
        return @stristr($_SERVER['HTTP_USER_AGENT'],'xqb') ? true : false;
    }
    /**
     * 获取客户端版本 字符串
     */
    public function getClientVersion(){
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $clent_version = "0";
        if ($this->isFromXjk()) {
            $ver_str   = @strstr($user_agent,"xqb/");
            $agent_arr = @explode("/", $ver_str);
            if (is_array($agent_arr)) {
                $clent_version = end($agent_arr);     
            }
        }
        
        return $clent_version;
    }

	/**
	 * 翻译文字
	 * @param unknown $key
	 * @param string $channel
	 */
	public function t($key,$channel=''){
	    return \common\helpers\Util::t($key,$channel);
	}
	
    /**
     * 统一设置cookie
     * @param unknown $name
     * @param unknown $val
     * @param unknown $expire
     * @return boolean
     */
    public function setCookie($name,$val,$expire=0){
        $cookieParams = ['httpOnly' => true, 'domain'=>YII_ENV_PROD ? APP_DOMAIN : ''];
        if($expire !== null){
            $cookieParams['expire'] = $expire;
        }
        $cookies = new \yii\web\Cookie($cookieParams);
        $cookies->name = $name;
        $cookies->value = $val;
        $this->response->getCookies()->add($cookies);
        return true;
    }
    /**
     * 统一获取cookie
     * @param unknown $name
     * @return mixed
     */
    public function getCookie($name){
        $val = $this->request->getCookies()->getValue($name);
        if($val){
            return $val;
        }
        $val = $this->response->getCookies()->getValue($name);
        return $val;
    }
}
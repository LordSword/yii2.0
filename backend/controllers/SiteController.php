<?php
namespace backend\controllers;

use backend\models\UserBackend;
use common\helpers\MessageHelper;
use common\models\Captcha;
use Yii;
use backend\models\LoginForm;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    public $verifyPermission = false;
    /**
     * @inheritdoc
     */
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'phone-captcha'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [ 'index', 'top', 'left', 'logout', 'home'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'testLimit' => 1,
                'height' => 35,
                'width' => 80,
                'padding' => 0,
                'minLength' => 4,
                'maxLength' => 4,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //include_once '../config/menu.php';
        $this->layout = false;

        return $this->render('index');
    }

    public function actionTop(){
        $this->layout = false;
        include_once '../config/menu.php';

        return $this->render('top', [
            'topMenu'=>!empty($topmenu)?$topmenu:''
        ]);
    }

    public function actionLeft(){
        $this->layout = false;
        $get_menu = Yii::$app->request->get('menu','index');
        include_once '../config/menu.php';

        return $this->render('left', [
            'menu'=>!empty($menu[$get_menu])?$menu[$get_menu]:''
        ]);
    }

    public function actionHome(){

        return $this->render('home');

    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = false;
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }

    public function actionPhoneCaptcha(){
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        $username = Yii::$app->request->get('username','');
        if(empty($username)){
            return ['code' => '-1', 'message' => '用户名不正确，请用手机号登录'];
        }
        if(is_numeric($username)){
            $user = UserBackend::findByPhone($username);
        }else{
            $user = UserBackend::findByUsername($username);
        }
        $result = Captcha::addLog($user->phone, $user->id, $user->username, Captcha::TYPE_ADMIN_LOGIN);
        if($result){
            MessageHelper::sendSms($user->phone, $result);
            return ['code'=> '0','message'=> '发送成功'];
        }
        return ['code'=> '-1','message'=> '用户名不正确，请用手机号登录'];

    }

}

<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>欢迎登录后台管理系统</title>
    <link href="<?= $this->baseUrl?>/admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="<?= $this->baseUrl?>/admin/js/jquery.js"></script>
    <script src="<?= $this->baseUrl?>/admin/js/cloud.js" type="text/javascript"></script>

    <script language="javascript">
        $(function(){
            $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
            $(window).resize(function(){
                $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
            })
        });
        function refreshCaptcha() {
            $.ajax({
                url: '<?php echo Url::toRoute(['site/captcha', 'refresh' => 1]); ?>',
                dataType: 'json',
                success: function(data){
                    $('#loginform-verifycode-image').attr('src', data.url);
                }
            });
        }
    </script>

</head>

<body style="background-color:#1c77ac; background-image:url(<?= $this->baseUrl?>/admin/images/light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;">



<div id="mainBody">
    <div id="cloud1" class="cloud"></div>
    <div id="cloud2" class="cloud"></div>
</div>


<div class="logintop">
    <span>欢迎登录后台管理界面平台</span>
    <ul>
        <li><a href="#">回首页</a></li>
        <li><a href="#">帮助</a></li>
        <li><a href="#">关于</a></li>
    </ul>
</div>
<style>
    #loginform-verifycode{
        position: relative;
        left:-2px;
        top:-15px;
    }
</style>
<div class="loginbody">

    <span class="systemlogo"></span>

    <div class="loginbox">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <ul>
            <span style="color:red;">
                <?php if ($model->hasErrors()) { $_err = $model->getFirstErrors(); echo array_shift($_err); } ?>
            </span>
            <li>
                <input name="LoginForm[username]" type="text" class="loginuser" placeholder="登录名/手机号" value="<?php echo $model->username; ?>" onclick="JavaScript:this.value=''"/>
            </li>
            <li>
                <input name="LoginForm[password]" type="password" class="loginpwd" placeholder="密码" value="<?php echo $model->password; ?>" onclick="JavaScript:this.value=''"/>
            </li>
            <li>
                <?php if(1):?>
                    <input name="LoginForm[phoneCaptcha]" type="text" class="loginyzm" placeholder="验证码" value="<?php echo $model->phoneCaptcha; ?>" onclick="JavaScript:this.value=''"/>
                    <input name="" type="button" class="loginsbtn" value="发送验证码"  onclick=""  />
                <?php else:?>
                    <input id="loginform-verifycode" name="LoginForm[verifyCode]" type="text" class="loginyzm" placeholder="验证码" value="<?php echo $model->verifyCode; ?>" onclick="JavaScript:this.value=''"/>
                    <img onclick="refreshCaptcha();" title="点击刷新验证码" src="<?php echo Url::toRoute(['site/captcha', 'v' => uniqid()],true); ?>" id="loginform-verifycode-image">
                <?php endif;?>
            </li>
            <li>
                <input name="" type="submit" class="loginbtn" value="登录"/>
                <label>
                    <input name="" type="checkbox" value="" checked="checked" />记住密码
                </label>
                <label>
                    <a href="#">忘记密码？</a>
                </label>
            </li>
        </ul>
        <?php ActiveForm::end(); ?>

    </div>

</div>



<div class="loginbm">版权所有  2013  .com 仅供学习交流，勿用于任何商业用途</div>
</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: psmy
 * Date: 2017/12/15
 * Time: 上午11:44
 */
$this->shownav('system','menu_adminuser',0);
use backend\components\widgets\ActiveForm;
?>

<div class="formbody">
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <div class="formtitle"><span>添加角色</span></div>

    <ul class="forminfo">
        <li>
            <label>标识<b>*</b></label>
            <input name="AdminRole[name]" type="text" class="dfinput" />
            <i>英文字符，唯一标识</i>
        </li>

        <li>
            <label>角色名称<b>*</b></label>
            <input name="AdminRole[title]" type="text" class="dfinput" />

        </li>

        <li>
            <label>角色描述<b>*</b></label>
            <textarea name="AdminRole[desc]" style="margin: 0px; width: 323px; height: 89px;" class="textinput"></textarea>

        </li>

        <li>
            <label>创建人</label>
            <input name="AdminRole[created_user]" readonly value="<?= Yii::$app->user->identity->username?>" type="text" class="dfinput" />
            <i></i>
        </li>

        <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
    <?php ActiveForm::end(); ?>

</div>

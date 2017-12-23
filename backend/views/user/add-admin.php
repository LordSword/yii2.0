<?php
/**
 * Created by PhpStorm.
 * User: psmy
 * Date: 2017/12/21
 * Time: 下午10:20
 */
$this->shownav('system','menu_adminuser',1);
use backend\components\widgets\ActiveForm;
use backend\models\AdminRole;
?>

<div class="formbody">
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <div class="formtitle"><span>添加管理员</span></div>

    <ul class="forminfo">
        <li>
            <label><?= $model->getAttributeLabel('username'); ?><b>*</b></label>
            <?= $form->field($model, 'username')->textInput(['class'=>'dfinput']); ?>
        </li>

        <li>
            <label><?= $model->getAttributeLabel('phone'); ?><b>*</b></label>
            <?= $form->field($model, 'phone')->textInput(['class'=>'dfinput']); ?>
        </li>

        <li>
            <label><?= $model->getAttributeLabel('password'); ?><b>*</b></label>
            <?= $form->field($model, 'password')->textInput(['class'=>'dfinput']); ?>
        </li>

        <li>
            <label><?= $model->getAttributeLabel('mark'); ?></label>
            <?= $form->field($model, 'mark')->textarea(['class'=>'textinput']); ?>
        </li>

        <?php $role = AdminRole::getAllRole();?>
        <div class="formtitle"><span>权限：</span></div>
        <table class="tablelist">
            <tbody>

            <?php
            $index = 0;
            $line_cnt = 5;
            foreach ($role as $value):?>
                <?php if( intval($index % $line_cnt) == 0):?>
                    <tr>
                <?php endif ?>

                <td width="200px" >
                    <input type="checkbox" class="checkbox" value="<?= $value['id']?>" name="roleId[]"> <?= $value['title']?>
                </td>
                <?php if( intval($index++ % $line_cnt) == $line_cnt - 1):?>
                    </tr>
                <?php endif ?>
            <?php endforeach;  ?>
            </tbody>
        </table>

        <br>
        <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
    <?php ActiveForm::end(); ?>

</div>

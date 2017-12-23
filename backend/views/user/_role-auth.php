<?php
/**
 * Created by PhpStorm.
 * User: psmy
 * Date: 2017/12/21
 * Time: 下午3:28
 */
use backend\components\widgets\ActiveForm;
?>
    <style>
        .item {

            line-height: 5px;
            margin-left: 5px;
            margin-top: 5px;
            border-right: 1px
        }
    </style>
    <?php $permissionChecks = isset($permissionChecks)?$permissionChecks:[];?>
    <div class="formbody">
        <?php $form = ActiveForm::begin(); ?>
        <div class="formtitle"><span>添加角色</span></div>

        <ul class="forminfo">
            <li>
                <label><?= $model->getAttributeLabel('name'); ?><b>*</b></label>
                <?= $form->field($model, 'name')->textInput(['class'=>'dfinput']); ?>
            </li>

            <li>
                <label><?= $model->getAttributeLabel('desc')?><b>*</b></label>
                <?= $form->field($model, 'desc')->textarea(['class'=>'textinput']); ?>
            </li>

            <div class="formtitle"><span>权限：</span></div>
            <?php foreach ($permissions as $controller => $permission): ?>
                <table class="tablelist" id="<?php echo $controller; ?>">
                    <tbody>
                    <tr>
                        <th  colspan="5">
                            <label> <?php echo $permission['label']; ?> - <?php echo $controller; ?></label>
                        </th>
                    </tr>

                    <?php
                    $index = 0;
                    $line_cnt = 5;
                    foreach ($permission['actions'] as $action):?>
                        <?php if( intval($index % $line_cnt) == 0):?>
                            <tr>
                        <?php endif ?>

                        <td width="200px" >
                            <div class="item<?php echo in_array($action->route, $permissionChecks) ? ' checked' : ''; ?>">
                                <label class="txt">
                                    <?php
                                    $route = explode("/",$action->route);
                                    $str = $action->title;
                                    ?>
                                    <input type="checkbox" value="<?php echo $action->route; ?>" name="permissions[]"<?php echo in_array($action->route, $permissionChecks) ? ' checked' : ''; ?>> <?php echo $str; ?>
                                </label>
                            </div>
                            <div style="color:#999;margin-left: 5px">
                                <?php echo "({$route[1]})"; ?>
                            </div>
                        </td>
                        <?php if( intval($index++ % $line_cnt) == $line_cnt - 1):?>
                            </tr>
                        <?php endif ?>
                    <?php endforeach;  ?>
                    </tbody>
                </table>
            <?php endforeach; ?>

            <br>
            <li>
                <label>&nbsp;</label>
                <input name="" type="submit" class="btn" value="确认保存"/>
            </li>
        </ul>
        <?php ActiveForm::end(); ?>

    </div>






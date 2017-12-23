<?php
/**
 * Created by PhpStorm.
 * User: psmy
 * Date: 2017/12/21
 * Time: 下午5:53
 */
use yii\helpers\Url;
use backend\models\UserBackend;
use backend\components\widgets\LinkPager;
$this->shownav('system','menu_adminuser',1);
?>


<div class="rightinfo">
    <div class="tools">

        <ul class="toolbar">
            <li class="click">
                <a href="<?= Url::toRoute('user/add-admin')?>">
                    <span>
                        <img src="<?= $this->baseUrl?>/admin/images/t01.png" />
                    </span>
                    添加
                </a>
            </li>
        </ul>

    </div>
    <table class="tablelist">
        <thead>
        <tr>
            <th>编号</th>
            <th>用户名</th>
            <th>手机号</th>
            <th>状态</th>
            <th>角色</th>
            <th>创建人</th>
            <th>备注</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($list as $value){?>
            <tr>
                <td><?= $value['id']?></td>
                <td><?= $value['username']?></td>
                <td><?= $value['phone']?></td>
                <td><?= UserBackend::$status[$value['status']]?></td>
                <td><?= UserBackend::getRoleName($value['id']);?></td>
                <td><?= $value['created_user']?></td>
                <td><?= $value['mark']?></td>
                <td><?= date('Y-m-d H:i:s', $value['created_at'])?></td>
                <td>
                    <?php if($value['id'] != 1){?>
                        <a href="#" class="tablelink"> 删除</a>
                    <?php }?>
                </td>
            </tr>
        <?php }?>

        </tbody>
    </table>

    <?php echo LinkPager::widget(['pagination' => $pages]); ?>

</div>




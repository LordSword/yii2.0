<?php
/**
 * Created by PhpStorm.
 * User: psmy
 * Date: 2017/12/14
 * Time: 下午2:51
 */
use yii\helpers\Url;
use backend\components\widgets\LinkPager;
$this->shownav('system','menu_adminuser',0);
?>


<div class="rightinfo">
    <div class="tools">

        <ul class="toolbar">
            <li class="click">
                <a href="<?= Url::toRoute('user/create')?>">
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
            <th>角色名称</th>
            <th>标识</th>
            <th>描述</th>
            <th>创建人</th>
            <th>更新时间</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($roleList as $value){?>
            <tr>
                <td><?= $value['id']?></td>
                <td><?= $value['title']?></td>
                <td><?= $value['name']?></td>
                <td><?= $value['desc']?></td>
                <td><?= $value['created_user']?></td>
                <td><?= date('Y-m-d H:i:s', $value['updated_at'])?></td>
                <td><?= date('Y-m-d H:i:s', $value['created_at'])?></td>
                <td>
                    <a href="#" class="tablelink">查看</a>
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




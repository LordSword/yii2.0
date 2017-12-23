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
                <td><?= $value['name']?></td>
                <td><?= $value['desc']?></td>
                <td><?= $value['created_user']?></td>
                <td><?= date('Y-m-d H:i:s', $value['updated_at'])?></td>
                <td><?= date('Y-m-d H:i:s', $value['created_at'])?></td>
                <td>
                    <?php if($value['id'] != 1):?>
                        <a href="<?= Url::toRoute(['user/auth-edit', 'role_id'=>$value['id']])?>" class="tablelink">编辑</a>
                        <a href="#" class="click tablelink"> 删除</a>
                    <?php endif;?>
                </td>
            </tr>
        <?php }?>

        </tbody>
    </table>

    <?php echo LinkPager::widget(['pagination' => $pages]); ?>

</div>
<div class="tip">
    <div class="tiptop"><span>提示信息</span><a></a></div>

    <div class="tipinfo">
        <span><img src="images/ticon.png" /></span>
        <div class="tipright">
            <p>是否确认对信息的修改 ？</p>
            <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
        </div>
    </div>

    <div class="tipbtn">
        <input name="" type="button"  class="sure" value="确定" />&nbsp;
        <input name="" type="button"  class="cancel" value="取消" />
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function(){
        $(".click").click(function(){
            $(".tip").fadeIn(200);
        });

        $(".tiptop a").click(function(){
            $(".tip").fadeOut(200);
        });

        $(".sure").click(function(){
            $(".tip").fadeOut(100);
        });

        $(".cancel").click(function(){
            $(".tip").fadeOut(100);
        });

    });
</script>
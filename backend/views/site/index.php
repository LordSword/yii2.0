<?php
use yii\helpers\Url;
?>

<frameset rows="88,*" cols="*" frameborder="no" border="0" framespacing="0">
    <frame src="<?= Url::toRoute('site/top')?>" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
    <frameset cols="187,*" frameborder="no" border="0" framespacing="0">
        <frame src="<?= Url::toRoute('site/left')?>" name="leftFrame" scrolling="No" noresize="noresize" id="leftFrame" title="leftFrame" />
        <frame src="<?= Url::toRoute('site/home')?>" name="rightFrame" id="rightFrame" title="rightFrame" />
    </frameset>
</frameset>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?= $this->baseUrl?>/admin/css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="<?= $this->baseUrl?>/admin/js/jquery.js"></script>
</head>

<script type="text/javascript">
    $(function(){
        //导航切换
        $(".menuson li").click(function(){
            $(".menuson li.active").removeClass("active")
            $(this).addClass("active");
        });

        $('.title').click(function(){
            var $ul = $(this).next('ul');
            $('dd').find('ul').slideUp();
            if($ul.is(':visible')){
                $(this).next('ul').slideUp();
            }else{
                $(this).next('ul').slideDown();
            }
        });
    })
</script>

<body style="background:#f0f9fd;">
	<div class="lefttop"><span></span>菜单栏</div>
    
    <dl class="leftmenu">
       <?php foreach ($menu as $item){?>
           <dd>
               <div class="title">
                   <span><img src="<?= $this->baseUrl.$item['icon']?>" /></span><?= $item['title']?>
               </div>
               <ul class="menuson">
                   <?php foreach ($item['menuchannel'] as $k=>$value){?>
                       <li <?php if($k == 0){?>class="active"<?php }?> >
                           <cite></cite>
                           <a href="<?= $value['redirectUrl']?>" target="rightFrame">
                               <?= $value['title']?>
                           </a>
                           <i></i>
                       </li>
                   <?php }?>
               </ul>
           </dd>
       <?php }?>
    </dl>
</body>
</html>

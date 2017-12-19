<?php

namespace backend\components\widgets;

class LinkPager extends \yii\widgets\LinkPager
{
	protected function renderPageButtons()
	{
	    $data = parent::renderPageButtons();
	    if($data){
	        $totalCount = $this->pagination->totalCount;
	        $msg = '<li><a href="javascript:">总共'.$totalCount.'条记录</a></li>';
	        $data = str_replace('</ul>', $msg.'</ul>', $data);
	    }
	    return $data;
	}
}
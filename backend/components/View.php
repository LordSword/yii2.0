<?php

namespace backend\components;

use Yii;

class View extends \yii\web\View
{

    // 入口文件，不保护域名的目录
    public $baseUrl;

    // 页面title
    public $title;

    //域名
    public $hostInfo;

    public function init()
    {
        parent::init();
        $this->baseUrl = Yii::$app->getRequest()->getBaseUrl();
        $this->hostInfo = Yii::$app->getRequest()->getHostInfo();
    }

    /**
     * 显示导航
     * @param string $topmenuKey 对应一级菜单配置中的key
     * @param string $menuKey 对应二级菜单配置中的key
     * @param integer $num 对应二级菜单配置中menuchannel中的个数
     */
    public function shownav($topmenuKey = '', $menuKey = '', $num = '')
    {
        include_once '../config/menu.php';
        $topmenuName = !empty($topmenu[$topmenuKey]) ? $topmenu[$topmenuKey]['title'] : '首页';
        $menuName = !empty($menu[$topmenuKey][$menuKey]) ? $menu[$topmenuKey][$menuKey]['title'] : '';
        $menuchannel = !empty($menu[$topmenuKey][$menuKey]['menuchannel'][$num]) ? $menu[$topmenuKey][$menuKey]['menuchannel'][$num]['title'] : '';
        echo "<div class='place'>
                <span>位置：</span>
                <ul class='placeul'>
                    <li><a href='#'>{$topmenuName}</a></li>
                    <li><a href='#'>{$menuName}</a></li>
                    <li><a href='#'>{$menuchannel}</a></li>
                </ul>
              </div>";
    }

}

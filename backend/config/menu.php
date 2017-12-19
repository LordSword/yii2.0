<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/8/20
 * Time: 0:05
 */
use yii\helpers\Url;

$topmenu = [
    'index' => [
        'title' => '首页',
        'icon'  => '/admin/images/icon01.png',
    ],
    'user'  => [
        'title' => '用户管理',
        'icon'  => '/admin/images/icon02.png',
    ],
    'system' => [
        'title' => '系统设置',
        'icon' => '/admin/images/icon06.png',
    ],
];

$menu = [
    'index' => [
        'menu_home' => [
            'title' => '管理中心',
            'icon' => '/admin/images/leftico01.png',
            'menuchannel' => [
                ['title' => '管理中心1', 'redirectUrl' => Url::to(['site/home'])],
                ['title' => '管理中心2', 'redirectUrl' => Url::to(['site/home'])],
                ['title' => '管理中心3', 'redirectUrl' => Url::to(['site/home'])],
            ],
        ],
        'menu_home2' => [
            'title' => '用户管理',
            'icon' => '/admin/images/leftico02.png',
            'menuchannel' => [
                ['title' => '用户列表', 'redirectUrl' => Url::to(['site/home'])],
                ['title' => '借款列表', 'redirectUrl' => Url::to(['site/home'])],
                ['title' => '用户管理', 'redirectUrl' => Url::to(['site/home'])],
            ],
        ],
    ],
    'user' => [

    ],
    'system' => [
        'menu_adminuser' => [
            'title' => '系统管理员',
            'icon' => '/admin/images/leftico01.png',
            'menuchannel' => [
                ['title' => '角色列表', 'redirectUrl' => Url::to(['user/role-list'])],
                ['title' => '人员列表', 'redirectUrl' => Url::to(['site/home'])],
            ],
        ],
    ],
];



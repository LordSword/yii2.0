<?php
/**
 * Created by PhpStorm.
 * User: psmy
 * Date: 2017/12/15
 * Time: 上午11:44
 */
$this->shownav('system','menu_adminuser',0);
?>
<?php echo $this->render('_role-auth', [
    'model' => $model,
    'permissions' => $permissions,
]); ?>
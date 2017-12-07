<?php
/**
 * Created by PhpStorm.
 * User: Hider
 * Date: 2017/12/2
 * Time: 16:42
 */

require ("./lib/init.php");

if (!acc()) {
    //如果没有登录,先跳转到登录页面
    header('Location:login.php');
    exit();
}
include(ROOT."/view/index.html");


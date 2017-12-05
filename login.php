<?php
/**
 * Created by PhpStorm.
 * User: Hider
 * Date: 2017/12/5
 * Time: 21:00
 */

require ("./lib/init.php");
if (empty($_POST)){
    include(ROOT."/view/login.html");
}else{
    $name = trim($_POST['username']);
    $pwd = trim($_POST['password']);

    $sql = "select * from user where name ='" . $name . "'";
    $user = mGetRow($sql);
    if (empty($user)) {
        var_dump($user);
        error('用户名错误');
    } else if ($pwd!== $user['password']) {
        error('密码错误');
    } else {
        setcookie('name', $user['name']);
        setcookie('ccode', ccode($user['name']));
        header('Location:index.php');
    }
}
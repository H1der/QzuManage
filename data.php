<?php
/**
 * Created by PhpStorm.
 * User: Hider
 * Date: 2017/11/28
 * Time: 21:07
 */


//$cats = mGetRow($sql);
//print_r($cats);
//exit();
if(empty($_POST)){
    $sql = 'select * from employee';
    $cats = mGetAll($sql);
include (ROOT.'./view/data.html');
}else{
    $empNo = $_POST['search'];
    $sql = 'select * from employee where empNo='.$empNo;
    mGetAll($sql);
    $cats = mGetAll($sql);
    include (ROOT.'./view/data.html');
}
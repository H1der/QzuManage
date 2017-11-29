<?php
/**
 * Created by PhpStorm.
 * User: Hider
 * Date: 2017/11/28
 * Time: 21:07
 */
include ('./lib/init.php');
$sql = 'select * from employee';
$cats = mGetAll($sql);

//$cats = mGetRow($sql);
//print_r($cats);
//exit();

include (ROOT.'./view/data.html');
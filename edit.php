<?php
/**
 * Created by PhpStorm.
 * User: Hider
 * Date: 2017/12/7
 * Time: 20:51
 */

require ("./lib/init.php");

$empNo = $_GET['empNo'];
$sql = 'select * from employee where empNo='.$empNo;
$rs = mGetAll($sql);
$sexman = <<< HTML
<input type="radio" name="empsex" value="男" title="男" checked="">
<input type="radio" name="empsex" value="女" title="女">
HTML;

$sexwoman = <<< HTML
<input type="radio" name="empsex" value="男" title="男">
<input type="radio" name="empsex" value="女" title="女" checked="">
HTML;

$engprodz = <<< HTML
<option value=""></option>
<option value="大专" selected="">大专</option>
<option value="本科" >本科</option>
<option value="硕士">硕士</option>
<option value="博士及以上">博士及以上</option>
HTML;

$engprobk = <<< HTML
<option value=""></option>
<option value="大专">大专</option>
<option value="本科" selected="">本科</option>
<option value="硕士">硕士</option>
<option value="博士及以上">博士及以上</option>
HTML;

$engpross = <<< HTML
<option value=""></option>
<option value="大专">大专</option>
<option value="本科" >本科</option>
<option value="硕士"selected="">硕士</option>
<option value="博士及以上">博士及以上</option>
HTML;

$engprobs = <<< HTML
<option value=""></option>
<option value="大专">大专</option>
<option value="本科" >本科</option>
<option value="硕士">硕士</option>
<option value="博士及以上"selected="">博士及以上</option>
HTML;

$marstan = <<<HTML
<option value=""></option>
<option value="未婚" selected="">未婚</option>
<option value="已婚">已婚</option>
HTML;
$marstay = <<<HTML
<option value=""></option>
<option value="未婚">未婚</option>
<option value="已婚" selected="">已婚</option>
HTML;

$workingy = <<<HTML
<option value=""></option>
<option value="在职" selected="">在职</option>
<option value="离职">离职</option>
HTML;
$workingn = <<<HTML
<option value=""></option>
<option value="在职">在职</option>
<option value="离职" selected="">离职</option>
HTML;



if (empty($_POST)) {
    include(ROOT . '/view/edit.html');
}else{
    $employee['empNo'] = trim($_POST['empNo']);
    $employee['empName'] = trim($_POST['empName']);
    $employee['empAge'] = trim($_POST['empAge']);
    $employee['depName'] = trim($_POST['depName']);
    $employee['empsex'] = trim($_POST['empsex']);
    $employee['empAddress'] = trim($_POST['empAddress']);
    $employee['empPhone'] = trim($_POST['empPhone']);
    $employee['engpro'] = trim($_POST['engpro']);
    $employee['marsta'] = trim($_POST['marsta']);
    $employee['working'] = trim($_POST['working']);
    mExec('employee',$employee,'update','empNo='.$empNo);

    header('Location:index.php');
}



<?php
/**
 * mysql.php mysql操作的系列函数
 * @author Hider
 */
/**
 * 连接数据库
 * @return resource 成功返回一个资源
 */
function mConn()
{
    //静态变量似的mConn在同一页面 数据库值只连接一次
    static $conn = null;
    if ($conn === null) {
        $cfg = require(ROOT . '/lib/config.php');
        $conn = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
        mysqli_query($conn, 'set names utf8');
//        mysqli_query($conn, 'set character set' . $cfg['charset']);
    }
    return $conn;
}

/**
 * 执行sql语句
 *
 * @param  string $sql
 * @return mixed 返回布尔值类型/资源
 */
function mQuery($sql)
{
    $rs = mysqli_query(mConn(), $sql);
    if ($rs === false) {
        mLog($sql . "\n" . mysqli_error($rs));
        return $rs;
    }
    mLog($sql);
    return $rs;
}

/**
 * 记录执行的送起来以及出错信息
 * @param $log 记录的信息
 */
function mLog($log)
{
    $path = ROOT . '/log/' . date('Ymd', time()) . '.txt';
    //格林威治时间+8小时=北京时间
    $head = '--------------------------------' . "\n" . date('Y/m/d H:i:s', time() + 8 * 3600) . "\n";
    file_put_contents($path, $head . $log . "\n" . "\n", FILE_APPEND);
}

/**
 * 查询select语句并返回多行,适用于查多条数据
 * @param string $sql select语句
 * @return mixed array 查询到返回二位数组,未查到返回false
 */
function mGetAll($sql)
{
    $rs = mQuery($sql);
    if (!$rs) {
        return false;
    } else {
        $arr = array();
        while ($row = mysqli_fetch_assoc($rs)) {
            $arr[] = $row;
        }
    }
    return $arr;
}

/**
 * select 取出一行数据
 *
 * @param str $sql 待查询的sql语句
 * @return arr/false 查询成功 返回一个一维数组
 */

function mGetRow($sql) {
    $rs = mQuery($sql);
    if(!$rs) {
        return false;
    }

    return mysqli_fetch_assoc($rs);
}

//$sql = 'select count(*) from cat';
//echo mGetOne($sql);
/**
 * 查询select语句并返回一个单元
 * @param string $sql select语句
 * @return mixed string 返回一个标量值未查到返回false
 */
function mGetOne($sql)
{
    $rs = mQuery($sql);
    if ($rs) {
        $row = mysqli_fetch_row($rs);
        return $row[0];
    } else {
        return false;
    }
}

/**
 * 拼接sql语句并发送查询
 * @param array $data 要插入或更改的数据,键代表列明,值为新值
 * @param string $table 带插入的表名
 * @param string $act 插入还是更新 默认为insert
 * @param string $where 繁殖update语句更改忘记加where改了所有的值
 * @return bool insert或者update插入成功或者失败
 */
function mExec($table, $data, $act = 'insert', $where = '0')
{
    if ($act == 'insert') {
        $sql = "insert into $table (";
        $sql .= implode(',', array_keys($data)) . ") values ('";
        $sql .= implode("','", array_values($data)) . "')";
        return mQuery($sql);
    } else if ($act == 'update') {
        $sql = "update $table set ";
        foreach ($data as $k => $v) {
            $sql .= $k . "='" . $v . "',";
        }
        $sql = rtrim($sql, ',');
        $sql .= 'where ' . $where;
        return mQuery($sql);
    }
}

/**
 * 返回最近一次insert长生的主键值
 * @return int
 */
function getListId()
{
    return mysqli_insert_id(mConn());
}


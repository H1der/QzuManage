<?php
/**
 * 成功返回的信息
 */
function succ($res)
{
    $result = 'succ';
    include(ROOT . '/view/admin/info.html');
    exit;
}

/**
 * 失败返回的报错信息
 */

function error($res)
{
    $result = 'fail';
    include(ROOT . '/view/admin/info.html');
    exit;
}

/**
 * @param int $num 文章总数
 * @param int $curr 当前显示的页码数      $curr-2 $curr-1 $curr $curr+1 $curr+2
 * @param int $cnt 每页显示的条数
 * @return arr
 *
 */
function getPage($num, $curr, $cnt)
{
    //最大的页码数
    $max = ceil($num / $cnt);
    //最左侧页码
    $left = max(1, $curr - 2);

    //最右侧页码
    $right = min($left + 4, $max);

    $left = max(1, $right - 4);

    /*	(1 [2] 3 4 5) 6 7 8 9
        1 2 (3 4 [5] 6 7) 8 9
        1 2 3 4 (5 6 7 [8] 9)*/
    $page = array();
    for ($i = $left; $i <= $right; $i++) {
        $_GET['page'] = $i;
        $page[$i] = http_build_query($_GET);
    }

    return $page;
}


/**
 * 获取来访者ip
 * @return array|false|null|string
 *
 */
function getIp()
{
    static $realip = null;
    if ($realip !== null) {
        return $realip;
    }
    if (getenv('HTTP_X_FORWARDED_FOR')) {
        $realip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('HTTP_CLIENT_IP')) {
        $realip = getenv('HTTP_CLIENT_IP');
    } else {
        $realip = getenv('REMOTE_ADDR');
    }
    return $realip;
}

/**
 * 生成随机字符串
 * @param int $num 生成的随机字符串的个数
 * @return str 生成的随机字符串
 */
function randStr($num = 6)
{
    $str = str_shuffle('abcedfghjkmnpqrstuvwxyzABCEDFGHJKMNPQRSTUVWXYZ23456789');
    return substr($str, 0, $num);
}

//echo randStr();

/**
 * 创建目录 ROOT.'/upload/2015/01/25/qwefas.jpg'
 *
 */
function createDir()
{
    $path = '/upload/' . date('Y/m/d');
    $fpath = ROOT . $path;
    if (is_dir($fpath) || mkdir($fpath, 0777, true)) {
        return $path;
    } else {
        return false;
    }
}

/**
 * 获取文件后缀
 * @param str $filename 文件名
 * @return str 文件的后缀名,且带点.
 */
function getExt($filename)
{
    return strrchr($filename, '.');
}

/**
 * @param $ori 原始图片路径
 * @param int $sw 缩略图的宽
 * @param int $sh 缩略图的高
 * @return $path 缩略图的路径
 */
function makeThumb($ori, $sw = 200, $sh = 200)
{
    $path = dirname($ori) . '/' . randStr() . '.png';
    $opic = ROOT . $ori;//大图的绝对路径
    $opath = ROOT . $path;//小图的绝对路径
    //原始大图片
    if (!list($bw, $bh, $type) = getimagesize($opic)) {
        return false;
    }
    $map = array(
        1 => 'imagecreatefromgif',
        2 => 'imagecreatefromjpeg',
        3 => 'imagecreatefrompng',
        6 => 'imagecreatefrombmp'
    );
    //如果传来的图片类型不在map里 无法处理则return false
    if (!isset($map[$type])) {
        return false;
    }
    //原始大图
    $func = $map[$type];
    $big = $func($opic);
    //创建小画布
    $small = imagecreatetruecolor($sw, $sh);
    $white = imagecolorallocate($small, 255, 255, 255);
    imagefill($small, 0, 0, $white);

    //计算缩略比
    $rate = min($sw / $bw, $sh / $bh);

    //真正粘到小图上的宽高
    $rw = $bw * $rate;
    $rh = $bh * $rate;
    imagecopyresampled($small, $big, ($sw - $rw) / 2, ($sh - $rh) / 2, 0, 0, $rw, $rh, $bw, $bh);

    //保存缩略图
    imagepng($small, $opath);

    //销毁画布
    imagedestroy($big);
    imagedestroy($small);
    return $path;
}

/**
 * 转移字符
 * 对post,get,cookie数组进行转义
 */
function _addslashes($arr)
{
    foreach ($arr as $k => $v) {
        if (is_string($v)) {
            $arr[$k] = addslashes($v);
        } else if (is_array($v)) {
            $arr[$k] = _addslashes($v);
        }
    }
    return $arr;
}

/**
 * md5加密用户名和盐
 * @param str $name 用户名
 * @return str 返回加密后的字符串
 */
function ccode($name)
{
    $cfg = include(ROOT . '/lib/config.php');
    $salt = $cfg['salt'];
    return md5($name . '|' . $salt);
}

/**
 * 检测是否登录
 */
function acc()
{
    if (!isset($_COOKIE['name']) || !isset($_COOKIE['ccode'])) {
        return false;
    }
    return $_COOKIE['ccode'] === ccode($_COOKIE['name']);
}
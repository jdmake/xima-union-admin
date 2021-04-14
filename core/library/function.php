<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/16
// +----------------------------------------------------------------------

/**
 * 接收参数
 */
if (!function_exists('input')) {
    function input($key, $default = '')
    {
        $value = isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
        return filter_words($value);
    }
}

/**
 * 输出错误页面
 */
if (!function_exists('app_error')) {
    function app_error($message, $jump_url = '', $second = 3)
    {
        echo view('error', [
            'message' => $message,
            'second' => $second,
            'url' => $jump_url
        ]);
        exit();
    }
}

/**
 * 输出成功页面
 */
if (!function_exists('app_success')) {
    function app_success($message, $jump_url = '', $second = 1)
    {
        echo view('success', [
            'message' => $message,
            'second' => $second,
            'url' => $jump_url
        ]);
        exit();
    }
}

/**
 * 判断请求方式
 */
if (!function_exists('method')) {
    function method()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }
}

/**
 * 安全过滤
 */
if (!function_exists('filter_words')) {
    function filter_words($str)
    {
        $arr = array(
            "/<(\\/?)(script|i?frame|style|html|body|title|link|meta|object|\\?|\\%)([^>]*?)>/isU",
            "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",
            "/select\b|insert\b|update\b|delete\b|drop\b|;|\"|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile|dump/is"
        );
        if (is_array($str)) {
            foreach ($str as &$item) {
                $item = preg_replace($arr, '', $item);
                $item = strip_tags($item);
            }
        }

        return $str;
    }
}

/**
 * 渲染模板
 */
if (!function_exists('view')) {
    function view($template, $vars = [])
    {
        return \library\template\Template::create()->render($template, $vars);
    }
}

/**
 * 创建DB
 */
if (!function_exists('db')) {
    function db()
    {
        return \library\db\Db::create();
    }
}

/**
 * 递归创建文件
 */
if (!function_exists('mkdirss')) {
    function mkdirss($dirs, $mode = 0777)
    {
        if (!is_dir($dirs)) {
            mkdirss(dirname($dirs), $mode);
            return @mkdir($dirs, $mode);
        }
        return true;
    }
}

// 汉字转拼单
if (!function_exists('convert_pinyin')) {
    function u2g($str)
    {
        return iconv("UTF-8", "GBK", $str);
    }

    function g2u($str)
    {
        return iconv("GBK", "UTF-8//ignore", $str);
    }

    function convert_pinyin($str, $ishead = 0, $isclose = 1)
    {
        $str = u2g($str);//转成GBK
        global $pinyins;
        $restr = '';
        $str = trim($str);
        $slen = strlen($str);
        if ($slen < 2) {
            return $str;
        }
        if (@count($pinyins) == 0) {
            $fp = fopen(APP_CORE . 'library' . DIRECTORY_SEPARATOR . 'pinyin.dat', 'r');
            while (!feof($fp)) {
                $line = trim(fgets($fp));
                $pinyins[$line[0] . $line[1]] = substr($line, 3, strlen($line) - 3);
            }
            fclose($fp);
        }
        for ($i = 0; $i < $slen; $i++) {
            if (ord($str[$i]) > 0x80) {
                $c = $str[$i] . $str[$i + 1];
                $i++;
                if (isset($pinyins[$c])) {
                    if ($ishead == 0) {
                        $restr .= $pinyins[$c];
                    } else {
                        $restr .= $pinyins[$c][0];
                    }
                } else {
                    //$restr .= "_";
                }
            } else if (eregi("[a-z0-9]", $str[$i])) {
                $restr .= $str[$i];
            } else {
                //$restr .= "_";
            }
        }
        if ($isclose == 0) {
            unset($pinyins);
        }
        return $restr;
    }
}

if (!function_exists('http_response_code')) {

    function http_response_code($code = NULL)
    {

        if ($code !== NULL) {

            switch ($code) {
                case 100:
                    $text = 'Continue';
                    break;
                case 101:
                    $text = 'Switching Protocols';
                    break;
                case 200:
                    $text = 'OK';
                    break;
                case 201:
                    $text = 'Created';
                    break;
                case 202:
                    $text = 'Accepted';
                    break;
                case 203:
                    $text = 'Non-Authoritative Information';
                    break;
                case 204:
                    $text = 'No Content';
                    break;
                case 205:
                    $text = 'Reset Content';
                    break;
                case 206:
                    $text = 'Partial Content';
                    break;
                case 300:
                    $text = 'Multiple Choices';
                    break;
                case 301:
                    $text = 'Moved Permanently';
                    break;
                case 302:
                    $text = 'Moved Temporarily';
                    break;
                case 303:
                    $text = 'See Other';
                    break;
                case 304:
                    $text = 'Not Modified';
                    break;
                case 305:
                    $text = 'Use Proxy';
                    break;
                case 400:
                    $text = 'Bad Request';
                    break;
                case 401:
                    $text = 'Unauthorized';
                    break;
                case 402:
                    $text = 'Payment Required';
                    break;
                case 403:
                    $text = 'Forbidden';
                    break;
                case 404:
                    $text = 'Not Found';
                    break;
                case 405:
                    $text = 'Method Not Allowed';
                    break;
                case 406:
                    $text = 'Not Acceptable';
                    break;
                case 407:
                    $text = 'Proxy Authentication Required';
                    break;
                case 408:
                    $text = 'Request Time-out';
                    break;
                case 409:
                    $text = 'Conflict';
                    break;
                case 410:
                    $text = 'Gone';
                    break;
                case 411:
                    $text = 'Length Required';
                    break;
                case 412:
                    $text = 'Precondition Failed';
                    break;
                case 413:
                    $text = 'Request Entity Too Large';
                    break;
                case 414:
                    $text = 'Request-URI Too Large';
                    break;
                case 415:
                    $text = 'Unsupported Media Type';
                    break;
                case 500:
                    $text = 'Internal Server Error';
                    break;
                case 501:
                    $text = 'Not Implemented';
                    break;
                case 502:
                    $text = 'Bad Gateway';
                    break;
                case 503:
                    $text = 'Service Unavailable';
                    break;
                case 504:
                    $text = 'Gateway Time-out';
                    break;
                case 505:
                    $text = 'HTTP Version not supported';
                    break;
                default:
                    exit('Unknown http status code "' . htmlentities($code) . '"');
                    break;
            }

            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

            header($protocol . ' ' . $code . ' ' . $text);
            $GLOBALS['http_response_code'] = $code;
        } else {

            $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);

        }

        return $code;

    }
}

//生成字母前缀
if (!function_exists('convert_letter')) {
    function convert_letter($s0)
    {
        $firstchar_ord = ord(strtoupper($s0{0}));
        if (($firstchar_ord >= 65 and $firstchar_ord <= 91) or ($firstchar_ord >= 48 and $firstchar_ord <= 57)) return $s0{0};
        $s = iconv("UTF-8", "gb2312", $s0);
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 and $asc <= -20284) return "A";
        if ($asc >= -20283 and $asc <= -19776) return "B";
        if ($asc >= -19775 and $asc <= -19219) return "C";
        if ($asc >= -19218 and $asc <= -18711) return "D";
        if ($asc >= -18710 and $asc <= -18527) return "E";
        if ($asc >= -18526 and $asc <= -18240) return "F";
        if ($asc >= -18239 and $asc <= -17923) return "G";
        if ($asc >= -17922 and $asc <= -17418) return "H";
        if ($asc >= -17417 and $asc <= -16475) return "J";
        if ($asc >= -16474 and $asc <= -16213) return "K";
        if ($asc >= -16212 and $asc <= -15641) return "L";
        if ($asc >= -15640 and $asc <= -15166) return "M";
        if ($asc >= -15165 and $asc <= -14923) return "N";
        if ($asc >= -14922 and $asc <= -14915) return "O";
        if ($asc >= -14914 and $asc <= -14631) return "P";
        if ($asc >= -14630 and $asc <= -14150) return "Q";
        if ($asc >= -14149 and $asc <= -14091) return "R";
        if ($asc >= -14090 and $asc <= -13319) return "S";
        if ($asc >= -13318 and $asc <= -12839) return "T";
        if ($asc >= -12838 and $asc <= -12557) return "W";
        if ($asc >= -12556 and $asc <= -11848) return "X";
        if ($asc >= -11847 and $asc <= -11056) return "Y";
        if ($asc >= -11055 and $asc <= -10247) return "Z";
        return 0;//null
    }

    /**
     * 文件夹文件（深）拷贝
     * @param string $src 来源文件夹
     * @param string $dst 目的地文件夹
     * @return bool
     */
    function recursive_dir_copy($src, $dst)
    {
        if (empty($src) || empty($dst)) {
            return false;
        }

        $dir = opendir($src);

        dir_mkdir($dst);

        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                $srcRecursiveDir = $src . DIRECTORY_SEPARATOR . $file;
                $dstRecursiveDir = $dst . DIRECTORY_SEPARATOR . $file;

                if (is_dir($srcRecursiveDir)) {
                    recursive_dir_copy($srcRecursiveDir, $dstRecursiveDir);
                } else {
                    copy($srcRecursiveDir, $dstRecursiveDir);
                }
            }
        }

        closedir($dir);

        return true;
    }

    /**
     * 创建文件夹
     * @param string $path 文件夹路径
     * @param int $mode 访问权限
     * @param bool $recursive 是否递归创建
     * @return bool
     */
    function dir_mkdir($path = '', $mode = 0755, $recursive = true)
    {
        clearstatcache();

        if (!is_dir($path)) {
            mkdir($path, $mode, $recursive);
            return chmod($path, $mode);
        }
        return true;
    }

    /**
     * curl GET 请求
     */
    function curl_get($url, $header = [], $timeout = 10, $referer = '')
    {
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            if(strstr($url, 'https://')) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            }

            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_REFERER, $referer);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)');

            $content = curl_exec($ch);

            if(curl_getinfo($ch)['http_code'] == 200 && $content) {
                curl_close($ch);
                return $content;
            }
            curl_close($ch);

        }
        $ctx = stream_context_create(array('http' => array('timeout' => $timeout)));
        $content = @file_get_contents($url, 0, $ctx);
        if ($content) {
            return $content;
        }
        return false;
    }

    function MyDate($format, $date)
    {
        return date($format, $date);
    }
    function cn_substr($str, $len)
    {
        return mb_substr($str, 0, $len, 'utf-8');
    }
    function html2text($str)
    {
        $str = preg_replace([
            '/(<.*?>)/is',
            '/\r\n/is',
            '/\t/is',
        ], '', $str);
        return htmlspecialchars($str);
    }
}

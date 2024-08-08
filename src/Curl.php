<?php
namespace Bonwey\QingtvLive;


// 使用示例
// Get

// echo ajax_curl("https://api.oioweb.cn/api/beian.php?url=qq.com");
// Post

// echo ajax_curl("https://api.oioweb.cn/api/beian.php",[
//     'post'=>[
//         'url'=>'qq.com'
//     ]
// ]);
// 文件上传

// echo ajax_curl("https://api.oioweb.cn/api/beian.php?url=qq.com",[
//     'post'=>[
//         'file'=>new CURLFile(realpath("Curl.jpg"))
//     ]
// ]);
// 设置请求头

// echo ajax_curl("https://api.oioweb.cn/api/beian.php?url=qq.com",[
//     'Header'=>[
//         'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3
// accept-encoding: gzip, deflate, br
// accept-language: zh-CN,zh;q=0.9
// cache-control: max-age=0'
//     ]
// ]);
// *模拟UseaAgent

// echo ajax_curl("https://api.oioweb.cn/api/beian.php?url=qq.com",[
//     'ua'=>'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36'
// ]);
// 携带Cookie

// echo ajax_curl("https://api.oioweb.cn/api/beian.php?url=qq.com",[
//     'cookie'=>'cookie内容'
// ]);
class Curl {
    function ajax_curl($url, $paras = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if (isset($paras['Header'])) {
            $Header = $paras['Header'];
        } else {
            $Header[] = "Accept:*/*";
            $Header[] = "Accept-Encoding:gzip,deflate,sdch";
            $Header[] = "Accept-Language:zh-CN,zh;q=0.8";
            $Header[] = "Connection:close";
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $Header);
        if (isset($paras['ctime'])) { // 连接超时
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $paras['ctime']);
        } else {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        }
        if (isset($paras['rtime'])) { // 读取超时
            curl_setopt($ch, CURLOPT_TIMEOUT, $paras['rtime']);
        }
        if (isset($paras['post'])) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $paras['post']);
        }
        if (isset($paras['header'])) {
            curl_setopt($ch, CURLOPT_HEADER, true);
        }
        if (isset($paras['cookie'])) {
            curl_setopt($ch, CURLOPT_COOKIE, $paras['cookie']);
        }
        if (isset($paras['refer'])) {
            if ($paras['refer'] == 1) {
                curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
            } else {
                curl_setopt($ch, CURLOPT_REFERER, $paras['refer']);
            }
        }
        if (isset($paras['ua'])) {
            curl_setopt($ch, CURLOPT_USERAGENT, $paras['ua']);
        } else {
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36");
        }
        if (isset($paras['nobody'])) {
            curl_setopt($ch, CURLOPT_NOBODY, 1);
        }
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (isset($paras['GetCookie'])) {
            curl_setopt($ch, CURLOPT_HEADER, 1);
            $result = curl_exec($ch);
            preg_match_all("/Set-Cookie: (.*?);/m", $result, $matches);
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($result, 0, $headerSize); //状态码
            $body = substr($result, $headerSize);
            $ret = [
                "Cookie" => $matches, "body" => $body, "header" => $header, 'code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
            ];
            curl_close($ch);
            return $ret;
        }
        $ret = curl_exec($ch);
        $error = curl_error($ch);
        if($error){
            return $error;
        }
        if (isset($paras['loadurl'])) {
            $Headers = curl_getinfo($ch);
            if (isset($Headers['redirect_url'])) {
                $ret = $Headers['redirect_url'];
            } else {
                $ret = false;
            }
        }
        curl_close($ch);
        return $ret;
    }
}
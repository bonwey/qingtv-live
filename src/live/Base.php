<?php
namespace Bonwey\QingtvLive\live;
use Bonwey\QingtvLive\Curl;
class Base { 

    public $host;
    public $curl;

    public function __construct(){
        $this->host = config('qingtvlive.host') ?? 'http://172.16.33.119:1607/api/';
        $this->curl = new Curl();
    }


    /**
     * 分析curl返回的结果
     */
    public function returnData($data){
        $arr = [
            'code'  =>  0,
            'msg'   =>  'success',
            'data'  => []
        ];
        if($data == false){
            $arr['code'] = -1;
            $arr['msg'] = 'CURL请求失败';
            return $data;
        }
        try{
            $data = json_decode($data,true);
        }catch(\Exception $e){
            $arr['code'] = -1;
            $arr['msg'] = '数据解析失败';
            return $arr;
        }
        if(!isset($data['code'])){
            $arr['code'] = -1;
            $arr['msg'] = '数据格式错误';
            return $arr;
        }
        if($data['code'] != 200){
            $arr['code'] = -1;
            $arr['msg'] = $data['message'] ?? $data['error'];
            return $arr;
        }
        // unset($data['data']['mobile']);
        // unset($data['data']['company']);
        $arr['data'] = $data['data'];
        return $arr;
    }

    /**
     * 拼接url
     */
    public function build_url($param){
        return http_build_query($param);
    }

    /**
     * get请求封装
     */
    public function http_get($url,$param) {
        return $this->returnData($this->curl->ajax_curl($this->host.$url.'?'.$this->build_url($param)));
    }

    /**
     * post请求封装
     */
    public function http_post($url,$param) {
        return $this->returnData($this->curl->ajax_curl($this->host.$url,['post'=>$param]));
    }

    /**
     * 统一数据返回
     */
    public function resArr($code,$msg,$data=[]) {
        return [
            'code'  =>  $code,
            'msg'   =>  $msg,
            'data'  =>  $data
        ];
    }

}
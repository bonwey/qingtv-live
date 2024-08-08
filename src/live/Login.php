<?php
namespace Bonwey\QingtvLive\live;
use Bonwey\QingtvLive\live\Base;

class Login extends Base{

    /**
     * 身份赋予
     * studio_id 直播间ID
     * user_id 观众ID
     * name 观众昵称
     * avatar 观众头像
     * key 密钥（由观众ID拼接AuthKey的字符串后使用MD5加密得到）, AuthKey需要到轻直播后台授权观看的身份赋予栏目内获取
     * expire 过期时间（单位：秒）
     */
    public function login($param){
        return $this->http_post('v1/live/api_endowment',$param);
    }
}
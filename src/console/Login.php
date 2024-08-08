<?php
namespace Bonwey\QingtvLive\console;
use Bonwey\QingtvLive\console\Base;

class Login extends Base{

    /**
     * 后台登录
     * mobile 手机号
     * password 密码
     * type 登录方式 0 验证码 1 密码
     * code 验证码
     */
    public function login($param){
        return $this->http_post('v1/admin/login',$param);
    }

    /**
     * 直播助手登录
     * account 账号
     * password 密码
     * studio_id 直播间ID
     * target_studio_id
     */
    public function helper_login($param){
        return $this->http_post('v1/live/login_helper',$param);
    }
}
<?php
namespace Bonwey\QingtvLive\console;
use Bonwey\QingtvLive\console\Base;

class Room extends Base{
    /**
     * 获取直播间列表
     * @param array
     * more 是否按照直播间ID查询 0.否 1.是
     * keywords 关键字(指定直播间查询，需要配合more参数:100001,100002)
     * page 页码
     * page_num 每页条目
     * file_class   分类id 空为全部
     * status   直播间状态 全部 0.预告 1.直播中 2.已结束 3.回放
     * mode 直播模板 全部 0.视频 3.互动 4.多流 5.多语
     * push_type    直播延迟 全部 0.正常直播 1.低延迟直播
     * file_class_status    直播间分类 0全部 1已分类 2未分类
     * start_at 开始时间
     * end_at   结束时间
     * create_at_order  创建时间排序 0关闭 1倒叙 2正序 默认1
     * start_at_order   开播时间 0关闭 1倒叙 2正序
     * status_order 直播状态排序 0关闭 1倒叙 2正序
     * sub_studio   子账号直播间 0全部
     */
    public function live_studio_list($param=[]) {
        return $this->http_get('v2/live/live_studio_list',$param);
    }

    /**
     * 创建直播间
     * title 直播间标题
     * mode 直播间模式 （0.视频 1.文档 2.音频 3.互动 4.多频道 5.多语种 6.竖屏直播）
     * people_mode 人数显示模式（0.不显示 1.实时在线 2.用户量 3.累计访问量）
     * start_at 开始时间
     * end_at 结束时间
     * chat_type 聊天室模式（1.轻聊版 2.标准版）
     */
    public function live_studio_create($param=[]){
        if(!isset($param['title']) || $param['title'] == ''){
            return $this->resArr(-1,'直播间标题不能为空');
        }
        if(!isset($param['start_at']) || $param['title'] == ''){
            return $this->resArr(-1,'直播开始时间不能为空');
        }
        if(!isset($param['end_at']) || $param['title'] == ''){
            return $this->resArr(-1,'直播间结束时间不能为空');
        }
        $arr = [
            'title' =>  $param['title'],
            'mode'  =>  $param['mode'] ?? 0,
            'people_mode'   =>  $param['people_mode'] ?? 3,
            'start_at'  =>  $param['start_at'],
            'end_at'    =>  $param['end_at'],
            'chat_type' =>  $param['chat_type'] ?? 1
        ];
        return $this->http_post('v1/live/create',$arr);
    }

    /**
     * 获取直播间详情
     * studio_id 直播间ID
     */
    public function live_studio_info($param = []) {
        if(!isset($param['studio_id']) || $param['studio_id'] == ''){
            return $this->resArr(-1,'直播间ID不能为空');
        }
        return $this->http_get('v1/live/get_live_info',['studio_id'=>$param['studio_id']]);
    }

    /**
     * 新增直播助手
     * account 账号
     * password 密码
     * 权限
     * chat 聊天互动
     * control 直播控制
     * set 直播设置
     * data 数据中心
     * studio_id 直播间ID
     */
    public function add_live_helper($param) {
        return $this->http_post('v1/live/add_live_helper',$param);
    }

    /**
     * 开关直播助手
     * status 0 关 1 开
     * studio_id 直播间ID
     */
    public function edit_live_helper($param) {
        return $this->http_post('v1/live/edit_live_helper',$param);
    }

    /**
     * 删除直播间
     * ids 直播间ID 多个用英文状态的逗号分隔
     * deleted_at 删除固定传1
     */
    public function delete_live_studio($param){
        if(!isset($param['ids']) || $param['ids'] == ''){
            return $this->resArr(-1,'直播间ID不能为空');
        }
        $param['deleted_at'] = 1;
        return $this->http_post('v1/live/delete',$param);
    }

    /**
     * 编辑直播间
     * studio_id 直播间ID
     * title    直播间标题
     * start_at 开始时间
     * end_at   结束时间
     * chat_type    聊天模式 （1.轻聊版 2.标准版）
     */
    public function edit_live_studio($param){
        if(!isset($param['studio_id']) || $param['studio_id'] == ''){
            return $this->resArr(-1,'直播间ID不能为空');
        }
        $param['chat_type'] = 1;
        return $this->http_post('v1/live/set_studio_info',$param);
    }


    /**
     * 开启自定义授权
     * studio_id 直播间ID
     * callback 回调地址
     * status 功能状态 0关 1开
     * identity_point 单点登录 0关 1开
     * 
     */
    public function custom_authorization($param){
        return $this->http_post('v1/live/custom_authorization',$param);
    }
}
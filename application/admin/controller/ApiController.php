<?php
/**
 */

namespace app\admin\controller;
use think\Controller;
class ApiController extends Controller
{
//    查询用户信息
    public function user(){

        $message='';
//        获取用户参数
        $name = input('name')?input('name'):$message = '请输入名字';
        $age = input('age')?input('age'):$message = '请输入年龄';
        $sex = input('sex');
        $sign = input('sign')?input('sign'):$message = '签名不能为空';

        if($message){
            $this->api_result('1',$message);
        }
//匹配数据库用户信息
        $condition = array(
            'nsme' => $name,
            'age'  => $age,
        );
//判断性别是否为空
        if($sex){
            $condition['sex'] = $sex;
        }
//查询数据库用户信息
        $data = db('table')->where($condition)->find();
//判断用户数据是否正确
        if(!$data){
            $this->api_result('1','用户数据不存在');
        }
//匹配用户信息成功返回
        $this->api_result('0','请求成功',$data);
    }
//定义用户信息转json判断是否成功
    public function api_result($code,$message,$data){
        $res = array(
            'code'=>$code,
            'message'=>$message,
        );
        $data?$res['data']=$data:'';

        if($data){
            $res['data']=$data;
        }

        echo json_encode($res,320);die;
    }
}
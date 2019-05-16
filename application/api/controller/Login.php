<?php
namespace app\api\controller;

use think\Controller;
use think\Request;
use Think\Db;

class Login extends Controller
{
     /**
    * 授权登录
    *
    * @return void
    */
    public function login()
    {
        $code=input('code');

        $payment=db("payment")->where("id",1)->find();
        $appid = $payment['appid'];
        $secret = $payment['appsecret'];
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$secret."&js_code=".$code."&grant_type=authorization_code";
        $results=json_decode(file_get_contents($url),true);
        
        $openid=$results['openid'];
        if(!$openid){
            $arr=[
                'error_code'=>1,
                'msg'=>'openID获取失败',
                'data'=>''
            ];
        }else{
            
            $data['openid']=$openid;
            $data['nickname']=\input('nickname');
            $data['image']=\input('image');
            
            $ret=db('user')->where(array('openid'=>$openid))->find();
            if($ret['openid']){
                $res=db("user")->where(array('openid'=>$openid))->update($data);

                //首次登陆赠送积分
                $login_log=db("integ_log")->where(["uid"=>$ret['uid'],"type"=>1,"types"=>1])->whereTime("time","d")->find();

                if(empty($login_log)){
                    //查询登陆赠送积分

                    $integ=db("integ")->where("id",1)->find();

                    $data['uid']=$ret['uid'];
                    $data['integ']=$integ['integ'];
                    $data['content']="登陆";
                    $data['type']=1;
                    $data['time']=time();
                    $data['types']=1;

                    
                    // 启动事务
                    Db::startTrans();
                    try{
                        db("user")->where("uid",$ret['uid'])->setInc("integ",$integ['integ']);
                        db("integ_log")->insert($data);
                        // 提交事务
                        Db::commit();    
                    } catch (\Exception $e) {
                        // 回滚事务
                        Db::rollback();
                    }

                }

                    $arr=[
                        'error_code'=>0,
                        'msg'=>'授权成功',
                        'data'=>[
                            'uid'=>$ret['uid'],
                        ]
                    ];
            }else{
                $data['time']=\time();
                $rea=db('user')->insert($data);
                $uid=db('user')->getLastInsID();
                if($rea){

                    //首次登陆赠送积分
                $login_log=db("integ_log")->where(["uid"=>$uid,"type"=>1,"types"=>1])->whereTime("time","d")->find();

                if(empty($login_log)){
                    //查询登陆赠送积分

                    $integ=db("integ")->where("id",1)->find();

                    $data['uid']=$uid;
                    $data['integ']=$integ['integ'];
                    $data['content']="登陆";
                    $data['type']=1;
                    $data['time']=time();
                    $data['types']=1;

                    
                    // 启动事务
                    Db::startTrans();
                    try{
                        db("user")->where("uid",$uid)->setInc("integ",$integ['integ']);
                        db("integ_log")->insert($data);
                        // 提交事务
                        Db::commit();    
                    } catch (\Exception $e) {
                        // 回滚事务
                        Db::rollback();
                    }

                }

                    $arr=[
                        'error_code'=>0,
                        'msg'=>'授权成功',
                        'data'=>[
                            'uid'=>$uid,
                        ]
                    ];
    
                }else{
                    $arr=[
                        'error_code'=>2,
                        'msg'=>'授权失败',
                        'data'=>''
                    ];
                }
               
            }
        }
        echo \json_encode($arr);
    }
    /**
    * 注册协议
    *
    * @return void
    */
    public function agreement()
    {
        $re=db("lb")->field("desc")->where("fid",1)->find();

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$re
        ];

        echo \json_encode($arr);

    }

    /**
    * 获取验证码
    *
    * @return void
    */
    public function getcode(){
        $phone=input('phone');
        $re=db('user')->where("phone=$phone")->find();
        if($re){
            $arr=[
                'error_code'=>1,
                'msg'=>'此手机号已注册',
                'data'=>""
            ];
        }else{
            $code =mt_rand(100000,999999);       
            $data['phone']=$phone;
            $data['code']=$code;
            $data['time']=time();
            $re=\db("sms_code")->where("phone='$phone'")->find();
            if($re){
                $del=db("sms_code")->where("phone='$phone'")->delete();
            }
            $rea=db("sms_code")->insert($data);
            Post($phone,$code);
            if($rea){
                $arr=[
                    'error_code'=>0,
                    'msg'=>'发送成功',
                    'data'=>''
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>'发送失败',
                    'data'=>''
                ];
            }
           
        }
        echo json_encode($arr);
    }

    /**
    * 注册
    *
    * @return void
    */
    public function save()
    {
        $phone=input("phone");
        $reu=db("user")->where("phone",$phone)->find();
        $code=input("code");
        $re=db("sms_code")->where(['phone'=>$phone,'code'=>$code])->find();
        if($re){
            $time=$re['time'];
            $times=time();
            $c_time=($times-$time);
            if($c_time < 300){
                db("sms_code")->where("id",$re['id'])->delete();
                if($reu){
                    $arr=[
                        'error_code'=>5,
                        'msg'=>'此手机号码已注册',
                        'data'=>''
                    ];
                }else{
                  $data['phone']=input("phone");
                  $data['pwd']=input("pwd");
                  $data['time']=time();
                  $data['type']=1;

                  $rea=db("user")->insert($data);

                  if($rea){
                        $arr=[
                            'error_code'=>0,
                            'msg'=>'注册成功',
                            'data'=>''
                        ]; 
                  }else{
                        $arr=[
                            'error_code'=>3,
                            'msg'=>'注册失败',
                            'data'=>''
                        ]; 
                  }
                    
                        
                }
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>'验证码已失效',
                    'data'=>''
                ]; 
            }
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'验证码错误',
                'data'=>''
            ];
        }
        
        echo json_encode($arr);
    }

    /**
    *  忘记密码获取验证码
    *
    * @return void
    */
    public function forget_get_code()
    {
        $phone=input('phone');
        $re=db('user')->where("phone=$phone")->find();
        if($re){
            $code =mt_rand(100000,999999);       
            $data['phone']=$phone;
            $data['code']=$code;
            $data['time']=time();
            $re=\db("sms_code")->where("phone='$phone'")->find();
            if($re){
                $del=db("sms_code")->where("phone='$phone'")->delete();
            }
            $rea=db("sms_code")->insert($data);
            Post($phone,$code);
            if($rea){
                $arr=[
                    'error_code'=>0,
                    'msg'=>'发送成功',
                    'data'=>''
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>'发送失败',
                    'data'=>''
                ];
            }
           
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'此手机号未注册',
                'data'=>""
            ];
            
        }
        echo json_encode($arr);
    }

    /**
    * 修改密码
    *
    * @return void
    */
    public function usave()
    {
        $code=input("code");
        $phone=input("phone");
        $re=db("sms_code")->where(['phone'=>$phone,'code'=>$code])->find();
        if($re){
            $time=$re['time'];
            $times=time();
            $c_time=($times-$time);
            if($c_time < 300){
                db("sms_code")->where("id",$re['id'])->delete();
                $user=db("user")->where("phone",$phone)->find();
                if($user){
                    $data['pwd']=input("pwd");
                    db("user")->where("phone",$phone)->update($data);
                   
                    $arr=[
                        'error_code'=>0,
                        'msg'=>'修改成功',
                        'data'=>''
                    ]; 
                    
                }else{
                    $arr=[
                        'error_code'=>3,
                        'msg'=>'此手机号码未注册',
                        'data'=>''
                    ]; 
                }
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>'验证码已失效',
                    'data'=>''
                ]; 
            }
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'验证码错误',
                'data'=>''
            ];
        }
        
        echo json_encode($arr);

    }
    /**
    * 登录
    *
    * @return void
    */
    public function index()
    {
        $phone=input("phone");
        $pwd=input("pwd");
        $re=db("user")->where(["phone"=>$phone,"pwd"=>$pwd])->find();
        if($re){

               //首次登陆赠送积分
               $login_log=db("integ_log")->where(["uid"=>$re['uid'],"type"=>1,"types"=>1])->whereTime("time","d")->find();

               if(empty($login_log)){
                   //查询登陆赠送积分

                   $integ=db("integ")->where("id",1)->find();

                   $data['uid']=$re['uid'];
                   $data['integ']=$integ['integ'];
                   $data['content']="登陆";
                   $data['type']=1;
                   $data['time']=time();
                   $data['types']=1;

                   
                   // 启动事务
                   Db::startTrans();
                   try{
                       db("user")->where("uid",$re['uid'])->setInc("integ",$integ['integ']);
                       db("integ_log")->insert($data);
                       // 提交事务
                       Db::commit();    
                   } catch (\Exception $e) {
                       // 回滚事务
                       Db::rollback();
                   }

               }
          
            $arr=[
                'error_code'=>0,
                'msg'=>'登录成功',
                'data'=>['uid'=>$re['uid']]
            ]; 
         
            
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'账号或密码错误',
                'data'=>[]
            ]; 
        }
        echo json_encode($arr);
    }
    /**
    * 关于我们
    *
    * @return void
    */
    public function about()
    {
        $re=db("sys")->where("id",1)->find();
        $url=Request::instance()->domain();

        $arrs['logo']=$url.$re['pclogo'];
        $arrs['content']=$re['content'];

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$arrs
        ]; 
        echo json_encode($arr);
    }

  

}
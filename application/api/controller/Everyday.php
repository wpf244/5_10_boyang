<?php
namespace app\api\controller;

use think\Request;
use think\Db;

class Everyday extends  BaseApi
{
    /**
    * 每日答题
    *
    * @return void
    */
    public function index()
    { 
        $uid=Request::instance()->header("uid");
        
        //每日答题列表
         $list=db("topic_day")->field("id,title,statu")->where("statu",0)->order("id desc")->limit("0,4")->select();

         foreach($list as $k => $v){
             $re=db("topic_day_log")->where(["uid"=>$uid,"did"=>$v['id']])->find();
             if($re){
                if($re['status'] == 0){
                    $list[$k]['status']=1;
                }else{
                    $list[$k]['status']=2;
                } 
                
                $list[$k]['number']=$re['number'];

             }else{
                 $list[$k]['status']=0;
             }
         }

         //答题次数
         $nums=db("topic_day_log")->where(["uid"=>$uid])->count();

         //奖励积分
         $integs=db("topic_day_log")->where(["uid"=>$uid])->sum("integ");

         //今日最佳成绩
         $number=db("topic_day_log")->where(["uid"=>$uid])->order("number desc")->find();

         if($number){
             $numbers=$number['number'];
         }else{
             $numbers=0;
         }
         $user['nums']=$nums;
         $user['integs']=$integs;
         $user['number']=$numbers;


         $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>[
                'user'=>$user,
                'list'=>$list,
            ]
        ]; 
        echo json_encode($arr);
    }
    /**
    * 每日答题更多
    *
    * @return void
    */
    public function more()
    {
        $uid=Request::instance()->header("uid");
        
        //每日答题列表
         $list=db("topic_day")->field("id,title,statu")->order("id desc")->select();

         foreach($list as $k => $v){
             $re=db("topic_day_log")->where(["uid"=>$uid,"did"=>$v['id']])->find();
             if($re){
                $list[$k]['status']=1;
                $list[$k]['number']=$re['number'];

             }else{
                 $list[$k]['status']=0;
             }
         }
         $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$list
        ]; 
        echo json_encode($arr);
    }
    /**
    * 答题列表
    *
    * @return void
    */
    public function lister()
    {
        $id=input("id");

        $re=db("topic_day")->where(["id"=>$id])->find();

        $tid=$re['tid'];

        $tids=\explode(",",$tid);

        $list=db("topic")->where(["id"=>["in",$tids]])->select();

        foreach($list as $k => $v){
            $list[$k]['option']=explode(",",$v['option']);
        }

        $uid=Request::instance()->header("uid");

        $num=db("topic_log")->where(["uid"=>$uid,"did"=>$id])->count();

        $log=db("topic_day_log")->where(["uid"=>$uid,"did"=>$id])->find();

        if($log){
            $num=0;
        }

        

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>[
                'title'=>$re['title'],
                'num'=>$num,
                'list'=>$list,
            ]
        ]; 
        echo json_encode($arr);
    }
    /**
    * 政治学习列表
    *
    * @return void
    */
    public function study()
    {
        $uid=Request::instance()->header("uid");

        $re=db("study")->whereTime("time","d")->find();

        $sid=$re['id'];

        $log=db("study_log")->where(["uid"=>$uid,"sid"=>$sid])->find();

        if($log){

            $arr=[
                'error_code'=>1,
                'msg'=>'今天已经做过了,明天再来吧',
                'data'=>[]
            ]; 
        }else{
          
            $tid=$re['tid'];

            $tids=\explode(",",$tid);

            $list=db("topic")->where(["id"=>["in",$tids]])->where("types",1)->select();

            foreach($list as $k => $v){
                $list[$k]['option']=explode(",",$v['option']);
            }

            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>[
                    'sid'=>$sid,
                    'title'=>$re['title'],
                    'list'=>$list,
                ]
            ]; 

        }

        echo json_encode($arr);
    }
    /**
    * 下一题-提交本题答案
    *
    * @return void
    */
    public function save()
    {
        $uid=Request::instance()->header("uid");

        $id=input("id");

        $did=input("did");

        $answer=input("answer");

        $re=db("topic")->where("id",$id)->find();

        if($re){

            $z_answer=$re['answer'];

            $type=$re['type'];

            //单选题比较
            if($type == 0 || $type == 3){
               if($answer == $z_answer){
                   $types=1;
               }else{
                   $types=0;
               }
            }else{
               $h_arr=explode(",",$answer);

               $z_arr=explode(",",$z_answer);

               if(count($h_arr) == count($z_arr)){
                    $result=array_diff($z_arr,$h_arr);

                    if($result){
                        $types=0;
                    }else{
                        $types=1;
                    }
               }else{
                    $types=0;
               }
            }
            $data['tid']=$id;
            $data['did']=$did;
            $data['uid']=$uid;
            $data['type']=$types;
            $data['time']=time();
            $data['content']=$answer;

            $log=db("topic_log")->where(["uid"=>$uid,"tid"=>$id,"did"=>$did])->find();

            if($log){
                db("topic_log")->where("id",$log['id'])->update($data);
            }else{
                db("topic_log")->insert($data);
            }
            if($types == 1){
                $arr=[
                    'error_code'=>0,
                    'msg'=>'回答正确',
                    'data'=>[]
                ];
            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>'回答错误',
                    'data'=>[]
                ];
            }
            
        }else{
            $arr=[
                'error_code'=>2,
                'msg'=>'非法操作',
                'data'=>[]
            ]; 
           
        }
       echo json_encode($arr);

    }
    /**
    * 下一题-提交政治学习本题答案
    *
    * @return void
    */
    public function save_study()
    {
        $uid=Request::instance()->header("uid");

        $id=input("id");

        $sid=input("sid");

        $answer=input("answer");

        $re=db("topic")->where("id",$id)->find();

        if($re){

            $z_answer=$re['answer'];

            $type=$re['type'];

            //单选题比较
            if($type == 0 || $type == 3){
               if($answer == $z_answer){
                   $types=1;
               }else{
                   $types=0;
               }
            }else{
               $h_arr=explode(",",$answer);

               $z_arr=explode(",",$z_answer);

               if(count($h_arr) == count($z_arr)){
                    $result=array_diff($z_arr,$h_arr);

                    if($result){
                        $types=0;
                    }else{
                        $types=1;
                    }
               }else{
                    $types=0;
               }
            }
            $data['tid']=$id;
            $data['sid']=$sid;
            $data['uid']=$uid;
            $data['type']=$types;
            $data['time']=time();
            $data['content']=$answer;

            $log=db("study_logs")->where(["uid"=>$uid,"tid"=>$id,"sid"=>$sid])->find();

            if($log){
                db("study_logs")->where("id",$log['id'])->update($data);
            }else{
                db("study_logs")->insert($data);
            }
            if($types == 1){
                $arr=[
                    'error_code'=>0,
                    'msg'=>'回答正确',
                    'data'=>[]
                ];
            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>'回答错误',
                    'data'=>[]
                ];
            }
            
        }else{
            $arr=[
                'error_code'=>2,
                'msg'=>'非法操作',
                'data'=>[]
            ]; 
           
        }
       echo json_encode($arr);

    }
    /**
    * 提交本次答题
    *
    * @return void
    */
    public function keep()
    {
        $uid=Request::instance()->header("uid");

        $did=input("did");

        //查询正确几题以上给积分
        $lb=db("lb")->where("fid",7)->find();

        $number=$lb['name'];

        //查询用户答对了几道题
        $user_number=db("topic_log")->where(["uid"=>$uid,"did"=>$did,"type"=>1])->count();

        // if($user_number > $number){
        //     $integ=($user_number-$number);
        // }else{
        //     $integ=0;
        // }
        $integ=$user_number;

        //查询用户一共答了几道题
        $user_numbers=db("topic_log")->where(["uid"=>$uid,"did"=>$did])->count();

        //正确率
        $acc=$user_number/$user_numbers;

        $data['number']=\intval($acc*5);

        $data['acc']=intval($acc*100);

        $data['times']=input("time");

        $data['time']=time();

        $data['uid']=$uid;

        $data['did']=$did;

        $data['integ']=$integ;

        $res=db("topic_day_log")->where(["uid"=>$uid])->whereTime("time","d")->find();

        if(empty($res)){
            // 启动事务
            Db::startTrans();
            try{
               if($integ >0){
                   $data['status']=1;
               } 
                $rea=db("topic_day_log")->insert($data);

                if($integ > 0){
                    $log['uid']=$uid;
                    $log['integ']=$integ;
                    $log['content']="每日答题";
                    $log['type']=1;
                    $log['types']=7;
                    $log['time']=time();

                    //用户增加积分
                    db("user")->where(["uid"=>$uid])->setInc("integ",$integ);

                    db("integ_log")->insert($log);

                }
                $arr=[
                    'error_code'=>0,
                    'msg'=>'提交成功',
                    'data'=>[]
                ]; 
                // 提交事务
                Db::commit();    
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();

                $arr=[
                    'error_code'=>1,
                    'msg'=>'提交失败',
                    'data'=>[]
                ]; 
            }
        }else{
            $arr=[
                'error_code'=>2,
                'msg'=>'每天只能答题一次',
                'data'=>[]
            ]; 
        }

        echo json_encode($arr);

    }
     /**
    * 提交本次答题
    *
    * @return void
    */
    public function keep_study()
    {
        $uid=Request::instance()->header("uid");

        $sid=input("sid");

    
        //查询用户答对了几道题
        $integ=db("study_logs")->where(["uid"=>$uid,"sid"=>$sid,"type"=>1])->count();

      
        //查询用户一共答了几道题
        $user_numbers=db("study_logs")->where(["uid"=>$uid,"sid"=>$sid])->count();

        //正确率
        $acc=$integ/$user_numbers;

        $data['number']=\intval($acc*5);

        $data['acc']=intval($acc*100);

        $data['times']=input("time");

        $data['time']=time();

        $data['uid']=$uid;

        $data['sid']=$sid;

        $data['integ']=$integ;

        $res=db("study_log")->where(["uid"=>$uid,"sid"=>$sid])->whereTime("time","d")->find();

        if(empty($res)){
            // 启动事务
            Db::startTrans();
            try{
                $rea=db("study_log")->insert($data);

                if($integ > 0){
                    $log['uid']=$uid;
                    $log['integ']=$integ;
                    $log['content']="政治学习";
                    $log['type']=1;
                    $log['types']=8;
                    $log['time']=time();

                    //用户增加政治学习积分
                    db("user")->where(["uid"=>$uid])->setInc("polit_integ",$integ);

                    db("polit_integ_log")->insert($log);

                }
                $arr=[
                    'error_code'=>0,
                    'msg'=>'提交成功',
                    'data'=>[]
                ]; 
                // 提交事务
                Db::commit();    
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();

                $arr=[
                    'error_code'=>1,
                    'msg'=>'提交失败',
                    'data'=>[]
                ]; 
            }
        }else{
            $arr=[
                'error_code'=>2,
                'msg'=>'每天只能答题一次',
                'data'=>[]
            ]; 
        }

        echo json_encode($arr);

    }
    /**
    * 答题报告
    *
    * @return void
    */
    public function inform()
    {
        $uid=Request::instance()->header("uid");

        $re=db("topic_day_log")->where(["uid"=>$uid])->whereTime("time","d")->find();

        $re['title']=db("topic_day")->where("id",$re['did'])->find()['title'];

        if($re){
            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>$re
            ]; 
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'获取失败',
                'data'=>[]
            ]; 
        }
        echo json_encode($arr);
    }
    /**
    * 政治学习答题报告
    *
    * @return void
    */
    public function inform_study()
    {
        $uid=Request::instance()->header("uid");

        $re=db("study_log")->where(["uid"=>$uid])->whereTime("time","d")->find();

        $re['title']=db("study")->where("id",$re['sid'])->find()['title'];

        if($re){
            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>$re
            ]; 
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'获取失败',
                'data'=>[]
            ]; 
        }
        echo json_encode($arr);
    }
    /**
    * 奖励积分
    *
    * @return void
    */
    public function reward_integ()
    {
        $uid=Request::instance()->header("uid");

        $res=db("topic_day_log")->where(["uid"=>$uid])->order(["id desc"])->select();

        if($res){

            foreach ($res as $k => $v) {
                $res[$k]['title']=db("topic_day")->where("id",$v['did'])->find()['title'];
            }

           $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>$res
            ]; 
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'暂无数据',
                'data'=>[]
            ];  
        }
        echo json_encode($arr);
    }
    /**
    * 智能答题生产题库
    *
    * @return void
    */
    public function power()
    {
        $uid=Request::instance()->header("uid");

        //删除用户已经生产的列表
        $rep=db("power")->where("uid",$uid)->find();
        if($rep){
            $pid=$rep['id'];
            db("power")->where("uid",$uid)->delete();

            //删除日志
            $repl=db("power_log")->where("pid",$pid)->find();

            if($repl){
                db("power_log")->where("pid",$pid)->delete();
            }
        }
        
        $date=date("Y年m月d日");
        
        $data['title']=$date."智能答题";

        //随机取出10条数据
        $num = 5;    //需要抽取的默认条数
        $table = 'topic';    //需要抽取的数据表
        $countcus = db($table)->count();    //获取总记录数
        $min = db($table)->min('id');    //统计某个字段最小数据
        $max = db($table)->max('id');
        if($countcus < $num){$num = $countcus;}
            $i = 1;
            $flag = 0;
            $ary = array();
            while($i<=$num){
                $rundnum = rand($min, $max);//抽取随机数
                if($flag != $rundnum){
                    //过滤重复 
                    if(!in_array($rundnum,$ary)){
                        $re = db($table)->field("id")->where(["id"=>$rundnum])->find();
                        if($re){
                            $ary[] = $rundnum;
                            $flag = $rundnum;
                        }else{
                            $i--;
                        }
                       
                    }else{
                        $i--;
                    }
                    $i++;
                }
            }
        $list = db($table)->field("id")->where(["id"=>["in",$ary]])->select();

        $list=array_column($list,'id');

        $data['tid']=implode(",",$list);
        $data['uid']=$uid;

        $day=db("power")->whereTime("time","d")->find();

        
            $data['time']=time();
            $res=db("power")->insert($data);
            $pid=db("power")->getLastInsID();
            if($res){
                $arr=[
                    'error_code'=>0,
                    'msg'=>'题库生产成功',
                    'data'=>["pid"=>$pid]
                ]; 
            }else{
                $arr=[
                    'error_code'=>0,
                    'msg'=>'题库生产失败',
                    'data'=>[]
                ]; 
            }
      
        echo json_encode($arr);
    }
    /**
    * 智能答题列表
    *
    * @return void
    */
    public function power_lister()
    {
        $id=input("pid");

        $re=db("power")->where(["id"=>$id])->find();

        $tid=$re['tid'];

        $tids=\explode(",",$tid);

        $list=db("topic")->where(["id"=>["in",$tids]])->select();

        foreach($list as $k => $v){
            $list[$k]['option']=explode(",",$v['option']);
        }

        

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>[
                'title'=>$re['title'],
                'list'=>$list,
            ]
        ]; 
        echo json_encode($arr);
    }
     /**
    * 下一题-提交本题答案
    *
    * @return void
    */
    public function saves()
    {
        $uid=Request::instance()->header("uid");

        $id=input("id");

        $pid=input("pid");

        $answer=input("answer");

        $re=db("topic")->where("id",$id)->find();

        if($re){

            $z_answer=$re['answer'];

            $type=$re['type'];

            //单选题比较
            if($type == 0){
               if($answer == $z_answer){
                   $types=1;
               }else{
                   $types=0;
               }
            }else{
               $h_arr=explode(",",$answer);

               $z_arr=explode(",",$z_answer);

               if(count($h_arr) == count($z_arr)){
                    $result=array_diff($z_arr,$h_arr);

                    if($result){
                        $types=0;
                    }else{
                        $types=1;
                    }
               }else{
                    $types=0;
               }
            }
            $data['tid']=$id;
            $data['pid']=$pid;
            $data['uid']=$uid;
            $data['type']=$types;
            $data['time']=time();
            $data['content']=$answer;

            $log=db("power_log")->where(["uid"=>$uid,"tid"=>$id,"pid"=>$pid])->find();

            if($log){
                db("power_log")->where("id",$log['id'])->update($data);
            }else{
                db("power_log")->insert($data);
            }
            if($types == 1){
                $arr=[
                    'error_code'=>0,
                    'msg'=>'回答正确',
                    'data'=>[]
                ];
            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>'回答错误',
                    'data'=>[]
                ];
            }
            
        }else{
            $arr=[
                'error_code'=>2,
                'msg'=>'非法操作',
                'data'=>[]
            ]; 
           
        }
       echo json_encode($arr);

    }
    /**
    * 提交本次答题
    *
    * @return void
    */
    public function keeps()
    {
        $uid=Request::instance()->header("uid");

        $pid=input("pid");

        //查询智能答题规则

        $read_integ=db("integ")->where("id",6)->find();

        $all=$read_integ['integ'];

        $one=$read_integ['mins'];

        $read_top=$read_integ['toplimit'];

        //查询用户答对了几道题
        $user_number=db("power_log")->where(["uid"=>$uid,"pid"=>$pid,"type"=>1])->count();

        if($user_number == 0){
            $integ=0;
        }elseif($user_number == 5){
            $integ=$all;
        }else{
            $integ=$one;
        }

        //查询用户一共答了几道题
        $user_numbers=db("power_log")->where(["uid"=>$uid,"pid"=>$pid])->count();

        //正确率
        $acc=$user_number/$user_numbers;

        $data['number']=\intval($acc*5);

        $data['acc']=intval($acc*100);

        $data['times']=input("time");  

        $data['integ']=$integ;

        $data['title']=db("power")->where("id",$pid)->find()['title'];

        //查询用户今日阅读文章所得积分

        $user_read_integ=db("integ_log")->where(["uid"=>$uid,"type"=>1,"types"=>6])->whereTime("time","d")->sum("integ");

        //今日所得积分没有超过上限
        if($read_top > $user_read_integ){
                                
            //查询今日还能获取多少积分
            $need_integ=$read_top-$user_read_integ;

            if($need_integ >= $integ){
                $integs=$integ;
            }else{
                $integs=$need_integ;
            }
            
            //用户增加积分和积分日志

            $datas['uid']=$uid;
            $datas['integ']=$integs;
            $datas['type']=1;
            $datas['content']="智能答题";
            $datas['types']=6;
            $datas['time']=time();
           

            // 启动事务
            Db::startTrans();
            try{
                db("user")->where("uid",$uid)->setInc("integ",$integs);
                db("integ_log")->insert($datas);

                $arr=[
                    'error_code'=>0,
                    'msg'=>'提交成功',
                    'data'=>$data
                ]; 
                // 提交事务
                Db::commit();    
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();

                $arr=[
                    'error_code'=>1,
                    'msg'=>'提交失败',
                    'data'=>[]
                ]; 
            }

        }else{
            $arr=[
                'error_code'=>0,
                'msg'=>'提交成功',
                'data'=>$data
            ]; 
        }

        echo json_encode($arr);

    }
    /**
    * 积分规则
    *
    * @return void
    */
    public function integ_rule()
    {
        $re=db("lb")->field("desc")->where("fid",8)->find();

        $re['desc']=strip_tags($re['desc']);

        $arr=[
            'error_code'=>0,
            'msg'=>'提交成功',
            'data'=>$re
        ]; 
        echo json_encode($arr);
    }

















}
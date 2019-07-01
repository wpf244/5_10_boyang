<?php
namespace app\api\controller;

use think\Request;
use think\Db;

class User extends BaseHome
{
    //实名认证
    public function ident()
    {
        $uid=Request::instance()->header("uid");

        $re=db("user")->field("uid,username,company_id,company,job,idcode,status")->where("uid",$uid)->find();

        if($re['status'] == 0){
            $lb=db("lb")->where("fid",2)->find();
        }
        if($re['status'] == 1){
            $lb=db("lb")->where("fid",3)->find();
        }
        if($re['status'] == 2){
            $lb=db("lb")->where("fid",5)->find();
        }
        if($re['status'] == 3){
            $lb=db("lb")->where("fid",4)->find();
        }
        
        $desc=strip_tags($lb['desc']);

        if($re['status'] == 0){
            $arr=[
                'error_code'=>0,
                'msg'=>'实名认证未提交',
                'data'=>[
                    'desc'=>$desc,
                    'info'=>[],
                ]
            ]; 
        }
        if($re['status'] == 1){
            $arr=[
                'error_code'=>1,
                'msg'=>'实名认证已提交',
                'data'=>[
                    'desc'=>$desc,
                    'info'=>$re,
                ]
            ]; 
        }
        if($re['status'] == 2){
            $arr=[
                'error_code'=>2,
                'msg'=>'实名认证已成功',
                'data'=>[
                    'desc'=>$desc,
                    'info'=>[],
                ]
            ]; 
        }
        if($re['status'] == 3){
            $arr=[
                'error_code'=>3,
                'msg'=>'实名认证已驳回',
                'data'=>[
                    'desc'=>$desc,
                    'info'=>$re,
                ]
            ]; 
        }


        echo json_encode($arr);

    }
    /**
    * 单位名称
    *
    * @return void
    */
    public function job()
    {
        $res=db("company")->field("cid,cname")->select();

        if($res){
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
    * 提交认证
    *
    * @return void
    */
    public function ident_save()
    {
        $uid=Request::instance()->header("uid");

        $data=input("post.");

        $data['apply_time']=time();

        $user=db("user")->where("uid",$uid)->find();

        $phone=$user['phone'];

        $username=input("username");
        $company=input("company");
        $job=input("job");
        $idcode=input("idcode");

        $log=db("user_log")->where(["username"=>$username,"company"=>$company,"idcode"=>$idcode])->find();

        if($log){
            $data['status']=2;

            $data['job']=$log['job'];
        }else{

            $data['status']=1;
        }
        


        $res=db("user")->where("uid",$uid)->update($data);

        if($res){
            $arr=[
                'error_code'=>0,
                'msg'=>'提交成功',
                'data'=>[]
            ]; 
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'提交失败',
                'data'=>[]
            ]; 
        }
        echo json_encode($arr);
    }
    /**
    * 浏览历史
    *
    * @return void
    */
    public function history()
    {
        $uid=Request::instance()->header("uid");

        $res=db("browse")->alias("a")->field("a.id,b.title")->where(["uid"=>$uid])->join("news b","a.nid=b.id")->order("a.id desc")->select();

        if($res){
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
    * 删除
    *
    * @return void
    */
    public function delete()
    {
        $id=input("id");

        $uid=Request::instance()->header("uid");

        $re=db("browse")->where(["id"=>$id,"uid"=>$uid])->find();

        if($re){
            $del=db("browse")->where("id",$id)->delete();
            if($del){
                $arr=[
                    'error_code'=>0,
                    'msg'=>'删除成功',
                    'data'=>[]
                ]; 
            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>'删除失败',
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
    * 一键清空
    *
    * @return void
    */
    public function delete_all()
    {
        $uid=Request::instance()->header("uid");

        $res=db("browse")->where(["uid"=>$uid])->find();

        if($res){
            $del=db("browse")->where("uid",$uid)->delete();
            if($del){
                $arr=[
                    'error_code'=>0,
                    'msg'=>'删除成功',
                    'data'=>[]
                ]; 
            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>'删除失败',
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
    * 积分制度
    *
    * @return void
    */
    public function insti()
    {
        $re=db("lb")->field("name,desc")->where(["fid"=>6])->find();
        
        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$re
        ]; 
    
        echo json_encode($arr);

    }
    /**
    * 用户积分
    *
    * @return void
    */
    public function integ()
    {
        $uid=Request::instance()->header("uid");

        $re=db("user")->field("integ,polit_integ")->where("uid",$uid)->find();

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$re
        ]; 
    
        echo json_encode($arr);
    }
    /**
    * 积分排名
    *
    * @return void
    */
    public function ranking()
    {
        $uid=Request::instance()->header("uid");

        $ranking="暂无排名";
       
        $res=db("user")->where("status",2)->field("username,integ,uid")->order("integ desc")->select();

        foreach($res as $k => $v){
            if($v['uid'] == $uid){
                $ranking=($k+1);
            }
        }

        //党员排名
        $party=db("user")->where("status",2)->where("job","党员")->field("username,polit_integ as integ,uid")->order("polit_integ desc")->select();

        $user=db("user")->where(["uid"=>$uid,"job"=>"党员"])->find();

        if($user){
            $status=1;
        }else{
            $status=0;
        }


        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>[
                'ranking'=>$ranking,
                'list'=>$res,
                'party'=>$party,
                'status'=>$status
                ]
        ]; 
    
        echo json_encode($arr);
    }
    /**
    * 积分规则
    *
    * @return void
    */
    public function rule()
    {
        $uid=Request::instance()->header("uid");

        //登录
        $login=db("integ")->field("integ,toplimit,desc")->where("id",1)->find();

        //查询今日已得积分
        $login_integ=db("integ_log")->where(["uid"=>$uid,"type"=>1,"types"=>1])->whereTime("time","d")->sum("integ");

        //完成状态

        if($login_integ >= $login['toplimit']){
            
            $login_status=1;

        }else{

            $login_status=0;

        }

        $login['integs']=$login_integ;

        $login['status']=$login_status;


        //阅读文章
        $read=db("integ")->field("integ,toplimit,desc")->where("id",2)->find();

        //查询今日已得积分
        $read_integ=db("integ_log")->where(["uid"=>$uid,"type"=>1,"types"=>2])->whereTime("time","d")->sum("integ");

        //完成状态

        if($read_integ >= $read['toplimit']){
            
            $read_status=1;

        }else{

            $read_status=0;

        }

        $read['integs']=$read_integ;

        $read['status']=$read_status;

        //观看视频
        $look=db("integ")->field("integ,toplimit,desc")->where("id",3)->find();

        //查询今日已得积分
        $look_integ=db("integ_log")->where(["uid"=>$uid,"type"=>1,"types"=>3])->whereTime("time","d")->sum("integ");

        //完成状态

        if($look_integ >= $look['toplimit']){
            
            $look_status=1;

        }else{

            $look_status=0;

        }

        $look['integs']=$look_integ;

        $look['status']=$look_status;

        //文章学习时长
        $reads=db("integ")->field("integ,toplimit,desc")->where("id",4)->find();

        //查询今日已得积分
        $reads_integ=db("integ_log")->where(["uid"=>$uid,"type"=>1,"types"=>4])->whereTime("time","d")->sum("integ");

        //完成状态

        if($reads_integ >= $reads['toplimit']){
            
            $reads_status=1;

        }else{

            $reads_status=0;

        }

        $reads['integs']=$reads_integ;

        $reads['status']=$reads_status;

        //视频学习时长
        $looks=db("integ")->field("integ,toplimit,desc")->where("id",5)->find();

        //查询今日已得积分
        $looks_integ=db("integ_log")->where(["uid"=>$uid,"type"=>1,"types"=>5])->whereTime("time","d")->sum("integ");

        //完成状态

        if($looks_integ >= $looks['toplimit']){
            
            $looks_status=1;

        }else{

            $looks_status=0;

        }

        $looks['integs']=$looks_integ;

        $looks['status']=$looks_status;

        //智能答题
        $intell=db("integ")->field("integ,toplimit,desc")->where("id",6)->find();

        //查询今日已得积分
        $intell_integ=db("integ_log")->where(["uid"=>$uid,"type"=>1,"types"=>6])->whereTime("time","d")->sum("integ");

        //完成状态

        if($intell_integ >= $intell['toplimit']){
            
            $intell_status=1;

        }else{

            $intell_status=0;

        }

        $intell['integs']=$intell_integ;

        $intell['status']=$intell_status;


        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>[
                // 'login'=>$login,
                // 'read'=>$read,
                // 'look'=>$look,
                'reads'=>$reads,
                'looks'=>$looks,
                // 'intell'=>$intell

            ]
            
        ]; 

        echo json_encode($arr);

    }
    /**
    * 文章学习列表
    *
    * @return void
    */
    public function read_lister()
    {
        $url=parent::getUrl();

        $res=db("news")->field("id,title,source,image,time,type")->where(["is_delete"=>0,"news_type"=>0])->order(["sort asc","id desc"])->select();

        if($res){
            foreach($res as $kn => $vn){
                $res[$kn]['image']=$url.$vn['image'];
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
    * 视频学习列表
    *
    * @return void
    */
    public function look_lister()
    {
        $url=parent::getUrl();

        $res=db("news")->field("id,title,source,image,time,type")->where(["is_delete"=>0,"news_type"=>1])->order(["sort asc","id desc"])->select();

        if($res){
            foreach($res as $kn => $vn){
                $res[$kn]['image']=$url.$vn['image'];
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
    * 有效阅读文章
    *
    * @return void
    */
    public function valid_read()
    {
        $uid=Request::instance()->header("uid");

        $nid=input("nid");

        $time=input("time");

        //查询新闻类型

        $news=db("news")->where("id",$nid)->find();

        $news_type=$news['news_type'];

        if($news_type == 0){
            //阅读文章
            
            //查询阅读文章规则

            // $read_integ=db("integ")->where("id",2)->find();

            // $read_top=$read_integ['toplimit'];

            // //查询用户今日阅读文章所得积分

            // $user_read_integ=db("integ_log")->where(["uid"=>$uid,"type"=>1,"types"=>2])->whereTime("time","d")->sum("integ");

            // $user_read_new=db("integ_log")->where(["uid"=>$uid,"type"=>1,"types"=>2,"nid"=>$nid])->whereTime("time","d")->find();

            // if(empty($user_read_new)){
                //今日所得积分没有超过上限
                // if($read_top > $user_read_integ){
                                
                //     //用户增加积分和积分日志

                //     $data['uid']=$uid;
                //     $data['integ']=$read_integ['integ'];
                //     $data['type']=1;
                //     $data['content']="阅读文章";
                //     $data['types']=2;
                //     $data['time']=time();
                //     $data['nid']=$nid;

                //     // 启动事务
                //     Db::startTrans();
                //     try{
                //         db("user")->where("uid",$uid)->setInc("integ",$read_integ['integ']);
                //         db("integ_log")->insert($data);
                //         // 提交事务
                //         Db::commit();    
                //     } catch (\Exception $e) {
                //         // 回滚事务
                //         Db::rollback();
                //     }

                // }

                //查询阅读文章时长规则

                $read_integs=db("integ")->where("id",4)->find();

                $read_tops=$read_integs['toplimit'];

                $times=$read_integs['mins']*60;

                //查询用户今日阅读文章时长所得积分

                $user_read_integs=db("integ_log")->where(["uid"=>$uid,"type"=>1,"types"=>4])->whereTime("time","d")->sum("integ");

                //今日所得积分没有超过上限
                if($read_tops > $user_read_integs){
                    
                    //查找今日累计时长
                    $user_time=db("integ_time")->where(["uid"=>$uid,"type"=>0])->whereTime("time","d")->find();

                    if($user_time){
                        $integ_time=$user_time['times'];
                    }else{
                        $integ_time=0;
                    }

                    $time=$time+$integ_time;

                    //查询需要增加多少积分

                    $integs=intval($time/$times);

                    $must_integ=$read_tops-$user_read_integs;

                    if($must_integ >= $integs ){
                        
                        $need_integ=$integs;

                        $nedd_time = ($time%$times);

                        $log['uid']=$uid;
                        $log['integ']=$need_integ;
                        $log['content']="文章学习时长";
                        $log['type']=1;
                        $log['time']=time();
                        $log['types']=4;
                        $log['nid']=$nid;

                        $time_log['uid']=$uid;
                        $time_log['times']=$nedd_time;
                        $time_log['time']=time();
                        $time_log['type']=0;

                        // 启动事务
                        Db::startTrans();
                        try{
                            if($integs > 0){
                                db("user")->where("uid",$uid)->setInc("integ",$need_integ);
                                db("integ_log")->insert($log);
                            }
                            
                            if($user_time){
                                db("integ_time")->where("id",$user_time['id'])->setField("times",$nedd_time);
                            }else{
                                db("integ_time")->insert($time_log);
                            }
                            // 提交事务
                            Db::commit();    
                        } catch (\Exception $e) {
                            // 回滚事务
                            Db::rollback();
                        }

                    }else{
                        $need_integ=$must_integ;

                        $log['uid']=$uid;
                        $log['integ']=$need_integ;
                        $log['content']="文章学习时长";
                        $log['type']=1;
                        $log['time']=time();
                        $log['types']=4;
                        $log['nid']=$nid;

                         // 启动事务
                         Db::startTrans();
                         try{
                             db("user")->where("uid",$uid)->setInc("integ",$need_integ);
                             db("integ_log")->insert($log);
                            
                             // 提交事务
                             Db::commit();    
                         } catch (\Exception $e) {
                             // 回滚事务
                             Db::rollback();
                         }
                    }

                }
            // }
        }

        if($news_type == 1){
            //观看视频
            
            //查询观看视频规则

            // $read_integ=db("integ")->where("id",3)->find();

            // $read_top=$read_integ['toplimit'];

            // //查询用户今日阅读文章所得积分

            // $user_read_integ=db("integ_log")->where(["uid"=>$uid,"type"=>1,"types"=>3])->whereTime("time","d")->sum("integ");

            // $user_read_new=db("integ_log")->where(["uid"=>$uid,"type"=>1,"types"=>3,"nid"=>$nid])->whereTime("time","d")->find();

            // if(empty($user_read_new)){
                //今日所得积分没有超过上限
                // if($read_top > $user_read_integ){
                                
                //     //用户增加积分和积分日志

                //     $data['uid']=$uid;
                //     $data['integ']=$read_integ['integ'];
                //     $data['type']=1;
                //     $data['content']="观看视频";
                //     $data['time']=time();
                //     $data['types']=3;
                //     $data['nid']=$nid;

                //     // 启动事务
                //     Db::startTrans();
                //     try{
                //         db("user")->where("uid",$uid)->setInc("integ",$read_integ['integ']);
                //         db("integ_log")->insert($data);
                //         // 提交事务
                //         Db::commit();    
                //     } catch (\Exception $e) {
                //         // 回滚事务
                //         Db::rollback();
                //     }

                // }

                //查询阅读文章时长规则

                $read_integs=db("integ")->where("id",5)->find();

                $read_tops=$read_integs['toplimit'];

                $times=$read_integs['mins']*60;

                //查询用户今日阅读文章时长所得积分

                $user_read_integs=db("integ_log")->where(["uid"=>$uid,"type"=>1,"types"=>5])->whereTime("time","d")->sum("integ");

                //今日所得积分没有超过上限
                if($read_tops > $user_read_integs){
                    
                    //查找今日累计时长
                    $user_time=db("integ_time")->where(["uid"=>$uid,"type"=>1])->whereTime("time","d")->find();

                    if($user_time){
                        $integ_time=$user_time['times'];
                    }else{
                        $integ_time=0;
                    }

                    $time=$time+$integ_time;

                    //查询需要增加多少积分

                    $integs=intval($time/$times);

                  //  var_dump($times);exit;

                    $must_integ=intval($read_tops-$user_read_integs);

                    

                    if($must_integ >= $integs ){
                        
                        $need_integ=$integs;

                        

                        $nedd_time = ($time%$times);
                     
                        $log['uid']=$uid;
                        $log['integ']=$need_integ;
                        $log['content']="视频学习时长";
                        $log['type']=1;
                        $log['time']=time();
                        $log['types']=5;
                        $log['nid']=$nid;

                        $time_log['uid']=$uid;
                        $time_log['times']=$nedd_time;
                        $time_log['time']=time();
                        $time_log['type']=1;
                    //    var_dump($log,);exit;
                        // 启动事务
                        Db::startTrans();
                        try{
                            if($integs > 0){
                                db("user")->where("uid",$uid)->setInc("integ",$need_integ);
                                db("integ_log")->insert($log);
                            }
                            
                            if($user_time){
                                db("integ_time")->where("id",$user_time['id'])->setField("times",$nedd_time);
                            }else{
                                db("integ_time")->insert($time_log);
                            }
                            // 提交事务
                            Db::commit();    
                        } catch (\Exception $e) {
                            // 回滚事务
                            Db::rollback();
                        }

                    }else{
                        $need_integ=$must_integ;

                        $log['uid']=$uid;
                        $log['integ']=$need_integ;
                        $log['content']="视频学习时长";
                        $log['type']=1;
                        $log['time']=time();
                        $log['types']=5;
                        $log['nid']=$nid;

                         // 启动事务
                         Db::startTrans();
                         try{
                             db("user")->where("uid",$uid)->setInc("integ",$need_integ);
                             db("integ_log")->insert($log);
                            
                             // 提交事务
                             Db::commit();    
                         } catch (\Exception $e) {
                             // 回滚事务
                             Db::rollback();
                         }
                    }

                }
            // }
        }

        $arr=[
            'error_code'=>0,
            'msg'=>'操作成功',
            'data'=>[]
        ]; 
    
        echo json_encode($arr);
    }
    /**
    * 积分记录
    *
    * @return void
    */
    public function integ_log()
    {
        $uid=Request::instance()->header("uid");

        $res=db("integ_log")->field("integ,content,type,time")->where(["uid"=>$uid])->order(["id desc"])->select();

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$res
        ]; 
    
        echo json_encode($arr);
    }

    /**
    * 模拟练习
    *
    * @return void
    */
    public function analog()
    {
   
        $uid=Request::instance()->header("uid");
        
        $res=db("analog")->order(["sort asc","id desc"])->select();

        foreach($res as $k => $v){
            $re=db("analog_log")->where(["aid"=>$v['id'],"uid"=>$uid])->find();

            if($re){
                if($re['status'] == 0 || $re['status'] == 1){
                    $res[$k]['statu']=1;//已经开始答题 未答题完毕
                }else{
                    $res[$k]['statu']=2;
                    $res[$k]['grade']=$re['grade']; //答题完毕
                }
            }else{
                $res[$k]['statu']=0; //未开始答题
            }
        }

        if($res){
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
    * 模拟练习题库
    *
    * @return void
    */
    public function analog_lister()
    {
        
        $uid=Request::instance()->header("uid");
        
        $id=input("id");
        
        $statu=input("statu");

        $re=db("analog")->where("id",$id)->find();

        if($re['status'] == 1){

            $list=db("analog_topic")->where(["aid"=>$id])->order(["sort asc","id desc"])->limit("0,100")->select();

            foreach($list as $k => $v){
                $list[$k]['option']=explode(",",$v['option']);
            }

            if($statu == 1){
                 $log=db("analog_log")->where(["aid"=>$id,"uid"=>$uid])->find();

                 if($log){
                    $top['title']=$re['title'];
                    $top['times']=$log['times'];
                    $top['num']=$log['num'];

                    $arr=[
                        'error_code'=>0,
                        'msg'=>'获取成功',
                        'data'=>[
                            'top'=>$top,
                            'list'=>$list,
                        ]
                    ]; 
                 }else{
                    $arr=[
                        'error_code'=>2,
                        'msg'=>'非法请求',
                        'data'=>[]
                    ]; 
                 }

            }else{

         

                $top['title']=$re['title'];
                $top['times']=intval($re['times'])*60;

                $arr=[
                    'error_code'=>0,
                    'msg'=>'获取成功',
                    'data'=>[
                        'top'=>$top,
                        'list'=>$list,
                    ]
                ]; 
            }

         
        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'此练习已结束',
                'data'=>[]
            ]; 
        }
        echo json_encode($arr);
    }
    /**
    * 答题未完成 用户中途退出答题
    *
    * @return void
    */
    public function sign_out()
    {
        $uid=Request::instance()->header("uid");

        $aid=input("aid");

        $data=input("post.");

        $data['uid']=$uid;

        $data['status']=1;

        $re=db("analog_log")->where(["uid"=>$uid,"aid"=>$aid])->find();

        if($re){
            $time=input("time");
            $data['time']=$re['time']+$time;
            db("analog_log")->where("id",$re['id'])->update($data);
        }else{
            db("analog_log")->insert($data);
        }
        $arr=[
            'error_code'=>0,
            'msg'=>'操作成功',
            'data'=>[]
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

        $aid=input("aid");

        $answer=input("answer");

        $re=db("analog_topic")->where("id",$id)->find();

        if($re){

            $z_answer=$re['answer'];

            $type=$re['type'];

            $fen = 0;

            //单选题比较
            if($type == 0 || $type == 3){
               if($answer == $z_answer){
                   if($type == 0){
                       $fen=1;
                   }
                   if($type == 3){
                       $fen=0.5;
                   }
                 
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
                        $fen = 2;
                        $types=1;
                    }
               }else{
                    $types=0;
               }
            }
            $data['tid']=$id;
            $data['aid']=$aid;
            $data['uid']=$uid;
            $data['type']=$types;
            $data['time']=time();
            $data['content']=$answer;
            $data['fen']=$fen;

            $log=db("analog_topic_log")->where(["uid"=>$uid,"tid"=>$id,"aid"=>$aid])->find();

            if($log){
                db("analog_topic_log")->where("id",$log['id'])->update($data);
            }else{
                db("analog_topic_log")->insert($data);
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

        $aid=input("aid");

        
        //查询用户答对了几道题
        $user_number=db("analog_topic_log")->where(["uid"=>$uid,"aid"=>$aid,"type"=>1])->count();

        $grade=db("analog_topic_log")->where(["uid"=>$uid,"aid"=>$aid,"type"=>1])->sum("fen");
        //查询用户一共答了几道题
        $user_numbers=db("analog_topic_log")->where(["uid"=>$uid,"aid"=>$aid])->count();

        //正确率
        $acc=$user_number/$user_numbers;

        $data['grade']=$grade;

        $data['time']=input("time");

        $data['uid']=$uid;

        $data['aid']=$aid;

        $data['status']=2;

        $res=db("analog_log")->where(["uid"=>$uid,"aid"=>$aid])->find();

        if(empty($res)){
            // 启动事务
         
                db("analog_log")->insert($data);

                $arr=[
                    'error_code'=>0,
                    'msg'=>'提交成功',
                    'data'=>['aid'=>$aid]
                ]; 
           
        }else{
             $time=$res['time'];
             $data['time']=$data['time']+$time;
            db("analog_log")->where("id",$res['id'])->update($data);

            $arr=[
                'error_code'=>0,
                'msg'=>'提交成功',
                'data'=>['aid'=>$aid]
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

        $aid=input("aid");

        $re=db("analog_log")->field("id,grade,time")->where(["uid"=>$uid,"aid"=>$aid])->find();

        $re['title']=db("analog_topic")->where("id",$aid)->find()['title'];

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
    * 答案解析
    *
    * @return void
    */
    public function analysis()
    {
        $uid=Request::instance()->header("uid");

        $aid=input("aid");

        //题目列表
        $list=db("analog_topic")->where(["aid"=>$aid])->order(["sort asc","id asc"])->select();

        foreach($list as $k => $v){
            $list[$k]['option']=explode(",",$v['option']);

            //查找用户的答案
            $user_answer=db("analog_topic_log")->where(["uid"=>$uid,"aid"=>$aid,"tid"=>$v['id']])->find();

            if($user_answer){
                $list[$k]['user_answer']=$user_answer['content'];
                $list[$k]['types']=$user_answer['type'];
            }else{
                $list[$k]['user_answer']="没有回答";
                $list[$k]['types']=0;
            }

        }
        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$list
        ]; 

        echo json_encode($arr);

    }


















    








}
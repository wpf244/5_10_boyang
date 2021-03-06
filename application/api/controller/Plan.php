<?php
namespace app\api\controller;

use think\Controller;

class Plan extends Controller
{
    public function index()
    {
        //更新之前的答题为过期

        db('topic_day')->where("statu",0)->setField("statu",1);
        
        $date=date("Y年m月d日");
        
        $data['title']=$date."答题";

        $lister=db("topic_lister")->select();

        foreach($lister as $k => $v){

        //随机取出10条数据
        $num = 10;    //需要抽取的默认条数
        $table = 'topic';    //需要抽取的数据表
        $countcus = db($table)->where("types",0)->count();    //获取总记录数
        $min = db($table)->where("types",0)->min('id');    //统计某个字段最小数据
        $max = db($table)->where("types",0)->max('id');
        if($countcus < $num){$num = $countcus;}
            $i = 1;
            $flag = 0;
            $ary = array();
            while($i<=$num){
                $rundnum = rand($min, $max);//抽取随机数
                if($flag != $rundnum){
                    //过滤重复 
                    if(!in_array($rundnum,$ary)){
                        $re = db($table)->field("id")->where("types",0)->where(["id"=>$rundnum])->find();
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
        $list = db($table)->field("id")->where("types",0)->where(["id"=>["in",$ary]])->select();

        $list=array_column($list,'id');

       $data['tid']=implode(",",$list);

      

      
           $lid=$v['id'];

           $day=db("topic_day")->where("lid",$lid)->whereTime("time","d")->find();

        if(empty($day)){
            $data['time']=time();
            $data['lid']=$lid;
            $res=db("topic_day")->insert($data);

            if($res){
                echo '1';
            }else{
                echo '0';
            }
        }else{
            echo '今日每日答题题库已生成';
        }

       }

        

        //更新模拟练习过期
        $list=db("analog")->where("status",1)->select();

        if($list){
            $time=time();
            foreach($list as $vl){
                if($time >= $vl['end_time']){
                    db("analog")->where("id",$vl['id'])->setField("status",0);
                }
            }
        }

        //政治学习
        //更新之前的答题为过期

        db('study')->where("statu",0)->setField("statu",1);
        
        $date=date("Y年m月d日");
        
        $dataz['title']=$date."政治学习";

        //随机取出10条数据
        $num = 5;    //需要抽取的默认条数
        $table = 'topic';    //需要抽取的数据表
        $countcus = db($table)->where("types",1)->count();    //获取总记录数
        $min = db($table)->where("types",1)->min('id');    //统计某个字段最小数据
        $max = db($table)->where("types",1)->max('id');
        if($countcus < $num){$num = $countcus;}
            $i = 1;
            $flag = 0;
            $ary = array();
            while($i<=$num){
                $rundnum = rand($min, $max);//抽取随机数
                if($flag != $rundnum){
                    //过滤重复 
                    if(!in_array($rundnum,$ary)){
                        $re = db($table)->field("id")->where("types",1)->where(["id"=>$rundnum])->find();
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
        $list = db($table)->field("id")->where("types",1)->where(["id"=>["in",$ary]])->select();

        $list=array_column($list,'id');

       $dataz['tid']=implode(",",$list);

        $day=db("study")->whereTime("time","d")->find();

        if(empty($day)){
            $dataz['time']=time();
            $res=db("study")->insert($dataz);

            if($res){
                echo '1';
            }else{
                echo '0';
            }
        }else{
            echo '今日政治学习题库已生成';
        }


        
    }
}
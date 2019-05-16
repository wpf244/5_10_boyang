<?php
namespace app\api\controller;

use think\Request;

class Index extends BaseHome
{
    public function index()
    {
        $url=parent::getUrl();
        
        //新闻分类

        $type=db("news_type")->field("type_id,type_name")->order(["type_sort asc","type_id desc"])->select();

        //banner图
        $banner=db("news")->field("id,title,image")->where(["is_delete"=>0,"banner"=>1])->order(["sort asc","id desc"])->select();

        foreach($banner as $k => $v){
            $banner[$k]['image']=$url.$v['image'];
        }

        //新闻推荐
        $news=db("news")->field("id,title,source,image,time,type")->where(["is_delete"=>0,"status"=>1])->order(["sort asc","id desc"])->select();

        foreach($news as $kn => $vn){
            $news[$kn]['image']=$url.$vn['image'];
        }

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>[
                'type'=>$type,
                'banner'=>$banner,
                'news'=>$news

            ]
        ]; 
        echo json_encode($arr);
    }
    /**
    * 分类列表
    *
    * @return void
    */
    public function lister()
    {
        $url=parent::getUrl();

        $tid=input("tid");

        $news=db("news")->field("id,title,source,image,time,type")->where(["is_delete"=>0,"tid"=>$tid])->order(["sort asc","id desc"])->select();
        
        if($news){
            foreach($news as $kn => $vn){
                $news[$kn]['image']=$url.$vn['image'];
            }
            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>$news
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
    * 新闻详情
    *
    * @return void
    */
    public function detail()
    {
        $id=input("id");

        $re=db("news")->field("id,title,source,time,content")->where("id",$id)->find();

        if($re){

            //增加用户浏览历史
            $uid=Request::instance()->header("uid");

            $data['uid']=$uid;

            $data['nid']=$id;

            $browse=db("browse")->where(["uid"=>$uid,"nid"=>$id])->find();

            if($browse){
                db("browse")->where("id",$browse['id'])->delete();
            }
            db("browse")->insert($data);

            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>$re
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
}
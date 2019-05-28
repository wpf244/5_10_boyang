<?php
namespace app\admin\controller;

class Follow extends BaseAdmin
{
    public function add()
    {
        return $this->fetch();
    }
    public function save()
    {
        $data=input("post.");
        $re=db("follow")->insert($data);

        if($re){
            $this->success("保存成功");
        }else{
            $this->error("保存失败");
        }
    }
    public function lister()
    {
        
        $list=db("follow")->order("id desc")->select();

        $this->assign("list",$list);
        
        return $this->fetch();
    }
    public function modifys()
    {
        $id=input("id");

        $re=db("follow")->where("id",$id)->find();

        $this->assign("re",$re);

        return $this->fetch();
    }
    public function usave()
    {
        $id=input("id");
        $re=db("follow")->where("id",$id)->find();

        if($re){
            $data=input("post.");
            $res=db("follow")->where("id",$id)->update($data);

            if($res){
                $this->success("修改成功",url('lister'));
            }else{
                $this->error("修改失败",url('lister'));
            }

        }else{
            $this->error("非法操作",url("lister"));
        }
    }
    public function delete(){
        $id=input('id');
        $re=db("follow")->where("id",$id)->find();
        if($re){
            db("follow")->where("id",$id)->delete();
        }
        $this->redirect('lister');
    }
}
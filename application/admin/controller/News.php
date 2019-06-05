<?php
namespace app\admin\controller;

class News extends BaseAdmin
{
    public function type()
    {
        $list=db('news_type')->order(['type_sort asc','type_id desc'])->paginate(10);
        $this->assign("list",$list);
        
        $page=$list->render();
        $this->assign("page",$page);

        return $this->fetch();
    }
    public function save_type(){
        $id=input('id');
        if($id){
            $data['type_name']=input('name');
            
            $res=db("news_type")->where(["type_id"=>$id])->update($data);
            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }
        }else{
            $data['type_name']=input('name');
            
            $re=db("news_type")->insert($data);
            if($re){
                $this->success("保存成功");
            }else{
                $this->error("保存失败");
            }
        }
    }
    public function delete_type(){
        $id=input('id');
       
        $del=db("news_type")->where(["type_id"=>$id])->delete();
        $this->redirect('type');
        
       
    }
    public function modify(){
        $id=input('id');
        $re=db('news_type')->where("type_id=$id")->find();
        
        echo json_encode($re);
    }
    public function sorts(){
        $data=input('post.');
       
        foreach ($data as $id => $sort){
            db('news_type')->where(array('type_id' => $id ))->setField('type_sort' , $sort);
        }
        $this->redirect('type');
    }

    public function lister()
    {
        
        $tid=input("tid");

        $keywords=input("keywords");

        if($tid || $keywords){
            if($tid && $tid != 0){
                $map['tid']=['eq',$tid];
            }
            if($keywords){
                $map['title']=['like','%'.$keywords.'%'];
            }
        }else{
            $map=[];
            $tid=0;
            $keywords="";
        }

        $this->assign("tid",$tid);
        $this->assign("keywords",$keywords);
        
        $list=db("news")->alias("a")->where(["is_delete"=>0])->where($map)->join("news_type b","a.tid=b.type_id")->order(["sort asc","banner desc","status desc","id desc"])->paginate(20,false,['query'=>request()->param()]);

        $this->assign("list",$list);

        $page=$list->render();
        $this->assign("page",$page);

        $res=db('news_type')->order(["type_sort asc"])->select();
        $this->assign("res",$res);
        
        return $this->fetch();
    }

    public function add()
    {
        $res=db('news_type')->order(["type_sort asc"])->select();
        $this->assign("res",$res);

        return $this->fetch();
    }
    public function save(){
        $data=input('post.');
        if(!is_string(input('image'))){
            $data['image']=uploads('image');
        }
       
        if(input('status')){
            $data['status']=1;
        }
        if(input('banner')){
            $data['banner']=1;
        }
        $data['time']=time();
        $re=db("news")->insert($data);
        if($re){
            $this->success("添加成功",url('lister'));
        }else{
            $this->error("添加失败");
        }
    }
    public function changeu(){
        $id=input('id');
        $re=db('news')->where("id=$id")->find();
        if($re){
            if($re['banner'] == 0){
                $res=db('news')->where("id=$id")->setField("banner",1);
            }
            if($re['banner'] == 1){
                $res=db('news')->where("id=$id")->setField("banner",0);
    
            }
            echo '0';
        }else{
            echo '1';
        }
    }
    public function changes(){
        $id=input('id');
        $re=db('news')->where("id=$id")->find();
        if($re){
            if($re['status'] == 0){
                $res=db('news')->where("id=$id")->setField("status",1);
            }
            if($re['status'] == 1){
                $res=db('news')->where("id=$id")->setField("status",0);
                
            }
            echo '0';
        }else{
            echo '1';
        }
    }

    public function sort(){
        $data=input('post.');
       
        foreach ($data as $id => $sort){
            db('news')->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('lister');
    }
    public function modifys(){
        $id=input('id');
        $re=db('news')->where("id=$id")->find();
        $this->assign("re",$re);
        
        $res=db('news_type')->order(["type_sort asc"])->select();
        $this->assign("res",$res);
        
        return view('modifys');
    }

    public function usave(){
        $id=input('id');
        $data=input('post.');
        $re=db("news")->where("id",$id)->find();

        if($re){
            if(!is_string(input('image'))){
                $data['image']=uploads('image');
              
            }else{
                $data['image']=$re['image'];
            }
        
            if(input('status')){
                $data['status']=1;
            }else{
                $data['status']=0;
            }
            if(input('banner')){
                $data['banner']=1;
            }else{
                $data['banner']=0;
            }
            
            $res=db("news")->where("id",$id)->update($data);
            if($res){
                $this->success("修改成功",url('lister'));
            }else{
                $this->error("修改失败");
            }
        }else{
            $this->error("参数错误");
        }
        
    }
    public function delete(){
        $id=input('id');
        $re=db("news")->where("id",$id)->find();
        if($re){
            db("news")->where("id",$id)->setField("is_delete",-1);
        }
        $this->redirect('lister');
    }
    public function delete_all(){
        $id=input('id');
        $arr=explode(",", $id);
        foreach($arr as $v){
            $re=db("news")->where("id",$v)->find();
            if($re){
                db("news")->where("id",$v)->setField("is_delete",-1);
            }
        }
        $this->redirect('lister');
    }

}
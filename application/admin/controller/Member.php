<?php
namespace app\admin\controller;

use think\Request;
use Think\Db;

class Member extends BaseAdmin
{
    public function lister()
    {
        
        $keywords=input("keywords");

        if($keywords){
           
            if($keywords){
                $map['phone|company']=['like','%'.$keywords.'%'];
            }
        }else{
            $map=[];

            $keywords="";
        }

        $this->assign("keywords",$keywords);
        
        $list=db("user")->order("uid desc")->where($map)->paginate(20,false,['query'=>request()->param()]);

        $cou=db("user")->order("uid desc")->where($map)->count();

        $this->assign("cou",$cou);
        
    
        $this->assign("list",$list);
        $page=$list->render();
        $this->assign("page",$page);   
        return $this->fetch();
    }

    public function modifys()
    {
        $uid=input("uid");
        $re=db("user")->where("uid",$uid)->find();
        $this->assign("re",$re);

        $res=db("company")->order(["csort asc","cid desc"])->select();

        $this->assign("res",$res);

        return $this->fetch();
    }

    public function usave()
    {
        $uid=input("uid");

        $re=db("user")->where(["uid"=>$uid])->find();

        if($re){

            $data=input("post.");

            $cid=input("company_id");

            $company=db("company")->where(["cid"=>$cid])->find();

            if($company){
                 $data['company']=$company['cname'];

                 $res=db("user")->where("uid",$uid)->update($data);

                 if($res){

                     $this->success("修改成功",url('lister'));

                 }else{
                    $this->error("修改失败",url('lister'));
                 }

            }else{
                $this->error("非法操作",url('lister'));
            }

        }else{
            $this->error("非法操作",url('lister'));
        }
    }

    public function company()
    {
        $list=db("company")->order(["csort asc","cid desc"])->paginate(10); 
        $this->assign("list",$list);

        $page=$list->render();
        $this->assign("page",$page);   

        return $this->fetch();
    }
    public function csave(){
        if($this->request->isAjax()){
            $id=input("cid");
            if($id){
                $data['cname']=input("cname");
                $res=db("company")->where("cid",$id)->update($data);
                if($res){
                    $this->success("修改成功！",url('company'));
                }else{
                    $this->error("修改失败！",url('company'));
                }
            }else{
                $data=input("post.");
                $re=db("company")->insert($data);
                if($re){
                    $this->success("添加成功！",url('company'));
                }else{
                    $this->error("添加失败！",url('company'));
                } 
            }
            
        }else{
            $this->success("非法提交",url('company'));
        }
    }
    public function modify(){
        $id=input('id');
        $re=db('company')->where("cid=$id")->find();
        echo json_encode($re);
    }

    public function deletes()
    {
        $id=input('id');
        $re=db("company")->where("cid=$id")->find();
        if($re){
            
            $del=db("company")->where("cid=$id")->delete();
            if($del){
                
                echo '0';
            }else{
                echo '1';
            }
        }else{
            echo '2';
        }
    }

  

    /**
    * 删除
    *
    * @return void
    */
    public function delete()
    {
        $id=input('id');
        $re=db("user")->where("uid=$id")->find();
        if($re){
            
            $del=db("user")->where("uid=$id")->delete();
            if($del){
                
                echo '0';
            }else{
                echo '1';
            }
        }else{
            echo '2';
        }
    }
    
   
    public function ident()
    {
        $list=db("user")->where(["status"=>1])->order(["apply_time asc"])->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

        return $this->fetch();
    }
    public function change()
    {
        $id=\input('id');
       
        $re=db("user")->where("uid",$id)->find();
        if($re){
            $data['status']=2;
            $data['oper_time']=time();
            $res=db("user")->where("uid",$id)->update($data);
            if($res){
                echo '1';
            }else{
                echo '0';
            }
        }else{
            echo '0';
        }
        
       
    }
    public function bo()
    {
        $id=\input('id');
       
        $re=db("user")->where("uid",$id)->find();
        if($re){
            $data['status']=3;
            $data['oper_time']=time();
            $res=db("user")->where("uid",$id)->update($data);
            if($res){
                echo '1';
            }else{
                echo '0';
            }
        }else{
            echo '0';
        }
        
       
    }
    public function change_all()
    {
        $id=\input('id');
        $arr=\explode(",",$id);
        foreach($arr as $v){
            $re=db("user")->where("uid",$v)->find();
            if($re){
                $data['status']=2;
                $data['oper_time']=time();
                $res=db("user")->where("uid",$v)->update($data);
               
            }
        }
        $this->redirect('ident');
    }
    public function bo_all()
    {
        $id=\input('id');
        $arr=\explode(",",$id);
        foreach($arr as $v){
            $re=db("user")->where("uid",$v)->find();
            if($re){
                $data['status']=3;
                $data['oper_time']=time();
                $res=db("user")->where("uid",$v)->update($data);
               
            }
        }
        $this->redirect('ident');
    }
    public function ident_apply()
    {
        $list=db("user")->where(["status"=>2])->order(["apply_time asc"])->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

        return $this->fetch();
    }
    public function ident_bo()
    {
        $list=db("user")->where(["status"=>3])->order(["apply_time asc"])->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

        return $this->fetch();
    }
    public function add()
    {
        $res=db("company")->order(["csort asc","cid desc"])->select();

        $this->assign("res",$res);
        
        return $this->fetch();
    }
    public function save()
    {
        

        $data=input("post.");

        $phone=input("phone");

        $user=db("user")->where("phone",$phone)->find();

        if(empty($user)){
            $cid=input("company_id");

            $company=db("company")->where(["cid"=>$cid])->find();
    
            if($company){
    
                $data['company']=$company['cname'];
    
                $data['time']=time();
    
                $data['apply_time']=time();
    
                $data['oper_time']=time();
    
                $res=db("user")->insert($data);
    
                if($res){
    
                    $this->success("添加成功",url('lister'));
    
                }else{
                $this->error("添加失败",url('lister'));
                }
    
            }else{
                $this->error("非法操作",url('lister'));
            }
        }else{
            $this->error("此手机号码已存在",url('lister'));
        }   
    }
    public function means()
    {
        
        $keywords=input("keywords");

        if($keywords){
           
            if($keywords){
                $map['username|company']=['like','%'.$keywords.'%'];
            }
        }else{
            $map=[];

            $keywords="";
        }

        $this->assign("keywords",$keywords);
        
        $list=db("user_log")->order("id desc")->where($map)->paginate(20,false,["query"=>request()->param()]);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);
        
        return $this->fetch();
    }
    public function adds()
    {
        return $this->fetch();
    }
    public function saves()
    {
        $data=input("post.");

        $re=db("user_log")->insert($data);

        if($re){
            $this->success("添加成功");
        }else{
            $this->error("添加失败");
        }
    }
    public function modifyu()
    {
        $id=input("id");

        $re=db("user_log")->where("id",$id)->find();

        $this->assign("re",$re);

        return $this->fetch();
    }
    public function usaves()
    {
        $id=input("id");

        $re=db("user_log")->where("id",$id)->find();

        if($re){
            $data=input("post.");

            $re=db("user_log")->where("id",$id)->update($data);
    
            if($re){
                $this->success("修改成功",url('means'));
            }else{
                $this->error("修改失败",url('means'));
            }
        }else{
            $this->error("非法操作",url('means'));
        }
        
        
    }
    public function deleteu()
    {
        $id=input('id');
        $re=db("user_log")->where("id=$id")->find();
        if($re){
            
            $del=db("user_log")->where("id=$id")->delete();
            if($del){
                
                echo '0';
            }else{
                echo '1';
            }
        }else{
            echo '2';
        }
    }

    public function addexcel()
    {
       
        vendor("PHPExcel.PHPExcel"); //获取PHPExcel类 
        $excel = new \PHPExcel();  

        $file = request()->file('file');  
        $info = $file->validate(['ext'=>'xlsx,xls,csv'])->move(ROOT_PATH . 'public' . DS . 'uploads');

        
        if($info){
        	$exclePath = $info->getSaveName();  //获取文件名  
            $file_name = ROOT_PATH . 'public' . DS . 'uploads' . DS . $exclePath;   //上传文件的地址  

          //  $objReader =\PHPExcel_IOFactory::createReader('Excel2007');  
            $obj_PHPExcel =\PHPExcel_IOFactory::load($file_name, $encode = 'utf-8');
         //   $obj_PHPExcel =$objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8  
         //   echo "<pre>";  
            $excel_array=$obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式  
            // array_shift($excel_array);  //删除第一个数组(标题);  
            $arr  = reset($excel_array);
            unset($excel_array[0]);
            $data = [];  
            $i=0;  
            foreach($excel_array as $k=>$v) {  
                $data[$k][$arr[0]] = $v[0];  
                $data[$k][$arr[1]] = $v[1];  
                $data[$k][$arr[2]] = $v[2]; 
                $data[$k][$arr[3]] = $v[3]; 
                $data[$k][$arr[4]] = $v[4]; 
                $i++;  
            }
         //   var_dump($data);exit;
            $res = db("user_log")->insertAll($data);

            if($res){
                $this->success("导入成功",url('means'));
            }else{
                $this->error("导入失败",url('means'));
            }
            
        }
    }
    
   
   

















 
}
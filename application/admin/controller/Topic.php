<?php
namespace app\admin\controller;

class Topic extends BaseAdmin
{
    public function lister()
    {


        $keywords = input("keywords");

        $type = input("type");

        $types = input('types');

        if ($keywords || $type  || $types) {

            if ($keywords) {
                $map['title'] = ['like', '%' . $keywords . '%'];
            }
            if ($type) {
                $map['type'] = ['eq', ($type - 1)];
            }
            if ($types) {
                $map['types'] = ['eq', ($types - 1)];
            }
        } else {
            $map = [];

            $keywords = "";

            $type = 0;

            $types = 0;
        }

        $this->assign("keywords", $keywords);
        $this->assign("type", $type);
        $this->assign("types", $types);

        $list = db("topic")->where($map)->order(["sort asc", "id desc"])->paginate(20, false, ['query' => request()->param()]);

        $this->assign("list", $list);

        $page = $list->render();

        $this->assign("page", $page);

        return $this->fetch();
    }
    public function add()
    {
        return $this->fetch();
    }
    public function save()
    {
        $data = input("post.");

        $re = db("topic")->insert($data);

        if ($re) {
            $this->success("保存成功", url('lister'));
        } else {
            $this->error("保存失败", url('lisetr'));
        }
    }
    public function modifys()
    {
        $id = input("id");
        $re = db("topic")->where("id", $id)->find();

        $this->assign("re", $re);

        return $this->fetch();
    }
    public function usave()
    {
        $id = input("id");
        $re = db("topic")->where("id", $id)->find();

        if ($re) {
            $data = input("post.");
            $res = db("topic")->where("id", $id)->update($data);

            if ($res) {
                $this->success("修改成功", url('lister'));
            } else {
                $this->error("修改失败", url('lister'));
            }
        } else {
            $this->error("非法操作", url("lister"));
        }
    }
    public function sort()
    {
        $data = input('post.');

        foreach ($data as $id => $sort) {
            db('topic')->where(array('id' => $id))->setField('sort', $sort);
        }
        $this->redirect('lister');
    }
    public function delete()
    {
        $id = input('id');
        $re = db("topic")->where("id", $id)->find();
        if ($re) {
            db("topic")->where("id", $id)->delete();
        }
        $this->redirect('lister');
    }
    public function delete_all()
    {
        $id = input('id');
        $arr = explode(",", $id);
        foreach ($arr as $v) {
            $re = db("topic")->where("id", $v)->find();
            if ($re) {
                db("topic")->where("id", $v)->delete();
            }
        }
        $this->redirect('lister');
    }
    public function addexcel()
    {

        vendor("PHPExcel.PHPExcel"); //获取PHPExcel类 
        $excel = new \PHPExcel();

        $file = request()->file('file');
        $info = $file->validate(['ext' => 'xlsx,xls,csv'])->move(ROOT_PATH . 'public' . DS . 'uploads');


        if ($info) {
            $exclePath = $info->getSaveName();  //获取文件名  
            $file_name = ROOT_PATH . 'public' . DS . 'uploads' . DS . $exclePath;   //上传文件的地址  

            //  $objReader =\PHPExcel_IOFactory::createReader('Excel2007');  
            $obj_PHPExcel = \PHPExcel_IOFactory::load($file_name, $encode = 'utf-8');
            //   $obj_PHPExcel =$objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8  
            //   echo "<pre>";  
            $excel_array = $obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式  
            // array_shift($excel_array);  //删除第一个数组(标题);  
            $arr  = reset($excel_array);
            unset($excel_array[0]);
            $data = [];
            $i = 0;
            foreach ($excel_array as $k => $v) {
                if (\trim($v[0]) != '') {
                    $data[$k][trim($arr[0])] = $v[0];
                    $data[$k][trim($arr[1])] = $v[1];
                    $data[$k][trim($arr[2])] = $v[2];
                    $data[$k][trim($arr[3])] = $v[3];
                    $data[$k][trim($arr[4])] = $v[4];
                }

                $i++;
            }
            //   var_dump($data);exit;
            $res = db("topic")->insertAll($data);

            if ($res) {
                $this->success("导入成功", url('lister'));
            } else {
                $this->error("导入失败", url('lister'));
            }
        }
    }
    public function addexcelz()
    {

        vendor("PHPExcel.PHPExcel"); //获取PHPExcel类 
        $excel = new \PHPExcel();

        $file = request()->file('file');
        // var_dump($file);
        // exit;
        $info = $file->validate(['ext' => 'xlsx,xls,csv'])->move(ROOT_PATH . 'public' . DS . 'uploads');



        if ($info) {
            $exclePath = $info->getSaveName();  //获取文件名  
            $file_name = ROOT_PATH . 'public' . DS . 'uploads' . DS . $exclePath;   //上传文件的地址  

            //  $objReader =\PHPExcel_IOFactory::createReader('Excel2007');  
            $obj_PHPExcel = \PHPExcel_IOFactory::load($file_name, $encode = 'utf-8');
            //   $obj_PHPExcel =$objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8  
            //   echo "<pre>";  
            $excel_array = $obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式  
            // array_shift($excel_array);  //删除第一个数组(标题);  
            $arr  = reset($excel_array);
            unset($excel_array[0]);
            // echo '<pre>';
            // print_r($excel_array);
            // exit;
            $data = [];
            $i = 0;
            foreach ($excel_array as $k => $v) {
                if (\trim($v[0]) != '') {
                    $data[$k][trim($arr[0])] = $v[0];
                    $data[$k][trim($arr[1])] = $v[1];
                    $data[$k][trim($arr[2])] = $v[2];
                    $data[$k][trim($arr[3])] = $v[3];
                    $data[$k][trim($arr[4])] = $v[4];
                    $data[$k]['types'] = 1;
                }
                $i++;
            }
            //   var_dump($data);
            // echo '<pre>';
            // print_r($data);
            // exit;
            $res = db("topic")->insertAll($data);

            if ($res) {
                $this->success("导入成功", url('lister'));
            } else {
                $this->error("导入失败", url('lister'));
            }
        }
    }
    public function everyday()
    {
        $id=input("id");
        
        $list = db("topic_day")->where("lid",$id)->order("id desc")->paginate(20);

        $this->assign("list", $list);

        $page = $list->render();

        $this->assign("page", $page);

        $lists = db("topic")->order(["sort asc", "id desc"])->paginate(50);

        $this->assign("lists", $lists);



        return $this->fetch();
    }
    public function look()
    {
        $id = input("id");

        $re = db("topic_day")->where("id", $id)->find();

        $tid = $re['tid'];

        $tids = \explode(",", $tid);

        $list = db("topic")->where(["id" => ["in", $tids]])->select();

        $this->assign("list", $list);

        return $this->fetch();
    }
    
    public function save_day()
    {
        $data = input("post.");
        $tid = $data['tid'];
        //  var_dump($tid);exit;
        $id = input("id");
        if ($tid) {
            $re = db("topic_day")->where("id", $id)->find();
            if ($re) {
                $day_tid = $re['tid'];
                $arr = explode(",", $day_tid);
                foreach ($tid as $v) {
                    if (!\in_array($v, $arr)) {
                        $arr[] = $v;
                    }
                }
                $tids = implode(",", $arr);
                $res = db("topic_day")->where("id", $id)->setField("tid", $tids);
                if ($res) {
                    $this->success("添加成功", url("everyday"));
                } else {
                    $this->error("添加失败", url('everyday'));
                }
            } else {
                $this->error("系统繁忙,请稍后再试", url('everyday'));
            }
        } else {
            $this->error("请选择需要添加的题目", url('everyday'));
        }
    }
    public function deletes()
    {
        $id = input('id');
        $re = db("topic_day")->where("id", $id)->find();
        if ($re) {
            db("topic_day")->where("id", $id)->delete();
        }
        $this->redirect('everyday');
    }
    public function analog()
    {
        $keywords = input("keywords");

        if ($keywords) {
            $map['title'] = ["like", "%" . $keywords . "%"];
        } else {
            $map = [];
            $keywords = "";
        }
        $this->assign("keywords", $keywords);

        $list = db("analog")->where($map)->order(["sort asc", "id desc"])->paginate(20, false, ['query' => request()->param()]);

        $this->assign("list", $list);

        $page = $list->render();

        $this->assign("page", $page);

        return $this->fetch();
    }
    public function adds()
    {
        return $this->fetch();
    }
    public function saves()
    {
        $data = input("post.");
        $data['time'] = time();

        $start_time = input("start_time");
        $end_time = input("end_time");

        if ($end_time > $start_time) {

            $data['start_time'] = strtotime($start_time);
            $data['end_time'] = strtotime($end_time);

            if ($data['end_time'] > time()) {
                $data['status'] = 1;
            } else {
                $data['status'] = 0;
            }

            $re = db("analog")->insert($data);

            if ($re) {
                $this->success("添加成功", url("analog"));
            } else {
                $this->error("添加失败", url("analog"));
            }
        } else {
            $this->error("结束时间不得小于等于开始时间");
        }
    }
    public function sorts()
    {
        $data = input('post.');

        foreach ($data as $id => $sort) {
            db('analog')->where(array('id' => $id))->setField('sort', $sort);
        }
        $this->redirect('analog');
    }
    public function deletea()
    {
        $id = input('id');
        $re = db("analog")->where("id", $id)->find();
        if ($re) {
            db("analog")->where("id", $id)->delete();
        }
        $this->redirect('analog');
    }
    public function modify()
    {
        $id = input("id");

        $re = db("analog")->where("id", $id)->find();

        $this->assign("re", $re);

        return $this->fetch();
    }
    public function usaves()
    {

        $id = input("id");
        $re = db("analog")->where("id", $id)->find();
        if ($re) {
            $data = input("post.");


            $start_time = input("start_time");
            $end_time = input("end_time");

            if ($end_time > $start_time) {

                $data['start_time'] = strtotime($start_time);
                $data['end_time'] = strtotime($end_time);

                if ($data['end_time'] > time()) {
                    $data['status'] = 1;
                } else {
                    $data['status'] = 0;
                }

                $re = db("analog")->where("id", $id)->update($data);

                if ($re) {
                    $this->success("修改成功", url("analog"));
                } else {
                    $this->error("修改失败", url("analog"));
                }
            } else {
                $this->error("结束时间不得小于等于开始时间");
            }
        } else {
            $this->error("非法操作");
        }
    }
    public function addexcels()
    {

        vendor("PHPExcel.PHPExcel"); //获取PHPExcel类 
        $excel = new \PHPExcel();

        $file = request()->file('file');
        $info = $file->validate(['ext' => 'xlsx,xls,csv'])->move(ROOT_PATH . 'public' . DS . 'uploads');

        $id = input("id");


        if ($info) {
            $exclePath = $info->getSaveName();  //获取文件名  
            $file_name = ROOT_PATH . 'public' . DS . 'uploads' . DS . $exclePath;   //上传文件的地址  

            //  $objReader =\PHPExcel_IOFactory::createReader('Excel2007');  
            $obj_PHPExcel = \PHPExcel_IOFactory::load($file_name, $encode = 'utf-8');
            //   $obj_PHPExcel =$objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8  
            //   echo "<pre>";  
            $excel_array = $obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式  
            // array_shift($excel_array);  //删除第一个数组(标题);  
            $arr  = reset($excel_array);
            unset($excel_array[0]);
            $data = [];
            $i = 0;
            foreach ($excel_array as $k => $v) {
                if (trim($v[0]) != '') {
                    $data[$k]['aid'] = $id;
                    $data[$k][trim($arr[0])] = $v[0];
                    $data[$k][trim($arr[1])] = $v[1];
                    $data[$k][trim($arr[2])] = $v[2];
                    $data[$k][trim($arr[3])] = $v[3];
                    $data[$k][trim($arr[4])] = $v[4];
                }

                $i++;
            }
            //   var_dump($data);exit;
            $res = db("analog_topic")->insertAll($data);

            if ($res) {
                $this->success("导入成功", url('analog'));
            } else {
                $this->error("导入失败", url('analog'));
            }
        }
    }
    public function looks()
    {
        $id = input("id");

        $re = db("analog")->where("id", $id)->find();

        $this->assign("re", $re);

        $title=input("title");

        $map=[];

        if($title){
            $map['title']=['like',"%".$title."%"];
        }else{
            $title='';
        }
        $this->assign("title",$title);

        $list = db("analog_topic")->where(["aid" => $id])->where($map)->order("id desc")->paginate(20,false,["query"=>request()->param()]);

        $this->assign("list", $list);

        $page=$list->render();

        $this->assign("page",$page);

        return $this->fetch();
    }
    public function delete_alls()
    {
        $id = input('id');
       
        $arr = explode(",", $id);
        foreach ($arr as $v) {
            $re = db("analog_topic")->where("id", $v)->find();
            if ($re) {
                db("analog_topic")->where("id", $v)->delete();
            }
        }
       $this->redirect("analog");
    }
    public function deletel()
    {
        $id = input('id');
        $re = db("analog_topic")->where("id=$id")->find();
        if ($re) {

            $del = db("analog_topic")->where("id=$id")->delete();
            if ($del) {

                echo '0';
            } else {
                echo '1';
            }
        } else {
            echo '2';
        }
    }
    public function modifyl()
    {
        $id = input("id");
        $re = db("analog_topic")->where("id", $id)->find();

        $this->assign("re", $re);

        return $this->fetch();
    }
    public function usavel()
    {
        $id = input("id");
        $re = db("analog_topic")->where("id", $id)->find();

        if ($re) {
            $data = input("post.");
            $res = db("analog_topic")->where("id", $id)->update($data);

            if ($res) {
                $this->success("修改成功", url('lister'));
            } else {
                $this->error("修改失败", url('lister'));
            }
        } else {
            $this->error("非法操作", url("lister"));
        }
    }
    public function study()
    {

        $list = db("study")->order("id desc")->paginate(20);

        $this->assign("list", $list);

        $page = $list->render();

        $this->assign("page", $page);

        return $this->fetch();
    }
    public function lookz()
    {
        $id = input("id");

        $re = db("study")->where("id", $id)->find();

        $tid = $re['tid'];

        $tids = \explode(",", $tid);

        $list = db("topic")->where(["id" => ["in", $tids]])->select();

        $this->assign("list", $list);

        return $this->fetch();
    }
    public function deletez()
    {
        $id = input('id');
        $re = db("study")->where("id", $id)->find();
        if ($re) {
            db("study")->where("id", $id)->delete();
        }
        $this->redirect('study');
    }
    public function index()
    {
        $list=db("topic_lister")->order(["sort asc","id desc"])->paginate(20,false,['query'=>request()->param()]);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);
        
        return $this->fetch();
    }
    public function save_type(){
        $id=input('id');
        if($id){
            $data=input("post.");
            
            $res=db("topic_lister")->where(["id"=>$id])->update($data);
            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }
        }else{
            $data=input("post.");
            
            $re=db("topic_lister")->insert($data);
            if($re){
                $this->success("保存成功");
            }else{
                $this->error("保存失败");
            }
        }
    }
    public function modifyls(){
        $id=input('id');
        $re=db('topic_lister')->where("id=$id")->find();
        
        echo json_encode($re);
    }
    public function sortls(){
        $data=input('post.');
       
        foreach ($data as $id => $sort){
            db('topic_lister')->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('index');
    }
    public function delete_type(){
        $id=input('id');
       
        $del=db("topic_lister")->where(["id"=>$id])->delete();
        $this->redirect('index');
        
       
    }
}

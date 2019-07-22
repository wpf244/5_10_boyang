<?php
namespace app\admin\controller;

class Integ extends BaseAdmin
{
    public function lister()
    {
        $re=db("integ")->where("id",1)->find();

        $this->assign("re",$re);

        return $this->fetch();
    }
    public function save()
    {
        $data=input("post.");

        $res=db("integ")->where("id",1)->update($data);

        if($res){
            $this->success("修改成功");
        }else{
            $this->error("修改失败");
        }
    }
    public function read()
    {
        $re=db("integ")->where("id",2)->find();

        $this->assign("re",$re);

        return $this->fetch();
    }
    public function saver()
    {
        $data=input("post.");

        $res=db("integ")->where("id",2)->update($data);

        if($res){
            $this->success("修改成功");
        }else{
            $this->error("修改失败");
        }
    }
    public function look()
    {
        $re=db("integ")->where("id",3)->find();

        $this->assign("re",$re);

        return $this->fetch();
    }
    public function savel()
    {
        $data=input("post.");

        $res=db("integ")->where("id",3)->update($data);

        if($res){
            $this->success("修改成功");
        }else{
            $this->error("修改失败");
        }
    }
    public function reads()
    {
        $re=db("integ")->where("id",4)->find();

        $this->assign("re",$re);

        return $this->fetch();
    }
    public function savers()
    {
        $data=input("post.");

        $res=db("integ")->where("id",4)->update($data);

        if($res){
            $this->success("修改成功");
        }else{
            $this->error("修改失败");
        }
    }
    public function looks()
    {
        $re=db("integ")->where("id",5)->find();

        $this->assign("re",$re);

        return $this->fetch();
    }
    public function savels()
    {
        $data=input("post.");

        $res=db("integ")->where("id",5)->update($data);

        if($res){
            $this->success("修改成功");
        }else{
            $this->error("修改失败");
        }
    }
    public function intell()
    {
        $re=db("integ")->where("id",6)->find();

        $this->assign("re",$re);

        return $this->fetch();
    }
    public function savei()
    {
        $data=input("post.");

        $res=db("integ")->where("id",6)->update($data);

        if($res){
            $this->success("修改成功");
        }else{
            $this->error("修改失败");
        }
    }
    public function index()
    {
        $list=db("user")->where("status",2)->order(["integ desc"])->paginate(20,false,['query'=>request()->param()]);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

        
        
        return $this->fetch();
    }
    public function out(){
        
         
        $list=db("user")->where("status",2)->order(["integ desc"])->select();
        
        // var_dump($data);exit;
        vendor('PHPExcel.PHPExcel');//调用类库,路径是基于vendor文件夹的
        vendor('PHPExcel.PHPExcel.Worksheet.Drawing');
        vendor('PHPExcel.PHPExcel.Writer.Excel2007');
        $objExcel = new \PHPExcel();
        //set document Property
        $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
    
        $objActSheet = $objExcel->getActiveSheet();
        $key = ord("A");
        $letter =explode(',',"A,B,C,D,E,F");
        $arrHeader =  array("账号名称","账号类型","真实姓名","政治面貌","所属单位","积分");
        //填充表头信息
        $lenth =  count($arrHeader);
        for($i = 0;$i < $lenth;$i++) {
            $objActSheet->setCellValue("$letter[$i]1","$arrHeader[$i]");
        }
        //填充表格信息
        foreach($list as $k=>$v){
            if($v['type'] == 0){
                $v['type']="微信用户";
            }else{
                $v['type']="手机号注册";
            }
            $k +=2;
            $objActSheet->setCellValue('A'.$k,$v['nickname'].$v['phone']);
            $objActSheet->setCellValue('B'.$k, $v['type']);    
            // 表格内容
            $objActSheet->setCellValue('C'.$k, $v['username']);
            $objActSheet->setCellValue('D'.$k, $v['job']);
            $objActSheet->setCellValue('E'.$k, $v['company']);
            $objActSheet->setCellValue('F'.$k, $v['integ']);
        
            // 表格高度
            $objActSheet->getRowDimension($k)->setRowHeight(20);
        }
    
        $width = array(20,20,15,10,10,30,10,15,15,15);
        //设置表格的宽度
        $objActSheet->getColumnDimension('A')->setWidth(20);
        $objActSheet->getColumnDimension('B')->setWidth(20);
        $objActSheet->getColumnDimension('C')->setWidth(25);
        $objActSheet->getColumnDimension('D')->setWidth(25);
        $objActSheet->getColumnDimension('E')->setWidth(25);
        $objActSheet->getColumnDimension('F')->setWidth(30);
        
        $outfile = "全体积分排名".".xls";
    
        $userBrowser=$_SERVER['HTTP_USER_AGENT'];
        
        if(preg_match('/MSIE/i', $userBrowser)){
            $outfile=urlencode($outfile);
           
        }else{
            $outfile= iconv("utf-8","gb2312",$outfile);;
            
        }
        ob_end_clean();
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$outfile.'"');
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        $objWriter->save('php://output');
    }

    public function indexs()
    {
        
       

 
   
        $start=input('start');
        $end=input('end');
         
        
        $this->assign("start",$start);
        $this->assign("end",$end);
        
        $list=db("user")->where("status",2)->order("integ desc")->paginate(20)->each(function($k,$v){

             $start=input('start');
              $end=input('end');
            
             if($start){
                $integ=db("integ_log")->where(["uid"=>$k['uid'],"type"=>1])->whereTime('time', 'between', [$start, $end])->sum("integ");
             }else{
                $integ=db("integ_log")->where(["uid"=>$k['uid'],"type"=>1])->whereTime("time","m")->sum("integ");
             }
           

             $k['integ']=$integ;

             return $k;
        }); 

        $page=$list->render();

    
        $this->assign("page",$page);

        $list=$list->toArray();
     
        $last_names = array_column($list['data'],'integ');
        array_multisort($last_names,SORT_DESC,$list['data']);

        $this->assign("list",$list['data']);


        return $this->fetch();
    }

    public function outs(){
        
        $start=input('start');
        $end=input('end');
        $list=db("user")->where("status",2)->order(["integ desc"])->select();

        foreach($list as $ks => $vs ){

     
            
             if($start){
                $integ=db("integ_log")->where(["uid"=>$vs['uid'],"type"=>1])->whereTime('time', 'between', [$start, $end])->sum("integ");
             }else{
                $integ=db("integ_log")->where(["uid"=>$vs['uid'],"type"=>1])->whereTime("time","m")->sum("integ");
             }

            

             $list[$ks]['integ']=$integ;

        }

       // $lists=$lists->toArray();

      //  $list=$lists['data'];

        $last_names = array_column($list,'integ');
        array_multisort($last_names,SORT_DESC,$list);
        
        // var_dump($data);exit;
        vendor('PHPExcel.PHPExcel');//调用类库,路径是基于vendor文件夹的
        vendor('PHPExcel.PHPExcel.Worksheet.Drawing');
        vendor('PHPExcel.PHPExcel.Writer.Excel2007');
        $objExcel = new \PHPExcel();
        //set document Property
        $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
    
        $objActSheet = $objExcel->getActiveSheet();
        $key = ord("A");
        $letter =explode(',',"A,B,C,D,E,F");
        $arrHeader =  array("账号名称","账号类型","真实姓名","政治面貌","所属单位","积分");
        //填充表头信息
        $lenth =  count($arrHeader);
        for($i = 0;$i < $lenth;$i++) {
            $objActSheet->setCellValue("$letter[$i]1","$arrHeader[$i]");
        }
        //填充表格信息
        foreach($list as $k=>$v){
            if($v['type'] == 0){
                $v['type']="微信用户";
            }else{
                $v['type']="手机号注册";
            }
            $k +=2;
            $objActSheet->setCellValue('A'.$k,$v['nickname'].$v['phone']);
            $objActSheet->setCellValue('B'.$k, $v['type']);    
            // 表格内容
            $objActSheet->setCellValue('C'.$k, $v['username']);
            $objActSheet->setCellValue('D'.$k, $v['job']);
            $objActSheet->setCellValue('E'.$k, $v['company']);
            $objActSheet->setCellValue('F'.$k, $v['integ']);
        
            // 表格高度
            $objActSheet->getRowDimension($k)->setRowHeight(20);
        }
    
        $width = array(20,20,15,10,10,30,10,15,15,15);
        //设置表格的宽度
        $objActSheet->getColumnDimension('A')->setWidth(20);
        $objActSheet->getColumnDimension('B')->setWidth(20);
        $objActSheet->getColumnDimension('C')->setWidth(25);
        $objActSheet->getColumnDimension('D')->setWidth(25);
        $objActSheet->getColumnDimension('E')->setWidth(25);
        $objActSheet->getColumnDimension('F')->setWidth(30);
        
        $outfile = "个人月度排名".".xls";
    
        $userBrowser=$_SERVER['HTTP_USER_AGENT'];
        
        if(preg_match('/MSIE/i', $userBrowser)){
            $outfile=urlencode($outfile);
           
        }else{
            $outfile= iconv("utf-8","gb2312",$outfile);;
            
        }
        ob_end_clean();
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$outfile.'"');
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        $objWriter->save('php://output');
    }
    public function teams()
    {
        $start=input('start');
        $end=input('end');
         
        
        $this->assign("start",$start);
        $this->assign("end",$end);
        

        // $list=db("company")->order(["cid desc"])->paginate(20)->each(function($k,$v){
        //       $user=db("user")->field("uid")->where("status",2)->where(["company_id"=>$k['cid']])->select();
              
        //       $arr=array();
        //       foreach($user as $vs){
        //         $arr[]=$vs['uid'];
        //       }

        //       $start=input('start');
        //       $end=input('end');
            
        //      if($start){
        //         $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime('time', 'between', [$start, $end])->sum("integ");
        //      }else{
        //         $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime("time","m")->sum("integ");
        //      }

        //  //     $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime("time","m")->sum("integ");

        //       $k['integ']=$integ;

        //       return $k;
        // });

        // $page=$list->render();

    
        // $this->assign("page",$page);

        // $list=$list->toArray();

        $list=db("company")->order(["cid desc"])->select();
        foreach($list as  &$v ){
            $user=db("user")->field("uid")->where("status",2)->where(["company_id"=>$v['cid']])->select();
            
            $arr=array();
            foreach($user as $vs){
              $arr[]=$vs['uid'];
            }

            $start=input('start');
            $end=input('end');
          
           if($start){
              $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime('time', 'between', [$start, $end])->sum("integ");
           }else{
              $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime("time","m")->sum("integ");
           }

       //     $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime("time","m")->sum("integ");

            $v['integ']=$integ;

            
      }

        
     
        $last_names = array_column($list,'integ');
        array_multisort($last_names,SORT_DESC,$list);

        $this->assign("list",$list);

        // $page=$list->paginate(20);

        // $this->assign("page",$page);


        return $this->fetch();
    }
    public function out_teams(){
        
         
        $start=input('start');
        $end=input('end');
        $list=db("company")->order(["cid desc"])->select();

        foreach($list as $ks => $vs ){
            $user=db("user")->field("uid")->where("status",2)->where(["company_id"=>$vs['cid']])->select();
              
              $arr=array();
              foreach($user as $vs){
                $arr[]=$vs['uid'];
              }

            
             if($start){
                $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime('time', 'between', [$start, $end])->sum("integ");
             }else{
                $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime("time","m")->sum("integ");
             }
             // $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime("time","m")->sum("integ");

              $list[$ks]['integ']=$integ;

        }

       // $lists=$lists->toArray();

      //  $list=$lists['data'];

        $last_names = array_column($list,'integ');
        array_multisort($last_names,SORT_DESC,$list);
        
        // var_dump($data);exit;
        vendor('PHPExcel.PHPExcel');//调用类库,路径是基于vendor文件夹的
        vendor('PHPExcel.PHPExcel.Worksheet.Drawing');
        vendor('PHPExcel.PHPExcel.Writer.Excel2007');
        $objExcel = new \PHPExcel();
        //set document Property
        $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
    
        $objActSheet = $objExcel->getActiveSheet();
        $key = ord("A");
        $letter =explode(',',"A,B");
        $arrHeader =  array("单位名称","积分");
        //填充表头信息
        $lenth =  count($arrHeader);
        for($i = 0;$i < $lenth;$i++) {
            $objActSheet->setCellValue("$letter[$i]1","$arrHeader[$i]");
        }
        //填充表格信息
        foreach($list as $k=>$v){
           
            $k +=2;
            $objActSheet->setCellValue('A'.$k,$v['cname']);
            $objActSheet->setCellValue('B'.$k, $v['integ']);    
            // 表格内容
          
            // 表格高度
            $objActSheet->getRowDimension($k)->setRowHeight(20);
        }
    
        $width = array(20,20,15,10,10,30,10,15,15,15);
        //设置表格的宽度
        $objActSheet->getColumnDimension('A')->setWidth(20);
        $objActSheet->getColumnDimension('B')->setWidth(20);
     
        
        $outfile = "团队总积分月度排名".".xls";
    
        $userBrowser=$_SERVER['HTTP_USER_AGENT'];
        
        if(preg_match('/MSIE/i', $userBrowser)){
            $outfile=urlencode($outfile);
           
        }else{
            $outfile= iconv("utf-8","gb2312",$outfile);;
            
        }
        ob_end_clean();
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$outfile.'"');
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        $objWriter->save('php://output');
    }
    public function team()
    {
        $start=input('start');
        $end=input('end');
         
        
        $this->assign("start",$start);
        $this->assign("end",$end);

        // $list=db("company")->order(["cid desc"])->paginate(20)->each(function($k,$v){
        //       $user=db("user")->field("uid")->where("status",2)->where(["company_id"=>$k['cid']])->select();
              
        //       $arr=array();
        //       foreach($user as $vs){
        //         $arr[]=$vs['uid'];
        //       }

        //       $start=input('start');
        //       $end=input('end');
            
        //      if($start){
        //         $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime('time', 'between', [$start, $end])->sum("integ");
        //      }else{
        //         $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime("time","m")->sum("integ");
        //      }

        //     //  $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime("time","m")->sum("integ");

        //       $cou=count($user);

        //       if($integ == 0 || $cou == 0){
        //           $avg=0;
        //       }else{
        //         $avg=intval($integ/$cou);
        //       }

              

        //       $k['integ']=$avg;

        //       return $k;
        // });

        // $page=$list->render();

    
        // $this->assign("page",$page);

        // $list=$list->toArray();

        $list=db("company")->order(["cid desc"])->select();

        foreach($list as $ks => $vs ){
            $user=db("user")->field("uid")->where("status",2)->where(["company_id"=>$vs['cid']])->select();
              
              $arr=array();
              foreach($user as $vs){
                $arr[]=$vs['uid'];
              }

             
            
             if($start){
                $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime('time', 'between', [$start, $end])->sum("integ");
             }else{
                $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime("time","m")->sum("integ");
             }
             // $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime("time","m")->sum("integ");

              $cou=count($user);

              if($integ == 0 || $cou == 0){
                $avg=0.00;
                }else{
                $avg=sprintf("%.2f",($integ/$cou));
                }

              $list[$ks]['integ']=$avg;

        }
     
        $last_names = array_column($list,'integ');
        array_multisort($last_names,SORT_DESC,$list);

        $this->assign("list",$list);


        return $this->fetch();
    }
    public function out_team(){
        
        $start=input('start');
        $end=input('end');
        $list=db("company")->order(["cid desc"])->select();

        foreach($list as $ks => $vs ){
            $user=db("user")->field("uid")->where("status",2)->where(["company_id"=>$vs['cid']])->select();
              
              $arr=array();
              foreach($user as $vs){
                $arr[]=$vs['uid'];
              }

             
            
             if($start){
                $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime('time', 'between', [$start, $end])->sum("integ");
             }else{
                $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime("time","m")->sum("integ");
             }
             // $integ=db("integ_log")->where(["uid"=>["in",$arr],"type"=>1])->whereTime("time","m")->sum("integ");

              $cou=count($user);

              if($integ == 0 || $cou == 0){
                $avg=0.00;
                }else{
                    $avg=sprintf("%.2f",($integ/$cou));
                }

              $list[$ks]['integ']=$avg;

        }

       // $lists=$lists->toArray();

      //  $list=$lists['data'];

        $last_names = array_column($list,'integ');
        array_multisort($last_names,SORT_DESC,$list);
        
        // var_dump($data);exit;
        vendor('PHPExcel.PHPExcel');//调用类库,路径是基于vendor文件夹的
        vendor('PHPExcel.PHPExcel.Worksheet.Drawing');
        vendor('PHPExcel.PHPExcel.Writer.Excel2007');
        $objExcel = new \PHPExcel();
        //set document Property
        $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
    
        $objActSheet = $objExcel->getActiveSheet();
        $key = ord("A");
        $letter =explode(',',"A,B");
        $arrHeader =  array("单位名称","积分");
        //填充表头信息
        $lenth =  count($arrHeader);
        for($i = 0;$i < $lenth;$i++) {
            $objActSheet->setCellValue("$letter[$i]1","$arrHeader[$i]");
        }
        //填充表格信息
        foreach($list as $k=>$v){
           
            $k +=2;
            $objActSheet->setCellValue('A'.$k,$v['cname']);
            $objActSheet->setCellValue('B'.$k, $v['integ']);    
            // 表格内容
          
            // 表格高度
            $objActSheet->getRowDimension($k)->setRowHeight(20);
        }
    
        $width = array(20,20,15,10,10,30,10,15,15,15);
        //设置表格的宽度
        $objActSheet->getColumnDimension('A')->setWidth(20);
        $objActSheet->getColumnDimension('B')->setWidth(20);
     
        
        $outfile = "团队平均月度排名".".xls";
    
        $userBrowser=$_SERVER['HTTP_USER_AGENT'];
        
        if(preg_match('/MSIE/i', $userBrowser)){
            $outfile=urlencode($outfile);
           
        }else{
            $outfile= iconv("utf-8","gb2312",$outfile);;
            
        }
        ob_end_clean();
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$outfile.'"');
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        $objWriter->save('php://output');
    }

    public function indexd()
    {
        $list=db("user")->where("job","党员")->where("status",2)->order("integ","desc")->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

        return $this->fetch();
    }
    public function outd(){
        
         
        $list=db("user")->where("job","党员")->where("status",2)->order("integ","desc")->select();
        
        // var_dump($data);exit;
        vendor('PHPExcel.PHPExcel');//调用类库,路径是基于vendor文件夹的
        vendor('PHPExcel.PHPExcel.Worksheet.Drawing');
        vendor('PHPExcel.PHPExcel.Writer.Excel2007');
        $objExcel = new \PHPExcel();
        //set document Property
        $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
    
        $objActSheet = $objExcel->getActiveSheet();
        $key = ord("A");
        $letter =explode(',',"A,B,C,D,E,F");
        $arrHeader =  array("账号名称","账号类型","真实姓名","政治面貌","所属单位","积分");
        //填充表头信息
        $lenth =  count($arrHeader);
        for($i = 0;$i < $lenth;$i++) {
            $objActSheet->setCellValue("$letter[$i]1","$arrHeader[$i]");
        }
        //填充表格信息
        foreach($list as $k=>$v){
            if($v['type'] == 0){
                $v['type']="微信用户";
            }else{
                $v['type']="手机号注册";
            }
            $k +=2;
            $objActSheet->setCellValue('A'.$k,$v['nickname'].$v['phone']);
            $objActSheet->setCellValue('B'.$k, $v['type']);    
            // 表格内容
            $objActSheet->setCellValue('C'.$k, $v['username']);
            $objActSheet->setCellValue('D'.$k, $v['job']);
            $objActSheet->setCellValue('E'.$k, $v['company']);
            $objActSheet->setCellValue('F'.$k, $v['integ']);
        
            // 表格高度
            $objActSheet->getRowDimension($k)->setRowHeight(20);
        }
    
        $width = array(20,20,15,10,10,30,10,15,15,15);
        //设置表格的宽度
        $objActSheet->getColumnDimension('A')->setWidth(20);
        $objActSheet->getColumnDimension('B')->setWidth(20);
        $objActSheet->getColumnDimension('C')->setWidth(25);
        $objActSheet->getColumnDimension('D')->setWidth(25);
        $objActSheet->getColumnDimension('E')->setWidth(25);
        $objActSheet->getColumnDimension('F')->setWidth(30);
        
        $outfile = "党员积分排名".".xls";
    
        $userBrowser=$_SERVER['HTTP_USER_AGENT'];
        
        if(preg_match('/MSIE/i', $userBrowser)){
            $outfile=urlencode($outfile);
           
        }else{
            $outfile= iconv("utf-8","gb2312",$outfile);;
            
        }
        ob_end_clean();
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$outfile.'"');
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        $objWriter->save('php://output');
    }
    public function polit()
    {
      //  $list=db("user")->where("job","党员")->order("integ","desc")->paginate(20);

        $start=input('start');
        $end=input('end');
         
        
        $this->assign("start",$start);
        $this->assign("end",$end);

        $list=db("user")->where("job","党员")->where("status",2)->order("polit_integ desc")->paginate(20)->each(function($k,$v){

            $start=input('start');
            $end=input('end');
          
           if($start){
              $integ=db("polit_integ_log")->where(["uid"=>$k['uid']])->whereTime('time', 'between', [$start, $end])->sum("integ");
           }else{
              $integ=db("polit_integ_log")->where(["uid"=>$k['uid']])->whereTime("time","m")->sum("integ");
           }

         //   $integ=db("polit_integ_log")->where(["uid"=>$k['uid']])->whereTime("time","m")->sum("integ");

            $k['integ']=$integ;

            return $k;
       }); 

       $page=$list->render();

   
       $this->assign("page",$page);

       $list=$list->toArray();
    
       $last_names = array_column($list['data'],'integ');
       array_multisort($last_names,SORT_DESC,$list['data']);

       $this->assign("list",$list['data']);

        return $this->fetch();
    }
    public function polits()
    {
      //  $list=db("user")->where("job","党员")->order("integ","desc")->paginate(20);

      $start=input('start');
        $end=input('end');
         
        
        $this->assign("start",$start);
        $this->assign("end",$end);

        $list=db("user")->where("status",2)->order("polit_integ desc")->paginate(20)->each(function($k,$v){

            $start=input('start');
            $end=input('end');
          
           if($start){
              $integ=db("polit_integ_log")->where(["uid"=>$k['uid']])->whereTime('time', 'between', [$start, $end])->sum("integ");
           }else{
              $integ=db("polit_integ_log")->where(["uid"=>$k['uid']])->whereTime("time","m")->sum("integ");
           }

          //  $integ=db("polit_integ_log")->where(["uid"=>$k['uid']])->whereTime("time","m")->sum("integ");

            $k['integ']=$integ;

            return $k;
       }); 

       $page=$list->render();

   
       $this->assign("page",$page);

       $list=$list->toArray();
    
       $last_names = array_column($list['data'],'integ');
       array_multisort($last_names,SORT_DESC,$list['data']);

       $this->assign("list",$list['data']);

        return $this->fetch();
    }
    public function outp(){
       
         
      //  $list=db("user")->where("job","党员")->order("integ","desc")->select();

      $list=db("user")->where("status",2)->where("job","党员")->order("polit_integ desc")->paginate(20)->each(function($k,$v){

     
        $start=input('start');
        $end=input('end');

       if($start){
          $integ=db("polit_integ_log")->where(["uid"=>$k['uid']])->whereTime('time', 'between', [$start, $end])->sum("integ");
       }else{
          $integ=db("polit_integ_log")->where(["uid"=>$k['uid']])->whereTime("time","m")->sum("integ");
       }
              //  $integ=db("polit_integ_log")->where(["uid"=>$k['uid']])->whereTime("time","m")->sum("integ");

                $k['integ']=$integ;

                return $k;
        }); 


       $list=$list->toArray();

        $last_names = array_column($list['data'],'integ');
        array_multisort($last_names,SORT_DESC,$list['data']);

       $list=$list['data'];
        
        // var_dump($data);exit;
        vendor('PHPExcel.PHPExcel');//调用类库,路径是基于vendor文件夹的
        vendor('PHPExcel.PHPExcel.Worksheet.Drawing');
        vendor('PHPExcel.PHPExcel.Writer.Excel2007');
        $objExcel = new \PHPExcel();
        //set document Property
        $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
    
        $objActSheet = $objExcel->getActiveSheet();
        $key = ord("A");
        $letter =explode(',',"A,B,C,D,E,F");
        $arrHeader =  array("账号名称","账号类型","真实姓名","政治面貌","所属单位","政治学习积分");
        //填充表头信息
        $lenth =  count($arrHeader);
        for($i = 0;$i < $lenth;$i++) {
            $objActSheet->setCellValue("$letter[$i]1","$arrHeader[$i]");
        }
        //填充表格信息
        foreach($list as $k=>$v){
            if($v['type'] == 0){
                $v['type']="微信用户";
            }else{
                $v['type']="手机号注册";
            }
            $k +=2;
            $objActSheet->setCellValue('A'.$k,$v['nickname'].$v['phone']);
            $objActSheet->setCellValue('B'.$k, $v['type']);    
            // 表格内容
            $objActSheet->setCellValue('C'.$k, $v['username']);
            $objActSheet->setCellValue('D'.$k, $v['job']);
            $objActSheet->setCellValue('E'.$k, $v['company']);
            $objActSheet->setCellValue('F'.$k, $v['integ']);
        
            // 表格高度
            $objActSheet->getRowDimension($k)->setRowHeight(20);
        }
    
        $width = array(20,20,15,10,10,30,10,15,15,15);
        //设置表格的宽度
        $objActSheet->getColumnDimension('A')->setWidth(20);
        $objActSheet->getColumnDimension('B')->setWidth(20);
        $objActSheet->getColumnDimension('C')->setWidth(25);
        $objActSheet->getColumnDimension('D')->setWidth(25);
        $objActSheet->getColumnDimension('E')->setWidth(25);
        $objActSheet->getColumnDimension('F')->setWidth(30);
        
        $outfile = "党员政治学习积分月度排名".".xls";
    
        $userBrowser=$_SERVER['HTTP_USER_AGENT'];
        
        if(preg_match('/MSIE/i', $userBrowser)){
            $outfile=urlencode($outfile);
           
        }else{
            $outfile= iconv("utf-8","gb2312",$outfile);;
            
        }
        ob_end_clean();
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$outfile.'"');
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        $objWriter->save('php://output');
    }
    public function outps(){
        
         
        //  $list=db("user")->where("job","党员")->order("integ","desc")->select();
  
        $list=db("user")->where("status",2)->order("polit_integ desc")->paginate(20)->each(function($k,$v){
  
            $start=input('start');
            $end=input('end');
          
           if($start){
              $integ=db("polit_integ_log")->where(["uid"=>$k['uid']])->whereTime('time', 'between', [$start, $end])->sum("integ");
           }else{
              $integ=db("polit_integ_log")->where(["uid"=>$k['uid']])->whereTime("time","m")->sum("integ");
           }
            
            // $integ=db("polit_integ_log")->where(["uid"=>$k['uid']])->whereTime("time","m")->sum("integ");
  
                  $k['integ']=$integ;
  
                  return $k;
          }); 
  
  
         $list=$list->toArray();
  
          $last_names = array_column($list['data'],'integ');
          array_multisort($last_names,SORT_DESC,$list['data']);
  
         $list=$list['data'];
          
          // var_dump($data);exit;
          vendor('PHPExcel.PHPExcel');//调用类库,路径是基于vendor文件夹的
          vendor('PHPExcel.PHPExcel.Worksheet.Drawing');
          vendor('PHPExcel.PHPExcel.Writer.Excel2007');
          $objExcel = new \PHPExcel();
          //set document Property
          $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
      
          $objActSheet = $objExcel->getActiveSheet();
          $key = ord("A");
          $letter =explode(',',"A,B,C,D,E,F");
          $arrHeader =  array("账号名称","账号类型","真实姓名","政治面貌","所属单位","政治学习积分");
          //填充表头信息
          $lenth =  count($arrHeader);
          for($i = 0;$i < $lenth;$i++) {
              $objActSheet->setCellValue("$letter[$i]1","$arrHeader[$i]");
          }
          //填充表格信息
          foreach($list as $k=>$v){
              if($v['type'] == 0){
                  $v['type']="微信用户";
              }else{
                  $v['type']="手机号注册";
              }
              $k +=2;
              $objActSheet->setCellValue('A'.$k,$v['nickname'].$v['phone']);
              $objActSheet->setCellValue('B'.$k, $v['type']);    
              // 表格内容
              $objActSheet->setCellValue('C'.$k, $v['username']);
              $objActSheet->setCellValue('D'.$k, $v['job']);
              $objActSheet->setCellValue('E'.$k, $v['company']);
              $objActSheet->setCellValue('F'.$k, $v['integ']);
          
              // 表格高度
              $objActSheet->getRowDimension($k)->setRowHeight(20);
          }
      
          $width = array(20,20,15,10,10,30,10,15,15,15);
          //设置表格的宽度
          $objActSheet->getColumnDimension('A')->setWidth(20);
          $objActSheet->getColumnDimension('B')->setWidth(20);
          $objActSheet->getColumnDimension('C')->setWidth(25);
          $objActSheet->getColumnDimension('D')->setWidth(25);
          $objActSheet->getColumnDimension('E')->setWidth(25);
          $objActSheet->getColumnDimension('F')->setWidth(30);
          
          $outfile = "全体政治学习积分月度排名".".xls";
      
          $userBrowser=$_SERVER['HTTP_USER_AGENT'];
          
          if(preg_match('/MSIE/i', $userBrowser)){
              $outfile=urlencode($outfile);
             
          }else{
              $outfile= iconv("utf-8","gb2312",$outfile);;
              
          }
          ob_end_clean();
          header("Content-Type: application/force-download");
          header("Content-Type: application/octet-stream");
          header("Content-Type: application/download");
          header('Content-Disposition:inline;filename="'.$outfile.'"');
          header("Content-Transfer-Encoding: binary");
          header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
          header("Pragma: no-cache");
          $objWriter->save('php://output');
      }




}
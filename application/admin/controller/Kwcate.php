<?php
namespace app\admin\controller;
//小讲分类管理
class Kwcate extends Islogin
{
    public function index()
    {
        $info = db("kwcate")->paginate(10);
    	$this->assign("info",$info);
        return $this->fetch();
    }

    // 进入编辑页
    public function edit()
    {
        // 进入编辑页面
        // 获取当前编辑的信息
        $info = db("kwcate")->where("id=".input('id'))->find();
        $this->assign("info",$info);
        return $this->fetch();
    }
    // 处理编辑
    public function update()
    {
        db("kwcate")->update(input());
        $this->success("修改成功","index");
    }

    // 进入添加页
    public function add()
    {
        return $this->fetch();
    }
    // 处理添加
    public function insert()
    {
        model("Kwcate")->insertInfo();
        $this->success("添加成功","index");
    }

    // 删除
    public function delete()
    {
        db("kwcate")->where("id=".input('id'))->delete();
        // $this->success("删除成功","index");
        $fruits = array ( 
            "fruits"  => array("a" => "orange", "b" => "banana", "c" => "apple"), 
            "numbers" => array(1, 2, 3, 4, 5, 6), 
            "holes"   => array("first", 5 => "second", "third") ,
            "successmessage" => input('id')
        ); 
        // echo json_encode($fruits);
        return json($fruits);
    }



}

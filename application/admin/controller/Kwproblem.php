<?php
namespace app\admin\controller;
use \think\Db;
//快问问题表管理
class Kwproblem extends Islogin
{
    public function index()
    {
        $info = db("kwproblem")->paginate(10);
    	$this->assign("info",$info);
        return $this->fetch();
    }

    // 进入编辑页
    public function edit()
    {
        // 进入编辑页面
        // 获取当前编辑的信息
        $info = db("kwproblem")->where("id=".input('id'))->find();
        $this->assign("info",$info);
        return $this->fetch();
    }
    // 处理编辑
    public function update()
    {
        db("kwproblem")->update(input());
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
        model("kwproblem")->insertInfo();
        $this->success("添加成功","index");
    }

    // 删除
    public function delete()
    {
        db("Kwproblem")->where("id=".input('id'))->delete();
        $successinfo = array ( 
            "successmessage" => input('id')
        ); 
        return json($successinfo);
    }
    //搜索
    public function search()
    {
        $info = Db::name("kwproblem")->where(input('searchkey'),'like',"%".input('searchtext')."%")->paginate(10,false,['query' => request()->param(), ]);
        $this->assign("info",$info);
        return $this->fetch("index");
    }


}

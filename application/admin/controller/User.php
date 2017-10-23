<?php
namespace app\admin\controller;
use \think\Db;
//用户管理
class User extends Islogin
{
    public function index()
    {
        $info = Db::name("user")->paginate(10);
    	$this->assign("info",$info);
        $searchinfo = Db::getTableInfo('fd_user');
        $this->assign("searchinfo",$searchinfo);
        $testinfo = substr($searchinfo['type']['user_name'], 0,3);
        $this->assign("testinfo",$testinfo);
        return $this->fetch();
    }

    // 进入编辑页
    public function edit()
    {
        // 进入编辑页面
        // 获取当前编辑的信息
        $info = db("user")->where("id=".input('id'))->find();
        $this->assign("info",$info);
        return $this->fetch();
    }
    // 处理编辑
    public function update()
    {
        db("user")->update(input());
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
        model("User")->insertInfo();
        $this->success("添加成功","index");
    }

    // 删除
    public function delete()
    {
        db("user")->where("id=".input('id'))->delete();
        $fruits = array ( 
            "fruits"  => array("a" => "orange", "b" => "banana", "c" => "apple"), 
            "numbers" => array(1, 2, 3, 4, 5, 6), 
            "holes"   => array("first", 5 => "second", "third") ,
            "successmessage" => input('id')
        ); 
        return json($fruits);
    }
    //搜索
    public function search()
    {
        $searchinfo = Db::getTableInfo('fd_user');
        $this->assign("searchinfo",$searchinfo);
        // if(stristr($searchinfo['type'][input('searchkey')],"var")>=0){
        //    $info = Db::name("user")->where(input('searchkey'),'like',"%".input('searchtext')."%")->paginate(10);
        // }else if(stristr($searchinfo['type'][input('searchkey')],"int")>=0){
        //    $info = Db::name("user")->where(input('searchkey'),'like',"%".input('searchtext')."%")->paginate(10);
        // }
        $info = Db::name("user")->where(input('searchkey'),'like',"%".input('searchtext')."%")->paginate(10,false,['query' => request()->param(), ]);
        $this->assign("info",$info);
        return $this->fetch("index");
    }


}

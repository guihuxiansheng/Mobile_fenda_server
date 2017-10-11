<?php
namespace app\api\controller;
    use \think\Controller;
/**
* 
*/
class Smalltalk extends controller
{
    function index()
    {
      $categories = db("categories")
                ->alias('c')
                ->field('name,id')
                ->select();
        return json($categories);
    }
    function expertlist()
    {
    $courselist = db("expert")
               ->field('id,expert_name,introduction')
               ->select();
        return json($courselist);
    }
     function special()
    {
    $speciallist = db("special")
                ->alias('s')
                ->join("expert e","e.id = s.speechmakerid")
                ->select();
        return json($speciallist);
    }
}
?>

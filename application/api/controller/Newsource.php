<?php
namespace app\api\controller;
    use \think\Controller;
/**
* 
*/
class Newsource extends controller
{
    function Newsource()
    {
        $courseID = input('id');
        
        $newsource =  db("course")
        ->alias('c')
        ->where('id',$courseID)
        ->select();
        return json($newsource);
    }
    function speechmakerid(){
        $speechmakerid = input('id');
        $speechmaker = db("special")
        ->where('id',$speechmakerid)
        ->select();
        return json($speechmaker);
    }
    
}
?>
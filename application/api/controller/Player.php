<?php
namespace app\api\controller;
    use \think\Controller;
/**
* 
*/
class Player extends controller
{
    function index()
    {   
        $audioID = input('id');
        $audio=db('audio')
        ->alias('a')
        ->where('a.id',$audioID)
        ->select();
        return json($audio);
    }
    function allaudio()
    {   
        $courseID = input('courseID');
        $allaudio=db('audio')
        ->alias('a')
        ->where('a.courseid',$courseID)
        ->select();
        return json($allaudio);
    }
    function single()
    {   
        $courseID = input('courseID');
        $single=db('single')
        ->alias('s')
        ->where('s.title_id',$courseID)
        ->select();
        return json($single);
    }
}
?>

<?php
namespace app\api\controller;
    use \think\Controller;
/**
* 
*/
class Topic extends controller
{
    function index()
    {   
        $topicid = input('id');
        $topic = db('specialtopic')
        ->alias('s')
        ->join('expert e','e.id = s.expertid')
        ->join('course c','c.special_id = s.id')
        ->field('e.*,c.id as courseID,c.*,s.*')
        ->where('s.id',$topicid )
        ->select();
        
        return json($topic);
    }

}
?>

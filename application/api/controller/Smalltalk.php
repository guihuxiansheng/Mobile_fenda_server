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
                ->field('name,id')
                ->select();
        return json($categories);
    }
   
    function course()
    {
        $selectedID = input('selectedID');
        $course = db("course")
        ->alias('c')
        ->join('expert e','e.id=c.expert_id')
        ->where('c.categroies_id',$selectedID)
        ->field('c.courseName,c.num,c.id,c.expert_id,e.expert_name,e.introduction,c.categroies_id,e.avatarPath,c.singleid')
        ->order('c.num desc')
        ->paginate(6);
        return json( $course);
    }
    function specialtopic(){
        $selectedID = input('selectedID');
        $topic = db('specialtopic')
        ->alias('s')
        ->where('s.categroies_id',$selectedID)
        ->select();
        return json($topic);
    }
    function topicshow(){
        $topicshow=db('topicshow')
        ->alias('t')
        ->join('specialtopic s','s.id = t.topicid')
        ->limit(4)
        ->select();
        return json($topicshow);
    }
}
?>

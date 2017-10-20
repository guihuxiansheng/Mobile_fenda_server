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
        $course =  db("course")
        ->alias('c')
        ->join('expert e','e.id=c.expert_id')
        ->join('single s','s.title_id = c.id')
        ->join('specialtopic sp','sp.id = c.special_id')
        ->where('c.id',$courseID)
        ->select();
        return json($course);
    }
    function audio(){
        $courseID = input('id');
        $audio = db('audio')
        ->alias('a')
        ->where('a.courseid',$courseID)
        ->select();
        return json($audio);
    }
    function comment(){
        $courseID = input('id');
        $comment = db('comment')
        ->alias('c')
        ->join('user u','u.id= c.user_id')
        ->where('c.courseID',$courseID)
        ->select();
        return json($comment);
    }
     function reply(){
        $courseID = input('id');
        $reply = db('reply')
        ->alias('r')
        ->where('r.courseid',$courseID)
        ->select();
        return json($reply);
    }
    function user(){
        $user = db('user')
        ->alias('u')
        ->join('reply r','r.userid= u.id')
        ->select();
        return json($user);
    }
    function topic(){
        $courseID = input('id');
        $topic = db('specialtopic')
        ->alias('s')     
        ->join('course c','c.special_id =s.id')
        ->where('c.id',$courseID)
        ->select();
        return json($topic);
    }
}
?>
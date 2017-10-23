<?php 
    namespace app\api\controller;
    use \think\Controller;
    /**
    * 
    */
    class Alllist extends Controller
    {
        
        function index()
        {
            $topic = db('specialtopic')
                ->alias('s')
                ->join('expert e','e.id = s.expertid')
                ->join('categories c','c.id=s.categroies_id')
                ->field('s.*,c.*,s.name as topic,e.*')
                ->select();
            return json($topic);
            
        }
    }
 ?>
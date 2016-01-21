<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pingke_index extends CI_Controller {
        function __construct(){
    // this is your constructor
            parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        }
	public function index(){
                $this -> load -> library('session');
                $name = $this -> session -> userdata('username');
                if(strlen($name)>=1){
                        $data['is_login'] = 1;
                }
                else{
                        $data['is_login'] = 0;
                }
                $name = $this -> session -> userdata('username');
                $data["nickname"] = $this-> session -> userdata('nickname');
		$this -> load -> view('pingke/index',$data);
	}
    public function star($pig){
        $data['pig'] = $pig;
        $this -> load -> view('pingke/start',$data);
    }
    public function add($course_id){
        $this -> load -> database();
        $teacher_name = $this->input -> post("teacher_name");
        $this -> load -> library('session');
        $name = $this -> session -> userdata('username');
        if(strlen($name)>=1){
            $data['is_login'] = 1;
        }
        else{
                $data['is_login'] = 0;
        }
        $name = $this -> session -> userdata('username');
        $data["nickname"] = $this-> session -> userdata('nickname');
        $this -> load -> view('pingke/add_tea',$data);
        if(strlen($teacher_name) >= 1){
            $data = array('teacher_name' => $teacher_name);
            $this -> db -> insert('teacher',$data);
            $query = $this -> db -> get_where('teacher',array('teacher_name' => $teacher_name ),1,0);
            foreach(($query->result()) as $row){
                $teacher_id = $row -> id;
            }   
            $data = array('id_course' => $course_id,'id_teacher' => $teacher_id,'score'=>0,'people'=>0);
            $this -> db -> insert('course_tea',$data);     
            redirect("/pingke_index/add/12");
        }
    }
    
    public function delete_later(){
        header("Content-type:text/html;charset=utf-8");
        $this -> load -> database();
        $query = $this -> db -> get('tempo');
        foreach(($query->result()) as $row){
            $query_course = $this -> db -> get_where('course',array('course_name' => $row->teacher_name),1,0);
            foreach(($query_course->result()) as $col){
                $col = $col;
            }
            $data = array('teacher_name' => $row->course_name);
            $this -> db -> insert('teacher',$data);
            $query_tem = $this -> db->get_where('teacher',array('teacher_name'=>$row->course_name),1,0);
            foreach(($query_tem->result()) as $pig){
                $teacher_id = $pig -> id;
            }
            $data = array('id_course' => $col->id,'id_teacher'=>$teacher_id,'score'=>0,'people'=>0);
            $this -> db -> insert('course_tea',$data);
            if($query_course->num_rows()==0){
                echo $row->teacher_name;
                echo "<br>";
            }
        }
    }
    public function add_tea($course_id,$teacher_name){

    }
	public function search(){
	    header("Content-type:text/html;charset=utf-8");
        $this -> load -> database();
    	$course_name = $this -> input -> post("course");
        $keywordArray = preg_split('/(?<!^)(?!$)/u',$course_name);
        foreach($keywordArray as $row){
            $this->db->like('course_name',$row,'both');
        }
        if(strlen($course_name)>=1){
            $query = $this->db->get('course');
        }
        else{
            redirect('/pingke_index/');
        }
		//$query = $this -> db -> get_where('course',array('course_name' => $course_name ),1,0);
		//获取ID
        /*
        foreach(($query->result()) as $row){
        	$course_id = $row -> id;
        }*/
        $this -> load -> library('session');
        $name = $this -> session -> userdata('username');
        $data["nickname"] = $this-> session -> userdata('nickname');
        $data["username"] = $name;
        if(strlen($name)>=1){
            $data['is_login'] = 1;
        }
        else{
            $data['is_login'] = 0;
        }
        //super root?
        $data['judge_root'] = 0;
        if($name[0]=='r' && $name[1] =='o' && $name[2] =='o' && $name[3] =='t'){
            $data['judge_root'] = 1;
        }
        //得到id
        if($query->num_rows()>=1){
                $num_tea = 0;
                $data["info"] = array(array("course_name"=>'play games',"teacher_name"=>"piggy"));
                unset($data["info"][0]);
                $data["noteacher"] = 0;
                foreach(($query->result()) as $pig){
                    $course_id = $pig -> id;
                    $query1 = $this -> db -> get_where('course_tea',array('id_course'=>$course_id),100,0);
                    foreach(($query1->result()) as $row){
                        $query_teacher = $this -> db -> get_where('teacher',array('id' => $row->id_teacher ),1,0);
                        foreach(($query_teacher->result()) as $col){
                          $teacher_name = $col -> teacher_name;
                        }
                        $num_tea +=1;
                        if($row->people == 0){
                            $data["info"][] = array('course_name'=>$pig->course_name,'teacher_name'=>$teacher_name,'score'=>0,'people'=>$row->people,'sid' => $row->id);
                        }
                        else{
                        $data["info"][] = array('course_name'=>$pig->course_name,'teacher_name'=>$teacher_name,'score'=>(($row->score)/($row->people)),'people'=>$row->people,'sid' => $row->id);
                        }
                    }
                }
                if($num_tea ==0 ){
                    $data["noteacher"] = 1; 
                    $data["course_name"] = $course_name;
                }
                $data["exist"] = 1;
                $this -> load -> view('pingke/search',$data);
                }
        else{    
                $this -> load -> view('notfound',$data);
                $data["exist"] = 0;    
        }
	}

        public function content($pig,$current_page){
                header("Content-type:text/html;charset=utf-8");
                $this -> load -> library('session');
                $name = $this -> session -> userdata('username');
                $this -> session -> set_userdata("page_id",$pig);
                if(strlen($name)>=1){
                        $data['is_login'] = 1;
                }
                else{
                        $data['is_login'] = 0;
                        redirect('/test/log');
                }
                $this -> load -> database();
                $query = $this -> db -> get_where('course_tea',array('id' => $pig),1,0);
                foreach(($query->result()) as $row){
                        $id_course = $row -> id_course;
                        $id_teacher = $row -> id_teacher;
                        $score = $row -> score;
                        $people = $row -> people;
                }
                $query = $this -> db -> get_where('teacher',array('id' => $id_teacher),1,0);
                foreach(($query->result()) as $row){
                        $teacher_name = $row -> teacher_name;
                }
                $query = $this -> db -> get_where('course',array('id' => $id_course),1,0);
                foreach(($query->result()) as $row){
                        $course_name = $row -> course_name;
                }          
                //以下是分页时间。
                //
                if($current_page % 5 == 0 ){
                        $first_page = $current_page-4;
                }
                else{
                        $first_page = (int)($current_page/5)*5 + 1;
                }
                $query = $this -> db -> get_where('comments',array('course_tea_id' => $pig),500,0);
                $rows = $query -> num_rows();
                if($rows % 6 == 0){
                        $pages = $rows/6;
                }
                else{
                        $pages = (int)($rows/6) + 1;
                }
                $content_array = $query -> result_array();
                if((($current_page-1)*6)+1 <= $rows){
                        $data["comment1"] = ($current_page-1)*6+1;
                        $data["content1"] = $content_array[$data["comment1"]-1]["content"];
                        $data["nickname1"] = $content_array[$data["comment1"]-1]["nickname"];
                }
                else{
                        $data["comment1"] = 0;
                }
                if($data["comment1"]+1<=$rows && $data["comment1"]!=0){
                        $data["comment2"] = $data["comment1"] +1;

                        $data["content2"] = $content_array[$data["comment2"]-1]["content"];
                        $data["nickname2"] = $content_array[$data["comment2"]-1]["nickname"];
                }
                else{
                        $data["comment2"] = 0;
                }
                if($data["comment2"]+1<=$rows && $data["comment2"]!=0){
                        $data["comment3"] = $data["comment2"] +1;
                        $data["content3"] = $content_array[$data["comment3"]-1]["content"];
                        $data["nickname3"] = $content_array[$data["comment3"]-1]["nickname"];
                }
                else{
                        $data["comment3"] = 0; 
                }
                if($data["comment3"]+1<=$rows && $data["comment3"]!=0){
                        $data["comment4"] = $data["comment3"] +1;
                        $data["content4"] = $content_array[$data["comment4"]-1]["content"];
                        $data["nickname4"] = $content_array[$data["comment4"]-1]["nickname"];
                }
                else{
                        $data["comment4"] = 0;
                }
                if($data["comment4"]+1<=$rows && $data["comment4"]!=0){
                        $data["comment5"] = $data["comment4"] +1;
                        $data["content5"] = $content_array[$data["comment5"]-1]["content"];
                        $data["nickname5"] = $content_array[$data["comment5"]-1]["nickname"];
                }
                else{
                        $data["comment5"] = 0;
                }
                if($data["comment5"]+1<=$rows && $data["comment5"]!=0){
                        $data["comment6"] = $data["comment5"] +1;
                        $data["content6"] = $content_array[$data["comment6"]-1]["content"];
                        $data["nickname6"] = $content_array[$data["comment6"]-1]["nickname"];
                }
                else{
                        $data["comment6"] = 0;
                }
                $data["course_tea_id"] = $pig;
                $data["teacher_name"] = $teacher_name;
                $data["course_name"] = $course_name;
                $data["people"] = $people;
                if($people ==0){
                    $data['score'] = 0;
                }
                else{
                    $data["score"] = $score/$people;
                }
                $data["is_login"] = 1;
                $data["pre"] = $first_page -1;
                $data["next"] = $first_page + 5;
                $data["page1"] = $first_page;
                $data["page2"] = $first_page+1;
                $data["page3"] = $first_page+2;
                $data["page4"] = $first_page+3;
                $data["page5"] = $first_page+4;
                if($data["pre"]<=0){
                        $data["pre"] = 1;
                        $data["next"] = 1;
                }
                else if($data["next"] > $pages){
                        $data["next"] = $pages;
                }
                if($data["page1"]>$pages){
                        $data["page1"] = 0;
                }
                if($data["page2"]>$pages){
                        $data["page2"] = 0;
                }
                if($data["page3"]>$pages){
                        $data["page3"] = 0;
                }
                if($data["page4"]>$pages){
                        $data["page4"] = 0;
                }
                if($data["page5"]>$pages){
                        $data["page5"] = 0;
                }
                        
                $data["current_page"] = $current_page;
                $this -> load -> library('session');
                $name = $this -> session -> userdata('username');
                $data["nickname"] = $this-> session -> userdata('nickname');
                $data["pig"] = $pig;
                $this -> load -> view('pingke/content',$data);    
        }

        public function addcomment(){
                $this -> load -> library('session');
                $course_tea_id = $this -> session -> userdata('page_id');
                $this -> load -> database();
                $this -> load -> library('session');
                $nickname = $this -> session -> userdata('nickname');
                $data['nickname'] = $nickname;
                $data['course_tea_id'] = $course_tea_id;
                $data['content'] = $this -> input -> post('content');
                $this -> db -> insert('comments',$data);
                redirect('/pingke_index/content/'.$course_tea_id.'/1');
        }
        public function score($pig,$score){
            $this -> load -> library('session');
            $this -> load -> database();
            $name = $this -> session -> userdata('username');
            $query = $this -> db -> get_where('anti_shua',array('user_name'=>$name,'course_tea_id'=>$pig),1,0);
            if($query->num_rows()==0){
                $this -> db -> where("id",$pig);
                $query = $this -> db -> get('course_tea');
                foreach(($query->result()) as $row){
                    $people_raw = $row -> people; 
                    $score_raw = $row -> score;
                }
                $score_new = $score_raw+$score;
                $people_new = $people_raw +1;
                $this -> db -> where("id",$pig);
                $this -> db -> update("course_tea",array('people'=>$people_new,'score'=>$score_new));
                $this -> db -> insert('anti_shua',array('course_tea_id'=>$pig,'user_name'=>$name));
            }
            redirect('/pingke_index/content/'.$pig.'/1');
        }

}
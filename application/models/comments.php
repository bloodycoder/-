<?php
class Comments extends CI_Model {

	public function __construct()
	{
	    //$this->load->database();
	}

	public function get_comments($course_id)
	{

	    $query = $this->db->get_where('news', array('slug' => $slug));
	    return $query->row_array();
	}
}

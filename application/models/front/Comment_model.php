
<?php
class Comment_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

    function post_comment($data)
    {
        $insert_array = array(
            'product_id'    =>  $data['product_id'],
            'user_id'       =>  $data['user_id'],
            'comment_time'  =>  date("Y-m-d"),
            'comment'       =>  $data['comment']
        );
        $insert_query = $this->db->insert('product_comment', $insert_array);
        if($insert_query){
            $query = $this->db->get_where("product_comment", array('product_id' => $data['product_id']));
            if($query->num_rows()>0)
            {
                $total_comments = $query->num_rows();
                foreach ($query->result() as $comment) {
                    $comment_array[] = (object)array(
                        'id'			=>	$comment->id,
                        'comment_time'	=>	$comment->comment_time,
                        'comment'		=>	$comment->comment,
                        'user_id'		=>	$comment->user_id
                    );
                }
                $return_array['total_comments'] = $total_comments;
                $return_array['comment_array'] = $comment_array; 
            }
            else{
                $return_array['total_comments'] = 0;
                $return_array['comment_array'] = array(); 
            }
        }
        else{
            $return_array['total_comments'] = 0;
            $return_array['comment_array'] = array(); 
        }
        return $return_array;
    }

}
?>
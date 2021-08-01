<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->database();

		$this->load->helper('form');
		$this->load->helper('html');
        $this->load->helper('url');
		$this->load->helper('cookie');
		$this->load->helper('date');
		$this->load->helper('string');

		$this->load->model('main_model');

		$this->load->library('email');
		$this->load->library('layout_front');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('session');

		$config['protocol'] = 'mail';
		$config['wordwrap'] = TRUE;
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$this->email->initialize($config);
	}

	public function index()
	{
		$viewdata['mainheader']='Contact us';
		$this->layout_front->view('/front/contact_us/index',$viewdata);
	}
    
    public function send_mail()
	{
	    // $this->load->library('email');
        
        $admin = $_POST['admin_email'];
        // $admin = "priyamsengupta1310@gmail.com";
        $sender_email = "support@readystaging.us";
        $subject = $_POST['subject'];
        
        $message = "<p>Hello ".$_POST['name']."</p>";
		$message .= "<p>Thank you for choosing us</p>";
		$message .= "<p>Our team will get back to you.</p>";
		$message .= "<p>Regards,</p>";
		$message .= "<p>Team Doughit</p>";
        
        $this->email->from($sender_email, 'Team Doughit');
        $this->email->to($_POST['email']); 
        $this->email->subject($subject);
        $this->email->message($message);
        
        
        $this->email->to($_POST['email']); 
        
        
        if($this->email->send())
        {            
            $message = "<p>Dear Admin,</p>";
		    $message .= "<p>We have a new enquiry</p>";
		    $message .= "<p><b>Name : </b>".$_POST['name']."</p>";
			$message .= "<p><b>Email : </b>".$_POST['email']."</p>";
			$message .= "<p><b>Phone Number : </b>".$_POST['phone']."</p>";
            $message .= "<p><b>Message : </b>".$_POST['message']."</p>";
		    $message .= "<p>Regards,</p>";
		    $message .= "<p>Team Doughit</p>";
            
            $this->email->from($sender_email, 'Team Doughit');
            $this->email->to($admin); 
            $this->email->subject("New Enquiry");
            $this->email->message($message);  
            if($this->email->send())
            {
                $insert_array = array(
                    'name'      =>  $_POST['name'],
                    'email'     =>  $_POST['email'],
                    'phone'     =>  $_POST['phone'],
                    'subject'   =>  $_POST['subject'],
                    'message'   =>  $_POST['message']
                );
                $return = $this->db->insert('contact_us', $insert_array);
                echo $return;
            }
            else{
                echo 0;
            }
        }
        else{
            echo 0;
        }
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
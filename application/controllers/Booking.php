<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Booking extends CI_Controller {

	/**
	 * @author	Priyam SenGupta
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
		
		$this->load->model('front/booking_model','booking_model');

		$this->load->library('email');
		// $this->load->library('layout_front_home');
		$this->load->library('layout_front');
		$this->load->library('form_validation');
		//$this->load->library('pagination');
		$this->load->library('session');
		//$this->load->library('converttime');

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
	    $this->load->library('email');
        
        $admin = $_POST['admin_email'];
        $sender_email = "support@readystaging.us";
        $subject = "Your booking has been done";
        
        $message = "<p>Hello ".$_POST['name']."</p>";
		$message .= "<p>Thank you for choosing us</p>";
		$message .= "<p>Your booking for ".$_POST['person_count']." people on ".$_POST['date']." has been confirmed.</p>";
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
		    $message .= "<p>We have a new booking</p>";
		    $message .= "<p><b>Name : </b>".$_POST['name']."</p>";
			$message .= "<p><b>Email : </b>".$_POST['email']."</p>";
			$message .= "<p><b>Number of people : </b>".$_POST['person_count']."</p>";
			$message .= "<p><b>Date of booking : </b>".$_POST['date']."</p>";
		    $message .= "<p>Regards,</p>";
		    $message .= "<p>Team Doughit</p>";
            
            $this->email->from($sender_email, 'Team Doughit');
            $this->email->to($admin); 
            $this->email->subject("Table Booking");
            $this->email->message($message);  
            if($this->email->send())
            {
                $return = $this->booking_model->booking($_POST);
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
?>
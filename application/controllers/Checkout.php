<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends CI_Controller {

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

		$this->load->model('front/checkout_model','checkout_model');
        $this->load->model('front/cart_model','cart_model');
		$this->load->model('main_model');

		$this->load->library('email');
		$this->load->library('layout_front');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('session');
		// $this->load->library('pdf');

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
		if($this->session->userdata('doughit_userid')){
			$return = $this->cart_model->get_cart($this->session->userdata('doughit_userid'));
            if(empty($return)){
                $this->session->set_userdata('error_msg', "No product added in the cart.");
            	redirect($this->config->item('base_url').'order_online');
            }
			$viewdata['data'] = $return;
			$viewdata['mainheader']= "Checkout";
			$this->layout_front->view('/front/checkout/index',$viewdata);
		}
		else
		{
			if(!empty($_COOKIE['cart'])) {
				$viewdata['data'] = json_decode($_COOKIE['cart'], true);
				$viewdata['mainheader']= "Checkout";
			    $this->layout_front->view('/front/checkout/index',$viewdata);
			} else {
				$this->session->set_userdata('error_msg', "No product added in the cart.");
            	redirect($this->config->item('base_url').'order_online');
			}
		}
	}

	public function get_province()
	{
		$country_id = $this->input->post('country_id');
		$getdata = array();
		$getdata['table_name'] = 'province';
		$getdata['field_name'] = '*';
		$getdata['condition'] = array('country_id'=> $country_id ,'is_active'=> 1);
		$getdata['sortorder'] = array();
		$getdata['groupbyorder'] = array();
		$getdata['searchvalue'] = array();
		$getdata['getvalue'] = 1;
		$getdata['limit'] = 0;
		$getdata['start'] = 0;
		$getdata['join'] = array();
		$details = $this->main_model->get_full_details($getdata);

		$viewdata['states']=$details;
		if(!empty($details))
		{
			$viewdata=$this->load->view('/front/checkout/ajaxStateData',$viewdata);
			return $viewdata;

		}else{

			return 0;
		}
	}

	public function place_order()
	{
		$mpdf = new \Mpdf\Mpdf();
		$user_id = $this->input->post('id');
		$return = $this->checkout_model->place_order($user_id);
		if(!empty($return)){
			$html = $this->load->view('invoice', $return, true);
			$invoice_name = 'invoice#'.$return['order_no'].$user_id.'.pdf';
			$pdfFilePath = $this->config->item('server_absolute_path'). "dist/invoice_pdfs/".$invoice_name;
			$mpdf->WriteHTML($html);
		
			$mpdf->Output($pdfFilePath, "F");

			$this->checkout_model->update_invoice($invoice_name,$return['order_id']);

			$getdata = array();
			$getdata['table_name'] = 'business_user';
			$getdata['field_name'] = '*';
			$getdata['condition'] = array('id' => $user_id);
			$getdata['sortorder'] = array();
			$getdata['groupbyorder'] = array();
			$getdata['searchvalue'] = array();
			$getdata['getvalue'] = 0;
			$getdata['limit'] = 0;
			$getdata['start'] = 0;
			$getdata['join'] = array();
			$user_details = $this->main_model->get_full_details($getdata);
		
			$message = "<p>Hello ".$user_details->fname."</p>";
			$message .= "<p>Your order has been placed successfully</p>";
			$message .= "<p>Below is your order invoice.</p>";
			
			$this->email->from("support@readystaging.us","Team Doughit");
			// $user_details->email
			$this->email->to($user_details->email); 
			$this->email->subject('Order Invoice');
			$this->email->message($message);
			$this->email->attach($pdfFilePath);
			$send = $this->email->send();
			$this->email->clear(TRUE);
			if($send) {
				echo 1;
			}
			else{
				echo -1;
			}
		}
		else{
			echo -2;
		}
		// echo $return['order_no'];
		// if(count($return)>0){
		// 	$this->html2pdf->folder('./dist/invoice_pdfs/');	    
		// 	$this->html2pdf->filename('invoice.pdf');
		// 	$this->html2pdf->paper('a4', 'portrait');

			
		// 	//Load html view
		// 	$this->html2pdf->html($this->load->view('invoice', $return, true));
			
		// 	//Check that the PDF was created before we send it
		// 	if($path = $this->html2pdf->create('save')) {
		// 		$getdata = array();
		// 		$getdata['table_name'] = 'business_user';
		// 		$getdata['field_name'] = '*';
		// 		$getdata['condition'] = array('id' => $user_id);
		// 		$getdata['sortorder'] = array();
		// 		$getdata['groupbyorder'] = array();
		// 		$getdata['searchvalue'] = array();
		// 		$getdata['getvalue'] = 0;
		// 		$getdata['limit'] = 0;
		// 		$getdata['start'] = 0;
		// 		$getdata['join'] = array();
		// 		$user_details = $this->main_model->get_full_details($getdata);
		// 		// $this->load->library('email');

		// 		$message = "<p>Hello ".$user_details->fname."</p>";
		// 		$message .= "<p>Your order has been placed successfully</p>";
		// 		$message .= "<p>Below is your order invoice.</p>";
				
		// 		// $this->email->from("dev.sirchend@gmail.com","Reset Password");
		// 		$this->email->from("support@readystaging.us","Team Doughit");

		// 		$this->email->to($user_details->email);
		// 		$this->email->subject('Order Invoice');
		// 		$this->email->message($message);
		// 		$this->email->attach($path);
		// 		$send = $this->email->send();
		// 		$this->email->clear(TRUE);
		// 		if($send) {
		// 			echo $return['order_no'];
		// 		}
		// 		else{
		// 			echo -1;
		// 		}
		// 	}
		// 	else{
		// 		echo -2;
		// 	}
		// }
		// else{
		// 	echo -3;
		// }
	}
}
?>
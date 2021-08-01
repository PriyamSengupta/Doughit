<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {

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
		
		$this->load->model('front/blog_model','blog_model');

		$this->load->library('email');
        $this->load->library('layout_front');
		$this->load->library('form_validation');
		$this->load->library('session');

		$config['protocol'] = 'mail';
		$config['wordwrap'] = TRUE;
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$this->email->initialize($config);
	}

	public function index($slug='')
	{
	    $url_segment = explode('/', $_SERVER['REQUEST_URI']);
// 		print_r($url_segment); die();
		if($url_segment[3] == '')
		{
			redirect($this->config->item('base_url'));
		}
		else
		{
		    $return = $this->blog_model->get_blog_info($url_segment[3]);
		    if($return != '')
			{
				$viewdata['mainheader']=$return->title;
				$viewdata['details'] = $return;
				$this->layout_front->view('/front/blog/index',$viewdata);
			}
			else 
			{
				redirect($this->config->item('base_url'));
			}
		}
	}

}
?>
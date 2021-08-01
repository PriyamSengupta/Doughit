<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Layout_front_home
{
    var $obj;
    var $layout;

    function __construct()
    {
        $this->obj =& get_instance();
        $this->layout = 'layout_front_home';
    }

    function setLayout($layout)
    {
      $this->layout = $layout;
    }

    function view($view, $data=null, $return=false)
    {
        $loadedData = array();
        $loadedData['content_for_layout'] = $this->obj->load->view($view,$data,true);

        if($return)
        {
            $output = $this->obj->load->view($this->layout, $loadedData, true);
            return $output;
        }
        else
        {
            $this->obj->load->view($this->layout, $loadedData, false);
        }
    }
}
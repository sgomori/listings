<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
    if ((isset($_SERVER['PHP_AUTH_USER'])
        && (($_SERVER['PHP_AUTH_USER'] !== 'wpghomes-admin')
        && ($_SERVER['PHP_AUTH_PW'] == 'Tyson-Admin-2016')))
        || (!isset($_SERVER['PHP_AUTH_USER'])))
    {
      header('WWW-Authenticate: Basic realm="Winnipeg Homes Admin"');
      header('HTTP/1.0 401 Unauthorized');
      echo 'You are not authorized to view this area.';
      die();
    }

		$this->data = array();
		$this->data['content'] = '';
		$this->data['assets_path'] = assets_url();
	}
	
	public function index()
	{
	  redirect('/admin/manage-pending');
	}


	public function manage_pending()
	{
    $query = $this->Listings_model->get_pending_listings();
    
    $this->data['listings'] = $query->result_array();
        
    $this->load->view('admin/admin_pending', $this->data);
	}
	
	
	public function set_as_sold()
	{
	  if (!$this->input->is_ajax_request())
	  {
	    return;
	  }
	  
	  $result = ($this->Listings_model->set_properties_to_sold($this->input->post('matrix_unique_ids')) ? 1 : 0);
	  
	  echo $result;
	}
	
}

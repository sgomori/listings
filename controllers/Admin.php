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
	  $this->load->view('admin/admin_dashboard');
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
	
	
	public function properties()
	{
    $where = '
      AND
      (
        Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
        OR
        Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
      )    
    ';
    
    $query = $this->Listings_model->get_all_listings($where);
    
    $this->data['listings'] = $query->result_array();
    
    $this->load->view('admin/admin_properties', $this->data); 
	}
	

	public function set_map($class, $matrix_unique_id)
	{    
    $property = $this->Listings_model->get_property_detail($class, $matrix_unique_id)->result_array();
    
    $this->data['property'] = $property[0];
    $this->data['class'] = $class;
    
    $this->load->view('admin/set_map', $this->data); 
    
  }
  
  
	public function update_map_marker()
	{
	  if (!$this->input->is_ajax_request())
	  {
	    return;
	  }
	  
	  $data = array(
              'matrix_unique_id' => $this->input->post('matrix_unique_id'),
              'class' => $this->input->post('type'),
              'lat' => $this->input->post('lat'),
              'lon' => $this->input->post('lon') 
	           );
	  
	  $result = ($this->Listings_model->update_map_marker($data) ? 1 : 0);
	  
	  echo $result;
	}
	
}

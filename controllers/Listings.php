<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->data = array();
		$this->data['content'] = '';
		$this->data['assets_path'] = assets_url();
		$this->data['header_variant'] = 'main';
		$this->header_view = 'inc/header';
		$this->footer_view = 'inc/footer';
		$this->analtyics = 'inc/analytics';
		
    $this->types = array(
            'all' => array('active' => ''),
            'res' => array('title' => 'Residential', 'active' => '', 'path' => 'homes'),
            'con' => array('title' => 'Condo', 'active' => '', 'path' => 'condos'),
            'rur' => array('title' => 'Rural/Farm', 'active' => '', 'path' => 'rural'),
            'open-houses' => array('title' => 'Open HOuses', 'active' => '', 'path' => 'open-houses'),
            'sold' => array('title' => 'Recently Sold', 'active' => '', 'path' => 'sold')
            );
            
    date_default_timezone_set('America/Winnipeg');
	}
	
  private function _generate_template()
  {
    $this->data['analytics'] = $this->load->view($this->analtyics, $this->data, TRUE);
    $this->data['header'] = $this->load->view($this->header_view, $this->data, TRUE);
    $this->data['footer'] = $this->load->view($this->footer_view, $this->data, TRUE);    
  }

	public function index($type = FALSE)
	{

    if ($type)
    {          
      if ($type == 'open-houses')
      {
        $query = $this->Listings_model->get_open_houses();
      }
      else if ($type == 'sold')
      {
        $query = $this->Listings_model->get_sold_listings();
      }
      else
      {
        $query = $this->Listings_model->get_listings_by_type($type);
        $this->data['header_variant'] = $type;
      }
      	     
      $this->types[$type]['active'] = ' class="active '.$type.'"';
      $this->data['h1'] = 'Our '.$this->types[$type]['title'].' Properties';
    }
    else
    {
      $where = '
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )    
      ';
      
      $query = $this->Listings_model->get_all_listings($where);
      
      $this->types['all']['active'] = ' class="active"';
      $this->data['h1'] = 'Our Properties';
    }
    
    $this->data['listings'] = $query->result_array();
    $this->data['type'] = $type;
    $this->data['types'] = $this->types;
            
    $this->_generate_template();
    $this->data['content'] = $this->load->view('standard_listing', $this->data, TRUE);
    
    $this->load->view('standard_page', $this->data);
	}
	

	public function property($class, $matrix_unique_id)
	{    
    $property = $this->Listings_model->get_property_detail($class, $matrix_unique_id)->result_array();
    $this->data['room_data'] = $this->Listings_model->get_room_detail($matrix_unique_id)->result_array();
    
    $open_houses = FALSE;
    
    if (isset($property[0]['Open_House_Date_NUM1']))
    {
      $open_houses = array(
                        'directions' => $property[0]['Directions'],
                        'remarks' => $property[0]['Remarks'],
                        'heading' => $property[0]['Heading_CAPS'],
                        'dates' => array()
                        );
      
      foreach ($property as $open_house)
      {
        $open_houses['dates'][] = array(
                                    'date' => $open_house['Open_House_Date_NUM1'],
                                    'start' => $open_house['FromTime'],
                                    'end' => $open_house['ToTime'],
                                    );
      }
    }
    
    $this->data['property'] = $property[0];
    $this->data['open_houses'] = $open_houses;
    
    $property_images = array();
    foreach (glob('assets/images/properties/image-'.$matrix_unique_id.'*.jpg') as $filename)
    {
      $property_images[] = $filename;
    }
    
    if (count($property_images) > 1)
    {
      unset($property_images[0]);
    }
    
    $property_images = array_values($property_images);
    
    $features = explode(',', $this->data['property']['Features'].','.$this->data['property']['Goods_Included']);
    sort($features);
    
    if (isset($this->data['property']['Amenities']))
    {
      $amenities = explode(',', $this->data['property']['Amenities']);
      sort($amenities);
    }
    else
    {
      $amenities = FALSE;
    }
    
    if (isset($this->data['property']['Site_Influences']))
    {
      $site_influences = explode(',', $this->data['property']['Site_Influences']);
      sort($site_influences);
    }
    else
    {
      $site_influences = FALSE;
    }
    
    if (isset($this->data['property']['Flooring']))
    {
      $flooring = explode(',', $this->data['property']['Flooring']);
      sort($flooring);
    }
    else
    {
      $flooring = FALSE;
    }

    $this->data['property_images'] = $property_images;
    $this->data['features'] = $features;
    $this->data['amenities'] = $amenities;
    $this->data['site_influences'] = $site_influences;
    $this->data['flooring'] = $flooring;
    
    $this->data['header_variant'] = $class;
    $this->_generate_template();
    $this->data['content'] = $this->load->view('property_detail', $this->data, TRUE);
                
    $this->load->view('standard_page', $this->data);
	}
	
	
	public function search()
	{
            
    $search = array();
    
    if (isset($_GET['bedrooms']))
    {
      $search[] = 'Total_Bedrooms >= '.$_GET['bedrooms'];
    }
    
    if (isset($_GET['bathrooms']))
    {
      $search[] = 'Number_of_Total_Baths >= '.$_GET['bathrooms'];
    }
    
    if (isset($_GET['price_lower']))
    {
      $search[] = 'CurrentPrice >= '.$_GET['price_lower'];
    }
    
    if (isset($_GET['price_upper']))
    {
      $search[] = 'CurrentPrice <= '.$_GET['price_upper'];
    }
    
    if (isset($_GET['area_lower']))
    {
      $search[] = 'Total_FloorLiv_Area_SF >= '.$_GET['area_lower'];
    }
    
    if (isset($_GET['area_upper']))
    {
      $search[] = 'Total_FloorLiv_Area_SF <= '.$_GET['area_upper'];
    }
    
    if (isset($search[0]))
    {
      $where = ' AND '.implode(' AND ', $search);
    }
    
              
    if ((isset($_GET['type'])) && ($_GET['type'] !== 'all'))
    {
      $query = $this->Listings_model->search_current_listings_by_type($_GET['type'], $where);
      
      $type = $_GET['type'];
      $this->types[$type]['active'] = ' class="active '.$type.'"';
      $this->data['h1'] = $this->types[$type]['title'].' Search Results';
    }
    else
    {
      $query = $this->Listings_model->search_current_listings($where);
      $this->types['all']['active'] = ' class="active"';
      $type = FALSE;
      $this->data['h1'] = 'Search Results';
    }	
    
    $this->data['listings'] = $query->result_array();
    $this->data['type'] = $type;
    $this->data['types'] = $this->types;
            
    $this->_generate_template();
    $this->data['content'] = $this->load->view('standard_listing', $this->data, TRUE);
    
    $this->load->view('standard_page', $this->data);
	}
	
	
	public function office()
	{
    $where = '
      (
        Sold_Date > NOW()
        OR
        Sold_Date = "0000-00-00 00:00:00"
      )
    ';
    
    $query = $this->Listings_model->get_all_listings($where);
    
    $this->types['all']['active'] = ' class="active"';
    $this->data['h1'] = 'Our Office\'s Listings';

    
    $this->data['listings'] = $query->result_array();
    $this->data['type'] = FALSE;
    $this->data['types'] = $this->types;
            
    $this->_generate_template();
    $this->data['content'] = $this->load->view('standard_listing', $this->data, TRUE);
    
    $this->load->view('standard_page', $this->data);
	}
	
	
	public function development($development)
	{
    $development = str_replace('-', ' ', $development);
    
    $query = $this->Listings_model->get_development_listings($development);
 
    $this->data['listings'] = $query->result_array();
    $this->data['type'] = 'con';
    $this->data['types'] = $this->types;
        
    $this->load->view('listings_only', $this->data);
	}
	
	
	public function send_message()
	{
	  $this->load->library('email');
    
    $name = $this->input->post('name');
	  $email = $this->input->post('email');
	  $message = $this->input->post('message');
	  $send_to = $this->input->post('send_to');
	  $ml_number = $this->input->post('ml_number'); 
	  $civic_address = $this->input->post('civic_address'); 
    
    $this->email->from($email, $name);
    $this->email->to($send_to);
    
    $this->email->subject('Contact Form Submission Re: '.$civic_address.', MLS #: '.$ml_number);
    $this->email->message($message);
    
    $this->email->send();
	}
}

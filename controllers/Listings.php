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
		$this->data['map'] = FALSE;
		$this->data['property_detail'] = FALSE;
		$this->data['title'] = 'Listings | An Experience Worth Repeating';
		$this->data['description'] = 'Winnipeg Real Estate Listings by Blair Sonnichsen and Tyson Sonnichsen';
		$this->data['og_image'] = base_url('assets/images/WH-OG.jpg');
		$this->data['og_width'] = 728;
		$this->data['og_height'] = 382;
		$this->header_view = 'inc/header';
		$this->footer_view = 'inc/footer';
		$this->analtyics = 'inc/analytics';
		
    $this->types = array(
            'all' => array('active' => ''),
            'res' => array('title' => 'Residential', 'active' => '', 'path' => 'homes'),
            'con' => array('title' => 'Condo', 'active' => '', 'path' => 'condos'),
            'rur' => array('title' => 'Rural/Farm', 'active' => '', 'path' => 'rural'),
            'open-houses' => array('title' => 'Open House', 'active' => '', 'path' => 'open-houses'),
            'sold' => array('title' => 'Recently Sold', 'active' => '', 'path' => 'sold'),
            'map' => array('title' => 'Listings Map', 'active' => '', 'path' => 'map')
            );

    date_default_timezone_set('America/Winnipeg');
	}
	
  private function _generate_template()
  {
    $this->data['analytics'] = $this->load->view($this->analtyics, $this->data, TRUE);
    $this->data['header'] = $this->load->view($this->header_view, $this->data, TRUE);
    
    $this->data['wpg_news_link'] = file_get_contents('/home4/winnipg2/wpg_news/wpg_news_link.txt');
    $this->data['footer'] = $this->load->view($this->footer_view, $this->data, TRUE);    
  }

	public function index($type = FALSE)
	{

    if ($type)
    {          
      if ($type == 'open-houses')
      {
        $query = $this->Listings_model->get_open_houses();
    		$this->data['title'] = 'Listings | Open Houses';
    		$this->data['description'] = 'Upcoming Open Houses with Blair Sonnichsen and Tyson Sonnichsen';
      }
      else if ($type == 'sold')
      {
        $query = $this->Listings_model->get_sold_listings();
    		$this->data['title'] = 'Listings | Recently Sold';
    		$this->data['description'] = 'Recently Sold Listings by Blair Sonnichsen and Tyson Sonnichsen';
      }
      else if ($type == 'rur')
      {
        $where = '
          AND
          (
            Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
            OR
            Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
          )
          AND
          (
            Listing.Area LIKE "R%"
            OR
            Listing.City_or_Town_Name LIKE "Headingley%"
          )
          AND
          (
            Listing.Active = 1
            OR
            Listing.Status LIKE "Sold"
            OR
            Listing.Status LIKE "Custom"
          ) 
        ';
        
        $query = $this->Listings_model->get_all_listings($where);
        $this->data['header_variant'] = $type;
    		$this->data['title'] = 'Rural Listings';
    		$this->data['description'] = 'Rural Listings by Blair Sonnichsen and Tyson Sonnichsen';
      }
      else
      {
        $query = $this->Listings_model->get_listings_by_type($type);
        $this->data['header_variant'] = $type;
    		$this->data['title'] = $this->types[$type]['title'].' Listings';
    		$this->data['description'] = $this->types[$type]['title'].' Listings by Blair Sonnichsen and Tyson Sonnichsen';
      }
      	     
      $this->types[$type]['active'] = ' class="active '.$type.'"';
      $this->data['h1'] = 'Our '.$this->types[$type]['title'].' Properties';
    }
    else
    {
      $where = '
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )
        AND
        (
          Listing.Active = 1
          OR
          Listing.Status LIKE "Sold"
          OR
          Listing.Status LIKE "Custom"
          OR
          Listing.Status LIKE "Pending"
        ) 
      ';
      
      $query = $this->Listings_model->get_all_listings($where);

  		$this->data['title'] = 'Listings | Winnipeg Homes for Sale';
  		$this->data['description'] = 'Winnipeg Homes for Sale by Blair Sonnichsen and Tyson Sonnichsen';      
      $this->types['all']['active'] = ' class="active"';
      $this->data['h1'] = 'Our Properties';
    }
    
    $listings = $query->result_array();
    
    foreach ($listings as &$listing)
    {
      $listing['address_slug'] = $this->_get_address_slug($listing);
    }
    
    $this->data['listings'] = $listings;
    $this->data['type'] = $type;
    $this->data['types'] = $this->types;
            
    $this->_generate_template();
    $this->data['content'] = $this->load->view('standard_listing', $this->data, TRUE);
    
    $this->load->view('standard_page', $this->data);
	}


	public function map()
	{
    $where = '
      AND
      (
        Status LIKE "Active"
      )
      AND
      (
        Active = 1
        OR
        Listing.Status LIKE "Custom"
      )
    ';
    
    $query = $this->Listings_model->get_all_listings($where);

		$this->data['title'] = 'Listings Map | Winnipeg Homes for Sale';
		$this->data['description'] = 'Winnipeg Homes for Sale by Blair Sonnichsen and Tyson Sonnichsen';      
    $this->types['map']['active'] = ' class="active"';
    $this->data['h1'] = 'Our Properties on the Map';
    
    $listings = array();
    $listings_coords = array();
    $result = $query->result_array();
    
    foreach ($result as &$listing)
    {
      $lat = $listing['Lat'];
      $lon = $listing['Lon'];
      
      if (($lat == '') || ($lon == ''))
      {
        $street = trim($listing['Street_Number']).'+'.str_replace(' ', '+', trim($listing['Street_Name'])).'+'.str_replace(' ', '+', trim($listing['Street_Type']));
        $city = str_replace(' ', '+', $listing['City_or_Town_Name']);
        
        $address = $street.','.$city.',Manitoba';
        $lat_lon = $this->_set_coordinates($listing['class'], $listing['Matrix_Unique_ID'], $address);
        
        $lat = $lat_lon['lat'];
        $lon = $lat_lon['lon'];
      }
      
      $listing['address_slug'] = $this->_get_address_slug($listing);
      
      $listings[] = $listing;
      
      $listings_coords[] = array(
                            'matrix_unique_id' => $listing['Matrix_Unique_ID'],
                            'lat' => $lat,
                            'lon' => $lon
                            );
    }
    
    $this->data['listings'] = $listings;
    $this->data['listings_coords_json'] = json_encode($listings_coords);
    
    $this->data['type'] = FALSE;
    $this->data['types'] = $this->types;
    $this->data['map'] = TRUE;
            
    $this->_generate_template();
    $this->data['content'] = $this->load->view('standard_listing', $this->data, TRUE);
    
    $this->load->view('standard_page', $this->data);
	}
  	

	public function property($class, $matrix_unique_id, $address_slug_suggestion = FALSE)
	{    
    $property = $this->Listings_model->get_property_detail($class, $matrix_unique_id)->result_array();
    
    if ((!isset($property[0])) || 
          (((int)$property[0]['Active'] === 0) && 
            ($property[0]['Status'] !== 'Sold') && 
            ($property[0]['Status'] !== 'Pending') &&
            ($property[0]['Status'] !== 'Custom') &&            
            (
              ($property[0]['Sales_Rep_MUI_1'] == '564206') ||
              ($property[0]['Sales_Rep_MUI_1'] == '16212643') ||
              ($property[0]['Sales_Rep_MUI_2'] == '564206') ||
              ($property[0]['Sales_Rep_MUI_2'] == '16212643')
            )                            
          ) ||
          (((int)$property[0]['Active'] === 0) &&          
            (
              ($property[0]['Sales_Rep_MUI_1'] !== '564206') &&
              ($property[0]['Sales_Rep_MUI_1'] !== '16212643') &&
              ($property[0]['Sales_Rep_MUI_2'] !== '564206') &&
              ($property[0]['Sales_Rep_MUI_2'] !== '16212643')
            )                            
          )
        )
    {
      header('HTTP/1.0 404 Not Found');
      
      $this->data['header_variant'] = $class;
      $this->data['analytics'] = '';
      $this->data['header'] = $this->load->view($this->header_view, $this->data, TRUE);
      $this->data['footer'] = $this->load->view($this->footer_view, $this->data, TRUE);
      
      $this->data['content'] = $this->load->view('property_not_found', $this->data, TRUE);
      $this->load->view('standard_page', $this->data);
    
      return;
    }

    $address_slug = $this->_get_address_slug($property[0]);
    
    if (($address_slug !== '') && ((!$address_slug_suggestion) || ($address_slug !== strtolower($address_slug_suggestion))))
    {
      header('HTTP/1.1 301 Moved Permanently');
      header('Location: '.base_url().$this->types[$class]['path'].'/'.$matrix_unique_id.'/'.$address_slug);     
    }
    
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
    
    natsort($property_images);
       
    if (count($property_images) > 1)
    {
      unset($property_images[0]);
    }
    
    $property_images = array_values($property_images);
    
    $feature_list = $this->data['property']['Features'];
    
    if (isset($this->data['property']['Goods_Included']))
    {
      $feature_list .= ','.$this->data['property']['Goods_Included'];
    }
    
    $features = explode(',', $feature_list);
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
    
    if (($this->data['property']['Lat'] == '') || ($this->data['property']['Lon'] == ''))
    {
      $street = trim($this->data['property']['Street_Number']).'+'.str_replace(' ', '+', trim($this->data['property']['Street_Name'])).'+'.str_replace(' ', '+', trim($this->data['property']['Street_Type']));
      $city = str_replace(' ', '+', $this->data['property']['City_or_Town_Name']);
      
      $address = $street.','.$city.',Manitoba';
      $lat_lon = $this->_set_coordinates($class, $this->data['property']['Matrix_Unique_ID'], $address);
      
      $this->data['property']['Lat'] = $lat_lon['lat'];
      $this->data['property']['Lon'] = $lat_lon['lon'];
    }
    
    // Similar Properties        
    $search = array();
    $search[] = 'Total_Bedrooms = '.$this->data['property']['Total_Bedrooms'];
    $search[] = 'CurrentPrice >= '.((int)$this->data['property']['CurrentPrice'] - 50000);
    $search[] = 'CurrentPrice <= '.((int)$this->data['property']['CurrentPrice'] + 50000);
    $search[] = 'Listing.Matrix_Unique_ID != '.$this->data['property']['Matrix_Unique_ID'];

    $where = ' AND '.implode(' AND ', $search);
      
    $query = $this->Listings_model->search_current_listings_by_type($class, $where, 3);            

    $similar_listings = $query->result_array();
    
    foreach ($similar_listings as &$listing)
    {
      $listing['address_slug'] = $this->_get_address_slug($listing);
    }
        
    $this->data['similar_listings'] = $similar_listings;
            
    $this->data['property_images'] = $property_images;
    $this->data['features'] = $features;
    $this->data['amenities'] = $amenities;
    $this->data['site_influences'] = $site_influences;
    $this->data['flooring'] = $flooring;

		$this->data['title'] = 'MLS '.$this->data['property']['ML_Number'];
    
    if (intval($this->data['property']['Display_Addrs_on_Pub_Web_Sites']) === 1)
		{
		  $this->data['title'] .= ', '.$this->data['property']['Street_Number'].' '.ucwords(strtolower($this->data['property']['Street_Name'])).' '.ucfirst(strtolower($this->data['property']['Street_Type']));
		}

		$this->data['description'] = 'Property details for '.$this->data['title'];
		
		if (isset($property_images[0]))
		{
      $this->data['og_image'] = base_url($property_images[0]);
  		$this->data['og_width'] = 640;
  		$this->data['og_height'] = 480;		
		}

    $this->data['header_variant'] = $class;
    $this->data['property_detail'] = TRUE;
    $this->data['types'] = $this->types;
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

    $listings = $query->result_array();
    
    foreach ($listings as &$listing)
    {
      $listing['address_slug'] = $this->_get_address_slug($listing);
    }
        
    $this->data['listings'] = $listings;
    $this->data['type'] = $type;
    $this->data['types'] = $this->types;
            
    $this->_generate_template();
    $this->data['content'] = $this->load->view('standard_listing', $this->data, TRUE);
    
    $this->load->view('standard_page', $this->data);
	}
	
	
	public function office()
	{
    $where = '
      AND
      (
        Status LIKE "Active"
      )
      AND
      (
        Active = 1
      )
    ';
    
    $query = $this->Listings_model->get_all_listings($where);
    
    $this->types['all']['active'] = ' class="active"';
    $this->data['h1'] = 'Our Office\'s Listings';
		$this->data['title'] = 'Office Listings';
		$this->data['description'] = 'Office Listings by Royal LePage Dynamic';

    $listings = $query->result_array();
    
    foreach ($listings as &$listing)
    {
      $listing['address_slug'] = $this->_get_address_slug($listing);
    }
        
    $this->data['listings'] = $listings;
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
    
    $listings = $query->result_array();
    
    foreach ($listings as &$listing)
    {
      $listing['address_slug'] = $this->_get_address_slug($listing);
    }
     
    $this->data['listings'] = $listings;
    $this->data['type'] = 'con';
    $this->data['types'] = $this->types;
        
    $this->load->view('listings_only', $this->data);
	}
  
  
  public function street($search)
	{
    $search = str_replace('-', ' ', $search);
    
    $query = $this->Listings_model->get_listings_by_street_search($search);
    
    $listings = $query->result_array();
    
    foreach ($listings as &$listing)
    {
      $listing['address_slug'] = $this->_get_address_slug($listing);
    }
     
    $this->data['listings'] = $listings;
    $this->data['type'] = 'con';
    $this->data['types'] = $this->types;
        
    $this->load->view('listings_only', $this->data);
	}
	
	
	public function latest($number)
	{
    $query = $this->Listings_model->get_latest_listings($number);

    $listings = $query->result_array();
    
    foreach ($listings as &$listing)
    {
      $listing['address_slug'] = $this->_get_address_slug($listing);
    }
     
    $this->data['listings'] = $listings;
    $this->data['type'] = FALSE;
    $this->data['types'] = $this->types;
        
    $this->load->view('listings_only', $this->data);
	}
  

	public function facebook_latest()
	{
    $query = $this->Listings_model->get_latest_listings(5);

    $listings = $query->result_array();
    
    foreach ($listings as &$listing)
    {
      $listing['address_slug'] = $this->_get_address_slug($listing);
    }
     
    $this->data['h1'] = 'Latest Listings';
    $this->data['listings'] = $listings;
    $this->data['type'] = FALSE;
    $this->data['types'] = $this->types;
        
    $this->load->view('styled_listings_only', $this->data);
	}
  
    
	public function facebook_open_houses()
	{
    $query = $this->Listings_model->get_open_houses();

    $listings = $query->result_array();
    
    foreach ($listings as &$listing)
    {
      $listing['address_slug'] = $this->_get_address_slug($listing);
    }
     
    $this->data['h1'] = 'Open Houses';
    $this->data['listings'] = $listings;
    $this->data['type'] = FALSE;
    $this->data['types'] = $this->types;
        
    $this->load->view('styled_listings_only', $this->data);
	}
	
	
	public function send_message()
	{
	  $this->load->library('email');
    
    $name = $this->input->post('name');
	  $email = $this->input->post('email');
	  $message = $this->input->post('message');
	  $send_to = $this->input->post('send_to');
	  $cc = $this->input->post('cc');
	  $ml_number = $this->input->post('ml_number'); 
	  $civic_address = $this->input->post('civic_address'); 
    
    $this->email->from($email, $name);
    $this->email->to($send_to);
    $this->email->cc($cc);
    
    $this->email->subject('Contact Form Submission Re: '.$civic_address.', MLS #: '.$ml_number);
    $this->email->message($message);
    
    $this->email->send();
	}
	
	
	public function xml_sitemap()
	{
    
    $pages = array(
                array(
                  'url' => base_url(),
                  'last_modified' => NULL,
                  'xml_change_freq' => 'hourly',
                  'xml_priority' => '1.0'
                )
              ); 
    
    foreach ($this->types as $key => $type)
    {
      if ($key === 'all')
      {
        continue;
      }
      
      $pages[] = array(
                      'url' => base_url($type['path']),
                      'last_modified' => NULL,
                      'xml_change_freq' => 'daily',
                      'xml_priority' => '0.9'
                      );      
    }

    $where = '
      AND
      (
        Status LIKE "Active"
      )
      AND
      (
        Active = 1
      )
    ';
        
    $query = $this->Listings_model->get_all_listings($where);
    
    foreach ($query->result_array() as $page)
    {
      
      $trans_date = explode(' ', $page['Last_Transaction_Date']);
      $address_slug = $this->_get_address_slug($page);
      
      $pages[] = array(
                      'url' => base_url($this->types[$page['class']]['path'].'/'.$page['Matrix_Unique_ID'].'/'.$address_slug),
                      'last_modified' => $trans_date[0],
                      'xml_change_freq' => 'weekly',
                      'xml_priority' => '0.6'
                      );
      
    }
     
    $this->data['pages'] = $pages;
    $this->output->set_content_type('text/xml');
	  $this->load->view('xml_sitemap', $this->data);
	}
	
	
	private function _set_coordinates($class, $matrix_unique_id, $address)
	{
    $json_location = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyCobf10IDhEOEPJsT_ImoVc1sN-qU-Xbpo&sensor=false';
  
    $json = json_decode(file_get_contents($json_location));
    
    if (isset($json->results[0]))
    {
      $lat = $json->results[0]->geometry->location->lat;
      $lon = $json->results[0]->geometry->location->lng;
      
      $this->Listings_model->set_coordinates($class, $matrix_unique_id, $lat, $lon);
    }
    else
    {
      $lat = '';
      $lon = '';    
    }    
    
    return array('lat' => $lat, 'lon' => $lon);
	}
  
  
  private function _get_address_slug($property)
  {
    $slug_parts = array();
    
    if (intval($property['Display_Addrs_on_Pub_Web_Sites']) === 1)
    {
      if ($property['Suite_Number'] !== '')
      {
        $slug_parts[] = str_replace(' ', '-', $property['Suite_Number']);
      }
      
      if ($property['Street_Number'] !== '')
      {
        $slug_parts[] = str_replace(' ', '-', $property['Street_Number']);
      }
      
      if ($property['Street_Name'] !== '')
      {
        $slug_parts[] = str_replace(' ', '-', $property['Street_Name']);
      }

      if ($property['Street_Type'] !== '')
      {
        $slug_parts[] = str_replace(' ', '-', $property['Street_Type']);
      }
            
      if ($property['Neighbourhood'] !== '')
      {
        $slug_parts[] = str_replace(' ', '-', $property['Neighbourhood']);
      }
      
      if ($property['City_or_Town_Name'] !== '')
      {
        $slug_parts[] = str_replace(' ', '-', $property['City_or_Town_Name']);
      }
    }
    else
    {
      return '';
    }
    
    $slug_words = implode(' ', $slug_parts);
    
    return url_title($slug_words, '-', TRUE);               
  }
}

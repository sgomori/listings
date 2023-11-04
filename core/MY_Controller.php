<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
    date_default_timezone_set('America/Winnipeg');
	}
	
  	
	protected function _set_coordinates($class, $matrix_unique_id, $address)
	{
    $json_location = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyClxbWC10PTf5lyJjh6xIE04axk_sLf0yY&sensor=false';
  
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
  
  
  // Builds a standardized URL slug based on address parts.
  protected function _get_address_slug($property)
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

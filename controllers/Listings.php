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
    $this->data['no_index'] = FALSE;
    $this->data['no_index_follow'] = FALSE;
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
    
    $this->data['wpg_news_comm_link'] = file_get_contents('/home4/winnipg2/wpg_news/wpg_news_comm_link.txt');
    $this->data['wpg_news_res_link'] = file_get_contents('/home4/winnipg2/wpg_news/wpg_news_res_link.txt');
    $this->data['footer'] = $this->load->view($this->footer_view, $this->data, TRUE);    
  }

	public function index($type = FALSE)
	{

    if ($type)
    {          
      if ($type == 'open-houses')
      {
        $query = $this->Listings_model->get_open_houses();
    		$this->data['title'] = 'Open Houses for Sale';
    		$this->data['description'] = 'Open Houses with Blair Sonnichsen and Tyson Sonnichsen';
      }
      else if ($type == 'sold')
      {
        $query = $this->Listings_model->get_sold_listings();
    		$this->data['title'] = 'Recently Sold';
    		$this->data['description'] = 'Recently Sold by Blair Sonnichsen and Tyson Sonnichsen';
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
            OR
            Listing.Status LIKE "Pending"
          ) 
        ';
        
        $query = $this->Listings_model->get_all_listings($where);
        $this->data['header_variant'] = $type;
    		$this->data['title'] = 'Rural Listings for Sale';
    		$this->data['description'] = 'Rural Listings for Sale by Blair Sonnichsen and Tyson Sonnichsen';
      }
      else
      {
        $query = $this->Listings_model->get_listings_by_type($type);
        $this->data['header_variant'] = $type;
    		$this->data['title'] = $this->types[$type]['title'].' for Sale';
    		$this->data['description'] = $this->types[$type]['title'].' for Sale by Blair Sonnichsen and Tyson Sonnichsen';
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

  		$this->data['title'] = 'Winnipeg Homes & Condos for Sale';
  		$this->data['description'] = 'Winnipeg Homes & Condos for Sale by Blair Sonnichsen and Tyson Sonnichsen';      
      $this->types['all']['active'] = ' class="active"';
      $this->data['h1'] = 'Our Properties';
    }
    
    $listings = $query->result_array();

    $city_prov = '';      
    $prov = '';
    $postal_code = '';    
          
    foreach ($listings as &$listing)
    {
      $listing['address_slug'] = $this->_get_address_slug($listing);
      
      if ($listing['Status'] === 'Pending')
      {
        $listing['Status'] = '';
      }
      
		  $city_prov = ucfirst(strtolower($listing['City_or_Town_Name']));
      $prov = FALSE;
      
      if ($city_prov === 'Winnipeg')
      {
        $city_prov .= ', Manitoba';
        $prov = 'Manitoba';
      }
      
      $postal_code = strtoupper($listing['Postal_Code']);

      if ((strpos($postal_code, ' ') === FALSE) && (strlen($postal_code) === 6))
      {
        $postal_code = substr($postal_code, 0, 3).' '.substr($postal_code, 2, 3);
      }
      
      $listing['city_prov'] = $city_prov;      
      $listing['prov'] = $prov;
      $listing['postal_code'] = $postal_code;                                          
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
    
    $this->data['no_index'] = TRUE;
    
		$this->data['title'] = 'Listings Map';
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
          ((strtotime($property[0]['Expiry_Date']) < time()) &&
            ($property[0]['Status'] !== 'Sold')
          ) ||          
          (($property[0]['Status'] === 'Sold') &&
            ((time() - strtotime($property[0]['Sold_Date'].' UTC')) > (3600 * 24 * 365))
          ) || 
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
          ((((int)$property[0]['Active'] === 0) || ($property[0]['Status'] !== 'Active')) &&          
            (
              ($property[0]['Sales_Rep_MUI_1'] !== '564206') &&
              ($property[0]['Sales_Rep_MUI_1'] !== '16212643') &&
              ($property[0]['Sales_Rep_MUI_2'] !== '564206') &&
              ($property[0]['Sales_Rep_MUI_2'] !== '16212643')
            )                            
          )
        )
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
      
      $query = $this->Listings_model->get_latest_listings(10);

      $full_listings = $query->result_array();
      
      $listings = array($full_listings[0]);
      
      unset($full_listings[0]);
      $full_listings = array_values($full_listings);
      
      for ($i = 0; $i < 4; $i++)
      {
        $random_spot = mt_rand(0, count($full_listings) - 1);
        $listings[] = $full_listings[$random_spot];
        unset($full_listings[$random_spot]);
        $full_listings = array_values($full_listings);
      }
      
      shuffle($listings);
      
      $city_prov = '';      
      $prov = '';
      $postal_code = '';    
            
      foreach ($listings as &$listing)
      {
        $listing['address_slug'] = $this->_get_address_slug($listing);
        
        if ($listing['Status'] === 'Pending')
        {
          $listing['Status'] = '';
        }
        
  		  $city_prov = ucfirst(strtolower($listing['City_or_Town_Name']));
        $prov = FALSE;
        
        if ($city_prov === 'Winnipeg')
        {
          $city_prov .= ', Manitoba';
          $prov = 'Manitoba';
        }
        
        $postal_code = strtoupper($listing['Postal_Code']);
  
        if ((strpos($postal_code, ' ') === FALSE) && (strlen($postal_code) === 6))
        {
          $postal_code = substr($postal_code, 0, 3).' '.substr($postal_code, 2, 3);
        }
        
        $listing['city_prov'] = $city_prov;      
        $listing['prov'] = $prov;
        $listing['postal_code'] = $postal_code;                                          
      }
      
      $this->data['listings'] = $listings;
      $this->data['type'] = $class;
      $this->data['header_variant'] = $class;
      $this->data['types'] = $this->types;
      
      $this->data['no_index_follow'] = TRUE;
              
      $this->_generate_template();
      
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

    if ($property[0]['Status'] === 'Pending')
    {
      $property[0]['Status'] = '';
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
    
    $property_images_jpg = array();
    $property_images_webp = array();    
            
    foreach (glob('assets/images/properties/image-'.$matrix_unique_id.'*.jpg') as $filename)
    {
      $file_name_parts = explode('.', $filename);
      
      $property_images_jpg[] = $file_name_parts[0].'.jpg';
      $property_images_webp[] = $file_name_parts[0].'.webp'; 
    }
    
    natsort($property_images_jpg);
    natsort($property_images_webp);
       
    if (count($property_images_jpg) > 1)
    {
      unset($property_images_jpg[0]);
      unset($property_images_webp[0]);
    }
    
    $property_images_jpg = array_values($property_images_jpg);
    $property_images_webp = array_values($property_images_webp);
    
    $features = FALSE;
    $feature_list = FALSE;

    if ((isset($this->data['property']['Features'])) && ($this->data['property']['Features'] !== ''))
    {
      $feature_list = $this->data['property']['Features'];
      
      if ((isset($this->data['property']['Goods_Included'])) && ($this->data['property']['Goods_Included'] !== ''))
      {
        $feature_list .= ','.$this->data['property']['Goods_Included'];
      }
    }
    else if ((isset($this->data['property']['Goods_Included'])) && ($this->data['property']['Goods_Included'] !== ''))
    {
      $feature_list .= $this->data['property']['Goods_Included'];
    }
    
 
    if ($feature_list)
    {
      $features = explode(',', $feature_list);
      sort($features);
      
      foreach ($features as &$feature)
      {
        $feature = ucwords($feature);
      }
    }
    
    $amenities = FALSE;
    
    if ((isset($this->data['property']['Amenities'])) && ($this->data['property']['Amenities'] !== ''))
    {
      $amenities = explode(',', $this->data['property']['Amenities']);
      sort($amenities);
      
      foreach ($amenities as &$amenity)
      {
        $amenity = ucwords($amenity);
      }
    }

    $site_influences = FALSE;
        
    if ((isset($this->data['property']['Site_Influences'])) && ($this->data['property']['Site_Influences'] !== ''))
    {
      $site_influences = explode(',', $this->data['property']['Site_Influences']);
      sort($site_influences);
      
      foreach ($site_influences as &$site_influence)
      {
        $site_influence = ucwords($site_influence);
      }
    }
    
    $flooring = FALSE;
        
    if ((isset($this->data['property']['Flooring'])) && ($this->data['property']['Flooring'] !== ''))
    {
      $flooring = explode(',', $this->data['property']['Flooring']);
      sort($flooring);
      
      foreach ($flooring as &$floor)
      {
        $floor = ucwords($floor);
      }
    }
    
    $parking_elements = FALSE;
        
    if ((isset($this->data['property']['Parking'])) && ($this->data['property']['Parking'] !== ''))
    {
      $parking_elements = explode(',', $this->data['property']['Parking']);
      sort($parking_elements);
      
      foreach ($parking_elements as &$parking)
      {
        $parking = ucwords($parking);
      }
    }
    
    $other_detail = array();

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
            
    $this->data['property_images_jpg'] = $property_images_jpg;
    $this->data['property_images_webp'] = $property_images_webp;
    $this->data['features'] = $features;
    $this->data['amenities'] = $amenities;
    $this->data['site_influences'] = $site_influences;
    $this->data['flooring'] = $flooring;
    $this->data['parking_elements'] = $parking_elements;

		$this->data['title'] = '';
    $this->data['city_prov'] = '';      
    $this->data['prov'] = '';
    $this->data['postal_code'] = '';
    $this->data['description'] = '';
    $description_address = '';
          
    if (intval($this->data['property']['Display_Addrs_on_Pub_Web_Sites']) === 1)
		{
		  $city_prov = ucfirst(strtolower($this->data['property']['City_or_Town_Name']));
      $prov = FALSE;
      
      if ($city_prov === 'Winnipeg')
      {
        $city_prov .= ', Manitoba';
        $prov = 'Manitoba';
      }
      
      $postal_code = strtoupper($this->data['property']['Postal_Code']);

      if ((strpos($postal_code, ' ') === FALSE) && (strlen($postal_code) === 6))
      {
        $postal_code = substr($postal_code, 0, 3).' '.substr($postal_code, 2, 3);
      }
      
      $this->data['city_prov'] = $city_prov;      
      $this->data['prov'] = $prov;
      $this->data['postal_code'] = $postal_code;
      $this->data['title'] .= $this->data['property']['Street_Number'].' '.ucwords(strtolower($this->data['property']['Street_Name'])).' '.ucfirst(strtolower($this->data['property']['Street_Type'])).', '.$city_prov.' '.$postal_code.' - ';
      $primary_details = '';
      $description_address = ' located at '.$this->data['property']['Street_Number'].' '.ucwords(strtolower($this->data['property']['Street_Name'])).' '.ucfirst(strtolower($this->data['property']['Street_Type'])).'. ';
		}
    
    if ((isset($this->data['property']['Property_Type'])) && ($this->data['property']['Property_Type'] !== ''))
    {
      $primary_details .= $this->data['property']['Property_Type'];
    }

    if ((isset($this->data['property']['Type'])) && ($this->data['property']['Type'] !== ''))
    {
      if ((isset($this->data['property']['Property_Type'])) && ($this->data['property']['Property_Type'] !== ''))
      {
        $primary_details .= ', ';
      }
      
      $primary_details.= $this->data['property']['Type'];
    }
    
    if ((isset($this->data['property']['Style'])) && ($this->data['property']['Style'] !== ''))
    {
      if (((isset($this->data['property']['Property_Type'])) && ($this->data['property']['Property_Type'] !== '')) || ((isset($this->data['property']['Type'])) && ($this->data['property']['Type'] !== '')))
      {
        $primary_details .= ' ';
      }
            
      $primary_details .= $this->data['property']['Style'];
    }
    
    $this->data['description'] = $primary_details.$description_address;
    
    $this->data['title'] .= $primary_details.' for Sale: MLS '.$this->data['property']['ML_Number'];
    
    if ((isset($this->data['property']['Total_Bedrooms'])) && ($this->data['property']['Total_Bedrooms'] !== '') && ((int)$this->data['property']['Total_Bedrooms'] > 0))
    {
      $this->data['description'] .= $this->data['property']['Total_Bedrooms'].' bedroom';
      
      if ((int)$this->data['property']['Total_Bedrooms'] > 1)
      {
        $this->data['description'] .= 's';
      }
    }
    
    if ((isset($this->data['property']['Number_of_Total_Baths'])) && ($this->data['property']['Number_of_Total_Baths'] !== '') && ((int)$this->data['property']['Number_of_Total_Baths'] > 0))
    {
      if ((isset($this->data['property']['Total_Bedrooms'])) && ($this->data['property']['Total_Bedrooms'] !== ''))
      {
        $this->data['description'] .= ', ';
      }
      
      $this->data['description'] .= $this->data['property']['Number_of_Total_Baths'].' bathroom';
      
      if ((int)$this->data['property']['Number_of_Total_Baths'] > 1)
      {
        $this->data['description'] .= 's';
      }
    }

    if ((isset($this->data['property']['Total_FloorLiv_Area_SF'])) && ($this->data['property']['Total_FloorLiv_Area_SF'] !== '') && ((int)$this->data['property']['Total_FloorLiv_Area_SF'] > 0))
    {
      if (((isset($this->data['property']['Total_Bedrooms'])) && ($this->data['property']['Total_Bedrooms'] !== '')) || ((isset($this->data['property']['Number_of_Total_Baths'])) && ($this->data['property']['Number_of_Total_Baths'] !== '')))
      {
        $this->data['description'] .= ' and ';
      }
      
      $this->data['description'] .= $this->data['property']['Total_FloorLiv_Area_SF'].' square feet';
    }
    
    if ($this->data['description'] !== $primary_details.$description_address)
    {
      $this->data['description'] .= '.';
    }
                          
		$target_description_length = 160;
    
    $truncated_description = substr($this->data['property']['Public_Remarks'], 0, ($target_description_length - strlen($this->data['description'])));
    
    $last_period = strpos($truncated_description, '.');
    
    if ($last_period !== FALSE)
    {
      $truncated_description = substr($truncated_description, 0, $last_period + 1);
      $this->data['description'] .= ' '.str_replace('"', '\"', $truncated_description);    
    }
    
    $listing_date_stamp = strtotime($this->data['property']['Date_Entered'].' UTC');
    
    $updated_stamp = 0;
    $this->data['updated_date'] = FALSE;    
    
    if (strtotime($this->data['property']['Last_ImgTransDate'].' UTC') > $updated_stamp)
    {
      $updated_stamp = strtotime($this->data['property']['Last_ImgTransDate'].' UTC');
    }

    if (strtotime($this->data['property']['LastChangeTypeDate'].' UTC') > $updated_stamp)
    {
      $updated_stamp = strtotime($this->data['property']['LastChangeTypeDate'].' UTC');
    }

    if (strtotime($this->data['property']['Last_Transaction_Date'].' UTC') > $updated_stamp)
    {
      $updated_stamp = strtotime($this->data['property']['Last_Transaction_Date'].' UTC');
    }
    
    if (strtotime($this->data['property']['LastListPriceChangeDate'].' UTC') > $updated_stamp)
    {
      $updated_stamp = strtotime($this->data['property']['LastListPriceChangeDate'].' UTC');
    }
    
    if (date('Y-m-d', $updated_stamp) !== date('Y-m-d', $listing_date_stamp))
    {
      $this->data['updated_date'] = date('Y-m-d', $updated_stamp);  
    }
    
    $this->data['listing_date'] = date('Y-m-d', $listing_date_stamp);
		
		if (isset($property_images_jpg[0]))
		{
      $this->data['og_image'] = base_url($property_images_jpg[0]);
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

    $listing['city_prov'] = '';      
    $listing['prov'] = '';
    $listing['postal_code'] = '';   
          
    foreach ($listings as &$listing)
    {
      $listing['address_slug'] = $this->_get_address_slug($listing);
      
		  $city_prov = ucfirst(strtolower($listing['City_or_Town_Name']));
      $prov = FALSE;
      
      if ($city_prov === 'Winnipeg')
      {
        $city_prov .= ', Manitoba';
        $prov = 'Manitoba';
      }
      
      $postal_code = strtoupper($listing['Postal_Code']);

      if ((strpos($postal_code, ' ') === FALSE) && (strlen($postal_code) === 6))
      {
        $postal_code = substr($postal_code, 0, 3).' '.substr($postal_code, 2, 3);
      }
      
      $listing['city_prov'] = $city_prov;      
      $listing['prov'] = $prov;
      $listing['postal_code'] = $postal_code;   
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
		$this->data['title'] = 'Office Listings for Sale';
		$this->data['description'] = 'Royal LePage Dynamic Office Listings';

    $listings = $query->result_array();
    
    foreach ($listings as &$listing)
    {
      $listing['address_slug'] = $this->_get_address_slug($listing);
      
		  $city_prov = ucfirst(strtolower($listing['City_or_Town_Name']));
      $prov = FALSE;
      
      if ($city_prov === 'Winnipeg')
      {
        $city_prov .= ', Manitoba';
        $prov = 'Manitoba';
      }
      
      $postal_code = strtoupper($listing['Postal_Code']);

      if ((strpos($postal_code, ' ') === FALSE) && (strlen($postal_code) === 6))
      {
        $postal_code = substr($postal_code, 0, 3).' '.substr($postal_code, 2, 3);
      }
      
      $listing['city_prov'] = $city_prov;      
      $listing['prov'] = $prov;
      $listing['postal_code'] = $postal_code;
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
      
      if ($listing['Status'] === 'Pending')
      {
        $listing['Status'] = '';
      } 
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
      
      if ($listing['Status'] === 'Pending')
      {
        $listing['Status'] = '';
      } 
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
      
      if ($listing['Status'] === 'Pending')
      {
        $listing['Status'] = '';
      }  
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
      
      if ($listing['Status'] === 'Pending')
      {
        $listing['Status'] = '';
      } 
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
      
      if ($listing['Status'] === 'Pending')
      {
        $listing['Status'] = '';
      } 
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
      if (($key === 'all') || ($key === 'map'))
      {
        continue;
      }
      else if ($key === 'sold')
      {
        $pages[] = array(
                        'url' => base_url($type['path']),
                        'last_modified' => NULL,
                        'xml_change_freq' => 'daily',
                        'xml_priority' => '0.7'
                        );
        continue;
      }
      
      $pages[] = array(
                      'url' => base_url($type['path']),
                      'last_modified' => NULL,
                      'xml_change_freq' => 'daily',
                      'xml_priority' => '0.9'
                      );      
    }

    $pages[] = array(
                    'url' => base_url('office'),
                    'last_modified' => NULL,
                    'xml_change_freq' => 'hourly',
                    'xml_priority' => '0.8'
                    ); 
                      
    $bt_where = '
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
        Listing.Status LIKE "Custom"
        OR
        Listing.Status LIKE "Pending"
      ) 
    ';
    
    $bt_result = $this->Listings_model->get_all_listings($bt_where);
    
    $pages = array_merge($pages, $this->_generate_xml_sitemap_content($bt_result, 'daily', '1'));


    $office_where = '
      AND
      (
        Status LIKE "Active"
      )
      AND
      (
        Active = 1
      )
      AND
      (
        Listing.Sales_Rep_MUI_1 NOT IN (564206, 16212643)
        OR
        Listing.Sales_Rep_MUI_2 NOT IN (564206, 16212643)
      )
    ';
    
    $office_result = $this->Listings_model->get_all_listings($office_where);
    
    $pages = array_merge($pages, $this->_generate_xml_sitemap_content($office_result, 'daily', '0.8'));

    
    $sold_result = $this->Listings_model->get_sold_listings();
    
    $pages = array_merge($pages, $this->_generate_xml_sitemap_content($sold_result, 'monthly', '0.1'));
     
    $this->data['pages'] = $pages;
    $this->output->set_content_type('text/xml');
	  $this->load->view('xml_sitemap', $this->data);
	}


  private function _generate_xml_sitemap_content($query, $frequency, $priority)
  {
    $items = array();
    
    foreach ($query->result_array() as $page)
    {
      $updated_stamp = strtotime($page['Last_Transaction_Date']);
      
      if (strtotime($page['Last_ImgTransDate'].' UTC') > $updated_stamp)
      {
        $updated_stamp = strtotime($page['Last_ImgTransDate'].' UTC');
      }
  
      if (strtotime($page['LastChangeTypeDate'].' UTC') > $updated_stamp)
      {
        $updated_stamp = strtotime($page['LastChangeTypeDate'].' UTC');
      }
  
      if (strtotime($page['Last_Transaction_Date'].' UTC') > $updated_stamp)
      {
        $updated_stamp = strtotime($page['Last_Transaction_Date'].' UTC');
      }
      
      if (strtotime($page['LastListPriceChangeDate'].' UTC') > $updated_stamp)
      {
        $updated_stamp = strtotime($page['LastListPriceChangeDate'].' UTC');
      }
      
      $updated_date = date('Y-m-d', $updated_stamp); 
      $address_slug = $this->_get_address_slug($page);
      
      $items[] = array(
                      'url' => base_url($this->types[$page['class']]['path'].'/'.$page['Matrix_Unique_ID'].'/'.$address_slug),
                      'last_modified' => $updated_date,
                      'xml_change_freq' => $frequency,
                      'xml_priority' => $priority
                      );
    }
    
    return $items;
  }
  	
	
	private function _set_coordinates($class, $matrix_unique_id, $address)
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

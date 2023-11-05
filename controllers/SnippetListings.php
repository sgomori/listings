<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SnippetListings extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	
  // For use with external pages calling listings snippets - makes use of listngs_only view.
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
  
  
  // For use with external pages calling listings snippets - makes use of listngs_only view.
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
	
	
  // For use with external pages calling listings snippets - makes use of listngs_only view.
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
  
  
  // For use with external pages call from Facebook page.
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
  
  
  // For use with external pages call from Facebook page.  
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
}

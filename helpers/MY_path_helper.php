<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Asset Path Function
 *
 * Returns the asset path - found in config. 
 *
 * @access	public
 * @return	mixed
 */
if ( ! function_exists('assets_url'))
{
	function assets_url()
	{

    $CI =& get_instance();
    
    // return the asset_url
    return base_url().$CI->config->item('asset_path');
	
	}
}

/* End of file MY_path_helper.php */
/* Location: ./listings_app/helpers/MY_path_helper.php */
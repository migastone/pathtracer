<?php
/**
 * Get asset URL
 *
 * @access  public
 * @return  string
 */
if(!function_exists('asset_url'))
{  
    function asset_url()
    {
        //get an instance of CI so we can access our configuration
        $CI =& get_instance();  
        //return the full asset path
        return base_url() . $CI->config->item('asset_path');
    }
}

if(!function_exists('css_path'))
{  
    function css_url()
    {
        //get an instance of CI so we can access our configuration
        $CI =& get_instance();  
        //return the full asset path
        return base_url() . $CI->config->item('css_path');
    }
}

if(!function_exists('js_path'))
{  
    function js_url()
    {
        //get an instance of CI so we can access our configuration
        $CI =& get_instance();  
        //return the full asset path
        return base_url() . $CI->config->item('js_path');
    }
}
?>
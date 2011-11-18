<?php

function anchor_img($uri = '', $anchor_attributes = '', $img_src = '', $img_attributes = '')
{
    if ( ! is_array($uri))
    {
        $site_url = ( ! preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
    }
    else
    {
        $site_url = site_url($uri);
    }

    if ($anchor_attributes != '')
    {
        $anchor_attributes = _parse_attributes($anchor_attributes);
    }
    
    if (strpos($img_src, '://') === FALSE)
    {
        $CI =& get_instance();
        $img_src = $CI->config->slash_item('base_url').$img_src;
    }
    
    if ($img_attributes != '')
    {
        $img_attributes = _parse_attributes($img_attributes);
    }

    return '<a href="'.$site_url.'">'.'<img src="'.$img_src.'" />'.'</a>';
}

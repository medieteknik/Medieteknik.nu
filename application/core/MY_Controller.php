<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Our own standard controller class
 *
 * MY_Controller is an extension of CI_Controller and simplifies language handling
 */ 
class MY_Controller extends CI_Controller 
{
	
	public $language = '';
	public $language_abbr = '';
	public $lang_data = '';
	
    function __construct()
    {
        parent::__construct();
        
        $this->language = $this->config->item('language');
		$this->language_abbr = $this->config->item('language_abbr');
		
		// language data
		$this->lang_data = $this->lang->load_with_fallback('common', $this->language, 'swedish');
        
        log_message('debug', "MY_Controller Class Initialized");
    }
}

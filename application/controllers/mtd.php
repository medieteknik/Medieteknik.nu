<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mtd extends MY_Controller
{

	public function index()
	{
		redirect('http://www.medieteknikdagarna.se/', 'refresh');
	}
}

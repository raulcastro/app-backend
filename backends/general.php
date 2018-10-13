<?php

$root = $_SERVER['DOCUMENT_ROOT'];

/**
 * Includes the file /models/Front_Model.php 
 * in order to interact with the database
 */
require_once $root.'/models/Front_Model.php';


/**
 * Contains the methods for interact with the databases
 *
 * @package    Oil and Gas Backend
 * @subpackage General info, not risky data
 * @license    http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author     Raul Castro <raul@crc-software.com> CRC Software Engineering 
 */
class generalFrontBackend
{
	protected  $model;
	
	/**
	 * Initialize a class, the model one
	 */
	public function __construct()
	{
		$this->model = new Front_Model();
	}
	
	/**
	 * Based on the section it returns the right info that could be propagated along the application
	 * 
	 * @param string $section
	 * @return array Array with the asked info of the application 
	 */
	public function loadBackend()
	{
		$data 		= array();
		
// 		Info of the Application
		
		$appInfoRow = $this->model->getGeneralAppInfo();
		
		$appInfo = array( 
                    'title'             => $appInfoRow['title'],
                    'siteName' 		=> $appInfoRow['site_name'],
                    'url' 		=> $appInfoRow['url'],
                    'content' 		=> $appInfoRow['content'],
                    'description'	=> $appInfoRow['description'],
                    'keywords' 		=> $appInfoRow['keywords'],
                    'location'		=> $appInfoRow['location'],
                    'creator' 		=> $appInfoRow['creator'],
                    'creatorUrl' 	=> $appInfoRow['creator_url'],
                    'twitter' 		=> $appInfoRow['twitter'],
                    'facebook' 		=> $appInfoRow['facebook'],
                    'googleplus' 	=> $appInfoRow['googleplus'],
                    'linkedin' 		=> $appInfoRow['linkedin'],
                    'youtube' 		=> $appInfoRow['youtube'],
                    'instagram'		=> $appInfoRow['instagram'],
                    'email'             => $appInfoRow['email'],
                    'lang'		=> $appInfoRow['lang']
		);
		
		$data['info'] = $appInfo;

		return $data;
	}
}

$backend = new generalFrontBackend();


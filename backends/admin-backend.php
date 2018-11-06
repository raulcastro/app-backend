<?php
$root = $_SERVER['DOCUMENT_ROOT'].'/';

/**
 * Includes the file /models/Layout_Model.php
 * in order to interact with the database
 */
require_once $root.'models/Layout_Model.php';

/**
 * Contains the classes for access to the basic app after log-in
 *
 * @package    Gallery Administrator
 * @subpackage Jonathan Cossu Photographer
 * @license    http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author     Raul Castro <raul@crc-software.com>
 */
class generalBackend
{
	protected  $model;
	
	/**
	 * Initialize a class, the model one
	 */
	
	public function __construct()
	{
		$this->model = new Layout_Model();
	}
	
	/**
	 * Based on the section it returns the right info that could be propagated along the application
	 *
	 * @param string $section
	 * @return array Array with the asked info of the application
	 */
	public function loadBackend($section = '')
	{
		$data 		= array();
		
		// 		Info of the Application
		
		$appInfoRow = $this->model->getGeneralAppInfo();
		
		$data['info'] = array(
				'title'         => $appInfoRow['title'],
				'siteName' 	=> $appInfoRow['site_name'],
				'url' 		=> $appInfoRow['url'],
				'content' 	=> $appInfoRow['content'],
				'description'	=> $appInfoRow['description'],
				'keywords' 	=> $appInfoRow['keywords'],
				'location'	=> $appInfoRow['location'],
				'creator' 	=> $appInfoRow['creator'],
				'creatorUrl' 	=> $appInfoRow['creator_url'],
				'twitter' 	=> $appInfoRow['twitter'],
				'facebook' 	=> $appInfoRow['facebook'],
				'googleplus' 	=> $appInfoRow['googleplus'],
				'linkedin' 	=> $appInfoRow['linkedin'],
				'youtube' 	=> $appInfoRow['youtube'],
				'instagram'	=> $appInfoRow['instagram'],
				'email'		=> $appInfoRow['email'],
				'lang'		=> $appInfoRow['lang']
		);
		
		// User Info
		$userInfoRow        = $this->model->getUserInfo();
		$data['userInfo']   = $userInfoRow;
                $data['categories'] = $this->model->getAllBlogCategories();
		
		switch ($section)
		{
                    case 'dashboard':
            //          get all gallery photos
                        $data['gallery'] = $this->model->getAllGalleryPhotos();
                    break;

                    case 'add-company':
                        $data['categories'] = $this->model->getAllRestaurantCategories();
                    break;

                    case 'edit-blog':
                        $data['entry'] = $this->model->getEntryBlogById($_GET['blogId']);
                        $data['categories'] = $this->model->getAllBlogCategories();
                        $data['gallery'] = $this->model->getGalleryByPost($_GET['blogId']);
                    break;

                    case 'blog':
                        if (!isset($_GET['category']))
                        {
                            $data['blog'] = $this->model->getAllBlogPosts();
                        }
                        else
                        {
                            $data['blog'] = $this->model->getPostByCategory($_GET['category']);
                        }
		    break;
                    
                    case 'featured':
                        $data['blog'] = $this->model->getFeaturedPosts();
                    break;
			
                    default:
                        break;
		}
		
		return $data;
	}
}

$backend = new generalBackend();

// $info = $backend->loadBackend();
// var_dump($info['categoryInfo']);

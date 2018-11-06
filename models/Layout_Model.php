<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root.'/Framework/Back_Default_Header.php';
require_once $root.'/Framework/Tools.php';

/**
 * Contains the methods for interact with the databases
 *
 * @package    Oil and Gas Backend
 * @subpackage CRC Software Engineering 
 * @license    http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author     Raul Castro <raul@crc-software.com>
 */
class Layout_Model
{
    private $db; 
	
    /**
     * Initialize the MySQL Link
     */
	public function __construct()
	{
		$this->db = new Mysqli_Tool(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	}
	
	/**
	 * getGeneralAppInfo
	 *
	 * get all the info that from the table app_info, this is about the application
	 * the name, url, creator and so
	 *
	 * @return array row containing the info
	 */
	
	public function getGeneralAppInfo()
	{
            try {
                $query = 'SELECT * FROM app_info';

                return $this->db->getRow($query);

            } catch (Exception $e) {
                    return false;
            }
	}
	
	/**
	 * Get the user info
	 * 
	 * Get's the user detail {user_id, name, ...}
	 * 
	 * @return mixed|bool An array of info or false
	 */
	public function getUserInfo()
	{
            try {
                    $query = "SELECT 
                ud.detail_id,
                ud.name,
                ud.email,
                ud.type_user
                FROM user_detail ud 
                WHERE ud.detail_id = ".$_SESSION['id_user'];

                return $this->db->getRow($query);

            } catch (Exception $e) {
                    return false;
            }
	}
	
	public function addPhotoGallery($name, $id)
	{
	    try
	    {
	        $query = 'INSERT INTO gallery(photo, date, blog_id)
	                VALUES("'.$name.'", NOW(), '.$id.')';
	        if ($this->db->run($query))
	            return $this->db->insert_id;
	    }
	    catch (Exception $e)
	    {
	        return false;
	    }
	}
	
	public function getAllGalleryPhotos()
	{
	    try {
	        $query = "SELECT * FROM gallery ORDER BY photo_id DESC";
	        return $this->db->getArray($query);
	    } catch (Exception $e) {
	        return false;
	    }
	}
	
	public function getGalleryByPost($id)
	{
	    try {
	        $query = 'SELECT * FROM gallery WHERE blog_id = '.$id.' ORDER BY photo_id DESC';
	        return $this->db->getArray($query);
	    } catch (Exception $e) {
	        return false;
	    }
	}
	
	public function updatePhoto($data)
	{
	    try
	    {
	        $query = 'UPDATE gallery
                            SET caption = ?
                            WHERE photo_id = ?';
	        $prep = $this->db->prepare($query);
	        $prep->bind_param('si',
	            $data['caption'],
	            $data['photoId']);
	        return $prep->execute();
	    }
	    catch (Exception $e)
	    {
	        return false;
	    }
	}
	
	public function deletePhotoGallery($photoId)
	{
	    try {
	        $photoId = (int) $photoId;
	        $query = "DELETE FROM gallery WHERE photo_id = ".$photoId;
	        return $this->db->run($query);
	    } catch (Exception $e) {
	        return false;
	    }
	}
	
	public function addEntryBlog($name, $category)
	{
	    try
	    {
	        $query = 'INSERT INTO blog(title, category_id, date, date_created, user_id)
	                VALUES("'.$name.'", '.$category.', NOW(), NOW(), '.$_SESSION['id_user'].')';

	        if ($this->db->run($query))
	            return $this->db->insert_id;
	    }
	    catch (Exception $e)
	    {
	        return false;
	    }
	}
	
	public function getEntryBlogById($postId)
	{
	    try {
	        $query = 'SELECT *, DATE_FORMAT(date, "%m/%d/%Y") as dateF FROM blog WHERE blog_id = '.$postId;
	        return $this->db->getRow($query);
	    } catch (Exception $e) {
	        return false;
	    }
	}
	
	public function updateEntry($data)
	{
	    try
	    {
	        $date = Tools::formatToMYSQL($data['postDate']);
	        $query = 'UPDATE blog
                    SET title = ?,
                    preview = ?,
                    category_id = ?,
                    featured = ?,
                    blog_content = ?,
                    date = ?
                    WHERE blog_id = ?';
	        $prep = $this->db->prepare($query);
	        $prep->bind_param('ssiissi',
	            $data['entryTitle'],
	            $data['entryPreview'],
	            $data['category'],
                    $data['featured'],
	            $data['entryDescription'],
	            $date,
	            $data['entryId']);
	        return $prep->execute();
	    }
	    catch (Exception $e)
	    {
	        return false;
	    }
	}
	
	public function updatePhotoEntry($entryId, $photo)
	{
	    try
	    {
	        $query = 'UPDATE blog
					SET photo = ?
					WHERE blog_id = ?';
	        $prep = $this->db->prepare($query);
	        $prep->bind_param('si',
	            $photo,
	            $entryId);
	        return $prep->execute();
	    }
	    catch (Exception $e)
	    {
	        return false;
	    }
	}
	
	public function getAllBlogPosts()
	{
	    try {
	        $query = "SELECT 
                    b.blog_id, 
                    b.photo,
                    b.title,
                    bc.title AS category,
                    b.preview,
                    b.featured
                    FROM blog b
                    LEFT JOIN blog_categories bc ON bc.category_id = b.category_id
                    ORDER BY b.blog_id DESC";
	        return $this->db->getArray($query);
	    } catch (Exception $e) {
	        return false;
	    }
	}
        
        public function getPostByCategory($categoryId)
        {
            try {
                $query = 'SELECT 
                    b.blog_id, 
                    b.photo,
                    b.title,
                    bc.title AS category,
                    b.preview,
                    b.featured
                    FROM blog b
                    LEFT JOIN blog_categories bc ON bc.category_id = b.category_id
                    WHERE b.category_id = '.$categoryId.'
                    ORDER BY b.blog_id DESC';
                
                return $this->db->getArray($query);
            } catch (Exception $e)
            {
                return false;
            }
            
        }
	
	public function deleteBlogPost($postId)
	{
	    $postId = (int) $postId;
	    try {
	        $query = 'DELETE FROM blog WHERE blog_id = '.$postId;
	        return $this->db->run($query);
	    } catch (Exception $e) {
	        return false;
	    }
	}
	
	public function getAllBlogCategories()
	{
	    try {
	        $query = 'SELECT * FROM blog_categories';
	        return $this->db->getArray($query);
	    } catch (Exception $e) {
	        return false;
	    }
	}
        
        public function getFeaturedPosts()
        {
            try {
                $query = 'SELECT 
                    b.blog_id, 
                    b.photo,
                    b.title,
                    bc.title AS category,
                    b.preview,
                    b.featured
                    FROM blog b
                    LEFT JOIN blog_categories bc ON bc.category_id = b.category_id
                    WHERE b.featured = 1
                    ORDER BY b.blog_id DESC';
                
                return $this->db->getArray($query);
            } catch (Exception $e)
            {
                return false;
            }
            
        }
    public function getAllRestaurantCategories()
    {
        try {
            $query = "SELECT * FROM restaurant_categories";
            return $this->db->getArray($query);
        }
        catch (Exception $e) {
            return false;
        }
    }
}

























<?php
/**
 * Contains the methods for interact with the databases
 *
 * @package    App Bike
 * @subpackage CRC Software Engineering 
 * @license    http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author     Raul Castro <raul@crc-software.com>
 */

$root = $_SERVER['DOCUMENT_ROOT'];
/**
 * Includes the file /Framework/Tools.php which contains a 
 * serie of useful snippets used along the code
 */
require_once $root.'/Framework/Tools.php';

class Layout_View
{
    /**
     * @property string $data a big array containing info for specific sections
     */
    private $data;
	
    /**
     * get's the data *ARRAY* and the title of the document
     * 
     * @param array $data Is a big array with the whole info of the document 
     * @param string $title The title that will be printed in <title></title>
     */
    public function __construct($data)
    {
            $this->data = $data;
    }

    /**
     * function printHTMLPage
     * 
     * Prints the content of the whole website
     * 
     * @param int $this->data['section'] the section that define what will be printed
     * 
     */
	
    public function printHTMLPage()
    {
    ?>
    <!DOCTYPE html>
    <html class='no-js' lang='<?php echo $this->data['info']['lang']; ?>'>
        <head>
            <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> <![endif]-->
            <meta charset="utf-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="shortcut icon" href="favicon.ico" />
            <link rel="icon" type="image/gif" href="favicon.ico" />
            <title><?php echo $this->data['title']; ?> - <?php echo $this->data['info']['title']; ?></title>
            <meta name="keywords" content="<?php echo $this->data['info']['keywords']; ?>" />
            <meta name="description" content="<?php echo $this->data['info']['description']; ?>" />
            <meta property="og:type" content="website" /> 
            <meta property="og:url" content="<?php echo $this->data['info']['url']; ?>" />
            <meta property="og:site_name" content="<?php echo $this->data['info']['siteName']; ?> />
            <link rel='canonical' href="<?php echo $this->data['info']['url']; ?>" />
            <?php 
            echo self::getCommonStyleDocuments(); 

            switch ($this->data['section']) 
            {
                case 'log-in':
                    echo self::getLogInHead();
                break;

                case 'blog':
                    echo self::getBlogHead();
                    break;

                case 'add-company':
                    echo self::getAddCompanyHead();
                    break;

                case 'dashboard':
                    echo self::getDashboardHead();
                    break;

                case 'main-gallery':
                    echo self::getMainGalleryHead();
                    break;

                case 'edit-blog':
                    echo self::getEditBlogHead();
                    break;

                case 'videos':
                    echo self::getMainVideosHead();
                    break;

                case 'settings':
                    echo self::getSettingsHead();
                    break;
            }
            ?>
            </head>
            <body id="<?php echo $this->data['section']; ?>" class="hold-transition <?php echo $this->data['template-class']; ?> fixed  skin-blue sidebar-mini">
            <?php 
            if ($this->data['section'] != 'log-in' && $this->data['section'] != 'log-out' && $this->data['section'] != 'unauthorized-page')
            {
            ?>
                <div class="wrapper">
                    <?php echo self :: getHeader(); ?>
                    <?php echo self :: getSidebar(); ?>	
                    <!-- Content Wrapper. Contains page content -->
                    <div class="content-wrapper">
                        <!-- Content Header (Page header) -->	
                        <section class="content-header">
                            <h1><?php echo $this->data['title']; ?></h1>
                            <ol class="breadcrumb">
                                <li><a href="#"><i class="fa <?php echo $this->data['icon']; ?>"></i><?php echo $this->data['title']; ?></a></li>
                                <!-- <li class="active">Here</li> -->
                            </ol>
                        </section>
                        <!-- Main content -->
                        <section class="content">
                            <?php 
                            switch ($this->data['section']) {
                                case 'dashboard':
                                    echo self::getDashboardContent();
                                    break;

                                case 'blog':
                                    echo self::getBlogContent();
                                    break;

                                case 'add-company':
                                    echo self::getAddCompanyContent();
                                    break;

                                case 'edit-blog':
                                    echo self::getEditBlogContent();
                                    break;

                                case 'main-gallery':
                                    echo self::getMainGalleryContent();
                                    break;

                                case 'videos':
                                    echo self::getMainVideosContent();
                                    break;

                                case 'settings':
                                    echo self::getSettingsContent();
                                    break;

                                case 'user-registration':
                                    echo self::getSaveUserForm();
                                    break;

                                case 'user-list':
                                    echo self::getListUserRegister();
                                    break;
                            }
                            ?>
                        </section>
                    </div>
                </div>
                <?php
                    echo self::getFooter();
                }
                else
                {
                    switch ($this->data['section']) 
                    {
                        case 'log-in':
                            echo self::getLoginUserForm();
                                //echo self::getLogInContent();
                        break;

                        case 'unauthorized-page':
                            echo self::getUnAuthorized();
                        break;

                        case 'log-out':
                            echo self::getSignOutContent();
                        break;

                        default:
                        break;
                    }
                }
			
                echo self::getCommonScriptDocuments();
			
                switch ($this->data['section'])
                {
                    case 'log-in':
                        echo self::getLogInScripts();
                        break;

                    case 'blog':
                        echo self::getBlogScripts();
                        break;

                    case 'add-company':
                        echo self::getAddCompanyScripts();
                        break;

                    case 'dashboard':
                        echo self::getDashboardScripts();
                        break;

                    case 'main-gallery':
                        echo self::getMainGalleryScripts();
                        break;

                    case 'edit-blog':
                        echo self::getEditBlogScripts();
                        break;

                    case 'videos':
                        echo self::getMainVideosScripts();
                        break;

                    case 'settings':
                        echo self::getSettingsScripts();
                        break;
                }
                ?>
        </body>
    </html>
    <?php
    }
    
    /**
     * returns the common css and js that are in all the web documents
     * 
     * @return string $documents css & js files used in all the files
     */
    public function getCommonStyleDocuments()
    {
        ob_start();
        ?>
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="/plugins/iCheck/square/blue.css">

        <link rel="stylesheet" href="/dist/css/skins/skin-blue.min.css">
       	<link href="/dist/css/Custom.css" media="screen" rel="stylesheet" type="text/css" />
	
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
    	
       	<?php 
       	$documents = ob_get_contents();
       	ob_end_clean();
       	return $documents; 
    }
    
    /**
     * returns the common css and js that are in all the web documents
     * 
     * @return string $documents css & js files used in all the files
     * 
     */
    public function getCommonScriptDocuments()
    {
        ob_start();
        ?>
        <!-- jQuery 2.2.3 -->
        <script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="/bootstrap/js/bootstrap.min.js"></script>
        <!-- AdminLTE App -->
        <script src="/dist/js/app.min.js"></script>
        <!-- SlimScroll -->
        <script src="/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- iCheck -->
        <script src="/plugins/iCheck/icheck.min.js"></script>
        <!-- bootBox -->

        <script src="/plugins/bootbox/bootbox.min.js"></script>
        <script>
            $(function() {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });

        </script>
       	<?php 
       	$documents = ob_get_contents();
       	ob_end_clean();
       	return $documents; 
    }
    
    /**
     * The main menu
     *
     * it's the top and main navigation menu
     * if is logged shows a sign-in | sign-up links
     * but if is logged it shows other menus included the sign-out
     *
     * @return string HTML Code of the main menu 
     * @TODO: WHERETOGO: Work with the log-out file?
     */
    public function getHeader()
    {
    	ob_start();
    	$active='class="active"';
    	?>  		
        <!-- Main Header -->
        <header class="main-header">
            <!-- Logo -->
            <a href="/" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b><?php echo $this->data['info']['siteName']; ?></b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><?php echo $this->data['info']['siteName']; ?></span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li>
                            <a href="/logout.php" class="">Log Out</a>
                        </li>
                        <?php if (isset($_SESSION['authorized']) && $_SESSION['authorized'] == 0) { ?>                    
                        <li>
                            <a href="/settings/" ><i class="fa fa-gears"></i></a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </nav>
        </header>
    	<?php
    	$header = ob_get_contents();
    	ob_end_clean();
    	return $header;
    }
    
    /**
     * it is the head that works for the sign in section, apparently isn't getting 
     * any parameter, I just left it here for future cases
     *
     * @package 	Reservation System
     * @subpackage 	Sign-in
     * @todo 		Delete it?
     * 
     * @return string
     */
    public function getLogInHead()
    {
    	ob_start();
    	?>
    	<script type="text/javascript">
        </script>
    	<?php
    	$signIn = ob_get_contents();
    	ob_end_clean();
    	return $signIn;
    }

    public function getLogInScripts()
    {
    	ob_start();
    	?>
    	<script type="text/javascript">
        </script>
        <script src="/js/log-in.js"></script>
    	<?php
    	$signIn = ob_get_contents();
    	ob_end_clean();
    	return $signIn;
    }
    /**
    * Obtiene el formulario del login.
    *
    *
    * @return 	string 		Retorna el contenedor completo del login.
    */
    
    public function getLoginUserForm() 
    {
        ob_start();
        ?>
        <div class="login-box">
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>
                
                <form action="<?php $root; ?>/controllers/login-controller.php" method="post">
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="Email" name="email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-xs-4">
                        		<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    		</div>
                    <!-- /.col -->
                    </div>
                </form>
            </div>
        </div>
        <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * getSignInContent
     *
     * the sign-in box
     *
     * @package Reservation System
     * @subpackage Sign-in
     *
     * @return string
     */
    public function getUnAuthorized()
    {
        ob_start();
        ?>
        <div class="login-box">
            <div class="login-logo">
                    <a href="/"><b>My Perfect Wedding</b> Administrator</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                    <h4>You are not authored to access this page. </h4>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
        <?php
        $wideBody = ob_get_contents();
        ob_end_clean();
        return $wideBody;
    }
    
    /**
     * getSignOutContent
     *
     * It finish the session
     *
     * @package 	Reservation System
     * @subpackage 	Sign-in
     *
     * @return string
     */
    public function getSignOutContent()
    {
    	ob_start();
    	?>
       	<div class="row login-box" id="sign-in">
            <div class="col-md-4 col-md-offset-4">
                <h3 class="text-center">You've been logged out successfully</h3>
                <br />
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a href="/" class="btn btn-lg btn-success btn-block">Login</a>
                    </div>
                </div>
            </div>
    	</div>
        <?php
        $wideBody = ob_get_contents();
        ob_end_clean();
        return $wideBody;
    }
   	
    /**
     * The side bar of the apliccation
     * 
     * Is the side-bar of the application where the main sections are as links
     * 
     * @return string
     * 
     */
    public function getSidebar()
    {
        ob_start();
        $active = 'class="active"';
        ?>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="/dist/img/user1-128x128.png" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p><?php echo $this->data['userInfo']['name']; ?></p>
                        <!-- Status -->
                        <a href="#"><i class="fa fa-lock text-info"></i> Administrator</a>
                    </div>
                </div>
 
                    <!-- Sidebar Menu -->
                <ul class="sidebar-menu">
                    <li class="header"><?php echo _("MAIN NAVIGATION"); ?></li>
                    <?php if (isset($_SESSION['type_user']) == 1) { ?>
                    <!-- <li class="active"><a href="/"><i class="fa fa-file-image-o"></i> <span>Gallery</span></a></li> -->

                    <li class="treeview active">
                        <a href="#">
                            <i class="fa fa-pencil-square"></i>
                            <span>Companies</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="/add-company/"><i class="fa fa-plus-square"></i>Add company</a></li>
                            <?php
                            /*foreach ($this->data['categories'] as $category)
                            {
                                ?>
                            <li><a href="/blog/<?php echo $category['category_id']; ?>/"><i class="fa fa-image"></i><?php echo $category['title']; ?></a></li>
                                <?php
                            }*/
                            ?>
                            
                        </ul>
                    </li>
                    <?php } ?>
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        <?php
        $sideBar = ob_get_contents();
        ob_end_clean();
        return $sideBar;
    }
    
     public function getDashboardHead()
    {
        ob_start();
        ?>
        <link href="/plugins/jquery.uploadfile/uploadfile.css" rel="stylesheet">
        <?php
        $head = ob_get_contents();
        ob_end_clean();
        return $head;
    }
    
    public function getDashboardScripts()
    {
        ob_start();
        ?>
        <script src="/plugins/jquery.uploadfile/jquery.uploadfile.min.js"></script>
        <script src="/dist/js/grid.js"></script>

        <?php
        $scripts = ob_get_contents();
        ob_end_clean();
        return $scripts;
    }
   	
   	/**
   	 * getGridContent
   	 * it returns the structure of the grid
   	 * @return string
   	 */
   	public function getDashboardContent()
   	{
        ob_start();
        ?>
        <section class='new-main-content cf' id='x-protips-grid'>
                <h1>Dashboard</h1>
        </section>
    	<?php
    	$dashboard = ob_get_contents();
    	ob_end_clean();
    	return $dashboard;
    }
   	
    public function getGridHead()
    {
        ob_start();
        ?>
        <link href="/plugins/jquery.uploadfile/uploadfile.css" rel="stylesheet">
        <?php
        $head = ob_get_contents();
        ob_end_clean();
        return $head;
    }
    
    public function getGridScripts()
    {
        ob_start();
        ?>
        <script src="/plugins/jquery.uploadfile/jquery.uploadfile.min.js"></script>
        <script src="/dist/js/grid.js"></script>

        <?php
        $scripts = ob_get_contents();
        ob_end_clean();
        return $scripts;
    }
   	
   	/**
   	 * getGridContent
   	 * it returns the structure of the grid
   	 * @return string
   	 */
   	public function getGridContent()
   	{
        ob_start();
        ?>
        <section class='new-main-content cf' id='x-protips-grid'>
                <input type="hidden" id="category-type-hidden" value="<?php echo $c; ?>" />
                <?php 
                        echo self::getGrid();
                ?>
        </section>
    	<?php
    	$grid = ob_get_contents();
    	ob_end_clean();
    	return $grid;
    }
    
    public function getBlogHead()
    {
        ob_start();
        ?>
            <script type="text/javascript"></script>
    	<?php
    	$head = ob_get_contents();
    	ob_end_clean();
    	return $head;
    }
    
    public function getBlogScripts()
    {
    	ob_start();
    	?>
        <script type="text/javascript">
        </script>
        <script src="/dist/js/blog.js"></script>
    	<?php
    	$scripts = ob_get_contents();
    	ob_end_clean();
    	return $scripts;
    }
    
    public function getBlogContent()
    {
        ob_start();
        ?>	
        <div class="row">
            <?php 
            foreach ($this->data['blog'] as $post) 
            {
                $photo = "";
                if (!$post['photo'])
                {
                    $photo = "/dist/img/blog-default.jpg";
                }
                else
                {
                    $photo = "/media/blog/thumb/".$post['photo'];
                }
            ?>
            <div class="col-md-3 item-photo" id="post-<?php echo $post['blog_id']; ?>">
                <div class="row item-box">
                    <div class="col-md-12 img-container">
                        <div class="horizontal">
                            <div class="vertical">
                                <img src="<?php echo $photo; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <p><b><?php echo $post['title']; ?></b></p>
                        <p><?php echo $post['category']; ?></p>
                    </div>
                    <div class="col-md-12">
                        <div class="timeline-footer">
                            <a class="btn btn-primary btn-xs" href="/edit-entry-blog/<?php echo $post['blog_id']?>/<?php echo Tools::slugify($post['title']); ?>/" >
                                Update
                            </a>
                            <a class="btn btn-danger btn-xs delete-post" 
                                        post-id="<?php echo $post['blog_id']; ?>">
                                Delete
                            </a>
                        </div>
                    </div>

                    </div>
                </div>
                <?php 
                }
                ?>
        </div>
		
        <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
   	
    
    public function getEditBlogHead()
    {
    	ob_start();
    	?>
    	<!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <link href="/plugins/jquery.uploadfile/uploadfile.css" rel="stylesheet">
        <link href="/plugins/jquery.drag-n-crop/jquery.drag-n-crop.css" rel="stylesheet" type="text/css">
        <!-- Select2 -->
        <link rel="stylesheet" href="/plugins/select2/select2.min.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
        <link href="/plugins/mini-upload-form/style.css" rel="stylesheet">
        <script type="text/javascript"></script>
    	<?php
    	$head = ob_get_contents();
    	ob_end_clean();
    	return $head;
    }
    
    public function getEditBlogScripts()
    {
    	ob_start();
    	?>
            <script src="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
            <script src="/plugins/jQueryUI/jquery-ui.min.js"></script>
            <script src="/plugins/jquery.uploadfile/jquery.uploadfile.min.js"></script>
            <script src="/plugins/imagesloaded/imagesloaded.js"></script>
            <script src="/dist/js/scale.fix.js"></script>
            <script src="/plugins/jquery.drag-n-crop/jquery.drag-n-crop.js"></script>
            <!-- Select2 -->
            <script src="/plugins/select2/select2.full.min.js"></script>	
            <!-- bootstrap datepicker -->
            <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>

            <script src="/dist/js/blog.js"></script>
            <script src="/plugins/mini-upload-form/jquery.knob.js"></script>
                <!-- jQuery File Upload Dependencies -->
            <script src="/plugins/mini-upload-form/jquery.ui.widget.js"></script>
            <script src="/plugins/mini-upload-form/jquery.iframe-transport.js"></script>
            <script src="/plugins/mini-upload-form/jquery.fileupload.js"></script>

            <!-- Our main JS file -->
            <script src="/plugins/mini-upload-form/script-blog.js"></script>
            <script src="/plugins/mini-upload-form/script.js"></script>
            <script type="text/javascript">
            	$(function () {
                //bootstrap WYSIHTML5 - text editor
                $(".textarea").wysihtml5();
                $('#postDate').datepicker({
                            autoclose: true
                    });
                $("#category, #featuredSelect").select2();
                    });
            </script>
    	<?php
    	$scripts = ob_get_contents();
    	ob_end_clean();
    	return $scripts;
    }
    
    public function getEditBlogContent()
    {
    	ob_start();
    	$photo = "";
    	if (!$this->data['entry']['photo'])
    	{
    	    $photo = "/dist/img/blog-default.jpg";
    	}
    	else 
    	{
    	    $photo = "/media/blog/thumb/".$this->data['entry']['photo'];
    	}
    	?>
    	<input type="hidden" id="entryId" value="<?php echo $this->data['entry']['blog_id']; ?>" />
        <div class="row">
            <div class="col-md-6">
                <div class="content-box">
                    <header>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <form id="upload" method="post" action="/ajax/media.php" enctype="multipart/form-data">
                                    <div id="drop">
                                        Drop Here
                                        <a>Browse</a>
                                        <input type="file" name="upl" multiple />
                                    </div>
                        
                                    <ul>
                                        <!-- The file uploads will be shown here -->
                                    </ul>
                                    <input type="hidden" name="section" value="update-photo-entry">
                                    <input type="hidden" name="entryId" value="<?php echo $this->data['entry']['blog_id']; ?>" />
                                </form>
                            </div>
                        </div>
                    </header>
					
                    <div class="clear"></div>
                        <p class="text-muted">(1260px w / 960px h | jpg)</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="content-box">
                    <div class="col-md-12 item-photo" id="photo-<?php echo $photo['photo_id']; ?>">
                        <div class="row item-box">
                            <div class="col-md-12" style="margin: 0 auto; text-align: center;" id="photoContainer">
                                <img src="<?php echo $photo; ?>" width="200" height="auto" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputName" class="col-sm-1 control-label">Title</label>
                            <div class="col-sm-11">
                                <input type="" class="form-control" id="entryTitle" placeholder="Title" value="<?php echo $this->data['entry']['title']; ?>">
                            </div>
                    </div>
                  	
                    <div class="form-group">
                        <label for="inputName" class="col-sm-1 control-label">Preview</label>
                            <div class="col-sm-11">
                                <textarea class="form-control" id="entryPreview" placeholder="Text preview"><?php echo $this->data['entry']['preview']; ?></textarea>
                            </div>
                  	</div>
                  	
                  	<div class="form-group">
                            <label for="inputName" class="col-sm-1 control-label">Date</label>
                            <div class="col-sm-11">
                                    <input type="" class="form-control" id="postDate" placeholder="Date" value="<?php echo $this->data['entry']['dateF']; ?>">
                            </div>
                  	</div>
                  	
                  	<div class="form-group">
                            <label  class="col-sm-1 control-label">Category</label>
                                <div class="col-sm-11">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="category">
                                        <option value="0">Category</option>
                                        <?php 
                                        foreach ($this->data['categories'] as $category)
                                        {
                                                ?>
                                        <option value="<?php echo $category['category_id']; ?>" <?php if ($category['category_id'] == $this->data['entry']['category_id']){ echo 'selected="selected"';}?>><?php echo $category['title']; ?></option>
                                                <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                        </div><!-- /.form-group -->
                        
                        <div class="form-group">
                            <label  class="col-sm-1 control-label">Featured</label>
                            <div class="col-sm-11">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="featuredSelect">
                                    <option value="0" <?php if ($this->data['entry']['featured'] == 0){ echo 'selected="selected"';}?>>Not featured</option>
                                    <option value="1" <?php if ($this->data['entry']['featured'] == 1){ echo 'selected="selected"';}?>>Featured</option>
                                </select>
                            </div>
                        </div><!-- /.form-group -->
					              	
                  	<div class="form-group">
                            <label for="inputName" class="col-sm-1 control-label">Content</label>
                            <div class="col-sm-11">
                                <div class="box-body pad">
                                    <form>
                                        <textarea class="textarea" id="entryDescription" placeholder="Place some text here" style="width: 100%; height: 500px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $this->data['entry']['blog_content']; ?></textarea>
                                    </form>
                                </div>
                            </div>
                        </div>
						                  	
                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-10">
                                <button type="submit" class="btn btn-info update-entry">Update</button>
                            </div>
                        </div>
                    </form>
                    </div>
            </div>
        <?php echo self::getMainGalleryContent(); ?>
        <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    
    public function getMainGalleryHead()
    {
    	ob_start();
    	?>
    	<script type="text/javascript"></script>
    	<link href="/plugins/mini-upload-form/style.css" rel="stylesheet">
    	<link href="/plugins/jquery.drag-n-crop/jquery.drag-n-crop.css" rel="stylesheet" type="text/css">
    	<?php
    	$head = ob_get_contents();
    	ob_end_clean();
    	return $head;
    }
    
    public function getMainGalleryScripts()
    {
    	ob_start();
    	?>
        <script src="/dist/js/gallery.js"></script>
        <script src="/plugins/mini-upload-form/jquery.knob.js"></script>
        <!-- jQuery File Upload Dependencies -->
        <script src="/plugins/mini-upload-form/jquery.ui.widget.js"></script>
        <script src="/plugins/mini-upload-form/jquery.iframe-transport.js"></script>
        <script src="/plugins/mini-upload-form/jquery.fileupload.js"></script>
        <!-- Our main JS file -->
        <script src="/plugins/mini-upload-form/script.js"></script>
        <script type="text/javascript"></script>
    	<?php
    	$scripts = ob_get_contents();
    	ob_end_clean();
    	return $scripts;
    }
    
    public function getMainGalleryContent()
    {
    	ob_start();
    	?>
        <div class="row">
            <div class="col-md-12">
                <div class="content-box">
                    <header>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <form id="uploadG" method="post" action="/ajax/media.php" enctype="multipart/form-data">
                                    <div id="dropG">
                                        Drop Here
                                        <a>Browse</a>
                                        <input type="file" name="upl" multiple />
                                    </div>
                        
                                    <ul>
                                        <!-- The file uploads will be shown here -->
                                    </ul>
                                    <input type="hidden" name="section" value="upload-gallery">
                                    <input type="hidden" name="postId" value="<?php echo $this->data['entry']['blog_id']; ?>">
                                </form>
                            </div>
                        </div>
                    </header>
					
                    <div class="clear"></div>
                    <p class="text-muted">(1260px w / 960 px h | JPG)</p>
			
                    <div class="slider-box">
                        <div id="slider-items">
                            <div class="row" id="gallery-container">
                                <?php 
                                foreach ($this->data['gallery'] as $photo) {
                                ?>
                                <div class="col-md-6 item-photo" id="photo-<?php echo $photo['photo_id']; ?>">
                                    <div class="row item-box">
                                        <div class="col-md-12 img-container">
                                            <div class="horizontal">
                                                <div class="vertical">
                                                    <img src="/media/gallery/thumb/<?php echo $photo['photo']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="timeline-footer">
                                                <a class="btn btn-danger btn-xs delete-photo" 
                                                        photo-id="<?php echo $photo['photo_id']; ?>">
                                                    Delete
                                                </a>
                                            </div>
                                        </div>
        						
                                    </div>
                                </div>
                                <?php 
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    
    public function getSettingsHead()
    {
    	ob_start();
    	?>
    	<script type="text/javascript"></script>
    	<?php
    	$head = ob_get_contents();
    	ob_end_clean();
    	return $head;
    }
    
    public function getSettingsScripts()
    {
    	ob_start();
    	?>
    	<script type="text/javascript"></script>
        <script src="/dist/js/settings.js"></script>
        <script src="/dist/js/categories.js"></script>
        <script src="/dist/js/locations.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByVcs7T5Y4tfwjcC82uUJ87aH6s7URdf4"></script>
        <script src="/dist/js/maps.js"></script>
    	<?php
    	$scripts = ob_get_contents();
    	ob_end_clean();
    	return $scripts;
    }
    
    public function getSettingsContent()
    {
    	ob_start();
    	?>
		<div class="row">
			<div class="col-md-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#generalSettings" data-toggle="tab">General</a></li>
						<li><a href="#categoriesSettings" data-toggle="tab">Organizaciones</a></li>
						<li><a href="#locationSettings" data-toggle="tab">Regiones</a></li>
					</ul>
					<div class="tab-content">
						<div class="active tab-pane" id="generalSettings">
							<div class="row">
								<div class="col-md-12">
									<form class="form-horizontal">
										<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">Título</label>
											<div class="col-sm-11">
												<input type="" class="form-control" id="siteTittle" placeholder="Title" value="<?php echo $this->data['appInfo']['title']; ?>">
											</div>
					                  	</div>
					                  	
					                  	<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">Nombre de la organización</label>
											<div class="col-sm-11">
												<input type="" class="form-control" id="siteName" placeholder="Site name" value="<?php echo $this->data['appInfo']['siteName']; ?>">
											</div>
					                  	</div>
					                  	
					                  	<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">Página web</label>
											<div class="col-sm-11">
												<input type="" class="form-control" id="siteUrl" placeholder="URL" value="<?php echo $this->data['appInfo']['url']; ?>">
											</div>
					                  	</div>
					                  	
					                  	<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">Content (SEO)</label>
											<div class="col-sm-11">
												<textarea class="form-control" id="siteContent" placeholder="Content"><?php echo $this->data['appInfo']['content']; ?></textarea>
											</div>
					                  	</div>
					                  	
					                  	<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">Description (SEO)</label>
											<div class="col-sm-11">
												<textarea class="form-control" id="siteDescription" placeholder="Description"><?php echo $this->data['appInfo']['description']; ?></textarea>
											</div>
					                  	</div>
					                  	
					                  	<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">Keywords (SEO)</label>
											<div class="col-sm-11">
												<textarea class="form-control" id="siteKeywords" placeholder="Keywords"><?php echo $this->data['appInfo']['keywords']; ?></textarea>
											</div>
					                  	</div>
					                  	
					                  	<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">E-mail</label>
											<div class="col-sm-11">
												<input type="" class="form-control" id="siteEmail" placeholder="Email" value="<?php echo $this->data['appInfo']['email']; ?>">
											</div>
					                  	</div>
					                  	
					                  	<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">Ubicación</label>
											<div class="col-sm-11">
												<input type="" class="form-control" id="siteLocation" placeholder="Location" value="<?php echo $this->data['appInfo']['location']; ?>">
											</div>
					                  	</div>
					                  	
					                  	<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">Twitter</label>
											<div class="col-sm-11">
												<input type="" class="form-control" id="siteTwitter" placeholder="Twitter" value="<?php echo $this->data['appInfo']['twitter']; ?>">
											</div>
					                  	</div>
					                  	
					                  	<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">Facebook</label>
											<div class="col-sm-11">
												<input type="" class="form-control" id="siteFacebook" placeholder="Facebook" value="<?php echo $this->data['appInfo']['facebook']; ?>">
											</div>
					                  	</div>
					                  	
					                  	<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">Google+</label>
											<div class="col-sm-11">
												<input type="" class="form-control" id="siteGoogleplus" placeholder="Google +" value="<?php echo $this->data['appInfo']['googleplus']; ?>">
											</div>
					                  	</div>
					                  	
					                  	<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">Pinterest</label>
											<div class="col-sm-11">
												<input type="" class="form-control" id="sitePinterest" placeholder="Pinterest" value="<?php echo $this->data['appInfo']['pinterest']; ?>">
											</div>
					                  	</div>
					                  	
					                  	<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">LinkedIn</label>
											<div class="col-sm-11">
												<input type="" class="form-control" id="siteLinkedin" placeholder="LinkedIn" value="<?php echo $this->data['appInfo']['linkedin']; ?>">
											</div>
					                  	</div>
					                  	
					                  	<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">Youtube</label>
											<div class="col-sm-11">
												<input type="" class="form-control" id="siteYoutube" placeholder="Youtube" value="<?php echo $this->data['appInfo']['youtube']; ?>">
											</div>
					                  	</div>
					                  	
					                  	<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">Instagram</label>
											<div class="col-sm-11">
												<input type="" class="form-control" id="siteInstagram" placeholder="Instagram" value="<?php echo $this->data['appInfo']['instagram']; ?>">
											</div>
					                  	</div>
					                  	
					                  	<div class="form-group">
											<div class="col-sm-offset-1 col-sm-10">
												<button type="submit" class="btn btn-sm btn-info update-settings">Guardar</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						
						<div class="tab-pane" id="categoriesSettings">
							<div class="row">
								<div class="col-md-6">
									<form class="form-horizontal">
										<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">Nombre</label>
											<div class="col-sm-8">
												<input type="" class="form-control" id="categoryName" placeholder="Nombre de la organizacion" value="">
											</div>
											<div class="col-sm-2">
												<button type="submit" class="btn btn-sm btn-info addCategory">Añadir</button>
											</div>
					                  	</div>
									</form>
									<div>
										<ul id="categoryList">
											<?php 
											foreach ($this->data['categories'] as $category)
											{
												?>
											<li id="cat-<?php echo $category['category_id']; ?>">
												<a href="javascript:void(0);" catId="<?php echo $category['category_id']; ?>">
													<?php echo $category['name']; ?>
												</a>
											</li>
												<?php
											}
											?>
										</ul>
									</div>
								</div>
								
								<div class="col-md-6" id="categorySettingsRight">
									<h4 id="catName"></h4>
									<form class="form-horizontal">
										<input type="hidden" value="0" id="currentCategory" />
										
										<div class="form-group">
					                    	<label for="inputName" class="col-sm-2 control-label">Nombre</label>
											<div class="col-sm-10">
												<input type="" class="form-control" id="currentName" placeholder="Nombre de la organización" value="">
											</div>
					                  	</div>
					                  	
					                  	<div class="form-group">
					                    	<label for="inputName" class="col-sm-2 control-label">Título</label>
											<div class="col-sm-10">
												<input type="" class="form-control" id="currentTitle" placeholder="Título" value="">
											</div>
					                  	</div>
					                  	
										<div class="form-group">
					                    	<label for="inputName" class="col-sm-2 control-label">Descripción</label>
											<div class="col-sm-10">
												<textarea class="form-control" id="currentDescription" rows="3" placeholder="Descripción"></textarea>
											</div>
					                  	</div>
										
										<div class="form-group">
											<div class="col-sm-offset-8 col-sm-10">
												<button type="submit" class="btn btn-xs btn-danger delete-category">Eliminar</button>
												<button type="submit" class="btn btn-xs btn-info update-category">Guardar</button>
											</div>
										</div>
										
										<div class="clr"></div>
									</form>
									
									<!-- 
									<h3>Subcategoría</h3>
										
									<div>
										<form class="form-horizontal">
											<div class="form-group">
						                    	<label for="inputName" class="col-sm-1 control-label">Nombre</label>
												<div class="col-sm-8">
													<input type="" class="form-control" id="subcategoryName" placeholder="Subcategory name" value="">
												</div>
												<div class="col-sm-2">
													<button type="submit" class="btn btn-xs btn-info addSubcategory">Añadir</button>
												</div>
						                  	</div>
										</form>
									</div>
										 -->
									
									<div class="clr"></div>
									
									<ul id="subcategoryList">
										
									</ul>
								</div>
							</div>
						</div>
						
						<div class="tab-pane" id="locationSettings">
							<div class="row">
								<div class="col-md-6">
								
									<form class="form-horizontal">
										<div class="form-group">
					                    	<label for="inputName" class="col-sm-1 control-label">Nombre</label>
											<div class="col-sm-8">
												<input type="" class="form-control" id="locationName" placeholder="Location name" value="">
											</div>
											<div class="col-sm-2">
												<button type="submit" class="btn btn-success addLocation">Añadir</button>
											</div>
					                  	</div>
									</form>
									<div>
										<ul id="locationList">
											<?php 
											foreach ($this->data['locations'] as $location)
											{
												?>
											<li id="loc-<?php echo $location['location_id']; ?>">
												<a href="javascript:void(0);" locId="<?php echo $location['location_id']; ?>">
													<?php echo $location['name']; ?>
												</a>
											</li>
												<?php
											}
											?>
										</ul>
									</div>
								</div>
								
								<div class="col-md-6" id="locationSettingsRight">
									<h4 id="locName"></h4>
									<form class="form-horizontal">
										<input type="hidden" value="0" id="currentLocation" />
										
										<div class="form-group">
					                    	<label for="inputName" class="col-sm-2 control-label">Nombre</label>
											<div class="col-sm-10">
												<input type="" class="form-control" id="currentLocationName" placeholder="Location name" value="">
											</div>
					                  	</div>
					                  	
										<div class="form-group">
					                    	<label for="inputName" class="col-sm-2 control-label">Descripción</label>
											<div class="col-sm-10">
												<textarea class="form-control" id="currentLocationDescription" rows="3" placeholder="Descripción"></textarea>
											</div>
					                  	</div>
										
										<div class="form-group">
											<div class="col-sm-offset-8 col-sm-10">
												<button type="submit" class="btn btn-sm btn-danger delete-location">Eliminar</button>
												<button type="submit" class="btn btn-sm btn-info update-location">Guardar</button>
											</div>
										</div>
										
										<div class="clr"></div>
									</form>
										
										<br>
										
										<h3>Indica la región en el mapa / <button type="submit" class="btn btn-sm btn-info update-region">Guardar</button></h3>
										
										<div id="map-canvas"></div>
										
										<br>
										
										<div class="Coordenadas">
											<ul id="mapCoords">
											</ul>
										</div>
								</div>
								
								<div class="col-md-6">
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }   
    
    public function getAddCompanyHead()
    {
    	ob_start();
    	?>
    	<script type="text/javascript"></script>
    	<?php
    	$head = ob_get_contents();
    	ob_end_clean();
    	return $head;
    }
    
    public function getAddCompanyScripts()
    {
    	ob_start();
    	?>
    	<script type="text/javascript">
		</script>
		<script src=""></script>
		<script src="/js/back/company.js"></script>
    	<?php
    	$scripts = ob_get_contents();
    	ob_end_clean();
    	return $scripts;
    }
    
    public function getAddCompanyContent()
    {
    	ob_start();
    	?>
		<div class="row">
			<div class="col-md-8 col-center">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Add a new company</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<form action="<?php $root; ?>/controllers/add-entry-blog.php" method="post" role="form">
						<div class="box-body">
							<div class="form-group">
								<label>Name:</label>
								<input type="text" class="form-control" id="" placeholder="Entry name" name="title">
							</div>
						</div>
						<!-- /.box-body -->
						
						<div class="form-group">
            					<label  class="col-sm-12 control-label">Category</label>
            					<div class="col-sm-12">
            						<select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="category" name="category">
            							<?php 
            							foreach ($this->data['categories'] as $category)
            							{
            								?>
            							<option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
            								<?php
            							}
            							?>
            						</select>
            					</div>
            				</div><!-- /.form-group -->
						<br><br><br>
						<div class="box-footer">
							<button type="submit" class="btn btn-primary" id="create-company">Create</button>
						</div>
					              
					</form>
					<!-- Loading (remove the following to stop the loading)-->
					<div class="overlay" id="add-company-loader">
						<i class="fa fa-refresh fa-spin"></i>
						<p class="over-message text-light-blue">wait, we are saving the data ...</p>
					</div>
					<!-- end loading -->
					
				</div>
			</div>
		</div>
        <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    
   	
    public function getSectionHead()
    {
    	ob_start();
    	?>
        <script type="text/javascript"></script>
    	<?php
    	$head = ob_get_contents();
    	ob_end_clean();
    	return $head;
    }
    
    public function getSectionScripts()
    {
    	ob_start();
    	?>
        <script type="text/javascript">
        </script>
        <script src=""></script>
    	<?php
    	$scripts = ob_get_contents();
    	ob_end_clean();
    	return $scripts;
    }
    
    public function getSectionContent()
    {
        ob_start();
        ?>

        <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    
   	
   	/**
   	 * The very awesome footer!
   	 * 
   	 * <s>useless</s>
   	 * 
   	 * @return string
   	 */
    public function getFooter()
    {
    	ob_start();
    	?>
        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
                <i><b>Developed by <a class="link-white-v2" href="https://www.crc-software.com/" target="_blank"> CRC Software</a> ©</b></i>
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; <?php echo date("Y"); ?> <a class="link-white-v2" href="<?php echo $this->data['info']['url']; ?>" target="_blank"><?php echo $this->data['info']['siteName']; ?></a>.</strong> All rights reserved.
        </footer>
    	<?php
    	$footer = ob_get_contents();
    	ob_end_clean();
    	return $footer;
	}

	public function getSaveUserForm () 
        {
            ob_start();
            $titlePass = "Password";
            $placeHolderText = "Ingresa tu password";
            ?>
		<div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php if (!isset($this->data['user-info'])) { echo "Registrar un usuario."; } else { echo "Actualizar información."; } ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="<?php $root; ?>/controllers/user-register-controller.php<?php if (isset($this->data['user-info'])) { echo "?edit=" . $_GET["edit"]; } ?>" method="post" class="form-horizontal">
              <div class="box-body">
              	<!-- name input -->
                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Nombre: </label>

                  <div class="col-sm-10">
                    <input name="name" type="text" class="form-control" id="inputName" placeholder="Nombre completo" value="<?php if (isset($this->data['user-info'])) { echo $this->data['user-info']['name']; } ?>">
                  </div>
                </div>
                <!-- mail input -->
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                  <div class="col-sm-10">
                    <input name="mail" type="email" class="form-control" id="inputEmail3" placeholder="Email" value="<?php if (isset($this->data['user-info'])) { echo $this->data['user-info']['email']; } ?>">
                  </div>
                </div>
                <?php if (isset($this->data['user-info'])) {
                		$titlePass = "Nuevo password";
                		$placeHolderText = "Ingresa un nuevo password para cambiarlo el anterior."
                ?>

                		<input name="lastPassword" type="text" value="<?php if (isset($this->data['user-info'])) { echo $this->data['user-info']['password']; } ?>" hidden>
                <?php } ?>
                <!-- password input -->
                <div class="form-group">
                  <label for="inputPass" class="col-sm-2 control-label"><?php echo $titlePass; ?></label>

                  <div class="col-sm-10">
                    <input name="password" type="password" class="form-control" id="inputPass" placeholder="<?php echo $placeHolderText; ?>">
                  </div>
                </div>
				<!-- Organización input -->
                <div class="form-group">
                  <label for="inputCategory" class="col-sm-2 control-label">Organización</label>

                  <div class="col-sm-10">
                    <select name="organization" id="inputCategory" class="form-control">
                    	<option value="0">Selecciona una opción</option>
	                <?php foreach ($this->data['categories'] as $c){ ?>
						<option value="<?php echo $c['category_id']; ?>" <?php if (isset($this->data['user-info']) && $this->data['user-info']['category_id'] == $c['category_id']) { echo "selected"; } ?>><?php echo $c['name']; ?></option>
		   			<?php } ?>
                  </select>
                  </div>
                </div>
                <!-- Organización input -->
                <div class="form-group">
                  <label for="inputCategory" class="col-sm-2 control-label">Tipo de usuario</label>

                  <div class="col-sm-10">
                    <select name="typeUser" id="inputCategory" class="form-control">
	                    <option value="0" <?php if (isset($this->data['user-info']) && $this->data['user-info']['type_user'] == 0) { echo "selected"; } ?>>Administrador</option>
	                    <option value="1" <?php if (isset($this->data['user-info']) && $this->data['user-info']['type_user'] == 1) { echo "selected"; } ?>>Cliente</option>
                  </select>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="submit" class="btn btn-info pull-right"></button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        </div>
	<?php
		$content = ob_get_contents();
    	ob_end_clean();
    	return $content;
	}

	public function getListUserRegister() {
		ob_start(); //echo "<pre>"; var_dump($this->data);
	?>
	<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Usuarios incorporados al sistema</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                	<th>Estado</th>
                  	<th>Tipo</th>
                  	<th>Nombre</th>
                  	<th>Correo</th>
                  	<th>Organización</th>
                  	<th>Acciones</th>
                </tr>
                <?php foreach ($this->data['list'] as $user) { ?>
                <tr>
                	<td><span class="label <?php if ($user['account_available'] == 'available') { echo "label-success"; } else { echo "label-danger"; } ?>"><?php echo $user["account_available"]; ?></span></td>
                	<td><?php if ($user['type_user'] == 0) { echo "Administrador"; } else { echo "Cliente"; } ?></td>
                  	<td><?php echo $user["name"]; ?></td>
                  	<td><?php echo $user["email"]; ?></td>
                  	<td><?php echo $user["c"]; ?></td>
                  	<td><ul><li><a href="/user/edit/<?php echo $user["user_detail_id"]; ?>/"><i class="fa fa-edit"></i> <?php echo _("Editar"); ?></a></li><li><a href="/user/delete/<?php echo $user["user_detail_id"]; ?>/"><i class="fa fa-eraser"></i> <?php echo _("Eliminar"); ?></a></li></ul></td>
                </tr>
                <?php } ?>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    </div>
	<?php
		$content = ob_get_contents();
    	ob_end_clean();
    	return $content;

	}
}
<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8" lang="<?php echo I18n::$lang;?>"/>
<link rel="alternate" href="<?php echo URL::site('?lang='.I18n::$lang);?>" hreflang="<?php echo I18n::$lang;?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width">
<link rel="shortcut icon" href="<?php echo BS_URL;?>favicon.ico" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta name="keywords" content="<?php echo $meta_keywords; ?>">
<meta name="description" content="<?php echo $meta_description;?>">
<meta name="copyright" content="<?php echo $meta_copyright;?>">
<meta name="robots" content="all,index,follow">
<meta name="googlebot" content="all,index,follow">
<meta name="allow-search" content="yes">
<meta name="audience" content="all">
<meta name="revisit" content="2 days">
<meta name="revisit-after" content="2 days">
<meta name="author" content="Web Architect">
<meta name="creator" content="Web Architect indonesia">
<meta http-equiv="Reply-to" content="info@webarq.com">
<meta name="distribution" content="global">
<meta name="document-classification" content="general">
<meta name="rating" content="general">
<meta http-equiv="Reply-to" content="info@webarq.com"/>
<!--
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Developed by <?php echo DEVELOPER_NAME;?> ( <?php echo DEVELOPER_URL;?> )
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ 
Generated : <?php echo date('d/m/Y H:m:s') . "\n";?>
-->
<script type="text/javascript"> var base_URL = '<?php echo BS_URL; ?>';</script>
<?php foreach($styles as $file => $type) { echo HTML::style(CSS.$file, array('media' => $type)), "\n"; }?>
<!--[if IE 7]> <link href="<?php echo ASSETS;?>css/styleIE7.css" rel="stylesheet" type="text/css"> <![endif]-->
<!--[if IE 8]> <link href="<?php echo ASSETS;?>css/styleIE8.css" rel="stylesheet" type="text/css"> <![endif]-->
<!--[if IE 9]> <link href="<?php echo ASSETS;?>css/styleIE9.css" rel="stylesheet" type="text/css"> <![endif]-->
<?php foreach($scripts as $file) { echo HTML::script(JS.$file, NULL, TRUE), "\n"; }?>
<title><?php echo !empty($page_title) ? $page_title : ''; ?> | <?php echo !empty($title_name) ? $title_name : ''; ?></title>
</head>
<?php 
$current_page = '' ?>
<body class="<?php echo ($current_page != 'home') ? $current_page : 'homePage';?>">
<div id="container">	
	<div id="header">
		<div class="outerwrapper"><img src="<?php echo ASSETS;?>images/themes/content/banner-header.jpg" width="1024" height="227" alt="" />
        <ul id="navigation">	
			<?php foreach ($pageCategory as $category ) {
				$category->name = ($category->name == 'home') ? '' : $category->name;
				$category->name = (strpos($category->name, 'http') === FALSE) ? URL::site($category->name) : $category->name;				
				?>
				<li><a href="<?php echo $category->name?>" title="<?php echo $category->title;?>"><?php echo $category->title;?></a>
				<?php if (!empty($page_category_child[$category->id])) { ?>	
					<ul class="hidden">
						<?php foreach ($page_category_child[$category->id] as $category_child => $child) { ?>
						<li>
							<a href="<?php echo URL::site($child->name);?>" title="<?php echo $child->title;?>">
								<?php echo HTML::chars($child->title, TRUE);?>
							</a>
						</li>
						<?php } ?>
					</ul>								
				<?php }?>
				</li>
			<?php } ?>
			<li><?php echo Form::open(URL::site('search'),array('name'=>'search-form','id'=>'search-form')); echo Form::input('search','',array('placeholder'=>'Search by Keywords')); echo Form::submit('', ''); echo Form::close();?></li>
        </ul>
        </div>
	</div><!-- end header -->

				
	<div id="middle" class="column container-fluid">
		<div class="outerwrapper">
		  <div class="container-fluid">
			  <div class="search-container text-center">
				<h1 class="page-header">This site is off for maintenance</h1>				
			  </div>
		  </div>
		</div>
	</div>	

	
<div id="footer">
	<div class="outerwrapper"><p><?php echo $copyright;?> Design by <?php echo DEVELOPER_NAME;?>.<br />
		<a href="<?php echo URL::site('sitemap');?>">Sitemap</a></p>
	</div>
</div><!-- end footer -->
</div><!-- end container -->
<script type="text/javascript">	
<?php if (Session::instance()->get("result") != '') : ?> 
	jAlert("<?php echo Session::instance()->get_once("result"); ?>", "Alert!");
<?php endif; ?>	
<?php if (Session::instance()->get("flash") != '') : ?> 
	jAlert("<?php echo Session::instance()->get_once("flash"); ?>", "Alert!");
<?php endif; ?>		
<?php if (Session::instance()->get("register_info") != '') : ?> 
	jAlert("<?php echo Session::instance()->get_once("register_info"); ?>", "Alert!"); 
<?php endif; ?>			
<?php if (Session::instance()->get("auth_error") != '') : ?> 
	jAlert("<?php echo Session::instance()->get_once("auth_error"); ?>", "Alert!");
<?php endif; ?>				
</script>
</body>
</html>
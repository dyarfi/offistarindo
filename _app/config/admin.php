<?php defined('SYSPATH') OR die('No direct access allowed.');
// Setting for using dashboard or not value True or False
$config['show_dashboard'] = TRUE;

// This is supposed to be redirection to edit profile view 
$config['default_page']	  = ($config['show_dashboard'] == TRUE) 
							// Redirect to user profile 
							? ADMIN . 'userdashboard/index'
							// Redirect to user dashboard
							: ADMIN . 'user/view/{admin_id}';
// Model List							
$config['models']			= array('User',/*'UserLevel',*/'UserProfile','History',/*'ModulePermission',*/'UserDashboard'/*,'Setting'*/);
// Module Menu List
$config['module_menu']		= array('userdashboard/index'	=> 'Dashboard Panel',
									'user/index'			=> 'User Listings',
									/*'userlevel/index'		=> 'User Levels Listings',*/
									/*'history/index'		=> 'User History Listings',*/
									);
/* MODULE FUNCTION
 * 
 * Currently is only set to user and and setting
 * Accessed by administrators only
 */
$config['module_function']	= array(
									'userdashboard/add'		=> 'Add New Dashboard',
									'userdashboard/view'	=> 'View Dashboard Details',
									'userdashboard/edit'	=> 'Edit Dashboard Details',
									'userdashboard/delete'	=> 'Delete Dashboard',
									'user/edit'  => 'Edit User Details',
									'user/view'  => 'View User Details',
									'setting/view'	  => 'View Setting Details',
									'setting/edit'    => 'Edit Setting Details',
									'setting/delete'  => 'Delete Setting Details',
                                    );
// Loading CSS
$config['css']				= array(
									/*'ui-lightness/jquery-ui.custom.css' => 'screen',*/
	'admin.css' => 'screen',
									'helper.css' => 'all',									
									'tipsy.css'=>'all',
									'jquery.jqplot.min.css' => 'all', 
									'jquery.superfish.css' => 'all',
									'jquery.alerts.css' => 'all',
									'colorbox.css' => 'all',
									//'shadowbox/shadowbox.css' => 'all',
									'jquery/jquery-ui-1.9.1/jquery.ui.all.css'=>'all',	
									/*'bootstrap/css/bootstrap.custom.css' =>'screen', */
									/*'reset.css' => 'screen'*/
									//---- Bootstrap -- start --
									//'bootstrap/css/bootstrap-theme.min.css' => 'all',
									//'bootstrap/css/bootstrap.min.css' => 'all',	
									//---- Bootstrap -- end --
									);
// Loading Javascript
$config['js']				= array(
									'admin.js',	
									'jquery.tipsy.js',
									'uploadify/swfobject.js',
									'extend/jquery.alphanumeric.js',
									'extend/jquery.autonumeric.js',
									'extend/jquery.char.counter.js',
									//'extend/jquery.shadowbox.js',
									/*'extend/jquery.combo.js',*/
									'jquery.jqplot.1.0.4/plugins/jqplot.donutRenderer.min.js',
									'jquery.jqplot.1.0.4/plugins/jqplot.pieRenderer.min.js',
									'jquery.jqplot.1.0.4/plugins/jqplot.barRenderer.min.js',
									'jquery.jqplot.1.0.4/plugins/jqplot.canvasTextRenderer.min.js',
									'jquery.jqplot.1.0.4/plugins/jqplot.canvasAxisTickRenderer.min.js',
									'jquery.jqplot.1.0.4/plugins/jqplot.categoryAxisRenderer.min.js',
									'jquery.jqplot.1.0.4/plugins/jqplot.pointLabels.min.js',
									'jquery.jqplot.1.0.4/jquery.jqplot.min.js',

/*	
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="js/jquery.fileupload-ui.js"></script>
*/
																			
									//'jquery.fileupload-ui.js',								
									'jquery.fileupload-validate.js',	
									//'jquery.fileupload-image.js',
									//'jquery.fileupload-audio.js',
									//'jquery.fileupload-video.js',
									'jquery.fileupload-process.js',	
									'jquery.fileupload.js',									
									'jquery.iframe-transport.js',	
									
									
									'ckeditor/adapters/jquery.js',
									'ckeditor/ckeditor.js',
									/*'tiny_mce/jquery.tinymce.js',*/
									/*'extend/jquery.form.js',*/
									/*'extend/jquery.cookie.js',*/
									/*'tiny_mce/plugins/tinybrowser/tb_tinymce.js.php',*/
									/*'jquery.hoverintent-min.js',*/
									/*'bootstrap/bootstrap-button.js',*/
									/*'bootstrap/bootstrap-alert.js',*/
									/*'bootstrap/bootstrap.min.js',*/	
									/*'uploadify/jquery.uploadify.v2.1.4.min.js',*/	
									/*'fabric/jquery-ui-1.9.1/jquery.ui.datepicker.min.js',*/
									/*'fabric/jquery-ui-1.9.1/jquery.effects.bounce.min.js',*/
									/*'fabric/jquery-ui-1.9.1/jquery.effects.core.min.js',*/
									/*'fabric/jquery-ui-1.9.1/jquery.ui.autocomplete.min.js',*/
									/*'fabric/jquery-ui-1.9.1/jquery.ui.position.min.js',*/
									/*'fabric/jquery-ui-1.9.1/jquery.ui.button.min.js',*/
									/*'fabric/jquery-ui-1.9.1/jquery.ui.draggable.min.js',*/
									/*'fabric/jquery-ui-1.9.1/jquery.ui.droppable.min.js',*/
									//'fabric/jquery-ui-1.9.1/jquery.ui.widget.min.js',
									'fabric/jquery-ui-1.9.1/jquery-ui.custom.min.js',
									'fabric/jquery-ui-1.9.1/jquery.ui.core.min.js',
                                    'jwplayer/jwplayer.js',
									'jquery.colorbox.js',
									'jquery.fancyzoom-min.js',
									'jquery.pngFix.js',
									'jquery.superfish-min.js',
									'jquery.alerts.js',
									'jquery.validate.min.js',
									/*'jquery.color.js',*/							
									//'bootstrap/bootstrap.min.js',
									'jquery-1.8.2.min.js',
                                    );

/** File Manager path and key access **/
$config['filemanager_path'] = URL::site() . 'filemanager/dialog.php?field_id=fileName&amp;akey='.sha1($_SERVER['HTTP_HOST'].date('dMY'));
/** Administration Control Panel Title **/
$config['title']		  = 'Administration Control Panel';
$config['show_developed'] = TRUE;
$config['item_per_page']  = 25;
/** Text Formats **/
$config['date_format']		= 'd M Y H:i:s';
$config['date_hours']		= 'd/m/Y H:i:s';
/** Error Fields **/
$config['error_field_open']	 = '<div class="form_row error">';
$config['error_field_close'] = '</div>';
$config['default'] = array ('view' => 'admin/default');
 return array_merge_recursive (
	$config 
 );

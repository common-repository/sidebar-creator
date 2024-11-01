<?php 
/**
 * Plugin Name: Sidebar Creator
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: It is Autometic sidebar Creator Plugin.
 * Version: 1.0.1
 * Author: souvikitobuz
 * Author URI: http://URI_Of_The_Plugin_Author
 * License: A "Slug" license name e.g. GPL2
 */

/*--------------------------------------------*/
/*--------------------------------------------*/
/*-------------Sidebar Creator Plugin-------- */
/*--------------------------------------------*/
/*--------------------------------------------*/
/** Step 2 (from text above). */
add_action( 'admin_menu', 'my_sidebar_plugin_menu' );

/** Step 1. */
function my_sidebar_plugin_menu() {
    
	add_theme_page( 'sidebar Plugin Options', 'Add Sidebar', 'manage_options', 'my-sidebar-unique-identifier', 'my_sidebar_plugin_options' );
}
/** Step 3. */
function my_sidebar_plugin_options() {
    
    wp_enqueue_script('jquery');
	wp_enqueue_script('custom_sidebar-js' ,plugins_url( 'sidebar-creator/custom_sidebar.js'));
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	?>
	
	<div class="my-form">
        <div class="wrap">
<h2>Sidebar Creator Settings</h2>

<form method="post" action="options.php" id="InputsWrapper"  role="form">

<?php wp_nonce_field('update-options'); ?>


 
<?php 

$xx=get_option('boxes');
//print_r($xx);
$no=count($xx);
?>
<div id="append">
 <p class="text-box">
            <label for="box1">Sidebar-<span class="box-number">1</span></label>
            <input type="text" name="boxes[]" value="<?php echo $xx[0]; ?>" id="box1" />
			<a href="#" class="remove-box">Remove</a>
            
        </p>


		
<?php if($no>1){ 
		for($i=1;$i<$no;$i++){

?>		
<p class="text-box"><label for="box' + n + '">Sidebar-<span class="box-number"><?php echo $i+1; ?></span></label> 
<input type="text" name="boxes[]" value="<?php echo $xx[$i]; ?>" id="box' + n + '" /> 
<a href="#" class="remove-box">Remove</a>
</p>
<?php }

} ?></div>
<!--<a class="add-box" href="#">Add More</a>-->
<button type="button"  class="add-box">Add More!</button>

</table>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="no_of_sidebar,sidebar_names,boxes" />

<p class="submit">
<input type="submit" class="button-primary clsSubmit" value="<?php _e('Save Changes') ?>" />
</p>


</form>
</div>
</div>
        <?php
}
/*side bar creator!!!!!!!!!!!*/



$xx=get_option('boxes');
//$no=count($xx);
//echo $no;
//print_r($xx); 
    if ( function_exists('register_sidebar') ) {
	  if(!empty($xx)){
        foreach ($xx as $side){         
             register_sidebar(array(
             'name' => $side.'(Custom-Sidebar)',
             'id' =>'sidebar_'.$side,
             'description'   => 'Copy this shortcode [custom-sidebar name="'.$side.'"]',
			 'before_widget' => '<div id="%1$s" class="widget %2$s" >',
			 'after_widget'  => '</div>',
			 'before_title'  => '<h2 class="widgettitle">',
			 'after_title'   => '</h2>' 
           ));
             
       }
	   }
}


 
/*sidebar short code*/
 
function sidebar_shortcode($atts){
    $nam=shortcode_atts( array(
		'name' => 'sidebar-name',),$atts,'custom-sidebar');
    $a=$nam[name].'(Custom-Sidebar)';
    dynamic_sidebar($a); 
	
    
}
add_shortcode( 'custom-sidebar' , 'sidebar_shortcode' );


add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
    .widgets-holder-wrap .sidebar-description {
-webkit-user-select: inherit;
}
  </style>';
}

?>
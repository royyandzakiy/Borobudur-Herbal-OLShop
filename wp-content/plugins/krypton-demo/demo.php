<?php
defined('ABSPATH') or die();
/* 
 * Plugin Name: Krypton WP Demo Packages
 * Plugin URI: http://www.detheme.com/
 * Description: Setup krypton demo
 * Version: 1.0.1
 * Author: detheme.com
 * Author URI: http://www.detheme.com/
 * Domain Path: /languages/
 *
 */

add_action('init','init_krypton_package');

function init_krypton_package(){

	add_filter('get_detheme_packages','get_krypton_demo_packages');

}

function get_krypton_demo_packages($packages){


   	$path= dirname(__FILE__)."/themes/";

	$wp_filesystem=new WP_Filesystem_Direct(array());

	  if($dirlist=$wp_filesystem->dirlist($path)){
	    foreach ($dirlist as $dirname => $dirattr) {

	       if($dirattr['type']!='d')
	       		continue;

	       	if($package= detheme_one_click_demo::get_package_info($path.$dirname."/style.css")){

	       		if($wp_filesystem->exists($path.$dirname."/screenshot.jpg")){
	       			$package['Thumbnail']=plugin_dir_url(__FILE__)."themes/".$dirname."/screenshot.jpg";
	       		}elseif(@file_exists($path.$dirname."/screenshot.png")){
	       			$package['Thumbnail']=plugin_dir_url(__FILE__)."themes/".$dirname."/screenshot.png";
	       		}
	       		$package['path']=$path.$dirname."/";
	       		$package['Category']=$package['Category']!=''?$package['Category']:__( 'General', 'detheme_demo' );
	       		$packages[$dirname]=$package;
	       	}
	    }
	  }



	return $packages;
}
?>
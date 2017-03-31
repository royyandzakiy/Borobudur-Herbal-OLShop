<?php
/**
 * @package WordPress
 * @subpackage DT Page Builder
 * @version 1.3.2
 * @since 1.0.0
 */

defined('DTPB_BASENAME') or die();
/* helper */

include_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php');
include_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php');


if (!function_exists('aq_resize')) {
  function aq_resize( $url, $width, $height = null, $crop = null, $single = true ) {

    if(!$url OR !($width || $height)) return false;

    //define upload path & dir
    $upload_info = wp_upload_dir();
    $upload_dir = $upload_info['basedir'];
    $upload_url = $upload_info['baseurl'];
    
    //check if $img_url is local
    /* Gray this out because WPML doesn't like it.
    if(strpos( $url, home_url() ) === false) return false;
    */
    
    //define path of image
    $rel_path = str_replace( str_replace( array( 'http://', 'https://' ),"",$upload_url), '', str_replace( array( 'http://', 'https://' ),"",$url));
    $img_path = $upload_dir . $rel_path;
    
    //check if img path exists, and is an image indeed
    if( !file_exists($img_path) OR !getimagesize($img_path) ) return false;
    
    //get image info
    $info = pathinfo($img_path);
    $ext = $info['extension'];
    list($orig_w,$orig_h) = getimagesize($img_path);
    
    $dims = image_resize_dimensions($orig_w, $orig_h, $width, $height, $crop);
    if(!$dims){
      return $single?$url:array('0'=>$url,'1'=>$orig_w,'2'=>$orig_h);
    }

    $dst_w = $dims[4];
    $dst_h = $dims[5];

    //use this to check if cropped image already exists, so we can return that instead
    $suffix = "{$dst_w}x{$dst_h}";
    $dst_rel_path = str_replace( '.'.$ext, '', $rel_path);
    $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

    //if orig size is smaller
    if($width >= $orig_w) {

      if(!$dst_h) :
        //can't resize, so return original url
        $img_url = $url;
        $dst_w = $orig_w;
        $dst_h = $orig_h;
        
      else :
        //else check if cache exists
        if(file_exists($destfilename) && getimagesize($destfilename)) {
          $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
        } 
        else {

          $imageEditor=wp_get_image_editor( $img_path );

          if(!is_wp_error($imageEditor)){

              $imageEditor->resize($width, $height, $crop );
              $imageEditor->save($destfilename);

              $resized_rel_path = str_replace( $upload_dir, '', $destfilename);
              $img_url = $upload_url . $resized_rel_path;


          }
          else{
              $img_url = $url;
              $dst_w = $orig_w;
              $dst_h = $orig_h;
          }

        }
        
      endif;
      
    }
    //else check if cache exists
    elseif(file_exists($destfilename) && getimagesize($destfilename)) {
      $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
    } 
    else {

      $imageEditor=wp_get_image_editor( $img_path );

      if(!is_wp_error($imageEditor)){
          $imageEditor->resize($width, $height, $crop );
          $imageEditor->save($destfilename);

          $resized_rel_path = str_replace( $upload_dir, '', $destfilename);
          $img_url = $upload_url . $resized_rel_path;
      }
      else{
          $img_url = $url;
          $dst_w = $orig_w;
          $dst_h = $orig_h;
      }


    }
    
    if(!$single) {
      $image = array (
        '0' => $img_url,
        '1' => $dst_w,
        '2' => $dst_h
      );
      
    } else {
      $image = $img_url;
    }
    
    return $image;
  }
}

function get_image_size( $image_id,$img_size="thumbnail"){

    global $_wp_additional_image_sizes;

    if(''==$img_size)
        $img_size="thumbnail";

    if(''==$image_id)
        return false;

    if(in_array($img_size, array('thumbnail','thumb','small', 'medium', 'large','full'))){

        if ( $img_size == 'thumb' ||  $img_size == 'small' || $img_size == 'thumbnail' ) {

            $image=wp_get_attachment_image_src($image_id,'thumbnail');
        }
        elseif ( $img_size == 'medium' ) {
            $image=wp_get_attachment_image_src($image_id,'medium');

        }
        elseif ( $img_size == 'large' ) {
            $image=wp_get_attachment_image_src($image_id,'large');
        }else{

            $image=wp_get_attachment_image_src($image_id,'full');

        }

    }
    elseif(!empty($_wp_additional_image_sizes[$img_size]) && is_array($_wp_additional_image_sizes[$img_size])){

        $width=$_wp_additional_image_sizes[$img_size]['width'];
        $height=$_wp_additional_image_sizes[$img_size]['height'];

        $img_url = wp_get_attachment_image_src($image_id,'full',false); 
        $image=aq_resize( $img_url[0],$width, $height, true,false ) ;


    }
    else{

        preg_match_all('/\d+/', $img_size, $thumb_matches);

        if(isset($thumb_matches[0])) {
            $thumb_size = array();
            if(count($thumb_matches[0]) > 1) {
                $thumb_size[] = $thumb_matches[0][0]; // width
                $thumb_size[] = $thumb_matches[0][1]; // height
            } elseif(count($thumb_matches[0]) > 0 && count($thumb_matches[0]) < 2) {
                $thumb_size[] = $thumb_matches[0][0]; // width
                $thumb_size[] = $thumb_matches[0][0]; // height
            } else {
                $thumb_size = false;
            }
        }

        if($thumb_size){

          $img_url = wp_get_attachment_image_src($image_id,'full',false); 
          $image=aq_resize( $img_url[0],$thumb_size[0], $thumb_size[1], true,false ) ;
        }
        else{
          return false;
        }
    }

    return $image;
}

function get_dt_elements(){

  global $DElements;

  if(!is_object($DElements)){

      $DElements=DElements::getInstance();
  }
  return $DElements->getElements();
}

function get_dt_element($shortcode=""){

  if(''==$shortcode) return false;

  global $DElements;

  if(!is_object($DElements)){

      $DElements=DElements::getInstance();
  }

  $elements=$DElements->getElements();

  return isset($elements[$shortcode])?$elements[$shortcode]:false;
}

function add_dt_element($shortcode_id,$params){

  global $DElements;
  if(!is_object($DElements)){

      $DElements=DElements::getInstance();
  }
  $DElements->addElement($shortcode_id,$params);
}

function remove_dt_element($shortcode_id){

  global $DElements;
  if(!is_object($DElements)){

      $DElements=DElements::getInstance();
  }
  $DElements->removeElement($shortcode_id);
}

function add_dt_element_render($shortcode_id,$funtionName){

  /**
  * @deprecated 1.4.0 use 2 args
  *
  */
  add_filter('render_'.$shortcode_id.'_shortcode',$funtionName,1,3);

}

function add_dt_element_preview($shortcode_id,$funtionName){

  add_filter('preview_'.$shortcode_id.'_shortcode',$funtionName,1,3);
}

function add_dt_element_option($shortcode_id,$options=array(),$replace=true){

  if($shortcode_id=='')
    return false;

  if(!$element=get_dt_element($shortcode_id))
    return false;

  $element->addOption($options,$replace);
}

function add_dt_element_options($shortcode_id,$options=array(),$replace=true){

  if($shortcode_id=='')
    return false;

 if(!$element=get_dt_element($shortcode_id))
    return false;
  $element->addOptions($options,$replace);
}

function remove_dt_element_options($shortcode_id,$optionName){

  if($shortcode_id=='')
    return false;

  $element=get_dt_element($shortcode_id);

 if(!$element) return false;
  $element->removeOption($optionName);
}

/**
* 
* @since 1.3.2
*/

function remove_dt_element_option($shortcode_id,$optionName){

  if($shortcode_id=='')
    return false;

  $element=get_dt_element($shortcode_id);

  if(!$element) return false;
  $element->removeOption($optionName);
}

function add_dt_field_type($type,$function_name){


  $classField='DElement_Field_'.$type;

  if(class_exists($classField) || !function_exists($function_name)) return false;
  add_action( $classField,$function_name,1,2);

}

function create_dependency_param($option=array()){

  if(!isset($option['dependency']) || ! is_array($option['dependency']))
      return "";

  $param=wp_parse_args($option['dependency'],array('element'=>"",'value'=>'','not_empty'=>false));
  $dependent=$param['element'];
  $dependent_value=$param['value'];
  $not_empty=$param['not_empty'];



  if($dependent=='' || ($dependent_value=='' && !$not_empty))
      return "";

  return " data-dependent=\"".$dependent."\" data-dependvalue=\"".($not_empty?"not_empty":(is_array($dependent_value)?@implode(",",$dependent_value):$dependent_value))."\"";
}

function getCssID($prefix=""){

  global $dt_el_id;

  if(!isset($dt_el_id)) {
    $dt_el_id=0;
  }

  $dt_el_id++;

  return $prefix.$dt_el_id;

}

function getCssMargin($atts,$is_array=false){

  $defaults=array(
          'm_top'=>'',
          'm_bottom'=>'',
          'm_left'=>'',
          'm_right'=>'',
          'p_top'=>'',
          'p_bottom'=>'',
          'p_left'=>'',
          'p_right'=>'',
        );

  $args=wp_parse_args($atts,$defaults);
  extract($args);
  $css_style=array();



  if(''!=$m_top){$m_top=(int)$m_top;$css_style['margin-top']="margin-top:".$m_top."px";}
  if(''!=$m_bottom){$m_bottom=(int)$m_bottom;$css_style['margin-bottom']="margin-bottom:".$m_bottom."px";}
  if(''!=$m_left){$m_left=(int)$m_left;$css_style['margin-left']="margin-left:".$m_left."px";}
  if(''!=$m_right){$m_right=(int)$m_right;$css_style['margin-right']="margin-right:".$m_right."px";}
  if(''!=$p_top){$p_top=(int)$p_top;$css_style['padding-top']="padding-top:".$p_top."px";}
  if(''!=$p_bottom){$p_bottom=(int)$p_bottom;$css_style['padding-bottom']="padding-bottom:".$p_bottom."px";}
  if(''!=$p_left){$p_left=(int)$p_left;$css_style['padding-left']="padding-left:".$p_left."px";}
  if(''!=$p_right){$p_right=(int)$p_right;$css_style['padding-right']="padding-right:".$p_right."px";}

  return $is_array?$css_style:@implode(";",$css_style);
}

if(!function_exists('darken')){
  function darken($colourstr, $procent=0) {
    $colourstr = str_replace('#','',$colourstr);
    $rhex = substr($colourstr,0,2);
    $ghex = substr($colourstr,2,2);
    $bhex = substr($colourstr,4,2);

    $r = hexdec($rhex);
    $g = hexdec($ghex);
    $b = hexdec($bhex);

    $r = max(0,min(255,$r - ($r*$procent/100)));
    $g = max(0,min(255,$g - ($g*$procent/100)));  
    $b = max(0,min(255,$b - ($b*$procent/100)));

    return '#'.str_repeat("0", 2-strlen(dechex($r))).dechex($r).str_repeat("0", 2-strlen(dechex($g))).dechex($g).str_repeat("0", 2-strlen(dechex($b))).dechex($b);
  }
}

if(!function_exists('lighten')){

    function lighten($colourstr, $procent=0){

      $colourstr = str_replace('#','',$colourstr);
      $rhex = substr($colourstr,0,2);
      $ghex = substr($colourstr,2,2);
      $bhex = substr($colourstr,4,2);

      $r = hexdec($rhex);
      $g = hexdec($ghex);
      $b = hexdec($bhex);

      $r = max(0,min(255,$r + ($r*$procent/100)));
      $g = max(0,min(255,$g + ($g*$procent/100)));  
      $b = max(0,min(255,$b + ($b*$procent/100)));

      return '#'.str_repeat("0", 2-strlen(dechex($r))).dechex($r).str_repeat("0", 2-strlen(dechex($g))).dechex($g).str_repeat("0", 2-strlen(dechex($b))).dechex($b);
    }

}

function get_carousel_preview($option=array(),$value=''){

    $dependency=create_dependency_param($option);
    $output='<div class="carousel-preview" '.$dependency.'>
    <div class="owl-pagination">
    <div class="owl-page active"><span></span></div>
    <div class="owl-page"><span></span></div>
    <div class="owl-page"><span></span></div>
    </div>
    </div>';
    print $output;


}
add_dt_field_type('carousel_preview','get_carousel_preview');

function dt_remove_autop($content) {

  return preg_replace('/<\/?p\>/', "", $content);
}

function dt_remove_wpautop($content) {
  return wpautop(preg_replace('/<\/?p\>/', "", $content)."");
}

if(!function_exists('dt_exctract_icon')){

  function dt_exctract_icon($file="",$pref=""){

    $wp_filesystem=new WP_Filesystem_Direct(array());

    if(!$wp_filesystem->is_file($file) || !$wp_filesystem->exists($file))
        return false;

     if ($buffers=$wp_filesystem->get_contents_array($file)) {
       $icons=array();

      foreach ($buffers as $line => $buffer) {

        if(preg_match("/^(\.".$pref.")([^:\]\"].*?):before/i",$buffer,$out)){

          if($out[2]!==""){
              $icons[$pref.$out[2]]=$pref.$out[2];
          }
        }
      }
      return $icons;

    }else{

      return false;
    }
  }
}

function get_font_lists($path){

  $wp_filesystem=new WP_Filesystem_Direct(array());

  $icons=array();
  if($dirlist=$wp_filesystem->dirlist($path)){
    foreach ($dirlist as $dirname => $dirattr) {

       if($dirattr['type']=='d'){
          if($dirfont=$wp_filesystem->dirlist($path.$dirname)){
            foreach ($dirfont as $filename => $fileattr) {
              if(preg_match("/(\.css)$/", $filename)){
                if($icon=dt_exctract_icon($path.$dirname."/".$filename)){

                  $icons=@array_merge($icon,$icons);
                }
                break;
              }
             
            }
          }
        }
        elseif($dirattr['type']=='f' && preg_match("/(\.css)$/", $dirname)){

          if($icon=dt_exctract_icon($path.$dirname)){
              $icons=@array_merge($icon,$icons);
          }

      }

    }
  }
  return $icons;
}


function get_dt_plugin_dir_url(){
  return plugins_url( '/detheme_builder/');
}

function detheme_font_list(){

  $path=DTPB_DIR."webicons/";

  $icons=array();
  if($newicons=get_font_lists($path)){
    $icons=array_merge($icons,$newicons);
  }

  return apply_filters('detheme_font_list',$icons);
}

if(! function_exists('is_assoc_array')){
  function is_assoc_array(array $array){

    $keys = array_keys($array);
    return array_keys($keys) !== $keys;
  }
}
?>

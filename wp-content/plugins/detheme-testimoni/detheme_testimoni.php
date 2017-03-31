<?php
/*
Plugin Name: Detheme Testimonials
Plugin URI: http://www.detheme.com/
Description: Add testimonial custom post
Version: 1.0.0
Author: detheme.com
Author URI: http://www.detheme.com/
Domain Path: /languages/
Text Domain: detheme
*/

class detheme_testimoni{

    function init(){

    load_plugin_textdomain('testimonials', false, dirname(plugin_basename(__FILE__)) . '/languages/');

    register_post_type('testimonials', array(
            'label' => __('Testimonials', 'detheme'),
            'public' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'rewrite' => array(
                'slug' => 'testimonials',
                'with_front' => false
            ),
            'hierarchical' => true,
            'menu_position' => 6,
            'supports' => array(
                'title',
                'editor',
                'thumbnail')

        )

    );

    add_filter("manage_edit-testimonials_columns", array($this,'show_testimonial_column'));
    add_action("manage_testimonials_posts_custom_column", array($this,"testimonial_custom_columns"));
    add_action('add_meta_boxes',array($this,'add_meta_boxes'),9999);
    add_action( 'save_post', array($this,'save_team_info') );

    }

    function add_meta_boxes(){

         add_meta_box( 'testimonial-meta-boxes', __( 'Client Information', 'detheme' ),array($this,'testimoni_meta_boxes'), 'testimonials', 'normal' );

    }

    function testimoni_meta_boxes( $post ) {


        $pagebuilder = get_post_meta($post->ID,'pagebuilder',true);

        if (!is_array($pagebuilder)) {

            $pagebuilder = array();

        }

  ?>
  <style type="text/css">
.testimonial-info label{
    display: inline-block;
    width: 30%;
    max-width: 200px;
}
.testimonial-info input{
    display: inline-block;
    width: 30%;
}
  </style>
  <?php wp_nonce_field( 'testimonial-setting','testimonial-setting');?>
                    <div class='testimonial-info'>
                        <div class="clear">
                            <label for='author' class='label_type1'><?php _e('Author','detheme');?>:</label> <input type='text' value='<?php print (isset($pagebuilder['page_settings']['testimonials']['testimonials_author']) ? $pagebuilder['page_settings']['testimonials']['testimonials_author'] : '');?>' id='position_link' name='pagebuilder[page_settings][testimonials][testimonials_author]' class='author itt_type1'>
                        </div>
                        <div class="clear">
                            <label for='company' class='label_type1'><?php _e('Company','detheme');?>:</label> <input type='text' value='<?php print (isset($pagebuilder['page_settings']['testimonials']['company']) ? $pagebuilder['page_settings']['testimonials']['company'] : '');?>' id='position_link' name='pagebuilder[page_settings][testimonials][company]' class='company itt_type1'>
                        </div>
                    </div>
    <?php
    }


    function show_testimonial_column($columns)
    {

        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "image" => __("Image", 'detheme'),
            "title" => __("Title", 'detheme'),
            "author" => __("Author", 'detheme'),
            "date" => __("Date", 'detheme'));
        return $columns;
    }

    function testimonial_custom_columns($column)

    {
        global $post;
        switch ($column) {
            case "image":
                $attachment_id=get_the_post_thumbnail($post->ID,'thumbnail');
                print ($attachment_id)?$attachment_id:"";
                break;
        }
    }

    function save_team_info($post_id){

           if ( (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) || !isset($_POST['testimonial-setting']))
             return $post_id;


            if ( !current_user_can('edit_post', $post_id) || !wp_verify_nonce( isset($_POST['testimonial-setting'])?$_POST['testimonial-setting']:"", 'testimonial-setting') )
             return $post_id;


            if (!isset($_POST['pagebuilder'])) {
                $pbsavedata = array();
            } else {
                $pbsavedata = $_POST['pagebuilder'];


            }

             $old = get_post_meta( $post_id, 'pagebuilder', true );
          
             update_post_meta( $post_id, 'pagebuilder', $pbsavedata,$old );
    }
}


add_action('init', array( new detheme_testimoni(),'init'),1);
?>
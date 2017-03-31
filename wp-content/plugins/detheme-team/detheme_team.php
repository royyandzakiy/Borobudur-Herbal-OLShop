<?php
/*
Plugin Name: Detheme Team
Plugin URI: http://www.detheme.com/
Description: Add team custom post
Version: 1.0.0
Author: detheme.com
Author URI: http://www.detheme.com/
Domain Path: /languages/
Text Domain: detheme
*/

class detheme_team{

    function init(){

    load_plugin_textdomain('detheme', false, dirname(plugin_basename(__FILE__)) . '/languages/');

    register_post_type('team', array(
            'label' => __('Team', 'detheme'),
            'public' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'rewrite' => array(
                'slug' => 'team',
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

    add_filter("manage_edit-team_columns", array($this,'show_team_column'));
    add_action("manage_team_posts_custom_column", array($this,"team_custom_columns"));
    add_action('add_meta_boxes',array($this,'add_meta_boxes'),9999);
    add_action( 'save_post', array($this,'save_team_info') );

    }

    function add_meta_boxes(){

         add_meta_box( 'team-meta-boxes', __( 'Team Information', 'detheme' ),array($this,'team_meta_boxes'), 'team', 'normal' );

    }

    function team_meta_boxes( $post ) {


        $pagebuilder = get_post_meta($post->ID,'pagebuilder',true);

        if (!is_array($pagebuilder)) {

            $pagebuilder = array();

        }


        $socials=array(
            'twitter'=>array('link'=>'','data-icon-code'=>'icon-twitter','name'=>__('Twitter', 'detheme')),
            'linkedin'=>array('link'=>'','data-icon-code'=>'icon-linkedin','name'=>__('Linkedin', 'detheme')),
            'google'=>array('link'=>'','data-icon-code'=>'icon-gplus','name'=>__('Google', 'detheme')),
            'facebook'=>array('link'=>'','data-icon-code'=>'icon-facebook','name'=>__('Facebook', 'detheme')),
            'email'=>array('link'=>'','data-icon-code'=>'icon-mail-alt','name'=>__('Email', 'detheme')),
            'website'=>array('link'=>'','data-icon-code'=>'icon-globe','name'=>__('Website', 'detheme'))
        );
  ?>
  <style type="text/css">
.team-info label{
    display: inline-block;
    width: 30%;
    max-width: 200px;
}
.team-info input{
    display: inline-block;
    width: 30%;
}
  </style>
  <?php wp_nonce_field( 'team-setting','team-setting');?>

                    <div class='team-info'>
                        <label for='position_link' class='label_type1'><?php _e('Position','detheme');?>:</label> <input type='text' value='<?php print (isset($pagebuilder['page_settings']['team']['position']) ? $pagebuilder['page_settings']['team']['position'] : '');?>' id='position_link' name='pagebuilder[page_settings][team][position]' class='position_link itt_type1'>
                        <div>
                            <div style='vertical-align:top;font-weight:bold;margin-top:5px;'><?php _e('Social Link', 'detheme');?></div>
<?php                               foreach ($socials as $key => $social) {
                                        echo "
                                        <div class='clear' style='margin:5px 5px 0px 0px;'>
                                        <label  class='stand_icon-container'>".$social['name']."</label>
                                            <input type='hidden' name='pagebuilder[page_settings][icons][".$key."][data-icon-code]' value='".$social['data-icon-code']."'>
                                            <input class='icon_name' type='hidden' name='pagebuilder[page_settings][icons][".$key."][name]' value='".$key."' '>
                                            <input class='icon_link itt_type1' type='text' name='pagebuilder[page_settings][icons][".$key."][link]' value='".((isset($pagebuilder['page_settings']['icons'][$key]['link']))?$pagebuilder['page_settings']['icons'][$key]['link']:"")."' placeholder='" . $social['name'] . "'>
                                        </div>";



                                    # code...

                                }
                                ?>
                       </div>
                    </div>
    <?php
    }


    function show_team_column($columns)
    {

        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "image" => __("Image", 'detheme'),
            "title" => __("Title", 'detheme'),
            "author" => __("Author", 'detheme'),
            "date" => __("Date", 'detheme'));
        return $columns;
    }

    function team_custom_columns($column)

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

           if ( (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) || !isset($_POST['team-setting']))
             return $post_id;


            if ( !current_user_can('edit_post', $post_id) || !wp_verify_nonce( isset($_POST['team-setting'])?$_POST['team-setting']:"", 'team-setting') )
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


add_action('init', array( new detheme_team(),'init'),1);
?>
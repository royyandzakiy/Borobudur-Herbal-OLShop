<?php
defined('ABSPATH') or die();

/*
Plugin Name: Detheme Portfolio
Plugin URI: http://www.detheme.com/
Description: Add portfolio custom post
Version: 1.0.6
Author: detheme.com
Author URI: http://www.detheme.com/
*/


class detheme_portfolio{

    var $predefineField=array('project button label','project link','date','website','client');

    function init(){

    load_plugin_textdomain('detheme', false, dirname(plugin_basename(__FILE__)) . '/languages/');

    $admin      = get_role('administrator');
    $admin-> add_cap( 'portfolio_setting' );


    $portfolio_settings_default=array(
            'labels' => array(
                'name' => __('Portfolios', 'detheme'),
                'singular_name' => __('Portfolio', 'detheme'),
                'add_new' => __('Add New', 'detheme')
            ),
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'rewrite' => array(
                'slug' => 'portfolio',
                'with_front' => false
            ),
            'has_archive'=>true,
            'taxonomies'=>array('post_tag'),
            'hierarchical' => true,
            'menu_position' => 5,
            'supports' => array(
                'title',
                'comments',
                'page-attributes',
                'custom-fields',
                'editor',
                'excerpt',
                'thumbnail'
            )
    );

    $portfolio_settings=get_option('dt_portfolio_settings');
    if(!$portfolio_settings){
        update_option('dt_portfolio_settings',$portfolio_settings_default);

    }else{


        $portfolio_settings=wp_parse_args($portfolio_settings,$portfolio_settings_default);
    }



    if(wp_verify_nonce( isset($_POST['portfolio-setting'])?$_POST['portfolio-setting']:"", 'portfolio-setting')){

         $portfolio_name=(isset($_POST['portfolio_name']))?$_POST['portfolio_name']:'';
         $singular_name=(isset($_POST['singular_name']))?$_POST['singular_name']:'';
         $rewrite_slug=(isset($_POST['portfolio_slug']))?$_POST['portfolio_slug']:'';

         $do_update=false;

         if($portfolio_name!=$portfolio_settings['labels']['name'] && ''!=$portfolio_name){
            $portfolio_settings['labels']['name']=$portfolio_name;
            $do_update=true;
         }

         if($singular_name!=$portfolio_settings['labels']['singular_name'] && ''!=$singular_name){
            $portfolio_settings['labels']['singular_name']=$singular_name;
            $do_update=true;
           
         }

         if($rewrite_slug!=$portfolio_settings['rewrite']['slug'] && ''!=$rewrite_slug){
            $portfolio_settings['rewrite']['slug']=$rewrite_slug;
            $do_update=true;
           
         }

         if($do_update){
             update_option('dt_portfolio_settings',$portfolio_settings);
         }

    }


    register_post_type('port', $portfolio_settings);
    register_taxonomy('portcat', 'port', array('hierarchical' => true, 'label' => sprintf(__('%s Category', 'detheme'),$portfolio_settings['labels']['singular_name']), 'singular_name' => __('Category')));

    add_filter("manage_edit-port_columns", array($this,'show_portfolio_column'));
    add_action("manage_port_posts_custom_column", array($this,"port_custom_columns"));
    add_action('template_redirect', array($this, 'loadTemplate'),100);
    add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 30 );
    add_action( 'save_post', array($this,'save_project_link') );
    add_action('admin_menu', array($this,'register_submenu_page'));

    }

    function register_submenu_page(){

    add_submenu_page( 'edit.php?post_type=port', __('Portfolio Settings', 'detheme'), __('Settings', 'detheme'),'portfolio_setting','portfolio-setting', array($this,'portfolio_setting'));


    }

    function portfolio_setting(){


    $portfolio_settings=get_option('dt_portfolio_settings');

    $args = array( 'page' => 'portfolio-setting');
    $url = add_query_arg( $args, admin_url( 'admin.php' ));

    $portfolio_name=$portfolio_settings['labels']['name'];
    $singular_name=$portfolio_settings['labels']['singular_name'];
    $slug=$portfolio_settings['rewrite']['slug'];
?>
<div class="portfolio-panel">
<h2><?php printf(__('%s Settings', 'detheme'),ucwords($portfolio_name));?></h2>
<form method="post" action="<?php print $url;?>">
<?php wp_nonce_field( 'portfolio-setting','portfolio-setting');?>
<input name="option_page" value="reading" type="hidden"><input name="action" value="update" type="hidden">
<table class="form-table">
<tbody>
<tr>
<th scope="row"><label for="portfolio_name"><?php _e('Label Name','detheme');?></label></th>
<td>
<input name="portfolio_name" id="portfolio_name" max-length="50" value="<?php print $portfolio_name;?>" class="" type="text"></td>
</tr>
<tr>
<th scope="row"><label for="singular_name"><?php _e('Singular Name','detheme');?></label></th>
<td>
<input name="singular_name" id="singular_name" max-length="50" value="<?php print $singular_name;?>" class="" type="text"></td>
</tr>
<tr>
<th scope="row"><label for="portfolio_slug"><?php _e('Rewrite Slug','detheme');?></label></th>
<td>
<input name="portfolio_slug" id="portfolio_slug" max-length="50" value="<?php print $slug;?>" class="" type="text"></td>
</tr>
</tbody></table>


<p class="submit"><input name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes');?>" type="submit"></p></form>
</div>
<?php
    }

    function add_meta_boxes(){

    global $wpdb;

    $predefineField=(array)$this->predefineField;

    $keys = $wpdb->get_col( "
        SELECT LOWER(meta_key)
        FROM $wpdb->postmeta
        GROUP BY meta_key
        HAVING meta_key NOT LIKE '\_%'
        ORDER BY meta_key");
    if ( $keys )
        natcasesort($keys);

    if(count($predefineField)){

        foreach($predefineField as $field){
            if(!in_array(strtolower($field), $keys)){

                add_post_meta( 999999, $field, '' );

            }
        }



    }


    }

    function save_project_link($post_id){

            if ( (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) || !isset($_POST['port_project_link']))
             return $post_id;

             if ( ! wp_verify_nonce( $_POST['port_project_link'], basename( __FILE__ ) ) )
             return $post_id;

             $old = get_post_meta( $post_id, '_linklabel', true );
             $new = (isset($_POST['_linklabel']))?$_POST['_linklabel']:'';
             
             update_post_meta( $post_id, '_linklabel', $new,$old );

             $old = get_post_meta( $post_id, '_linkproject', true );
             $new = (isset($_POST['_linkproject']))?$_POST['_linkproject']:'';

            
             update_post_meta( $post_id, '_linkproject', $new,$old );

    }

    function post_custom_meta_box($post) {

        $linklabel = get_post_meta( $post->ID, '_linklabel', true );
        $linkproject = get_post_meta( $post->ID, '_linkproject', true );


    ?>
    <input type="hidden" name="port_project_link" value="<?php print wp_create_nonce( basename( __FILE__ ) );?>" />
    <table border="0" cellpadding="0" width="100%">
        <tr>
        <td width="200"><strong><?php _e('Label','detheme') ?></strong></td>
        <td><input name="_linklabel" type="text" id="linklabel" class="widefat" value="<?php echo esc_attr( $linklabel) ?>" /></td>
        </tr>
        <tr>
        <td><strong><?php _e('Link','detheme') ?></strong></td>
        <td><input name="_linkproject" type="text" id="linkproject" class="widefat" value="<?php echo esc_attr($linkproject) ?>" /></td>
        </tr>
    </table>
    

    <?php
    }

    function portfolio_gallery_metaboxes( $post ) {
    ?>
        <div id="product_images_container">
            <ul class="product_images">
                <?php
                    if ( metadata_exists( 'post', $post->ID, '_product_image_gallery' ) ) {
                        $product_image_gallery = get_post_meta( $post->ID, '_product_image_gallery', true );
                    } else {
                        // Backwards compat
                        $attachment_ids = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids&meta_key=_woocommerce_exclude_image&meta_value=0' );
                        $attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
                        $product_image_gallery = implode( ',', $attachment_ids );
                    }

                    $attachments = array_filter( explode( ',', $product_image_gallery ) );

                    if ( $attachments )
                        foreach ( $attachments as $attachment_id ) {
                            echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
                                ' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '
                                <ul class="actions">
                                    <li><a href="#" class="delete tips" data-tip="' . __( 'Delete image', 'woocommerce' ) . '">' . __( 'Delete', 'woocommerce' ) . '</a></li>
                                </ul>
                            </li>';
                        }
                ?>
            </ul>

            <input type="hidden" id="product_image_gallery" name="product_image_gallery" value="<?php echo esc_attr( $product_image_gallery ); ?>" />

        </div>
        <p class="add_product_images hide-if-no-js">
            <a href="#" data-choose="<?php _e( 'Add Images to Product Gallery', 'woocommerce' ); ?>" data-update="<?php _e( 'Add to gallery', 'woocommerce' ); ?>" data-delete="<?php _e( 'Delete image', 'woocommerce' ); ?>" data-text="<?php _e( 'Delete', 'woocommerce' ); ?>"><?php _e( 'Add product gallery images', 'woocommerce' ); ?></a>
        </p>
        <?php
    }


    function show_portfolio_column($columns)
    {

        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "image" => __("Image", 'detheme'),
            "title" => __("Title", 'detheme'),
            "author" => __("Author", 'detheme'),
            "portfolio-category" => __("Categories", 'detheme'),
            "date" => __("Date", 'detheme'));
        return $columns;
    }

    function port_custom_columns($column)

    {

        global $post;
        switch ($column) {
            case "portfolio-category":
                echo get_the_term_list($post->ID, 'portcat', '', ', ', '');
                break;
            case "image":
                $attachment_id=get_the_post_thumbnail($post->ID,'thumbnail');
                print ($attachment_id)?$attachment_id:"";
                break;
        }
    }


    function loadTemplate(){

    global $post;

    if(!isset($post))
        return true;

    $standard_type=$post->post_type;

    if(is_single() && $standard_type == 'port') {
       $templateName='port';
    }
    else{
        return true;
    }

        if ( $templateName ) {
            $template = locate_template( array( "{$templateName}.php", "templates/detheme/{$templateName}.php" ),false );
        }

        // Get default slug-name.php
        if ( ! $template && $templateName && file_exists( plugin_dir_path(__FILE__). "/templates/{$templateName}.php" ) ) {
            $template = locate_template(plugin_dir_path(__FILE__). "/templates/{$templateName}.php",false);
        }

        // Allow 3rd party plugin filter template file from their plugin
        $template = apply_filters( 'detheme_get_template_part', $template,$templateName );

        if ( $template ) {
            load_template( $template, false );
            exit;
        }

    }

}
add_action('init', array(new detheme_portfolio(),'init'),1);
?>
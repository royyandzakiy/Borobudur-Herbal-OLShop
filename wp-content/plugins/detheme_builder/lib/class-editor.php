<?php
defined('DTPB_BASENAME') or die();


class dt_Builder_Editor {

  function __construct() {

  }

  function render(){

    $builder_settings = apply_filters('detheme_builder_settings',get_option('detheme_builder_settings',array('page')));
    if(empty($builder_settings)) $builder_settings=array();

    foreach ($builder_settings as $posttype) {
      add_meta_box( 'dtbuilder', __( 'deTheme Builder', 'detheme_builder' ), array($this,'render_page_metabox'), $posttype, 'advanced', 'high' );
    }
    
    add_action( 'save_post', array($this,'save_custom_css'));
  }

  function save_custom_css($post_id){

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    $builder_settings = apply_filters('detheme_builder_settings',get_option('detheme_builder_settings',array('page')));

    if(!wp_verify_nonce( isset($_POST['dtbuilder_save_custom_css'])?$_POST['dtbuilder_save_custom_css']:"", 'dtbuilder_save_custom_css') || !in_array(get_post_type(),$builder_settings))
        return;

     $old = get_post_meta( $post_id, '_dtbuilder_custom_css', true );
     $new = (isset($_POST['dtbuilder_custom_css']))?$_POST['dtbuilder_custom_css']:'';
     update_post_meta( $post_id, '_dtbuilder_custom_css', $new,$old );
  }

  function render_page_metabox($post){


   wp_enqueue_script( 'jquery-ui-core' );
   wp_enqueue_script( 'jquery-ui-sortable' );
   wp_enqueue_script( 'jquery-ui-draggable' );
   wp_enqueue_script( 'jquery-ui-droppable' );
   wp_enqueue_script( 'jquery-ui-resizable' );

    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('iris');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('page-editor',get_dt_plugin_dir_url().'lib/js/editor.min.js',array('jquery','media-views', 'media-editor'));
    wp_enqueue_script('page-editor-custom',get_dt_plugin_dir_url().'lib/js/backend.js',array('page-editor'));
    wp_enqueue_script('icon_picker',get_dt_plugin_dir_url().'lib/js/icon_picker.js',array('jquery'));

    wp_localize_script( 'icon_picker', 'picker_i18nLocale', array(
      'search_icon'=>__('Search Icon','detheme_builder'),
    ) );


    wp_enqueue_style('icon_picker-font',get_dt_plugin_dir_url()."lib/css/fontello.css");
    wp_enqueue_style('page-editor',get_dt_plugin_dir_url().'lib/css/editor.css','');
    wp_enqueue_style('flaticon-font',get_dt_plugin_dir_url().'lib/css/flaticon.css','');
    wp_enqueue_style('jquery-ui-resizable',get_dt_plugin_dir_url().'lib/css/jquery-ui-resizable.css','');

    do_action('webfonts-font-loaded');

    wp_localize_script( 'page-editor', 'dtb_i18nLocale', array(
      'move_this_element' => __('Move this element','detheme_builder'),
      'edit_title_panel'=>__('Edit','detheme_builder'),
      'close'=>__('Close','detheme_builder'),
      'save'=>__('Save','detheme_builder'),
      'cancel'=>__('Cancel','detheme_builder'),
      'select_image'=>__('Select Image','detheme_builder'),
      'insert_image'=>__('Insert Image','detheme_builder'),
      'custom_css_title'=>__('Custom CSS','detheme_builder'),
      'show_shortcode_title'=>__('Element Shortcode','detheme_builder'),
      'add_shortcode_title'=>__('Add Shortcode','detheme_builder'),
      'are_you_sure_delete_confirmation'=>__('Are you sure delete this element','detheme_builder'),
      'are_you_sure_delete_column_confirmation'=>__('Are you sure delete this column','detheme_builder'),
      'column_canot_delete'=>__('This column can\'t delete','detheme_builder'),
      'custom_column_placeholder'=>__('4 4 4 Total=12','detheme_builder'),
      'insert_video'=>__('Insert Video','detheme_builder'),
      'select_video'=>__('Select Video','detheme_builder'),
      'click_to_toggle'=>__('Click to toggle row','detheme_builder'),
      'row'=>__('Row','detheme_builder'),
      'classic_editor'=>__('Classic Editor','detheme_builder')
    ) );
   
    $elements=get_dt_elements();
    $elements=apply_filters('allowed_element_in_post',$elements);

    $custom_css =  get_post_meta($post->ID, '_dtbuilder_custom_css', true);

    wp_nonce_field( 'dtbuilder_save_custom_css','dtbuilder_save_custom_css');

    ?>
    <div id="dtduilder_wrap" style="display:none">
    <textarea id="dtbuilder_custom_css_field" style="display:none" name="dtbuilder_custom_css"><?php print htmlspecialchars($custom_css);?></textarea>
    <div class="element-builders">
       <div class="element-builder element-row" data-tag="dt_row" data-column="12">
          <div class="element-holder dragger"><i class="dashicons dashicons-editor-justify"></i><?php _e('Row','detheme_builder');?></div>
           <div class="element-toolbar">
            <div class="toolbar-panel-left">
              <div class="element-holder"><i title="<?php _e('Move this row','detheme_builder');?>" class="flaticon-pointer2"></i></div>
              <div class="toolbar row-selection">
                <div class="select-column">
                  <div title="<?php _e('Change column','detheme_builder');?>" class="dashicons dashicons-menu"></div>
                </div>
                <ul class="option-column-group">
                  <li class="option-column"><a href="#" class="column_1" data-column="12"><span></span></a></li>
                  <li class="option-column"><a href="#" class="column_2" data-column="6 6"><span></span><span></span></a></li>
                  <li class="option-column"><a href="#" class="column_3" data-column="4 4 4"><span></span><span></span><span></span></a></li>
                  <li class="option-column"><a href="#" class="column_4" data-column="3 3 3 3"><span></span><span></span><span></span><span></span></a></li>
                  <li class="option-column"><a href="#" class="column_6" data-column="2 2 2 2 2 2"><span></span><span></span><span></span><span></span><span></span><span></span></a></li>
                  <li class="option-column"><a href="#" class="column_custom"><?php _e('Custom','detheme_builder');?></a></li>
                </ul>
              </div>
              <div class="toolbar element-shortcode"><a title="<?php _e('Show this shortcode','detheme_builder');?>" href="#">&lt;/&gt;</a></div>
              <div class="toolbar element-setting" data-title="<?php _e('Row','detheme_builder');?>"><a title="<?php _e('Edit this row','detheme_builder');?>" href="#">
                <div class="dashicons dashicons-admin-generic"></div></a>
              </div>
            </div>
            <ul class="toolbar-panel-right">
              <li class="toolbar element-copy"><a title="<?php _e('Copy this row','detheme_builder');?>" href="#"><div class="dashicons dashicons-admin-page"></div></a></li>
              <li class="toolbar element-delete"><a title="<?php _e('Delete this row','detheme_builder');?>" href="#"><div class="dashicons dashicons-no-alt"></div></a></li>
              <li class="toolbar element-up"><a title="<?php _e('Move up this row','detheme_builder');?>" href="#"><div class="dashicons dashicons-arrow-up-alt"></div></a></li>
              <li class="toolbar element-down"><a title="<?php _e('Move down this row','detheme_builder');?>" href="#"><div class="dashicons dashicons-arrow-down-alt"></div></a></li>
            </ul>
          </div>
          <div class="open-tag render-tag">[dt_row]</div>
          <div class="column-container">
            <div class="element-builder element-column col-12" data-column="12" data-tag="dt_column">
              <div class="toolbar element-setting" data-title="<?php _e('Column','detheme_builder');?>"><a title="<?php _e('Edit this column','detheme_builder');?>" href="#"><div class="dashicons dashicons-admin-generic"></div></a></div>
              <div class="toolbar element-addshortcode"><a title="<?php _e('Add shortcode to this column','detheme_builder');?>" href="#"><div class="dashicons dashicons-welcome-edit-page"></div></a></div>
              <div class="toolbar element-delete-column"><a title="<?php _e('Delete this column','detheme_builder');?>" href="#"><div class="dashicons dashicons-trash"></div></a></div>
              <div class="open-tag render-tag">[dt_column]</div>
              <div class="element-content dropable-element"></div>
              <div class="close-tag render-tag">[/dt_column]</div>
            </div>
          </div>
        <div class="close-tag render-tag">[/dt_row]</div>
      </div>
      <?php 
      if(count($elements)):

      foreach ($elements as $tag => $element) {

          if(in_array($tag,array('dt_row','dt_column','dt_inner_row','dt_inner_column','dt_inner_row_1','dt_inner_column_1','dt_inner_row_2','dt_inner_column_2')))
            continue;

          $settings=$element->getSettings();
          $element_options=$element->getConfigs();

          if($settings['is_container']){?>

      <div class="element-builder element-container element-<?php print $tag;print ($settings['show_on_create'])?" show-create":"";?>" data-tag="<?php print $tag;?>">
        <div class="element-holder dragger"><i class="dashicons <?php print $settings['icon']!=''?$settings['icon']:'dashicons-media-default';?>"></i><?php print $settings['title'];?></div>
        <div class="element-panel">
         <div class="element-toolbar">
            <div class="element-holder-label"><?php print $settings['title'];?></div>
            <div class="toolbar element-setting" data-title="<?php print $settings['title'];?>"><a title="<?php _e('Edit this element','detheme_builder');?>" href="#"><div class="dashicons dashicons-edit"></div></a></div>
            <div class="toolbar element-shortcode"><a title="<?php _e('Show this shortcode','detheme_builder');?>" href="#">&lt;/&gt;</a></div>
            <div class="toolbar element-copy"><a title="<?php _e('Copy this element','detheme_builder');?>"  href="#"><div class="dashicons dashicons-admin-page"></div></a></div>
            <div class="toolbar element-delete"><a title="<?php _e('Delete this element','detheme_builder');?>"  href="#"><div class="dashicons dashicons-no-alt"></div></a></div>
         </div>
        </div>
        <div class="open-tag render-tag">[<?php print $tag;?>]</div>
         <div class="element-content dropable-element"></div>
        <div class="close-tag render-tag">[/<?php print $tag;?>]</div>
       </div>


          <?php }
          elseif($settings['as_parent'] && ''!=$settings['as_parent']){
            ?>
      <div class="element-builder element-parent element-<?php print $tag;print ($settings['show_on_create'])?" show-create":"";?>" data-child="<?php print (is_array($settings['as_parent']))?@implode(",",$settings['as_parent']):$settings['as_parent'];?>" data-tag="<?php print $tag;?>">
        <div class="element-holder dragger"><i class="dashicons <?php print $settings['icon']!=''?$settings['icon']:'dashicons-media-default';?>"></i><?php print $settings['title'];?></div>
        <div class="element-panel">
        <div class="element-holder-label"><?php print $settings['title'];?></div>
        <div class="children-toolbar">
          <?php if(is_array($settings['as_parent'])):

              foreach($settings['as_parent'] as $child){

                if(isset($elements[$child])){

                  $childElement=$elements[$child];
                  $childSettings=$childElement->getSettings();

                  print '<div class="toolbar"><a title="'.sprintf(__('Add %s','detheme_builder'),$childSettings['title']).'"  href="#" data-child="'.$child.'"><div class="dashicons dashicons-plus-alt"></div> '.$childSettings['title'].'</a></div>';

                }
              }
          ?>
            <?php else:

             if(isset($elements[$settings['as_parent']])){

                  $childElement=$elements[$settings['as_parent']];
                  $childSettings=$childElement->getSettings();
                  print '<div class="toolbar"><a title="'.sprintf(__('Add %s','detheme_builder'),$childSettings['title']).'"  href="#" data-child="'.$settings['as_parent'].'"><div class="dashicons dashicons-plus-alt"></div> '.$childSettings['title'].'</a></div>';
                }
            ?>

          <?php endif;?>
         </div>
         <div class="element-toolbar">
          <div class="toolbar element-setting" data-title="<?php print $settings['title'];?>"><a title="<?php _e('Edit this element','detheme_builder');?>" href="#"><div class="dashicons dashicons-edit"></div></a></div>
          <div class="toolbar element-shortcode"><a title="<?php _e('Show this shortcode','detheme_builder');?>" href="#">&lt;/&gt;</a></div>
          <div class="toolbar element-copy"><a title="<?php _e('Copy this element','detheme_builder');?>" href="#"><div class="dashicons dashicons-admin-page"></div></a></div>
          <div class="toolbar element-delete"><a title="<?php _e('Delete this element','detheme_builder');?>" href="#"><div class="dashicons dashicons-no-alt"></div></a></div>
        </div>
      </div>
        <div class="open-tag render-tag">[<?php print $tag;?>]</div>
        <div class="element-content dropable-element"></div>
        <div class="close-tag render-tag">[/<?php print $tag;?>]</div>
       </div>

      <?php
          }
          elseif($settings['as_child'] && ''!=$settings['as_child']){
        ?>

      <div style="display:none" class="element-builder element-child element-<?php print $tag; print ($settings['show_on_create'])?" show-create":"";?>" data-parent="<?php print $settings['as_child'];?>" data-tag="<?php print $tag;?>">
        <div class="element-holder"><i title="<?php _e('Move this element','detheme_builder');?>" class="flaticon-pointer2"></i></div>
        <div class="element-toolbar element-panel">
          <div class="element-holder-label"><?php print $settings['title'];?></div>
          <div class="toolbar element-setting" data-title="<?php print $settings['title'];?>"><a title="<?php _e('Edit this element','detheme_builder');?>" href="#"><div class="dashicons dashicons-edit"></div></a></div>
          <div class="toolbar element-copy"><a title="<?php _e('Copy this element','detheme_builder');?>" href="#"><div class="dashicons dashicons-admin-page"></div></a></div>
          <div class="toolbar element-delete"><a title="<?php _e('Delete this element','detheme_builder');?>" href="#"><div class="dashicons dashicons-no-alt"></div></a></div>
        </div>
        <div class="open-tag render-tag">[<?php print $tag;?>]</div>
        <textarea class="content-tag render-tag"><?php print isset($element_options['content']) ? $element_options['content']:"";?></textarea>
        <div class="close-tag render-tag">[/<?php print $tag;?>]</div>
       </div>


         <?php
          }
          else{

          ?>
      <div class="element-builder element-frebase element-<?php print $tag; print ($settings['show_on_create'])?" show-create":""; ?>" data-tag="<?php print $tag;?>">
        <div class="element-holder dragger"><i class="dashicons <?php print $settings['icon']!=''?$settings['icon']:'dashicons-media-default';?>"></i><?php print $settings['title'];?></div>
          <div class="element-panel">
            <div class="element-holder-label"><?php print $settings['title'];?></div>
            <div class="element-toolbar">
              <div class="toolbar element-setting" data-title="<?php print $settings['title'];?>"><a title="<?php _e('Edit this element','detheme_builder');?>" href="#"><div class="dashicons dashicons-edit"></div></a></div>
              <div class="toolbar element-shortcode"><a title="<?php _e('Show this shortcode','detheme_builder');?>" href="#">&lt;/&gt;</a></div>
              <div class="toolbar element-copy"><a title="<?php _e('Copy this element','detheme_builder');?>" href="#"><div class="dashicons dashicons-admin-page"></div></a></div>
              <div class="toolbar element-delete"><a title="<?php _e('Delete this element','detheme_builder');?>" href="#"><div class="dashicons dashicons-no-alt"></div></a></div>
            </div>
          </div>
        <div class="element-preview"><?php print $element->preview_admin();?></div>
        <div class="open-tag render-tag">[<?php print $tag;?>]</div>
        <textarea class="content-tag render-tag"><?php print isset($element_options['content']) ? $element_options['content']:"";?></textarea>
        <div class="close-tag render-tag">[/<?php print $tag;?>]</div>
       </div>
        <?php }
        }

         ?>

    

    <?php endif;?>
    </div>
    <?php 



    $content=$post->post_content;

    foreach ($elements as $tag => $element) {
       $regexshortcodes=$element->getRegex();
       $content= preg_replace_callback( '/' . $regexshortcodes . '/s',array( $element, 'do_shortcode_tag' ), $content );

    }

    if($content==$post->post_content){

      $content='[dt_row][dt_column column="12"]'.($content!=''?'[dt_text_html]'.$content.'[/dt_text_html]':'').'[/dt_column][/dt_row]';

      foreach ($elements as $tag => $element) {
         $regexshortcodes=$element->getRegex();
         $content= preg_replace_callback( '/' . $regexshortcodes . '/s',array( $element, 'do_shortcode_tag' ), $content );
      }

    }

    ?>
     <div class="dt-editor-container">
      <a id="dtbuilder_custom_css_edit" class="btn" href="#">&lt;/&gt;CSS</a>
        <div class="dt-editor-work">
          <?php print $content;?>
        </div>
        <div class="page_bottom_toolbar">
          <a class="add-page-shortcode" title="<?php _e('Add shortcode to this page','detheme_builder');?>" href="#"><span class="dashicons dashicons-welcome-edit-page"></span></a>
        </div>
      </div>
   </div>
    <?php
  }

}

?>

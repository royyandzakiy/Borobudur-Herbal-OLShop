<?php
/**
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 1.0.0
 * @version 3.0.0
 */

defined('ABSPATH') or die();

add_filter('wp_nav_menu_objects','mainNavFilter');

add_filter('nav_menu_link_attributes','formatMenuAttibute',2,2);


add_action( 'save_post', 'save_boxsize_metaboxes' );
add_action( 'save_post', 'save_sidebar_metaboxes' );
add_action( 'save_post', 'save_krpton_comment_metaboxes' );


add_action('post_comment_status_meta_box-options','add_krypton_comment_option');

add_filter( 'admin_post_thumbnail_html', 'show_box_portfolio',1,2);

function add_krypton_comment_option($post=null){

    if($post):


    $showSocial = get_post_meta( $post->ID, 'show_social', true );
    $showComment = get_post_meta( $post->ID, 'show_comment', true );


    print "<br/><label for=\"show_comment\" class=\"selectit\"><input name=\"show_comment\" type=\"checkbox\" id=\"show_comment\" value=\"yes\" ".checked($showComment, 'yes',false)." /> ".
    __( 'Hide Comment','krypton' )."</label>";

    print "<br/><label for=\"show_social\" class=\"selectit\"><input name=\"show_social\" type=\"checkbox\" id=\"show_social\" value=\"yes\" ".checked($showSocial, 'yes',false)." /> ".
    __( 'Hide Social Share','krypton' )."</label>";


    endif;

}


function save_krpton_comment_metaboxes($post_id){

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

     $old = get_post_meta( $post_id, 'show_comment', true );
     $new = (isset($_POST['show_comment']))?$_POST['show_comment']:'';
     
     update_post_meta( $post_id, 'show_comment', $new,$old );
     
     $old = get_post_meta( $post_id, 'show_social', true );
     $new = (isset($_POST['show_social']))?$_POST['show_social']:'';
     
     update_post_meta( $post_id, 'show_social', $new,$old );

}

function show_box_portfolio($content,$posid){

    $post = get_post( $posid );
    $metabox="";

    if("port"==$post->post_type || "portfolio"==$post->post_type){

    $orientations=array('square','big square','portrait','landscape');


    $boxsize = get_post_meta( $post->ID, 'post_box_size', true );
    $mediatype = get_post_meta( $post->ID, 'mediatype', true );
    
    $metabox .= '<input type="hidden" name="post_box_size" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';
    $metabox .= '<label for="boxsize">'.__('Image Orientation','Krypton').' :</label>';
    $metabox .="<select id=\"boxsize\" name=\"boxsize\">";
    $metabox .="<option value=\"\">".__('Default','Krypton')."</option>";
    
    foreach($orientations as $orientation){
        $metabox .="<option value=\"".$orientation."\" ".(($orientation==$boxsize)?"selected=\"selected\"":"").">".__(ucwords($orientation),'Krypton')."</option>";
    }
    
    $metabox .="</select>";

    $metabox.='<p><strong>'.__('Media Gallery','Krypton').'</strong></p>';
    $metabox.='<p>'.__( 'Select Layout :', 'Krypton' ).'&nbsp;
      <select name="mediatype" id="mediatype">
        <option value="1"'.(("1"==$mediatype || empty($mediatype) || !isset($mediatype))?" selected":"").'>'.__('Default','Krypton').'</option>
        <option value="2"'.(("2"==$mediatype)?" selected":"").'>'.__('Carousel','Krypton').'</option>
      </select>
</p>';


    }


    return $content.$metabox;
}


function save_sidebar_metaboxes($post_id){

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

     $old = get_post_meta( $post_id, 'sidebar_position', true );
     $new = (isset($_POST['sidebar_position']))?$_POST['sidebar_position']:'';
     
     update_post_meta( $post_id, 'sidebar_position', $new,$old );

     $old = get_post_meta( $post_id, 'masonrycolumn', true );
     $new = (isset($_POST['masonrycolumn']))?$_POST['masonrycolumn']:'';
     
     update_post_meta( $post_id, 'masonrycolumn', $new,$old );

     $old = get_post_meta( $post_id, 'portfoliocolumn', true );
     $new = (isset($_POST['portfoliocolumn']))?$_POST['portfoliocolumn']:'';
     
     update_post_meta( $post_id, 'portfoliocolumn', $new,$old );

     $old = get_post_meta( $post_id, 'portfoliotype', true );
     $new = (isset($_POST['portfoliotype']))?$_POST['portfoliotype']:'';
     
     update_post_meta( $post_id, 'portfoliotype', $new,$old );

     $old = get_post_meta( $post_id, 'subtitle', true );
     $new = (isset($_POST['subtitle']))?$_POST['subtitle']:'';
     
     update_post_meta( $post_id, 'subtitle', $new,$old );

}

function save_boxsize_metaboxes( $post_id){

    if(!isset($_POST['post_box_size']))
            return $post_id;
        
    if ( ! wp_verify_nonce( $_POST['post_box_size'], basename( __FILE__ ) ) )
        return $post_id;

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

     $old = get_post_meta( $post_id, 'post_box_size', true );
     $new = $_POST['boxsize'];
     
     update_post_meta( $post_id, 'post_box_size', $new,$old );
     
     $old = get_post_meta( $post_id, 'mediatype', true );
     $new = $_POST['mediatype'];
     
     update_post_meta( $post_id, 'mediatype', $new,$old );

}


// add_meta_box('pageparentdiv', 'page' == $post_type ? __('Page Attributes') : __('Attributes'), 'page_attributes_meta_box', null, 'side', 'core');

function dtmenu_metaboxes() {

 remove_meta_box('pageparentdiv', 'page','side');

  add_meta_box('dtpageparentdiv',  __('Page Attributes','Krypton'), 'dt_page_attributes_meta_box', 'page', 'side', 'core');

}

add_action( 'admin_menu' , 'dtmenu_metaboxes' );




function dt_page_attributes_meta_box($post) {


  $post_type_object = get_post_type_object($post->post_type);
  if ( $post_type_object->hierarchical ) {
    $dropdown_args = array(
      'post_type'        => $post->post_type,
      'exclude_tree'     => $post->ID,
      'selected'         => $post->post_parent,
      'name'             => 'parent_id',
      'show_option_none' => __('(no parent)','Krypton'),
      'sort_column'      => 'menu_order, post_title',
      'echo'             => 0,
    );

    $dropdown_args = apply_filters( 'page_attributes_dropdown_pages_args', $dropdown_args, $post );
    $pages = wp_dropdown_pages( $dropdown_args );

    $sidebar_position=array('sidebar-left'=>__('Left','Krypton'),'sidebar-right'=>__('Right','Krypton'),'nosidebar'=>__('No Sidebar','Krypton'));

    if ( ! empty($pages) ) {
?>
<script type="text/javascript">
jQuery(document).ready(function($) { 
  var $select = jQuery('select#page_template'),$custommeta = jQuery('#custommeta'),$deprecatedlayout=$('#deprecated-layout');
    
  $select.live('change',function(){
    var this_value = jQuery(this).val();

    jQuery('#dt_column').css('display','none');
    
    switch ( this_value ) {
      case 'portfolio.php':
        $custommeta.find('.dt_portcolumn').fadeIn('slow');
        $custommeta.find('.dt_column').fadeOut('slow');
        $custommeta.find('.dt_portfolio').fadeIn('slow');
        $custommeta.find('#sidebar_option').fadeIn('slow');
        $deprecatedlayout.fadeIn();
        break;
      case 'blogmasonry.php':
        $custommeta.find('.dt_portcolumn').fadeOut('slow');
        $custommeta.find('.dt_column').fadeIn('slow');
        $custommeta.find('.dt_portfolio').fadeOut('slow');
        $custommeta.find('#sidebar_option').fadeIn('slow');
        $deprecatedlayout.fadeOut();
        break;
      case 'woocommerce-page-full.php':
      case 'fullwidth.php':
      case 'homepage.php':
        $custommeta.find('.dt_portcolumn').fadeOut('slow');
        $custommeta.find('.dt_column').fadeOut('slow');
        $custommeta.find('.dt_portfolio').fadeOut('slow');
        $custommeta.find('#sidebar_option').fadeOut('slow');

        if(this_value=='homepage.php'){$deprecatedlayout.fadeIn();} else{$deprecatedlayout.fadeOut();}
        break;
      default:
        $custommeta.find('.dt_portcolumn').fadeOut('slow');
         $custommeta.find('.dt_column').fadeOut('slow');
         $custommeta.find('.dt_portfolio').fadeOut('slow');
         $custommeta.find('#sidebar_option').fadeIn('slow');
         $deprecatedlayout.fadeOut();
    }
  });
  
 $select.trigger('change');

  
});

</script>
<p><strong><?php _e('Page Subtitle','Krypton') ?></strong></p>
<p><input name="subtitle" type="text" id="subtitle" class="widefat" value="<?php echo esc_attr($post->subtitle) ?>" /></p>
<p><strong><?php _e('Parent','Krypton') ?></strong></p>
<label class="screen-reader-text" for="parent_id"><?php _e('Parent','Krypton') ?></label>
<?php echo $pages; ?>
<?php
    } // end empty pages check
  } // end hierarchical check.
  if ( 'page' == $post->post_type && 0 != count( get_page_templates() ) ) {
    $template = !empty($post->page_template) ? $post->page_template : false;
 

  $templates = get_page_templates();

  if(!is_plugin_active('woocommerce/woocommerce.php') && isset($templates['Woocommerce Page'])){
    unset($templates['Woocommerce Page']);
  }

  ksort( $templates );

/**
* @deprecated portfolio.php
* @since 3.0
*/

   ?>
<p><strong><?php _e('Template','Krypton') ?></strong></p>
<label class="screen-reader-text" for="page_template"><?php _e('Page Template','Krypton'); ?></label><select name="page_template" id="page_template">
<option value='default'><?php _e('Default Template','Krypton'); ?></option>
<?php 
foreach (array_keys( $templates ) as $tmpl )
    : 

   if(($templates[$tmpl]=='portfolio.php' || $templates[$tmpl]=='homepage.php') && $template!=$templates[$tmpl])
        continue;


    if ( $template == $templates[$tmpl] )
      $selected = " selected='selected'";
    else
      $selected = '';
  echo "\n\t<option value='".$templates[$tmpl]."' $selected>$tmpl</option>";
  endforeach;
 ?>
</select>
<div id="custommeta">
<p id="deprecated-layout" style="display: none;" ><?php esc_html_e( 'This layout is deprecated and are no longer supported in newer versions of krypton wp template.', 'Krypton' ); ?></p>
<div style="margin: 13px 0 11px 4px; display: none;" class="dt_portfolio">
      <p><?php esc_html_e( 'Select Layout Type', 'Krypton' ); ?>&nbsp;
      <select name="portfoliotype" id="portfoliotype">
        <option value="1"<?php print ("1"==$post->portfoliotype || empty($post->portfoliotype) || !isset($post->portfoliotype))?" selected":"";?>><?php _e('Type 1','Krypton');?></option>;
        <option value="2"<?php print ("2"==$post->portfoliotype)?" selected":"";?>><?php _e('Type 2','Krypton');?></option>;
      </select>
</p>
</div>
<div style="margin: 13px 0 11px 4px; display: none;" class="dt_column">
      <p><?php esc_html_e( 'Select Column', 'Krypton' ); ?>&nbsp;
      <select name="masonrycolumn" id="masonrycolumn">
<?php 
for($col=3;$col<5;$col++) {
  print "<option value='".$col."'".(($post->masonrycolumn==$col)?" selected":"").">".sprintf(__('%d Column','Krypton'),$col)."</option>";
}
?>
</select>
</p>
</div>
<div style="margin: 13px 0 11px 4px; display: none;" class="dt_portcolumn">
      <p><?php esc_html_e( 'Select Column', 'Krypton' ); ?>&nbsp;
      <select name="portfoliocolumn" id="portfoliocolumn">
<?php 
for($col=4;$col<6;$col++) {
  print "<option value='".$col."'".(($post->portfoliocolumn==$col)?" selected":"").">".sprintf(__('%d Column','Krypton'),$col)."</option>";
}
?>
</select>
</p>
</div>
 <p id="sidebar_option">
  <?php _e('Sidebar Position','Krypton') ?>&nbsp;
<select name="sidebar_position" id="sidebar_position">
<option value='default'><?php _e('Default','Krypton'); ?></option>
<?php foreach ($sidebar_position as $position=>$label) {
  print "<option value='".$position."'".(($post->sidebar_position==$position)?" selected":"").">".ucwords($label)."</option>";

}?>
</select>
</p>


</div>
<?php
  } ?>
<p><strong><?php _e('Order','Krypton') ?></strong></p>
<p><label class="screen-reader-text" for="menu_order"><?php _e('Order','Krypton') ?></label><input name="menu_order" type="text" size="4" id="menu_order" value="<?php echo esc_attr($post->menu_order) ?>" /></p>
<p><?php if ( 'page' == $post->post_type ) _e( 'Need help? Use the Help tab in the upper right of your screen.','Krypton' ); ?></p>
<?php
}



function mainNavFilter($items) {



  foreach ($items as $item) {

      

      if (hasSub($item->ID, $items)) {

        $item->classes[] = 'dropdown'; 

      }

  }

    return $items;        

}





function formatMenuAttibute($atts, $item){

  global $dropdownmenu;

  if(in_array('dropdown', $item->classes)){



    $atts['class']="dropdown-toggle";

    $atts['data-toggle']="dropdown";
    $dropdownmenu=$item;



  }



  return $atts;

}



function hasSub($menu_item_id, $items) {

      foreach ($items as $item) {

        if ($item->menu_item_parent && $item->menu_item_parent==$menu_item_id) {

          return true;

        }

      }

      return false;

}



class dtmenu_walker extends Walker_Nav_Menu {



   function start_lvl(&$output, $depth=0,$args=array()) {

      global $dropdownmenu;

      $output .= "\n<ul class=\"dropdown-menu\">\n";
      $output.=(isset($dropdownmenu)?"<li><a href=\"".$dropdownmenu->url."\" class='menuTitle'>".$dropdownmenu->title."</a></li>\n":"");


      unset($dropdownmenu);



    }
    function end_lvl( &$output, $depth = 0, $args = array() ) {

       $output .= "</ul>\n";

    }

}


function dt_page_menu( $args = array() ) {

  $defaults = array('sort_column' => 'menu_order, post_title', 'menu_class' => 'menu','container_class'=>'','container'=>'div', 'echo' => true, 'link_before' => '', 'link_after' => '');

  $args = wp_parse_args( $args, $defaults );

  $args = apply_filters( 'wp_page_menu_args', $args );



  $menu = '';



  $list_args = $args;



  // Show Home in the menu

  if ( ! empty($args['show_home']) ) {

    if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] )

      $text = __('Home','Krypton');

    else

      $text = $args['show_home'];

    $class = '';

    if ( is_front_page() && !is_paged() )

      $class = 'class="current_page_item"';

    $menu .= '<li ' . $class . '><a href="' . home_url( '/' ) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';

    // If the front page is a page, add it to the exclude list

    if (get_option('show_on_front') == 'page') {

      if ( !empty( $list_args['exclude'] ) ) {

        $list_args['exclude'] .= ',';

      } else {

        $list_args['exclude'] = '';

      }

      $list_args['exclude'] .= get_option('page_on_front');

    }

  }



  $list_args['echo'] = false;

  $list_args['title_li'] = '';

  $menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages($list_args) );



  if ( $menu )

    $menu = '<ul class="' . esc_attr($args['menu_class']) . '">' . $menu . '</ul>';



  $menu = '<'.esc_attr($args['container']).' class="' . esc_attr($args['container_class']) . '">' . $menu . "</".esc_attr($args['container']).">\n";

  $menu = apply_filters( 'wp_page_menu', $menu, $args );

  if ( $args['echo'] )

    echo $menu;

  else

    return $menu;

}





function dt_tag_cloud_args($args=array()){



  $args['filter']=1;

  return $args;

}



function dt_tag_cloud($return="",$tags, $args = '' ){



  if(!count($tags))

    return $return;





  $return='<ul class="list-unstyled">';

  foreach ($tags as $tag) {

    $return.='<li class="tag"><a href="'.$tag->link.'">'.ucwords($tag->name).'</a></li>';

  }



  $return.='</ul>';



  return $return;

}



function dt_widget_title($title="",$instance=array(),$id=null){



  if(empty($instance['title']))

      return "";

  return $title;

}



add_filter('widget_tag_cloud_args','dt_tag_cloud_args');

add_filter('wp_generate_tag_cloud','dt_tag_cloud',1,3);

add_filter('widget_title','dt_widget_title',1,3);

if(!function_exists('get_avatar_url')){
  function get_avatar_url($author_id,$args=array()){

        $get_avatar=get_avatar( $author_id, $args);

        preg_match("/src='(.*?)'/i", $get_avatar, $matches);
        if (isset($matches[1])) {
          return $matches[1];
        } else {
          return;
        }
  }

}

// Comment Functions

function dt_comment_form( $args = array(), $post_id = null ) {
  if ( null === $post_id )
    $post_id = get_the_ID();
  else
    $id = $post_id;

  $commenter = wp_get_current_commenter();
  $user = wp_get_current_user();
  $user_identity = $user->exists() ? $user->display_name : '';

  $args = wp_parse_args( $args );
  if ( ! isset( $args['format'] ) )
    $args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';

  $req      = get_option( 'require_name_email' );
  $aria_req = ( $req ? " aria-required='true'" : '' );
  $html5    = 'html5' === $args['format'];
  /*$fields   =  array(
    'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
    'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
    'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label> ' .
                '<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
  );*/

  $fields   =  array(
    'author' => '<div class="row">
                    <div class="form-group col-xs-12 col-sm-4">
                    <input type="text" class="form-control" name="author" id="author" placeholder="'.__('full name','Krypton').'" required>
                  </div>',
    'email' => '<div class="form-group col-xs-12 col-sm-4">
                      <input type="email" class="form-control"  name="email" id="email" placeholder="'.__('email address','Krypton').'" required>
                  </div>',
    'url' => '<div class="form-group col-xs-12 col-sm-4">
                  <input type="text" class="form-control" name="url" id="url" placeholder="website">
                </div>
              </div>',
  );

  $required_text = sprintf( ' ' . __('Required fields are marked %s','Krypton'), '<span class="required">*</span>' );
  $defaults = array(
    'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
    'comment_field'        => '<div class="row">
                                  <div class="form-group col-xs-12">
                                    <textarea class="form-control" rows="3" name="comment" id="comment" placeholder="'.__('your message','Krypton').'" required></textarea>

                                  </div>
                              </div>',
    'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.','Krypton' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
    'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','Krypton' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
    'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.','Krypton' ) . ( $req ? $required_text : '' ) . '</p>',
    'comment_notes_after'  => '',
    'id_form'              => 'commentform',
    'id_submit'            => 'submit',
    'title_reply'          => '<hr /><div class="col-sm-12 comment-leave-title">'.__('Leave a Comment','Krypton').'</div><hr />',
    'title_reply_to'       => __( 'Leave a Comment to %s','Krypton' ),
    'cancel_reply_link'    => __( 'Cancel reply','Krypton' ),
    'label_submit'         => __( 'Submit','Krypton' ),
    'format'               => 'html5',
  );

  $args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

  ?>
    <?php if ( comments_open( $post_id ) ) : ?>

      <?php do_action( 'comment_form_before' ); ?>
      <section id="respond" class="comment-respond">
        <h3 id="reply-title" class="comment-reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h3>
        <?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
          <?php echo $args['must_log_in']; ?>
          <?php do_action( 'comment_form_must_log_in_after' ); ?>
        <?php else : ?>
          <form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="comment-form"<?php echo $html5 ? ' novalidate' : ''; ?> data-abide>
            <?php do_action( 'comment_form_top' ); ?>
            <?php 
              if ( is_user_logged_in() ) :
                echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity );
                do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
                echo $args['comment_notes_before'];
              else : 
                do_action( 'comment_form_before_fields' );
                foreach ( (array) $args['fields'] as $name => $field ) {
                  echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
                }
                do_action( 'comment_form_after_fields' );
              endif; 
            ?>
            <?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
            <?php echo $args['comment_notes_after']; ?>
            <p class="form-submit">
              <input name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
              <?php comment_id_fields( $post_id ); ?>
            </p>
            <?php do_action( 'comment_form', $post_id ); ?>
          </form>
        <?php endif; ?>
      </section><!-- #respond -->
      <?php do_action( 'comment_form_after' ); ?>
    <?php else : ?>
      <?php do_action( 'comment_form_comments_closed' ); ?>
    <?php endif; ?>
  <?php
}

/**
 * Retrieve HTML content for reply to comment link.
 *
 * The default arguments that can be override are 'add_below', 'respond_id',
 * 'reply_text', 'login_text', and 'depth'. The 'login_text' argument will be
 * used, if the user must log in or register first before posting a comment. The
 * 'reply_text' will be used, if they can post a reply. The 'add_below' and
 * 'respond_id' arguments are for the JavaScript moveAddCommentForm() function
 * parameters.
 *
 * @since 2.7.0
 *
 * @param array $args Optional. Override default options.
 * @param int $comment Optional. Comment being replied to.
 * @param int $post Optional. Post that the comment is going to be displayed on.
 * @return string|bool|null Link to show comment form, if successful. False, if comments are closed.
 */
function dt_get_comment_reply_link($args = array(), $comment = null, $post = null) {
  global $user_ID;

  $defaults = array('add_below' => 'comment', 'respond_id' => 'respond', 'reply_text' => __('Reply','Krypton'),
    'login_text' => __('Log in to Reply','Krypton'), 'depth' => 0, 'before' => '', 'after' => '');

  $args = wp_parse_args($args, $defaults);

  if ( 0 == $args['depth'] || $args['max_depth'] <= $args['depth'] )
    return;

  extract($args, EXTR_SKIP);

  $comment = get_comment($comment);
  if ( empty($post) )
    $post = $comment->comment_post_ID;
  $post = get_post($post);

  if ( !comments_open($post->ID) )
    return false;

  $link = '';

  if ( get_option('comment_registration') && !$user_ID )
    $link = '<a rel="nofollow" class="comment-reply-login" href="' . esc_url( wp_login_url( get_permalink() ) ) . '">' . $login_text . '</a>';
  else 
    $link = "<a class='reply comment-reply-link' href='#' onclick='return addComment.moveForm(\"$add_below-$comment->comment_ID\", \"$comment->comment_ID\", \"$respond_id\", \"$post->ID\")'>$reply_text</a>";
  
  //var_dump($args);
  return apply_filters('comment_reply_link', $before . $link . $after, $args, $comment, $post);
  //var_dump(apply_filters('comment_reply_link', $args, $comment, $post));
  //return apply_filters('comment_reply_link', $args, $comment, $post);
}

/**
 * Displays the HTML content for reply to comment link.
 *
 * @since 2.7.0
 * @see dt_get_comment_reply_link() Echoes result
 *
 * @param array $args Optional. Override default options.
 * @param int $comment Optional. Comment being replied to.
 * @param int $post Optional. Post that the comment is going to be displayed on.
 * @return string|bool|null Link to show comment form, if successful. False, if comments are closed.
 */
function dt_comment_reply_link($args = array(), $comment = null, $post = null) {
  echo dt_get_comment_reply_link($args, $comment, $post);
}

if ( ! function_exists( 'dt_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own dt_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Krypton 1.0
 */
function dt_comment( $comment, $args, $depth ) {

  $GLOBALS['comment'] = $comment;
  switch ( $comment->comment_type ) :
    case 'pingback' :
    case 'trackback' :
      // Display trackbacks differently than normal comments.
      ?>
      <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
      <p><?php _e( 'Pingback:', 'Krypton' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'Krypton' ), '<span class="edit-link">', '</span>' ); ?></p></li>
      <?php
    break;
  
    default :
      // Proceed with normal comments.

      ?>

              <li class="comment_item media"  id="comment-<?php print $comment->comment_ID; ?>">
      
                <?php $avatar_url = get_avatar_url($comment->user_id,array('size'=>85 )); ?>

                <a class="pull-left" href="<?php comment_author_url(); ?>"><img src="<?php echo $avatar_url ?>" class="author-avatar img-circle img-responsive" alt="<?php print esc_attr($comment->comment_author);?>"></a>

                <div class="media-body">
                  <h4 class="media-heading"><?php comment_author(); ?><small><?php comment_date('j F Y') ?></small><small><?php dt_comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'Krypton' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></small><small><?php edit_comment_link( __( 'Edit', 'Krypton' ), '', '' ); ?></small></h4>
                  <p><?php comment_text(); ?></p>
                </div>
              </li>
      <?php
    break;
  endswitch; // end comment_type check
}
endif; 


remove_shortcode('gallery');

add_shortcode('gallery', 'dt_gallery_shortcode');

add_filter('post_gallery','getPortfolioGallery',1,2);


function getPortfolioGallery($out,$attr=array()){

  global $post,$carouselGallery;

  if( $post && ('port'!==$post->post_type || isset($attr['is_widget'])))
      return '';


  $gallerytype = get_post_meta( get_the_ID(), 'mediatype', true );

  if('2'== $gallerytype){

 if ( isset( $attr['orderby'] ) ) {
    $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
    if ( !$attr['orderby'] )
      unset( $attr['orderby'] );
  }

    extract(shortcode_atts(array(
      'order'      => 'ASC',
      'orderby'    => 'menu_order ID',
      'id'         => $post ? $post->ID : 0,
      'itemtag'    => 'dl',
      'icontag'    => 'dt',
      'captiontag' => 'dd',
      'columns'    => 3,
      'size'       => 'thumbnail',
      'include'    => '',
      'exclude'    => '',
      'link'       => ''
    ), $attr, 'gallery'));

    $id = intval($id);
    if ( 'RAND' == $order )
      $orderby = 'none';

    if ( !empty($include) ) {
      $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

      $attachments = array();
      foreach ( $_attachments as $key => $val ) {
        $attachments[$val->ID] = $_attachments[$key];
      }
    } elseif ( !empty($exclude) ) {
      $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
      $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
      return '';



    $carouselGallery='<div id="portfolio-carousel" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">';

  $i=0;

  foreach ( $attachments as $id => $attachment ) {
  
      $url = wp_get_attachment_url($id);

      $carouselGallery.='<div class="item'.((0==$i)?" active":"").'">
                      <img src="'.$url.'" alt="'.esc_html($attachment->post_title).'">
                    </div>';
      $i++;

    }

    $carouselGallery.='</div>
                  
                  <a class="left carousel-control" href="#portfolio-carousel" data-slide="prev">
                    <span><i class="icon-left-open-big"></i></span>
                  </a>
                  <a class="right carousel-control" href="#portfolio-carousel" data-slide="next">
                    <span><i class="icon-right-open-big"></i></span>
                  </a>
                </div>';


    return "<!-- gallery -->";
  }else{


    return "";
  }
}

if(!function_exists('nl2space')){
    function nl2space($str) {
        $arr=explode("\n",$str);
        $out='';

        for($i=0;$i<count($arr);$i++) {
            if(strlen(trim($arr[$i]))>0)
                $out.= trim($arr[$i]).' ';
        }
        return $out;
    }
}

function dt_gallery_shortcode($attr) {
  global $krypton_config,$dt_revealData;
  $post = get_post();

  static $instance = 0;
  $instance++;

  if ( ! empty( $attr['ids'] ) ) {
    // 'ids' is explicitly ordered, unless you specify otherwise.
    if ( empty( $attr['orderby'] ) )
      $attr['orderby'] = 'post__in';
    $attr['include'] = $attr['ids'];
  }

  // Allow plugins/themes to override the default gallery template.
  $output = apply_filters('post_gallery', '', $attr);


  if ( $output != '' )
    return $output;

  // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
  if ( isset( $attr['orderby'] ) ) {
    $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
    if ( !$attr['orderby'] )
      unset( $attr['orderby'] );
  }

  extract(shortcode_atts(array(
    'order'      => 'ASC',
    'orderby'    => 'menu_order ID',
    'id'         => $post ? $post->ID : 0,
    'itemtag'    => 'dl',
    'icontag'    => 'dt',
    'captiontag' => 'dd',
    'columns'    => 3,
    'size'       => 'thumbnail',
    'include'    => '',
    'exclude'    => '',
    'link'       => ''
  ), $attr, 'gallery'));

  $id = intval($id);
  if ( 'RAND' == $order )
    $orderby = 'none';

  if ( !empty($include) ) {
    $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

    $attachments = array();
    foreach ( $_attachments as $key => $val ) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  } elseif ( !empty($exclude) ) {
    $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  } else {
    $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  }

  if ( empty($attachments) )
    return '';

  if ( is_feed() ) {
    $output = "\n";
    foreach ( $attachments as $att_id => $attachment )
      $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
    return $output;
  }

  $itemtag = tag_escape($itemtag);
  $captiontag = tag_escape($captiontag);
  $icontag = tag_escape($icontag);
  $valid_tags = wp_kses_allowed_html( 'post' );
  if ( ! isset( $valid_tags[ $itemtag ] ) )
    $itemtag = 'dl';
  if ( ! isset( $valid_tags[ $captiontag ] ) )
    $captiontag = 'dd';
  if ( ! isset( $valid_tags[ $icontag ] ) )
    $icontag = 'dt';

  $columns = intval($columns);
  $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
  $float = is_rtl() ? 'right' : 'left';

  $selector = "gallery-{$instance}";

  $gallery_style = $gallery_div = '';
  if ( apply_filters( 'use_default_gallery_style', true ) )
    $gallery_style = "<style type='text/css'>#{$selector} {margin: auto;}#{$selector} .gallery-item { float: {$float}; margin-top: 10px; text-align: center; width: {$itemwidth}%; } #{$selector} img { border: 2px none #cfcfcf; } #{$selector} .gallery-caption { margin-left: 0; } /* see gallery_shortcode() in wp-includes/media.php */</style>";
  $size_class = sanitize_html_class( $size );
  $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
  $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

  $i = 0;
  foreach ( $attachments as $id => $attachment ) {
    if ( ! empty( $link ) && 'file' === $link ) {
      $url = wp_get_attachment_url($id);

      $image_output = '<a href="'.$url.'" data-modal="modal_post_'.$id.'" onClick="return false;" class="md-trigger">'.wp_get_attachment_image( $id, $size, false).'</a>';


      //$image_output = wp_get_attachment_link( $id, $size, false, false );
    } elseif ( ! empty( $link ) && 'none' === $link )
      $image_output = wp_get_attachment_image( $id, $size, false );
    else
      $image_output = wp_get_attachment_link( $id, $size, true, false );

    $image_meta  = wp_get_attachment_metadata( $id );

    $orientation = '';
    if ( isset( $image_meta['height'], $image_meta['width'] ) )
      $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

    $output .= "<{$itemtag} class='gallery-item'><{$icontag} class='gallery-icon {$orientation}'>$image_output</{$icontag}>";

    $output_popup = "";

//    if ( $captiontag && trim($attachment->post_excerpt) ) {

      $output .= "
        <{$captiontag} class='wp-caption-text gallery-caption'>
        " . wptexturize($attachment->post_excerpt) . "
        </{$captiontag}>";

      if ($krypton_config['dt-select-modal-effects']=='') { 
        $md_effect = 'md-effect-15';
      } else {
        $md_effect = $krypton_config['dt-select-modal-effects'];
      } 

      $output_popup = '<div id="modal_post_'.$id.'" class="popup-gallery md-modal '.$md_effect.'">
        <div class="md-content">
          <img src="'. wp_get_attachment_url($id) .'" class="img-responsive" alt="'.$attachment->post_title.'"/>';
      if(!empty($attachment->post_excerpt)):
      
      $output_popup.='<div class="md-description">'."
            <{$captiontag} class='wp-caption-text gallery-caption-modal'>
        " . wptexturize($attachment->post_excerpt) . "
        </{$captiontag}>".'
          </div>';
      endif;

      $output_popup.='<button class="button md-close right btn-cross"><i class="icon-cancel"></i></button>
        </div>
      </div>'."\n";

      array_push($dt_revealData, $output_popup);

//    }

    $output .= "</{$itemtag}>";
    if ( $columns > 0 && ++$i % $columns == 0 )
      $output .= '<br style="clear: both" />';
  }

  $output .= "
      <br style='clear: both;' />
    </div>\n";

  $output = nl2space($output);
  return $output;
}

// function to display number of posts.
function dt_get_post_views($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return sprintf(__("%d View",'Krypton'),0);
    } elseif ($count<=1) {
        return sprintf(__("%d View",'Krypton'),$count);  
    }


    $output = str_replace('%', number_format_i18n($count),__('% Views','Krypton'));
    return $output;
}

function dt_get_post_view_number($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    return (int)$count;
}

// function to display number of posts without "Views" Text.
function dt_get_post_views_number($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

// function to count views.
function dt_set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


// Add it to a column in WP-Admin
add_filter('manage_posts_columns', 'dt_posts_column_views');
add_action('manage_posts_custom_column', 'dt_posts_custom_column_views',5,2);

function dt_posts_column_views($defaults){
    $defaults['post_views'] = __('Views','Krypton');
    return $defaults;
}

function dt_posts_custom_column_views($column_name, $id){
  if($column_name === 'post_views'){
        echo dt_get_post_views(get_the_ID());
    }
}


/** Breadcrumbs **/
/** http://dimox.net/wordpress-breadcrumbs-without-a-plugin/ **/
function dimox_breadcrumbs() {
  /* === OPTIONS === */
  $text['home']     = 'Home'; // text for the 'Home' link
  $text['category'] = '%s'; // text for a category page
  $text['search']   = '%s'; // text for a search results page
  $text['tag']      = '%s'; // text for a tag page
  $text['author']   = '%s'; // text for an author page
  $text['404']      = 'Error 404'; // text for the 404 page

  $show_current   = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
  $show_on_home   = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
  $show_title     = 1; // 1 - show the title for the links, 0 - don't show
  $delimiter      = '  /  '; // delimiter between crumbs
  $before         = '<span class="current">'; // tag before the current crumb
  $after          = '</span>'; // tag after the current crumb
  /* === END OF OPTIONS === */

  global $post;
  $home_link    = home_url('/');
  $link_before  = '<span typeof="v:Breadcrumb">';
  $link_after   = '</span>';
  $link_attr    = ' rel="v:url" property="v:title"';
  $link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;

  if ($post) {
    $parent_id    = $parent_id_2 = $post->post_parent;
  }
  $frontpage_id = get_option('page_on_front');

  if (is_home() || is_front_page()) {

    if ($show_on_home == 1) echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';

  } else {

    echo '<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';
    if ($show_home_link == 1) {
      echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';

      if ( is_search() ) {
        echo $delimiter;
      } else {
        if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
      }
    }

    if ( is_category() ) {
      $this_cat = get_category(get_query_var('cat'), false);
      if ($this_cat->parent != 0) {
        $cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
        if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
        $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
        $cats = str_replace('</a>', '</a>' . $link_after, $cats);
        if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
        echo $cats;
      }
      if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

    } elseif ( is_search() ) {
      echo $before . sprintf($text['search'], get_search_query()) . $after;

    } elseif ( is_day() ) {
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
      echo $before . get_the_time('d') . $after;

    } elseif ( is_month() ) {
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo $before . get_the_time('F') . $after;

    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;

    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
        if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, $delimiter);
        if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
        $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
        $cats = str_replace('</a>', '</a>' . $link_after, $cats);
        if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
        echo $cats;
        if ($show_current == 1) echo $before . get_the_title() . $after;
      }

    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;

    } elseif ( is_attachment() ) {
      $parent = get_post($parent_id);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      if ($cat) {
        $cats = get_category_parents($cat, TRUE, $delimiter);
        $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
        $cats = str_replace('</a>', '</a>' . $link_after, $cats);
        if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
        echo $cats;
      }
      printf($link, get_permalink($parent), $parent->post_title);
      if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

    } elseif ( is_page() && !$parent_id ) {
      if ($show_current == 1) echo $before . get_the_title() . $after;

    } elseif ( is_page() && $parent_id ) {
      if ($parent_id != $frontpage_id) {
        $breadcrumbs = array();
        while ($parent_id) {
          $page = get_page($parent_id);
          if ($parent_id != $frontpage_id) {
            $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
          }
          $parent_id = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        for ($i = 0; $i < count($breadcrumbs); $i++) {
          echo $breadcrumbs[$i];
          if ($i != count($breadcrumbs)-1) echo $delimiter;
        }
      }
      if ($show_current == 1) {
        if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
        echo $before . get_the_title() . $after;
      }

    } elseif ( is_tag() ) {
      echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

    } elseif ( is_author() ) {
      global $author;
      $userdata = get_userdata($author);
      echo $before . sprintf($text['author'], $userdata->display_name) . $after;

    } elseif ( is_404() ) {
      echo $before . $text['404'] . $after;

    } elseif ( has_post_format() && !is_singular() ) {
      echo get_post_format_string( get_post_format() );
    }

    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      if ( is_page() ) echo $delimiter;
      echo __('Page','Krypton') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }

    echo '</div><!-- .breadcrumbs -->';

  }
} // end dimox_breadcrumbs()

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


if (!function_exists('mb_strlen'))
{
  function mb_strlen($str="")
  {
    return strlen($str);
  }
}

function wp_trim_chars($text, $num_char = 55, $more = null){

  if ( null === $more )
    $more = '';
  $original_text = $text;
  $text = wp_strip_all_tags( $text );

  $words_array = preg_split( "/[\n\r\t ]+/", $text, $num_char + 1, PREG_SPLIT_NO_EMPTY );
  $text = @implode( ' ', $words_array );
  
  
  if ( strlen( $text ) > $num_char ) {
  
    $text = substr($text,0, $num_char );
    $text = $text . $more;
  }

  return apply_filters( 'wp_trim_chars', $text, $num_char, $more, $original_text );
}

function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

add_action( 'admin_head', 'dt_custom_post_icons');
function dt_custom_post_icons() { 
    echo '<style type="text/css">
        #adminmenu #menu-posts-port div.wp-menu-image:before,#adminmenu #menu-posts-team div.wp-menu-image:before,
        #adminmenu #menu-posts-testimonials div.wp-menu-image:before {
          content: \'\';
        }
        #menu-posts-port .wp-menu-image {
            background: url('.get_template_directory_uri().'/lib/images/custom-post-icons.png) no-repeat -56px 2px !important;
        }
        
        #menu-posts-port:hover .wp-menu-image, #menu-posts-port.wp-has-current-submenu .wp-menu-image {
            background-position: -56px -28px !important;
        }

        #menu-posts-team .wp-menu-image {
            background: url('.get_template_directory_uri().'/lib/images/custom-post-icons.png) no-repeat -28px 2px !important;
        }
        
        #menu-posts-team:hover .wp-menu-image, #menu-posts-team.wp-has-current-submenu .wp-menu-image {
            background-position: -28px -26px !important;
        }

        #menu-posts-testimonials .wp-menu-image {
            background: url('.get_template_directory_uri().'/lib/images/custom-post-icons.png) no-repeat 2px 2px !important;
        }
        
        #menu-posts-testimonials:hover .wp-menu-image, #menu-posts-testimonials.wp-has-current-submenu .wp-menu-image {
            background-position: 2px -26px !important;
        }

        </style>
    ';
}

function responsiveVideo($html, $data, $url) {

  if (!is_admin() && !preg_match("/flex\-video/mi", $html) && preg_match("/youtube|vimeo/", $data)) {
    $html="<div class=\"flex-video widescreen\">".$html."</div>";
  }
  return $html;
}

add_filter('embed_handler_html', 'responsiveVideo', 92, 3 ); 
add_filter('oembed_dataparse', 'responsiveVideo', 90, 3 );
add_filter('embed_oembed_html', 'responsiveVideo', 91, 3 );

function add_video_wmode_transparent($html) {
   if (strpos($html, "<iframe " ) !== false) {
      $search = array('?feature=oembed');
      $replace = array('?feature=oembed&wmode=transparent');
      $html = str_replace($search, $replace, $html);

      return $html;
   } else {
      return $html;
   }
}
add_filter('the_content', 'add_video_wmode_transparent', 10, 1);

function wooCommerceThumbnail($attr=array(), $attachment=null){

  if(in_array('attachment-shop_thumbnail',$attr)){

    $attr['class']="img-responsive attachment-shop_thumbnail";
  }

  return $attr;

}

add_filter('wp_get_attachment_image_attributes','wooCommerceThumbnail',1,2);

function dt_wc_body_class($classess=array()){

  if(!in_array('woocommerce-page',$classess)){
      $classess[]="woocommerce-page";
  }

  return $classess;

}


add_filter('detheme_woocommerce_product_price_html','detheme_woocommerce_product_price_html');

function detheme_woocommerce_product_price_html($product){

    $price="";


    $tax_display_mode      = get_option( 'woocommerce_tax_display_shop' );
    $display_price         = $tax_display_mode == 'incl' ? $product->get_price_including_tax() : $product->get_price_excluding_tax();
    $display_regular_price = $tax_display_mode == 'incl' ? $product->get_price_including_tax( 1, $product->get_regular_price() ) : $product->get_price_excluding_tax( 1, $product->get_regular_price() );
    $display_sale_price    = $tax_display_mode == 'incl' ? $product->get_price_including_tax( 1, $product->get_sale_price() ) : $product->get_price_excluding_tax( 1, $product->get_sale_price() );

    if ( $product->get_price() > 0 ) {

      if ( $product->is_on_sale() && $product->get_regular_price() ) {
        $price .= '<del>' . ( ( is_numeric( $display_regular_price ) ) ? get_woocommerce_currency_symbol().detheme_woocommerce_product_price( $display_regular_price ) : $display_regular_price ) . '</del> <ins>' . ( ( is_numeric( $display_price ) ) ? get_woocommerce_currency_symbol().detheme_woocommerce_product_price( $display_price ) : $display_price ) . '</ins>';
      } else {
        $price .= get_woocommerce_currency_symbol().detheme_woocommerce_product_price( $display_price ). $product->get_price_suffix();

      }

    } elseif ( $product->get_price() === '' ) {

      $price = apply_filters( 'woocommerce_empty_price_html', '', $product );

    } elseif ( $product->get_price() == 0 ) {

      if ( $product->is_on_sale() && $product->get_regular_price() ) {

        $price .= $product->get_price_html_from_to( $display_regular_price, __( 'Free!', 'woocommerce' ) );

        $price = apply_filters( 'woocommerce_free_sale_price_html', $price, $product );

      } else {

        $price = __( 'Free!', 'woocommerce' );

        $price = apply_filters( 'woocommerce_free_price_html', $price, $product );

      }
    }

    return apply_filters( 'woocommerce_get_price_html', $price, $product );

}

add_filter('detheme_woocommerce_product_price','detheme_woocommerce_product_price');


function detheme_woocommerce_product_price($price=0){

  global $krypton_config;

  $abbrevi=(isset($krypton_config['product-price-abbrevi']))?$krypton_config['product-price-abbrevi']:array();
  $default=array('thousand'=>__('K', 'Krypton'),
                'million'=>__('M', 'Krypton'),
                'billion'=>__('B', 'Krypton'),
                'trillion'=>__('T', 'Krypton')
          );

  $decimal_sep     = wp_specialchars_decode( stripslashes( get_option( 'woocommerce_price_decimal_sep' ) ), ENT_QUOTES );
  $thousands_sep   = wp_specialchars_decode( stripslashes( get_option( 'woocommerce_price_thousand_sep' ) ), ENT_QUOTES );
  $num_decimals    = absint( get_option( 'woocommerce_price_num_decimals' ) );

  $abbrevi=wp_parse_args($abbrevi,$default);
  $price_length=mb_strlen(number_format($price,0,'',''));
  $abbr="";

    if($price_length > 12){
      $newprice=$price/1000000000000;
      $price=$newprice;
      $abbr=$abbrevi['trillion'];
    }
    elseif($price_length > 9 && $price_length <= 12 ){
      $newprice=$price/1000000000;
      $price=$newprice;
      $abbr=$abbrevi['billion'];

    }
    elseif($price_length > 6 && $price_length <= 9 ){
      $newprice=$price/1000000;
      $price=$newprice;
      $abbr=$abbrevi['million'];

    }
    elseif($price_length > 3 && $price_length <= 6 ){

      $newprice=$price/1000;
      $price=$newprice;
      $abbr=$abbrevi['thousand'];

    }

    if(floor( $price ) == $price ){
        $num_decimals=0;
    }

  $price= @number_format( $price,$num_decimals, $decimal_sep, $thousands_sep ).$abbr;


  return rtrim($price);

}


function detheme_woocommerce_cart_subtotal($wc_cart,$compound=false){

      // If the cart has compound tax, we want to show the subtotal as
      // cart + shipping + non-compound taxes (after discount)

      $currency_symbol = get_woocommerce_currency_symbol();

      if ( $compound ) {

        $cart_subtotal = detheme_woocommerce_product_price( $wc_cart->cart_contents_total + $wc_cart->shipping_total + $wc_cart->get_taxes_total( false, false ) );

      // Otherwise we show cart items totals only (before discount)
      } else {

        // Display varies depending on settings
        if ( $wc_cart->tax_display_cart == 'excl' ) {

          $cart_subtotal = $currency_symbol.detheme_woocommerce_product_price( $wc_cart->subtotal_ex_tax );

          if ( $wc_cart->tax_total > 0 && $wc_cart->prices_include_tax ) {
            $cart_subtotal .= ' <small>' . WC()->countries->ex_tax_or_vat() . '</small>';
          }

        } else {

          $cart_subtotal = $currency_symbol.detheme_woocommerce_product_price( $wc_cart->subtotal );

          if ( $wc_cart->tax_total > 0 && !$wc_cart->prices_include_tax ) {
            $cart_subtotal .= ' <small>' . WC()->countries->inc_tax_or_vat() . '</small>';
          }

        }
      }

      return $cart_subtotal;
}


add_filter('detheme_woocommerce_cart_subtotal','detheme_woocommerce_cart_subtotal',1,2);



function load_wc_select($shortcode){
  $frontend_script_path = plugins_url( 'woocommerce/assets/js/' );
  $assets_path = plugins_url( 'woocommerce/assets/' );
  wp_register_script( 'chosen', $frontend_script_path . 'chosen/chosen.jquery.js', array( 'jquery' ), '1.0.0', true );
  wp_register_script('wc-country-select', $frontend_script_path . 'frontend/country-select.js', array( 'jquery' ), WC_VERSION, true );
  wp_register_script( 'wc-address-i18n', $frontend_script_path . 'frontend/address-i18n.js', array( 'jquery' ), WC_VERSION, true );

  wp_enqueue_script( 'wc-chosen', $frontend_script_path . 'frontend/chosen-frontend.js', array( 'chosen' ), WC_VERSION, true );
  wp_enqueue_style( 'woocommerce_chosen_styles', $assets_path . 'css/chosen.css' );
  wp_enqueue_script('wc-country-select');
  wp_enqueue_script('wc-address-i18n');
  return $shortcode;
}

if (!is_admin()) {
  add_filter("woocommerce_checkout_shortcode_tag", "load_wc_select");
}

function woocommerce_custom_show_page_title() {
  return false;
}
add_filter("woocommerce_show_page_title","woocommerce_custom_show_page_title");


function detheme_woocommerce_subcategory_count_html($html,$category){

  if($category->count == 1){

      $html=sprintf(__('%d Item','Krypton'),$category->count);
  }elseif($category->count >= 2){
      $html=sprintf(__('%d Items','Krypton'),$category->count);
  }
  else{
      $html=__('No Items','Krypton');

  }




  return $html;
}

add_filter('woocommerce_subcategory_count_html','detheme_woocommerce_subcategory_count_html',1,2);


if ( ! function_exists( 'krypton_woocommerce_login_form' ) ) {

  /**
   * Output the WooCommerce Login Form
   *
   * @access public
   * @subpackage  Forms
   * @return void
   */
  function krypton_woocommerce_login_form( $args = array(),$echo=false ) {

    $defaults = array(
      'message'  => '',
      'redirect' => ''
    );

    $args = wp_parse_args( $args, $defaults  );

    if($echo){

      ob_start();
      wc_get_template( 'global/popup-form-login.php', $args );

      $content=ob_get_contents();

      ob_end_clean();

      return $content;

    }
    else{

      wc_get_template( 'global/popup-form-login.php', $args );

    }
  }
}

function krypton_protected_meta($protected, $meta_key, $meta_type){

  $protected=(in_array($meta_key,
    array('masonrycolumn','portfoliocolumn','portfoliotype','post_views_count','show_comment','show_social','sidebar_position','subtitle')
  ))?true:$protected;
  return $protected;
}

add_filter('is_protected_meta','krypton_protected_meta',1,3);

if ( ! function_exists( 'dt_woocommerce_content' ) ) {

  /**
   * Output WooCommerce content.
   *
   * This function is only used in the optional 'woocommerce.php' template
   * which people can add to their themes to add basic woocommerce support
   * without hooks or modifying core templates.
   *
   * @access public
   * @return void
   */
  function dt_woocommerce_content() {

    if ( is_singular( 'product' ) ) {

      while ( have_posts() ) : the_post();

        wc_get_template_part( 'content', 'single-product' );

      endwhile;

    } else { ?>

      <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

        <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

      <?php endif; ?>

      <?php //do_action( 'woocommerce_archive_description' ); ?>

      <?php if ( have_posts() ) : ?>

        <?php do_action('woocommerce_before_shop_loop'); ?>

        <?php woocommerce_product_loop_start(); ?>

          <?php woocommerce_product_subcategories(); ?>

          <?php while ( have_posts() ) : the_post(); ?>

            <?php wc_get_template_part( 'content', 'product' ); ?>

          <?php endwhile; // end of the loop. ?>

        <?php woocommerce_product_loop_end(); ?>

        <?php do_action('woocommerce_after_shop_loop'); ?>

      <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

        <?php wc_get_template( 'loop/no-products-found.php' ); ?>

      <?php endif;

    }
  }
}

function woo_related_products_limit($args) {
  return wp_parse_args(array(
  'post_type' => 'product',
  'no_found_rows' => 1,
  'posts_per_page' => 4,
  'ignore_sticky_posts' => 1
  ),
  $args);
}
add_filter( 'woocommerce_related_products_args', 'woo_related_products_limit' );

if(function_exists('wc_get_page_id') && !function_exists('woocommerce_page_title')){

  function woocommerce_page_title($echo = true ){

    if ( is_search() ) {
      $page_title = sprintf( __( 'Search Results: &ldquo;%s&rdquo;', 'woocommerce' ), get_search_query() );

      if ( get_query_var( 'paged' ) )
        $page_title .= sprintf( __( '&nbsp;&ndash; Page %s', 'woocommerce' ), get_query_var( 'paged' ) );

    } elseif ( is_tax() ) {

      $page_title = single_term_title( "", false );

    } else {

      $shop_page_id = wc_get_page_id( 'shop' );
      $page_title   = get_the_title( $shop_page_id );

    }

    $page_title = apply_filters( 'woocommerce_page_title', $page_title );

    if ( $echo )
        echo $page_title;
      else
        return $page_title;
  }
}

if(!function_exists('mb_eregi')){

    function mb_eregi($pattern,$string,$regs=array()){

      return eregi($pattern,$string,$regs=array());

    }
}

if(!function_exists('mb_ereg')){

    function mb_ereg($pattern,$string,$regs=array()){

      return ereg($pattern,$string,$regs=array());

    }
}

add_action( 'wp_ajax_contact_action', 'contact_action_callback' );
add_action('wp_ajax_nopriv_contact_action','contact_action_callback');

function contact_action_callback() {
    global $krypton_config;
    
    $targetemail = $krypton_config['dt-contact-form-email'];

    $default=array(
        'inputFullname'=>'',
        'inputEmail'=>'',
        'inputPhone'=>'',
        'inputMessage'=>'',
        'num1'=>'',
        'num2'=>'',
        'captcha'=>''
        );

    //$args=wp_parse_args($_POST,$default);

    $total = $_POST['captcha'];
    $name = $_POST['inputFullname'];
    $email = $_POST['inputEmail'];
    $phone = $_POST['inputPhone'];
    $message = $_POST['inputMessage'];


    $captcha_error = captcha_validation($_POST['num1'], $_POST['num2'], $total);

    if (is_null($captcha_error)) { 
        $fullmessage = __('Name : ','Krypton'). $name . '<br />' .

        __('Email : ','Krypton') . $email . '<br />' .

        __('Phone : ','Krypton') . $phone . '<br />' .

        __('Message : ','Krypton') . $message . '<br />';

        $headers = 'MIME-Version: 1.0' . '\r\n';
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . '\r\n';

        if (function_exists('wp_mail')) {
                add_filter( 'wp_mail_content_type', 'set_html_content_type' );

                wp_mail($targetemail, __("Contact from ",'Krypton') . $name, $fullmessage);
        } else {
                mail($targetemail, __("Contact from ",'Krypton') . $name, $fullmessage);
        }
    }
} //function contact_action_callback

function captcha_validation($num1, $num2, $total) {
        global $error;
        //Captcha check - $num1 + $num = $total
        if( intval($num1) + intval($num2) == intval($total) ) {
                $error = null;
        }
        else {
                $error = __("Captcha value is wrong.",'Krypton');
        }
        return $error;
}


function set_html_content_type() {
    return 'text/html';
}


if ( ! function_exists( '_wp_render_title_tag' ) ) :
/* backword compatibility */

  function krypton_slug_render_title() {
    $tag="title";
    echo "<$tag>".wp_title('|', false, 'left')."</$tag>\n";
  }
  add_action( 'wp_head', 'krypton_slug_render_title',1);

  function krypton_page_title($title, $sep, $seplocation){

    if(defined('WPSEO_VERSION'))
      return $title;

    $blogname=get_bloginfo('name','raw'); 

    if($sep!=''){

        if($seplocation=='left'){

          $title=$blogname." ".$title;
        }
        else{

          $title=$title." ".$blogname;
        }


    }

    return $title;
  }

  add_filter('wp_title','krypton_page_title',1,3);

endif;

if (!function_exists('smarty_modifier_truncate')) {

    function smarty_modifier_truncate($string, $length = 80, $etc = '... ',$break_words = false, $middle = false)
    {
        if ($length == 0)
            return '';
        if (mb_strlen($string, 'utf8') > $length) {
            $length -= mb_strlen($etc, 'utf8');
            if (!$break_words && !$middle) {
                $string = preg_replace('/\s+\S+\s*$/su', '', mb_substr($string, 0, $length + 1, 'utf8'));
            }
            if (!$middle) {
                return mb_substr($string, 0, $length, 'utf8') . $etc;
            } else {
                return mb_substr($string, 0, $length / 2, 'utf8') . $etc . mb_substr($string, -$length / 2, utf8);
            }
        } else {
            return $string;
        }
    }
}


function krypton_link_excerpt_more($excerpt_more=""){

  return '<i class="icon-right-4"></i>';
}

add_filter('excerpt_more','krypton_link_excerpt_more');


/*wpml translation */

function _get_wpml_post($post_id){

  if(!defined('ICL_LANGUAGE_CODE'))
        return get_post($post_id);

    global $wpdb;

   $postid = $wpdb->get_var(
      $wpdb->prepare("SELECT element_id FROM {$wpdb->prefix}icl_translations WHERE trid=(SELECT trid FROM {$wpdb->prefix}icl_translations WHERE element_id='%d' LIMIT 1) AND element_id!='%d' AND language_code='%s'", $post_id,$post_id,ICL_LANGUAGE_CODE)
   );

  if($postid)
      return get_post($postid);
  
  return get_post($post_id);
}

/**
*
* post footer
* @since 3.0
*/

function get_detheme_post_footer_page(){

  global $krypton_config;

  $args=wp_parse_args($krypton_config,array('showfooterpage'=>true,'postfooterpage'=>false));
  $post_ID=get_the_ID();

  $originalpost = $GLOBALS['post'];


  if(!$args['showfooterpage'] || !$args['postfooterpage'] || $post_ID==$args['postfooterpage'])
    return;

  $post = _get_wpml_post($args['postfooterpage']);
  if(!$post)  return;

  $old_sidebar=get_query_var('sidebar');
  set_query_var('sidebar','nosidebar');

  $GLOBALS['post']=$post;
  $post_footer_page=do_shortcode($post->post_content);
  $GLOBALS['post']=$originalpost;

  set_query_var('sidebar',$old_sidebar);

  print $post_footer_page;

}

add_action('after_footer_section','get_detheme_post_footer_page'); 


/**
 *  auto update handle
 * @since 3.0 
 */
function detheme_automatic_updater_disabled($disabled){
  global $krypton_config;


  if(isset($krypton_config['disable_automatic_update'])){
      if(isset($krypton_config['core_automatic_update'])){

        if("minor"==$krypton_config['core_automatic_update']){
          add_filter('allow_dev_auto_core_updates','__return_false');
          add_filter('allow_minor_auto_core_updates','__return_true');
          add_filter('allow_major_auto_core_updates','__return_false');
        }
        elseif('true'==$krypton_config['core_automatic_update']){
          add_filter('allow_dev_auto_core_updates','__return_true');
          add_filter('allow_minor_auto_core_updates','__return_true');
          add_filter('allow_major_auto_core_updates','__return_true');
        }
        else{
          add_filter('allow_dev_auto_core_updates','__return_false');
          add_filter('allow_minor_auto_core_updates','__return_false');
          add_filter('allow_major_auto_core_updates','__return_false');
        }

      }

    return !(bool)$krypton_config['disable_automatic_update'];
  }

  return $disabled;
}

add_filter('automatic_updater_disabled','detheme_automatic_updater_disabled');
?>
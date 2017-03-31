<?php
defined('DTPB_BASENAME') or die();

class DElements
{
    protected static $elements = array();

    public static function getInstance(){

      static $instance = null;
      if ($instance === null)
        $instance = new DElements();
      return $instance;
    }

    public static function addElement($shortcode_id,$params) {

        if( ''==$shortcode_id || empty($shortcode_id)) {
          trigger_error(__("Shortcode tag required", 'detheme_builder'), E_USER_ERROR);
          die();
        }


        $classname='DElement_'.sanitize_key($shortcode_id);

        $params['id']=$shortcode_id;


        if(class_exists($classname) && $shortcode=new $classname($params)){
        }
        else{

          $shortcode=new DElement($params);
        }

        self::$elements[$shortcode_id] = $shortcode;

    }

    public static function removeElement($shortcode_id){

      if(isset(self::$elements[$shortcode_id])){
        unset(self::$elements[$shortcode_id]);
      }



    }

    public static function getElements()
    {
        $el=self::$elements;

        $sort_col = array();

        foreach ($el as $key=> $row) {

          $setting=$row->getSettings();
          $order=$setting['order'];
          $sort_col[$key] = $order;
        }

        array_multisort($sort_col,SORT_ASC, $el);

        return $el;
    }
}

class DElement {

        protected $shortcode;
        protected $atts;
        protected $settings;
        protected $shortcode_string = '';
        protected $shortcode_regex='';
        protected $content='';

        public function __construct($settings) {

            $settings=wp_parse_args($settings,array('id'=>'','order'=>999,'show_on_create'=>true,'title'=>__('Element Title','detheme_builder'),'icon'=>'dashicons-admin-page','options'=>array()));

            $this->settings = $settings;
            $this->shortcode = $this->settings['id'];

            if(!shortcode_exists($this->shortcode)){
                add_shortcode($this->shortcode,array($this,'output'));
            }
        }

        public function removeOption($optionName){

            $options=&$this->settings['options'];
            foreach ($options as $key => &$value) {

                if($value['param_name']==$optionName){
                  unset($options[$key]);
                  break;
                }
            }
        }

        public function addOption($option,$replace=true){

            $options=&$this->settings['options'];


            $after=(is_string($replace))?$replace:"";

            $available=false;
            $position=0;

            foreach ($options as $key => &$value) {

                if(!empty($after) && $value['param_name']==$after){

                  $position=($key+1);

                }

                if($value['param_name']==$option['param_name']){

                    if(empty($after) && !is_string($replace) && $replace){
                      $available=true;
                      $value=$option;

                    }
                    else{
                      unset($options[$key]);
                    }
                }

            }

            if(!$available){
              if($position){
                array_splice($options,$position,0,array($option));
              }
              else{
                array_push($options,$option);
              }
            }
        }

        public function addOptions($newoptions,$replace=true){

            $options=&$this->settings['options'];

            $available=false;


            foreach ($options as $key => &$value) {

                  if(@in_array($value['param_name'],array_keys($newoptions))){

                      if($replace){
                        $value=$newoptions[$value['param_name']];
                        unset($newoptions[$value['param_name']]);
                      }
                      else{
                        unset($options[$key]);
                      }

                  }
           }


            if(count($newoptions)){
              $options=@array_merge($options,$newoptions);

            }

        }

        public function do_shortcode_tag($content){


          $output="";


          $this->setShortcodeString($content[0]);
          $settings=$this->getSettings();

          switch ($this->shortcode) {
            case 'dt_row':
            case 'dt_inner_row':
            case 'dt_inner_row_1':
              $output='<div class="element-builder element-row" data-tag="'.$this->shortcode.'" data-column="12">
<div class="builder_handlediv" title="'.__('Click to toggle row','detheme_builder').'"></div>
                  <h3 class="row-title">'.__('Row','detheme_builder').'</h3>
                  <div class="inside_row">
                  <div class="element-toolbar">
                  <div class="toolbar-panel-left">
                  <div class="element-holder"><i title="'.__('Move this row','detheme_builder').'"  class="flaticon-pointer2"></i></div>
                      <div class="toolbar row-selection"><div class="select-column"><div title="'.__('Change column','detheme_builder').'"  class="dashicons dashicons-menu"></div></div>
                        <ul class="option-column-group">
                          <li class="option-column"><a href="#" class="column_1" data-column="12"><span></span></a></li>
                          <li class="option-column"><a href="#" class="column_2" data-column="6 6"><span></span><span></span></a></li>
                          <li class="option-column"><a href="#" class="column_3" data-column="4 4 4"><span></span><span></span><span></span></a></li>
                          <li class="option-column"><a href="#" class="column_4" data-column="3 3 3 3"><span></span><span></span><span></span><span></span></a></li>
                          <li class="option-column"><a href="#" class="column_6" data-column="2 2 2 2 2 2"><span></span><span></span><span></span><span></span><span></span><span></span></a></li>
                          <li class="option-column"><a href="#" class="column_custom">'.__('Custom','detheme_builder').'</a></li>
                        </ul>
                      </div>
                      <div class="toolbar element-shortcode"><a title="'.__('Show this shortcode','detheme_builder').'" href="#">&lt;/&gt;</a></div>
                      <div class="toolbar element-setting" data-title="'.__('Row','detheme_builder').'"><a title="'.__('Edit this row','detheme_builder').'" href="#"><div class="dashicons dashicons-admin-generic"></div></a></div>
                    </div>
                    <ul class="toolbar-panel-right">
                      <li class="toolbar element-copy"><a title="'.__('Copy this row','detheme_builder').'" href="#"><div class="dashicons dashicons-admin-page"></div></a></li>
                      <li class="toolbar element-delete"><a title="'.__('Delete this row','detheme_builder').'" href="#"><div class="dashicons dashicons-no-alt"></div></a></li>
                      <li class="toolbar element-up"><a title="'.__('Move up this row','detheme_builder').'" href="#"><div class="dashicons dashicons-arrow-up-alt"></div></a></li>
                      <li class="toolbar element-down"><a title="'.__('Move down this row','detheme_builder').'" href="#"><div class="dashicons dashicons-arrow-down-alt"></div></a></li>
                    </ul>

                  </div>
                  <div class="open-tag render-tag">['.$this->shortcode.' '.trim($content[3]).']</div>
                  <div class="column-container">'.$this->content.'</div>
                  <div class="close-tag render-tag">[/'.$this->shortcode.']</div>
                  </div>
                </div>';

              break;
            case 'dt_column':
            case 'dt_inner_column':
            case 'dt_inner_column_1':

              $this->atts['column']=isset($this->atts['column'])?$this->atts['column']:12;

              $css_column=(in_array($this->atts['column'],array(1,2,3,4,5,6,7,8,9,10,11,12)))?"col-".min((int)$this->atts['column'],12):"col_custom_".$this->atts['column'];
              $output='<div class="element-builder element-column '.$css_column.'" data-column="'.$this->atts['column'].'" data-tag="'.$this->shortcode.'">
            <div class="toolbar element-setting" data-title="'.__('Column','detheme_builder').'"><a title="'.__('Edit this column','detheme_builder').'" href="#"><div class="dashicons dashicons-admin-generic"></div></a></div>
            <div class="toolbar element-addshortcode"><a title="'.__('Add shortcode to this column','detheme_builder').'" href="#"><div class="dashicons dashicons-welcome-edit-page"></div></a></div>'
            .'<div class="toolbar element-delete-column"><a title="'.__('Delete this column','detheme_builder').'" href="#"><div class="dashicons dashicons-trash"></div></a></div>'
            .'<div class="open-tag render-tag">['.$this->shortcode.' '.preg_replace('/column=\"(.*)\"/', '', trim($content[3])).']</div>
            <div class="element-content dropable-element">'.$this->content.'</div>
            <div class="close-tag render-tag">[/'.$this->shortcode.']</div>
          </div>';
              break;
            default:

             if($settings['is_container']){

        $output='<div class="element-builder element-container element-'.$this->shortcode.'" data-tag="'.$this->shortcode.'">
            <div class="element-holder"><i title="'.__('Move this element','detheme_builder').'" class="flaticon-pointer2"></i></div>
            <div class="element-panel">
              <div class="element-holder-label">'.$settings['title'].'</div>
              <div class="element-toolbar">
                <div class="toolbar element-setting" data-title="'.$settings['title'].'"><a title="'.__('Edit this element','detheme_builder').'" href="#"><div class="dashicons dashicons-edit"></div></a></a></div>
                <div class="toolbar element-shortcode"><a title="'.__('Show this shortcode','detheme_builder').'" href="#">&lt;/&gt;</a></div>
                <div class="toolbar element-copy"><a title="'.__('Copy this element','detheme_builder').'" href="#"><div class="dashicons dashicons-admin-page"></div></a></div>
                <div class="toolbar element-delete"><a title="'.__('Delete this element','detheme_builder').'" href="#"><div class="dashicons dashicons-no-alt"></div></a></div>
              </div>
            </div>
            <div class="open-tag render-tag">['.$this->shortcode." ".trim($content[3]).']</div>
            <div class="element-content dropable-element">'.$this->content.'</div>
            <div class="close-tag render-tag">[/'.$this->shortcode.']</div>
           </div>';
            }
            elseif($settings['as_parent']){

            $output='<div class="element-builder element-parent element-'.$this->shortcode.'" data-child="'.((is_array($settings['as_parent']))?@implode(",",$settings['as_parent']):$settings['as_parent']).'" data-tag="'.$this->shortcode.'">
            <div class="element-holder"><i title="'.__('Move this element','detheme_builder').'" class="flaticon-pointer2"></i></div>
          <div class="element-panel">
          <div class="element-holder-label">'.$settings['title'].'</div>
          <div class="children-toolbar">';

          if(is_array($settings['as_parent'])):

              foreach($settings['as_parent'] as $child){

                if($childElement=get_dt_element($child)){
                  $childSettings=$childElement->getSettings();
                    $output.='<div class="toolbar"><a title="'.sprintf(__('Add %s','detheme_builder'),$childSettings['title']).'" href="#" data-child="'.$child.'"><div class="dashicons dashicons-plus-alt"></div> '.$childSettings['title'].'</a></div>';
                }
              }
            
            else:

                if($childElement=get_dt_element($settings['as_parent'])){
                   $childSettings=$childElement->getSettings();
                   $output.='<div class="toolbar"><a title="'.sprintf(__('Add %s','detheme_builder'),$childSettings['title']).'" href="#" data-child="'.$settings['as_parent'].'"><div class="dashicons dashicons-plus-alt"></div> '.$childSettings['title'].'</a></div>';
                }
          endif;

          $output.='</div>
            <div class="element-toolbar">
              <div class="toolbar element-setting" data-title="'.$settings['title'].'"><a title="'.__('Edit this element','detheme_builder').'" href="#"><div class="dashicons dashicons-edit"></div></a></a></div>
              <div class="toolbar element-shortcode"><a title="'.__('Show this shortcode','detheme_builder').'" href="#">&lt;/&gt;</a></div>
              <div class="toolbar element-copy"><a title="'.__('Copy this element','detheme_builder').'" href="#"><div class="dashicons dashicons-admin-page"></div></a></div>
              <div class="toolbar element-delete"><a title="'.__('Delete this element','detheme_builder').'" href="#"><div class="dashicons dashicons-no-alt"></div></a></div>
            </div>
            </div>
            <div class="open-tag render-tag">['.$this->shortcode." ".trim($content[3]).']</div>
            <div class="element-content dropable-element">'.$this->content.'</div>
            <div class="close-tag render-tag">[/'.$this->shortcode.']</div>
           </div>';

            }
            elseif($settings['as_child']){

            $output='<div class="element-builder element-child element-'.$this->shortcode.'" data-parent="'.$settings['as_child'].'" data-tag="'.$this->shortcode.'">
            <div class="element-holder"><i title="'.__('Move this element','detheme_builder').'" class="flaticon-pointer2"></i></div>
            <div class="element-toolbar element-panel">
                <div class="element-holder-label">'.$settings['title'].'</div>
                <div class="toolbar element-setting" data-title="'.$settings['title'].'"><a title="'.__('Edit this element','detheme_builder').'" href="#"><div class="dashicons dashicons-edit"></div></a></a></div>
                <div class="toolbar element-copy"><a title="'.__('Copy this element','detheme_builder').'" href="#"><div class="dashicons dashicons-admin-page"></div></a></div>
                <div class="toolbar element-delete"><a title="'.__('Delete this element','detheme_builder').'" href="#"><div class="dashicons dashicons-no-alt"></div></a></div>
            </div>
            <div class="element-preview">'.$this->preview_admin().'</div>
            <div class="open-tag render-tag">['.$this->shortcode." ".trim($content[3]).']</div>
            <textarea class="content-tag render-tag">'.$this->content.'</textarea>
            <div class="close-tag render-tag">[/'.$this->shortcode.']</div>
           </div>';

            }
            else{

            $output='<div class="element-builder element-frebase element-'.$this->shortcode.'" data-tag="'.$this->shortcode.'">
            <div class="element-holder"><i title="'.__('Move this element','detheme_builder').'" class="flaticon-pointer2"></i></div>
            <div class="element-panel">
              <div class="element-holder-label">'.$settings['title'].'</div>
              <div class="element-toolbar">
                <div class="toolbar element-setting" data-title="'.$settings['title'].'"><a title="'.__('Edit this element','detheme_builder').'" href="#"><div class="dashicons dashicons-edit"></div></a></a></div>
                <div class="toolbar element-shortcode"><a title="'.__('Show this shortcode','detheme_builder').'" href="#">&lt;/&gt;</a></div>
                <div class="toolbar element-copy"><a title="'.__('Copy this element','detheme_builder').'" href="#"><div class="dashicons dashicons-admin-page"></div></a></div>
                <div class="toolbar element-delete"><a title="'.__('Delete this element','detheme_builder').'" href="#"><div class="dashicons dashicons-no-alt"></div></a></div>
              </div>
            </div>
            <div class="element-preview">'.$this->preview_admin().'</div>
            <div class="open-tag render-tag">['.$this->shortcode." ".trim($content[3]).']</div>
            <textarea class="content-tag render-tag">'.$this->content.'</textarea>
            <div class="close-tag render-tag">[/'.$this->shortcode.']</div>
           </div>';

            }
              break;
          }

         return $output;


        }

        public function shortcode($shortcode) {

        }

        public function preview_admin() {

          $tag=$this->shortcode;
          $atts=$this->atts;
          $function_name=$tag."_shortcode";

          $output=apply_filters('preview_'.$function_name,"",$this->content,$atts);

          if(is_string($output) && $output!=''){

            $previewvalue="";
            $setting=$this->settings;

            if(isset($setting['options']) && is_array($setting['options'])){
              foreach ($setting['options'] as $option) {
                
                if(isset($option['admin_label']) && $option['admin_label'] && isset($atts[$option['param_name']])){
                    $previewvalue.="<div class=\"element-field-preview\"><span class=\"field-preview\">".$option['heading']." : </span><span class=\"field-value\">".$atts[$option['param_name']]."</span></div>";
                }
              }
            }


            return $previewvalue.$output;
          }

           return $this->preview($atts, $this->content);

        }

        public function preview($atts, $content = null) {

            $setting=$this->settings;

            if(isset($setting['options']) && is_array($setting['options'])){

              $previewvalue="";

              foreach ($setting['options'] as $option) {
                
                if(isset($option['admin_label']) && $option['admin_label'] && isset($atts[$option['param_name']])){
                    $previewvalue.="<div class=\"element-field-preview\"><span class=\"field-preview\">".$option['heading']." : </span><span class=\"field-value\">".$atts[$option['param_name']]."</span></div>";
                }
              }

              return $previewvalue;
            }

            return "";
        }

        public function output($atts, $content = null, $tag = '') {

          $content=$this->shortcode_unautop($content);

          $function_name=$tag."_shortcode";
          $output=apply_filters('render_'.$function_name,"",$content,$atts);

          if(is_string($output) && $output!=''){
            return $output;
          }
          else{
            $output=apply_filters('_render_'.$function_name,$content,$atts);
            if(is_string($output) && $output!="" && $output!=$content)
              return $output;
          }

          return $this->render($atts, $content, $tag);
     
        }

        public function render($atts, $content = null, $tag = '') {

          $function_name=$tag."_shortcode";
          $compile="";

         if(function_exists($function_name)){
            $compile.= call_user_func( $function_name,$atts, $content);
          }
          else{
             $compile.=$this->createShortcodeString($tag,$atts,$content);
          }

         return $compile;
     
        }

        public function setShortcodeString($shortcode_string="") {

            $this->shortcode_string=stripslashes($shortcode_string);
            $this->extractShortcodeString();

        }

        public function createShortcodeString($tag,$settings=array(),$content=""){

          $atts=array();

          if(count($settings) && is_array($settings)){

            foreach ($settings as $key => $setting) {

               if($setting!='') $atts[$key]=$key."=\"".$setting."\"";
              
            }
          }

          $shortcode="[$tag ".@implode(" ",$atts)."]".$content."[/$tag]";

          return $shortcode;

        }

      public function shortcode_unautop( $content) {

         if ( $content ) {

            $s = array(
              '[^<\/p>]','[<p>$]'
            );

            $content = preg_replace( $s, '', $content );

          }

          return $content;
        }

        public function getShortcodeString($settings=array(),$content=""){

          $tag=$this->shortcode;
          $atts=array();


         if(count($settings) && is_array($settings)){

            foreach ($settings as $key => $setting) {

               if($setting['value']!='') $atts[$setting['name']]=($setting['name']=='content')?$setting['value']:$setting['name']."=\"".str_replace("\"", "'",$setting['value'])."\"";
              
            }
          }

         if(isset($atts['content'])){
            $content=stripslashes($atts['content']);
            unset($atts['content']);
         }


          $shortcode="[$tag ".@implode(" ",$atts)."]".$content."[/$tag]";

          return $shortcode;

        }

        public function extractShortcodeString($shortcode_string="") {

              if(''==$shortcode_string){

                $shortcode_string=$this->shortcode_string;
              }

              $shortcode=$this->shortcode;
              if(''==$shortcode) return false;

              $shortcode_string=stripslashes($shortcode_string);

              if(!$regexshortcodes=self::getRegex($shortcode)) return false;
              if(!preg_match_all( '/' . $regexshortcodes . '/s', $shortcode_string, $matches, PREG_SET_ORDER ))
                return false;

              $atts=shortcode_parse_atts($matches[0][3]);

              $content=isset($atts['content'])?$atts['content']:$matches[0][5];


              if(isset($atts['content'])) {
                unset($atts['content']);
                $matches[0][5]=$content;
              }

              $this->content=$content;
              $this->atts=$atts;
              return $matches[0];

        }

        public function getSettings() {

            $default=array(
              'title'=>__('Module Title','detheme_builder'),
              'as_parent'=>false,
              'as_child'=>false,
              'is_container'=>false,
              'show_on_create'=>true,
              'options'=>array(),
              );

            return wp_parse_args($this->settings,$default);
        }

        public function getConfigs() {
          $atts=$this->atts;
          $settings=$this->getSettings();
          $options=$settings['options'];
          $config=array();
          if(count($options)){

            foreach ($options as $option) {
              $config[$option['param_name']]=isset($option['default']) && ''!=$option['default']?$option['default']:"";
            }

            return wp_parse_args($atts,$config);


          }
          else{
            return array();
          }
        }

        public function getContent(){

          return $this->content;
        }

        public function getRegex($tagregexp=''){

          if(''==$tagregexp){
               $tagregexp=$this->shortcode;
          }

          if(''==$tagregexp) {

              global $shortcode_tags;
              $tagnames = array_keys($shortcode_tags);
              $tagregexp = join( '|', array_map('preg_quote', $tagnames) );

          }

          $regexshortcodes=
          '\\['                              // Opening bracket
          . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
          . "($tagregexp)"                     // 2: Shortcode name
          . '(?![\\w-])'                       // Not followed by word character or hyphen
          . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
          .     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
          .     '(?:'
          .         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
          .         '[^\\]\\/]*'               // Not a closing bracket or forward slash
          .     ')*?'
          . ')'
          . '(?:'
          .     '(\\/)'                        // 4: Self closing tag ...
          .     '\\]'                          // ... and closing bracket
          . '|'
          .     '\\]'                          // Closing bracket
          .     '(?:'
          .         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
          .             '[^\\[]*+'             // Not an opening bracket
          .             '(?:'
          .                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
          .                 '[^\\[]*+'         // Not an opening bracket
          .             ')*+'
          .         ')'
          .         '\\[\\/\\2\\]'             // Closing shortcode tag
          .     ')?'
          . ')'
          . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]


          return $regexshortcodes;
        }

        public function getSettingForm($echo=false){

          $settings=$this->getSettings();
          $options=$settings['options'];


         $atts=$this->atts;
         if(count($options)){

            $form="";

            foreach ($options as $option) {



              if(''!=$option['type']){

                if('devider'==$option['type']){
                     $form.=self::_getSettingField($option,(isset($atts[$option['param_name']])?(('content'==$option['param_name'])?$this->content:$atts[$option['param_name']]):(isset($option['default'])?$option['default']:'')));
                }
                else{

                  $form.="<div class=\"field-wrap".(isset($option['param_holder_class']) && ''!=$option['param_holder_class']?" ".$option['param_holder_class']:"")."\">";
                  $form.=isset($option['heading'])?"<div class=\"field-label\">".$option['heading']."</div>":"";
                  $form.="<div class=\"field-input field-type-".$option['type']."\">";

                  if($option['param_name']=='content'){
                      $form.=self::_getSettingField($option,(isset($this->content)?$this->content:(isset($option['default'])?$option['default']:'')));
                  }
                  else{
                    $form.=self::_getSettingField($option,(isset($atts[$option['param_name']])?$atts[$option['param_name']]:(isset($option['default'])?$option['default']:'')));
                  }
                 
                  $form.="</div>";
                  if(isset($option['description']) && ''!=$option['description']){
                    $form.="<span class=\"field-description\">".$option['description']."</span>";

                  }
                  $form.="</div>";
                }
              }
            }
            return $echo? print $form : $form;
          }

        }

        public function _getSettingField($option,$value=null){

          $classField='DElement_Field_'.$option['type'];

            if(class_exists($classField)){

              $field=new $classField();

              return $field->render($option,$value); 
            }
            else{

              ob_start();
              do_action($classField,$option,$value);
              return ob_get_clean();
            }
        }
 }

class DElement_Field{

  public function render($option=array(),$value=''){}

}


class DElement_Field_radio extends DElement_Field{

  public function render($options=array(),$value=''){

     $fieldname=$options['param_name'];
     $fieldid=sanitize_html_class($fieldname);
     $css=isset($options['class'])&& ''!=$options['class']?" ".(is_array($options['class'])?@implode(" ",$options['class']):$options['class']):"";//sanitize_html_class($fieldname);

     $output='<div class="radio-options '.$css.'">';
     $radio_options=$options['value'];

     $dependency=create_dependency_param($options);


      if(count($radio_options)){
           $output.='<ul class="inline-list">';

          foreach ($radio_options as $option=>$label) {
              $output.='<li><input type="radio" name="'.$fieldname.'_option" class="radio-option" '.(($option==$value)?'checked="checked" ':'').'value="'.$option.'" />'.$label.'</li>';

          }
           $output.='</ul>';
      }
      $output.='<input type="hidden" class="param_value radio-input-value '.$fieldid.'" name="'.$fieldname.'" value="'.$value.'" '.$dependency.'/>';
      $output.='</div>';
      return     $output;

    }
}

class DElement_Field_check extends DElement_Field{

  public function render($options=array(),$value=''){

     $fieldname=$options['param_name'];
     $fieldid=sanitize_html_class($fieldname);
     $css=isset($options['class'])&& ''!=$options['class']?" ".(is_array($options['class'])?@implode(" ",$options['class']):$options['class']):"";
     $dependency=create_dependency_param($options);

     $output='<div class="checkbox-options '.$css.'">';
      $output.='<input type="checkbox" name="'.$fieldname.'" class="param_value checkbox-option" '.(($value=='1')?'checked="checked" ':'').'value="1" '.$dependency.'/>'.$options['heading'].'';
      $output.='</div>';
      return  $output;

    }
}

class DElement_Field_checkbox extends DElement_Field{

  public function render($options=array(),$value=''){

     $fieldname=$options['param_name'];
     $fieldid=sanitize_html_class($fieldname);
     $css=isset($options['class'])&& ''!=$options['class']?" ".(is_array($options['class'])?@implode(" ",$options['class']):$options['class']):"";

     $output='<div class="checkbox-options '.$css.'">';
     $array_value=@explode(",",trim($value));

     $dependency=create_dependency_param($option);


    if(is_array($options['value']) && count($options['value'])){

      if(isset($options['show_all']) && $options['show_all']){

           $output.='<input type="checkbox" name="'.$fieldname.'_option" class="all-option checkbox-option" '.((!count($array_value) || in_array('all',$array_value))?'checked="checked" ':'').'value="all" />'.(isset($options['show_all_label'])?$options['show_all_label']:__('All','detheme_builder'));
      }

      foreach ($options['value'] as $label=>$key) {
          $output.='<input type="checkbox" name="'.$fieldname.'_option" class="checkbox-option" '.((in_array($key,$array_value))?'checked="checked" ':'').'value="'.$key.'" />'.$label;
      }
    }
      $output.='<input type="hidden" name="'.$fieldname.'" class="param_value checkbox-input-value" value="'.$value.'" '.$dependency.'/>';
      $output.='</div>';
      return  $output;

    }
}

class DElement_Field_devider extends DElement_Field{

  function render($option=array(),$value=''){

    return "<hr/>";
  }

}

class DElement_Field_colorpicker extends DElement_Field{

  function render($option=array(),$value=''){

   $pallete=isset($option['palletes'])?(is_array($option['palletes'])?@implode(",",$option['palletes']):$option['palletes']):true;

   $fieldname=$option['param_name'];
   $fieldid=sanitize_html_class($fieldname);
   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);
   $dependency=create_dependency_param($option);

    return "<input type=\"text\" id=\"".$fieldid."\" data-palletes=\"".$pallete."\" class=\"param_value dt-color-picker".$css."\" name=\"".$fieldname."\" value=\"".$value."\" ".$dependency."/>";
  }

}

class DElement_Field_textfield extends DElement_Field{

  function render($option=array(),$value=''){

   $dependency=create_dependency_param($option);
   $fieldname=$option['param_name'];
   $fieldid=sanitize_html_class($fieldname);
   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);

    return "<input type=\"text\" id=\"".$fieldid."\" class=\"param_value inputbox".$css."\" name=\"".$fieldname."\" value=\"".$value."\"". $dependency."/>";
  }

}

class DElement_Field_textarea extends DElement_Field{

  function render($option=array(),$value=''){

   $fieldname=$option['param_name'];
   $fieldid=sanitize_html_class($fieldname);
   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);

   $dependency=create_dependency_param($option);

    return "<textarea id=\"default-".$fieldid."\" class=\"param_value text_area ".$css."\" name=\"".$fieldname."\" ".$dependency.">".htmlspecialchars($value)."</textarea>";
  }

}

class DElement_Field_textarea_html extends DElement_Field_textarea{

  function render($option=array(),$value=''){


   $fieldname=$option['param_name'];
   $fieldid=sanitize_html_class($fieldname);
   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";

   $dependency=create_dependency_param($option);

  ob_start();
    wp_editor( $value, "editor-".$fieldid, array(
      'dfw' => true,
      'drag_drop_upload' => true,
      'tabfocus_elements' => 'insert-media-button,save-post',
      'editor_height' => 360,
      'textarea_name'=>$fieldname,
      'editor_class'=>'param_value html-editor '.$css,
      'tinymce' => array(
        'resize' => false,
        'add_unload_trigger' => false,
      ),
    ) );

    $compile=ob_get_contents();

    ob_end_clean();


    return $compile;

  }

}

class DElement_Field_dropdown extends DElement_Field{

  function render($option=array(),$value=null){

   $fieldname=$option['param_name'];
   $fieldid=sanitize_html_class($fieldname);
   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);

   $dependency=create_dependency_param($option);

    $compile="<select id=\"".$fieldid."\" class=\"param_value select-option".$css."\" name=\"".$fieldname."\"".$dependency.">";



    if(is_array($option['value']) && count($option['value'])){
       foreach ($option['value'] as $key=>$label) {

          if ( is_numeric( $key ) && !is_assoc_array($option['value']) ) {
            $key = $label;
          }

          $compile.="<option value=\"".$key."\"".($key==$value && ''!=$value?" selected=\"selected\"":"").">".$label."</option>";
      }
    }
    $compile.="</select>";
    return $compile;
  }

}


class DElement_Field_iconlists extends DElement_Field{

  function render($option=array(),$value=''){

   $fieldname=$option['param_name'];
   $fieldid=sanitize_html_class($fieldname);
   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);

   $icons=detheme_font_list();

   $output="<div class=\"dt-iconlist ".$css."\">";

   $dependency=create_dependency_param($option);

   if($icons){
       $output.="<span class=\"icon-selection-preview\"><i class=\"".$value."\"></i></span>";
       $output.="<i id=\"".$fieldid."_icon_selection_value\" class=\"icon_selection_button fontellopicker-plus\" title=\"".__('Add New Icon','detheme_builder')."\"></i>";
       $output.='<script type="text/javascript">
        jQuery(document).ready(function($){
            var options={
                icons:new Array(\''.@implode("','",$icons).'\'),
                onUpdate:function(e){
                  var par=this.closest(\'.dt-iconlist\'),fieldinput=par.find(\'[name='.$fieldname.']\'),preview=par.find(\'.icon-selection-preview i\');
                  fieldinput.val(e);
                  preview.removeClass().addClass(e);
                }
            };

            $("#'.$fieldid.'_icon_selection_value").iconPicker(options);
        });
        </script>';
    }
    else{

          $output.=sprintf(__('No css font available, please check plugin folder <b>%s</b>','detheme_builder'),DTPB_BASENAME.'/webicons/');

    }
    $output .= '<input id="'.$fieldid.'" name="' . $fieldname . '" class="param_value icon-selection-value ' . $option['param_name'] . ' ' . $option['type'] . '_field" type="hidden" value="' . $value . '" '.$dependency.'/></div>';    
    return $output;
  }

}



class DElement_Field_iconlists_multi extends DElement_Field{

  function render( $option=array(),$value='' ) {

   $dependency=create_dependency_param($option);
   $output="";

   $icons=detheme_font_list();

   $theIcons=(''!==$value)?explode(',',trim($value)):false;

   $fieldname=$option['param_name'];
   $fieldid=sanitize_html_class($fieldname);
   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);


   $output="<div class=\"dt-iconlist ".$css."\">";

   if($icons){
         $output.="<ul class=\"edit_form_icon_choice\">";
        if($theIcons){

            foreach ($theIcons as $theIcon) {
                $output.='<li><i data-icon="'.$theIcon.'" class="'.$theIcon.'"></i></li>';
            }

        }

        $output.="</ul>";

       $output.="<i id=\"".$fieldid."_icon_selection_value\" class=\"icon_selection_button fontellopicker-plus\" title=\"".__('Add New Icon','detheme_builder')."\"></i>";
       $output.='<script type="text/javascript">
        jQuery(document).ready(function($){
            var options={
                icons:new Array(\''.@implode("','",$icons).'\'),
                onUpdate:function(e){
                  var par=this.closest(\'.dt-iconlist\'),fieldinput=par.find(\'[name='.$fieldname.']\'),
                  preview=par.find(\'.edit_form_icon_choice\');

                  var newicon=$(\'<li><i data-icon="\'+e+\'" class="\'+e+\'"></i></li>\');
                  newicon.click(function(){
                    this.remove();
                    '.$fieldid.'_saveIcon();
                  });
                  preview.append(newicon);
                  '.$fieldid.'_saveIcon();
                }
            },$'.$fieldid.'choices=$(\'#'.$fieldid.'\').closest(\'.dt-iconlist\').find(\'.edit_form_icon_choice\');

            $("#'.$fieldid.'_icon_selection_value").iconPicker(options);

            var '.$fieldid.'_saveIcon=function(){

              var theicon=$(\'i\',$'.$fieldid.'choices);
              var select=[];
              theicon.each(function (index,el){
                select.push($(el).data(\'icon\'));
              });

              $(\'#'.$fieldid.'\').val(select.join(\',\'));
            }

            $(\'li\',$'.$fieldid.'choices).click(function(){
                this.remove();
              '.$fieldid.'_saveIcon();
            });
        });
        </script>';
  
    }
    else{

          $output.=sprintf(__('No css font available, please check plugin folder <b>%s</b>','detheme_builder'),DTPB_BASENAME.'webicons/');

    }

    $output .= '<input name="' . $fieldname . '" id="'.$fieldid.'" class="param_value icon-selection-value ' . $option['param_name'] . ' ' . $option['type'] . '_field" type="hidden" value="' . $value . '" ' . $dependency . '/></div>';


    return $output;

  }
}

class DElement_Field_image extends DElement_Field{

  function render($option=array(),$value=''){

   $fieldname=$option['param_name'];
   $fieldid=sanitize_html_class($fieldname);
   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);
   $preview_image="";

   $dependency=create_dependency_param($option);


   if(''!=$value  && $image_url = wp_get_attachment_image_src( trim($value), 'thumbnail')){

    $preview_image="<div class=\"preview-image\"><img class=\"add_field_image\" width=\"100\" data-id=\"".trim($value)."\" src=\"".$image_url[0]."\" /><a class=\"remove_field_image\"><div class=\"dashicons dashicons-no-alt\"></div></a></div>";
   }
   $output="<div class=\"field-image ".$css."\">";
   $output.="<div class=\"preview-images\">".$preview_image."</div>";
   $output.="<input type=\"hidden\" id=\"".$fieldid."\" class=\"param_value ".$css."\" name=\"".$fieldname."\" value=\"".$value."\" ".$dependency."/>";
   $output.="<a class=\"add_field_image \">".__('Add Image','detheme_builder')."</a>";
   $output.="</div>";

   return $output;
  }

}

class DElement_Field_images extends DElement_Field{

  function render($option=array(),$value=''){

   $fieldname=$option['param_name'];
   $fieldid=sanitize_html_class($fieldname);
   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);
   $preview_image="";

   $dependency=create_dependency_param($option);


   if(''!=$value  && count($values=explode(',',trim($value)))){


    foreach ($values as $image) {
      $image_url = wp_get_attachment_image_src( trim($image), 'thumbnail');
      $preview_image.="<div class=\"preview-image\"><img width=\"100\" data-id=\"".trim($image)."\" src=\"".$image_url[0]."\" /><a class=\"remove_field_image\"><div class=\"dashicons dashicons-no-alt\"></div></a></div>";


    }
  
   }

   $output="<div class=\"field-image ".$css."\">";
   $output.="<div class=\"preview-images\">".$preview_image."</div>";
   $output.="<input type=\"hidden\" id=\"".$fieldid."\" class=\"param_value ".$css."\" name=\"".$fieldname."\" value=\"".$value."\" ".$dependency."/>";
   $output.="<a class=\"add_field_image multi-image\">".__('Add Image','detheme_builder')."</a>";
   $output.="</div>";

   return $output;
  }

}

class DElement_Field_video extends DElement_Field{

  function render($option=array(),$value=''){

   $fieldname=$option['param_name'];
   $fieldid=sanitize_html_class($fieldname);
   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);
   $dependency=create_dependency_param($option);

   $value=trim($value);

   $params=isset($option['params'])?$option['params']:array();
   $params=wp_parse_args($params,array('mime_type'=>'video'));
   $mime_types=$params['mime_type'];

   $video='';

    if($value){
      $media_url=wp_get_attachment_url($value);
      $mediadata=wp_get_attachment_metadata($value);

      $videoformat="video/mp4";
      if($mediadata['mime_type']=='video/webm'){
           $videoformat="video/webm";
      }

      $video='<video class="attached_video" data-id="'.$value.'" autoplay width="266">
      <source src="'.$media_url.'" type="'.$videoformat.'" /></video>';
    }
   $output="<div class=\"field-video ".$css."\" data-mime=\"".$mime_types."\">";
   $output.="<div class=\"preview-video\"><a class=\"add_field_video\" href=\"#\" title=\"".__('Add Video', "detheme_builder")."\">".($video!=''?$video:__('Add Video', "detheme_builder")).'</a>';
   $output.= '<a href="#" style="display:'.($video!=''?"block":"none").'" class="remove_attach_video">'.__('Remove Video','detheme_builder').'</a></div>';
   $output.="<input type=\"hidden\" id=\"".$fieldid."\" class=\"param_value ".$css."\" name=\"".$fieldname."\" value=\"".$value."\" ".$dependency."/>";
   $output.="</div>";

   return $output;
  }

}


class DElement_Field_iconfield extends DElement_Field{

    function render($option=array(),$value=''){

     $dependency=create_dependency_param($option);

     $fieldname=$option['param_name'];
     $fieldid=sanitize_html_class($fieldname);
     $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);

        $output = '<span class="icon-wrap"><i class="'.$option['class'].'"></i></span><input name="' . $fieldname . '" id="'.$fieldid.'" class="param_value inputbox ' . $option['param_name'] . ' ' . $option['type'] . '_field" type="text" value="' . $value . '" '.$dependency.'/>';    

        return $output;

    }

}


class DElement_Field_slider_value extends DElement_Field{

  function render($option=array(),$value=''){


   $fieldname=$option['param_name'];
   $fieldid=sanitize_html_class($fieldname);
   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);

    $output="";
    $params=$option['params'];

    $dependency=create_dependency_param($option);

    $params=wp_parse_args($params,array('min'=>0,'max'=>1000,'step'=>'1'));

    $output='<div class="input-slider-container '.$css.'"><input type="text" class="'.$fieldid.' slider_value param_value" name="'.$fieldname.'" value="'.$value.'" '.$dependency.'/>';
    $output.='<div data-min="'.$params['min'].'" data-max="'.$params['max'].'" data-step="'.$params['step'].'" class="input-slider" ></div></div>';
    return     $output;
  }

}


class DElement_Field_select_layout extends DElement_Field{

  function render($option=array(),$value=''){

   $fieldname=$option['param_name'];
   $fieldid=sanitize_html_class($fieldname);
   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);
   $output="";

   $dependency=create_dependency_param($option);

    $options=$option['value'];

    $output.="<ul class=\"option-select ".$css."\">";

    if(count($options)){

        foreach($options as $layout=>$label){
            $output.="<li class=\"layout-option layout-".sanitize_title($layout).($value==$layout?" active":"")."\" data-option=\"".$layout."\">".$label."</li>";
        }
    }

    $output.='<input value="' . $value . '" class="'.$option['param_name'].' '.$option['type'].'_field param_value" type="hidden" name="'.$fieldname.'" '.$dependency.'/> ';
    $output.="</ul>";
    return $output;
  }

}

class DElement_Field_categories extends DElement_Field{

  function render($option=array(),$value=''){

   $fieldname=$option['param_name'];
   $fieldid=sanitize_html_class($fieldname);
   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);

   $dependency=create_dependency_param($option);

    $args = array(
          'orderby' => 'name',
          'show_count' => 0,
          'pad_counts' => 0,
          'hierarchical' => 0,
    );


    $categories=get_categories($args);

    $compile="<select id=\"".$fieldid."\" class=\"param_value select-option".$css."\" name=\"".$fieldname."\"".$dependency.">";
    $compile .= '<option value="">'.__('All Categories','detheme_builder').'</option>';

    if(count($categories)):

    foreach ( $categories as $category ) {

        $selected = '';
        if ($value!=='' && $category->term_id === $value) {
            $selected = ' selected="selected"';
        }
        $compile .= '<option value="'.$category->term_id.'"'.$selected.'>'.$category->name.'</option>';
    }

    endif;

    $compile.="</select>";
    return $compile;
  }

}

class DElement_Field_taxonomy extends DElement_Field{

  function render($option=array(),$value=''){

   $fieldname=$option['param_name'];
   $fieldid=sanitize_html_class($fieldname);
   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);

   $dependency=create_dependency_param($option);

    $taxonomies=get_taxonomies();

    $compile="<select id=\"".$fieldid."\" class=\"param_value select-option".$css."\" name=\"".$fieldname."\"".$dependency.">";
    $compile .= '<option value="">'.__('Select Taxonomy','detheme_builder').'</option>';

    if(count($taxonomies)):

    foreach ( $taxonomies as $taxonomy ) {

        $tax = get_taxonomy($taxonomy);
        if ( !$tax->show_tagcloud || empty($tax->labels->name) )
          continue;

        $compile .= '<option value="'.esc_attr($taxonomy).'" '.selected($taxonomy, $value).'>'.$tax->labels->name.'</option>';
    }

    endif;

    $compile.="</select>";
    return $compile;
  }

}
?>

<?php
/**
 * @package WordPress
 * @subpackage Krypton
 * @version 3.0.0
 * @since Krypton 3.0.0
 */
defined('ABSPATH') or die();

if(is_plugin_active('detheme_builder/detheme_builder.php')){


if(!function_exists('detheme_get_image_id')){

    function detheme_get_image_id($image_url) {


        if(!function_exists('wp_generate_attachment_metadata')){

            require_once(ABSPATH . 'wp-admin/includes/image.php');
        }

        global $wpdb;

        $upload_dir_paths = wp_upload_dir();

        $attachment = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 

        if(!$attachment && false !== strpos( $image_url, $upload_dir_paths['baseurl'] )){


            // If this is the URL of an auto-generated thumbnail, get the URL of the original image
            $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $image_url );

            // Remove the upload path base directory from the attachment URL
            $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

            $image_path=$upload_dir_paths['basedir']."/".$attachment_url;

            $attachment=wp_insert_attachment(array('post_title'=>sanitize_title(basename($image_url)),'post_mime_type'=>'image/jpg','guid'=>$image_url));
            wp_update_attachment_metadata( $attachment, wp_generate_attachment_metadata( $attachment ,$image_path));
            update_attached_file($attachment,$image_path);
        }

       return $attachment;

    }
}

function gt3_stripslashes_in_array(&$item)

{

    $item = stripslashes($item);

}

function convert_detheme_gt3_column($gt3_column='block_1_1'){

  $column=12;

  switch($gt3_column){
        case 'block_1_4':
                $column = 3;
            break;
        case 'block_1_3':
                $column = 4;
            break;
        case 'block_1_2':
                $column = 6;
            break;
        case 'block_2_3':
                $column = 8;
            break;
        case 'block_3_4':
                $column = 9;
            break;
    }

    return $column;


}

function convert_gt3_to_shortcode($modules=array()){


    $shortcodes=array();


	if (!is_array($modules)) {$modules=array();}

    $row_width=0;
    $modul_id=0;
    $is_section=false;
    $is_row=false;

   foreach ($modules as $module_key => $module) {


        $shortcode="";
        $column_width=convert_detheme_gt3_column($module['size']);

        if(!$is_section && $row_width==0 && !in_array($module['name'],array('dt_section_start','dt_section_end','dt_section_separator'))){
            $shortcode="[dt_row expanded=\"3\"][dt_column column=\"12\"]";
        }

        if(!in_array($module['name'],array('dt_section_start','dt_section_end','dt_section_separator'))){

           if($row_width==0){
               $shortcode.="[dt_inner_row]";
           }

            $shortcode.="[dt_inner_column column=\"".$column_width."\"]";


        }

        switch ($module['name']) {

            case 'dt_section_start': 
                        $shortcode.="[dt_row".
                        (isset($module['padding_top'])?' p_top="'.$module['padding_top'].'"':'').
                        (isset($module['padding_bottom'])?' p_bottom="'.$module['padding_bottom'].'"':'').
                        (isset($module['margin_top'])?' m_top="'.$module['margin_top'].'"':'').
                        (isset($module['margin_bottom'])?' m_bottom="'.$module['margin_bottom'].'"':'').
                        (isset($module['bg_color'])?' bg_color="#'.$module['bg_color'].'"':'').
                        (isset($module['properties'])?' background_style="'.($module['properties']=='stretch'?"cover":($module['properties']=='parralax'?"parallax":"repeat")).'"':'').
                        (isset($module['bg_image']) && $module['bg_image']!=''?' background_type="image" image="'.detheme_get_image_id($module['bg_image']).'"':'').
                        " expanded=\"2\"][dt_column column=\"12\"]";
                        $is_section=true;
                break;
            case 'dt_section_end': 


                        if($row_width > 0 ){

                            $row_width_need=12 - $row_width;
                            $shortcodes['end_section'.$modul_id]="[dt_inner_column column=\"".$row_width_need."\"][/dt_inner_column][/dt_inner_row]";
                            $modul_id++;
                            $row_width=0;
                        }

                        $shortcode.="[/dt_column][/dt_row]";
                        $is_section=false;
                break;
            case 'html': 
            case 'html_raw': 

                        if(isset($module['heading_text']) && $module['heading_text']!=''){
                            $heading_tag=isset($module['heading_size']) && $module['heading_size']!=''?$module['heading_size']:"h2";
                            $heading_align=isset($module['heading_alignment']) && $module['heading_alignment']!=''?$module['heading_alignment']:"";
                            $heading_color=isset($module['heading_color']) && $module['heading_color']!=''?$module['heading_color']:"";

                            $heading="<".$heading_tag." style=\"".($heading_align?"text-align:".$heading_align.";":"").
                            ($heading_color?"color:#".$heading_color:"")."\">".$module['heading_text']."</$heading_tag>";

                            $module["html"]=$heading.$module["html"];


                        }


                        $shortcode.="[dt_text_html".
                        (isset($module['custom_class']) && $module['custom_class']!=''?' el_class="'.$module['custom_class'].'"':"").
                        (isset($module['padding_bottom']) && $module['padding_bottom']!=''?' p_bottom="'.$module['padding_bottom'].'"':'')."]".
                        $module["html"]."[/dt_text_html]";
                break;
            case 'section_header':
                        $shortcode.="[section_header layout_type=\"section-heading-krypton\" use_decoration=\"1\" separator_position=\"center\"".
                        " pre_heading=\"".$module["pre_heading"]."\" after_heading=\"".$module["after_heading"]."\" ".
                        "main_heading=\"".$module['main_heading']."\" separator_color=\"#1abc9c\"".
                        (isset($module['padding_bottom'])?' m_bottom="40px"':'')."][/section_header]";
                break;
            case 'dt_section_separator':
                        $shortcode.="[dt_row expanded=\"1\"][dt_column column=\"12\"][dt_section_separator separator=\"".$module["separator"]."\" separatorcolor=\"#".$module["separatorcolor"].
                        "\" backgroundcolor=\"#".$module["backgroundcolor"]."\"".
                        (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'')."][/dt_section_separator][/dt_column][/dt_row]";

                break;
            case 'dt_twitter_slider':
                        $shortcode.="[dt_twitter_slider twitteraccount=\"".$module["twitter_account"]."\"".
                        " numberoftweets=\"".$module["tweet_count"]."\" dateformat=\"".$module["date_format"]."\"".
                        " twittertemplate=\"".$module["template"]."\" color_text=\"#".$module["color_text"]."\"".
                        " isautoplay=\"".$module["autoplay"]."\" transitionthreshold=\"".$module["transitionthreshold"]."\"".
                        (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'').
                        "'][/dt_twitter_slider]";
                break;
            case 'dt_portfolio':

                        if($module["heading_text"]!=''){

                             $shortcode.="[section_header use_decoration=\"0\" main_heading=\"".$module['heading_text']."\"".
                             (isset($module['heading_color'])?' color="#'.$module['heading_color'].'"':'').
                             (isset($module['heading_alignment'])?' text_align="'.$module['heading_alignment'].'"':'')."][/section_header]";
                        }

                    $shortcode.="[dt_portfolio portfolio_num=\"".$module["portfolio_per_page"]."\"".
                        " column=\"".$module["view_type"]."\" show_filter=\"".(isset($module["filter"]) ? $module["filter"] : "no")."\"".
                        " layout=\"1\" portfolio_cat=\"".@implode(",", array_keys($module["selected_categories"]))."\" spy=\"".$module["scroll_type"]."\"".
                        " scroll_delay=\"".$module["scroll_delay"]."\"".
                        (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'').
                        "][/dt_portfolio]";

                break;
            case 'post_carousel':
                     $shortcode.="[post_carousel number_of_posts=\"".$module["number_of_posts"]."\" col=\"".$module["posts_per_line"]."\"".
                     " category=\"".@implode(',',array_keys($module["selected_categories"]))."\" speed=\"".$module["slide_speed"]."\" sorting_type=\"".$module["sorting_type"]."\"".
                     " type=\"".$module["layout_type"]."\" spy=\"".$module["scroll_type"]."\" scroll_delay=\"".$module["scroll_delay"]."\"".
                     (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'').
                     "][/post_carousel]";
                break;
            case 'dt_price_table':

                    $price_items_number=3;
                    $tempcompile='';

                    if (isset($module["module_items"]) && is_array($module["module_items"])) {
                        $price_items_number = max(3,min(count($module["module_items"]),4));
                        
                        foreach ($module["module_items"] as $key => $thisitem) {

                            if (isset($thisitem['price_features']) && is_array($thisitem['price_features'])) {
                                $price_features = @implode("\n", $thisitem['price_features']);
                            } else {
                                $price_features = '';
                            }

                            $tempcompile .= "[dt_pricetable_item block_name='".$thisitem['block_name']."' block_subtitle='".$thisitem['block_subtitle']."' block_price='".$thisitem['block_price']."' block_symbol='".$thisitem['block_symbol']."' block_link='".$thisitem['block_link']."' get_it_now_caption='".$thisitem['get_it_now_caption']."' most_popular='".$thisitem['most_popular']."' price_column='".$price_items_number."' spy='".$thisitem["scroll_type"]."' spydelay='".$thisitem["scroll_delay"]."']".$price_features."[/dt_pricetable_item]";
                        }
                    }

                    if($module["heading_text"]!=''){

                         $shortcode.="[section_header use_decoration=\"0\" main_heading=\"".$module['heading_text']."\"".
                         (isset($module['heading_color'])?' color="#'.$module['heading_color'].'"':'').
                         (isset($module['heading_alignment'])?' text_align="'.$module['heading_alignment'].'"':'')."][/section_header]";
                    }


                     $shortcode.="[dt_pricetable table_column=\"".$price_items_number."\"".
                     (isset($module['custom_class'])?' el_class="'.$module['custom_class'].'"':'').
                     (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'').
                     "]".$tempcompile."[/dt_pricetable]";


                break;
            case 'dt_progressbar':
                        if($module["heading_text"]!=''){

                             $shortcode.="[section_header use_decoration=\"0\" main_heading=\"".$module['heading_text']."\"".
                             (isset($module['heading_color'])?' color="#'.$module['heading_color'].'"':'').
                             (isset($module['heading_alignment'])?' text_align="'.$module['heading_alignment'].'"':'')."][/section_header]";
                        }

                        if (isset($module["module_items"]) && is_array($module["module_items"])) {
                           
                            foreach ($module["module_items"] as $diagkey => $diag_item) {
                              $shortcode .= "[dt_progressbar_item unit=\"%\" value=\"".$diag_item['percent']."\"".
                              (isset($diag_item["segment_color"])?" color=\"#".$diag_item["segment_color"]."\"":"").
                              (isset($diag_item["segment_color"])?" bg=\"#".$diag_item["inactive_color"]."\"":"").
                              (isset($diag_item["title"])?" title=\"".$diag_item["title"]."\"":"")."][/dt_progressbar_item]";
                            }

                        }


                break;
            case 'dt_circlebar':
                        if($module["heading_text"]!=''){

                             $shortcode.="[section_header use_decoration=\"0\" main_heading=\"".$module['heading_text']."\"".
                             (isset($module['heading_color'])?' color="#'.$module['heading_color'].'"':'').
                             (isset($module['heading_alignment'])?' text_align="'.$module['heading_alignment'].'"':'')."][/section_header]";
                        }

                        if (isset($module["module_items"]) && is_array($module["module_items"])) {

                            $module_items=array_chunk($module["module_items"], 12);
                            $column_width=false;

                            foreach ($module_items as $num_row => $module_item) {

                                $shortcode .= "[dt_inner_row_1 ".(isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'')."]";

                                $diag_items_number = count($module_item);
                                $column_width=(!$column_width)?floor(12/$diag_items_number):$column_width;

                                $row_width_section=0;


                                foreach ($module_item as $circlebar_item) {

                                    $shortcode .= "[dt_inner_column_1 column=\"".$column_width."\"][dt_circlebar_item unit=\"%\" value=\"".$circlebar_item['percent']."\"".
                                    (isset($circlebar_item["segment_color"])?" color=\"#".$circlebar_item["segment_color"]."\"":"").
                                    (isset($circlebar_item["inactive_color"])?" bg=\"#".$circlebar_item["inactive_color"]."\"":"").
                                    (isset($circlebar_item["title"])?" title=\"".$circlebar_item["title"]."\"":"")."][/dt_circlebar_item][/dt_inner_column_1]";
                                    
                                    $row_width_section+=$column_width;
                                }


                                if($row_width_section < 12 ){

                                    $shortcode .= "[dt_inner_column_1 column=\"".(12 - $row_width_section)."\"][/dt_inner_column_1]";


                                }


                                $shortcode .= "[/dt_inner_row_1]";

                            }
                        }

                break;
            case 'dt_verticalslide':
                        if($module["heading_text"]!=''){

                             $shortcode.="[section_header use_decoration=\"0\" main_heading=\"".$module['heading_text']."\"".
                             (isset($module['heading_color'])?' color="#'.$module['heading_color'].'"':'').
                             (isset($module['heading_alignment'])?' text_align="'.$module['heading_alignment'].'"':'')."][/section_header]";
                        }

                        $shortcode.="[dt_verticaltab spy=\"".$module["scroll_type"]."\" scroll_delay=\"".$module["scroll_delay"].
                        (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'')."\"]";

                        if (isset($module["vertical_slide"]) && is_array($module["vertical_slide"])) {

                           foreach ($module["vertical_slide"] as $slide) {

                            $shortcode.="[dt_verticaltab_item icon_type=\"".preg_replace('/^icon-/', 'fontelloicon-', $slide['data-icon-code'])."\"".
                            (isset($slide["title"])?" title=\"".$slide["title"]."\"":"").
                            (isset($slide["subtitle"])?" sub_title=\"".$slide["subtitle"]."\"":"")."]";

                            if(isset($slide['slider_image']) && ""!=$slide['slider_image']){

                                $image_id=detheme_get_image_id($slide['slider_image']);

                                if ($slide['link'] != '') {
                                    $shortcode .= '<a href="'.$slide['link'].'">'."<img class=\"img-responsive alignnone size-full wp-image-".$image_id."\" src=\"".$slide['slider_image']."\" alt=\"\" /></a>";
                                } else {
                                    $shortcode.="<img class=\"img-responsive alignnone size-full wp-image-".$image_id."\" src=\"".$slide['slider_image']."\" alt=\"\" />";
                                }

                            }
                            $shortcode.="[/dt_verticaltab_item]";

                           }

                        }

                        $shortcode.="[/dt_verticaltab]";
                break;
            case 'dt_iconboxes':
                         $shortcode.="[dt_iconbox".
                         (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'').
                         (isset($module["icon_type"])?" icon_type=\"".$module["icon_type"]."\"":"").
                         (isset($module["layout_type"])?" layout_type=\"".$module["layout_type"]."\"":"").
                         (isset($module["target"])?" target=\"".$module["target"]."\"":"").
                         (isset($module["link"])?" link=\"".$module["link"]."\"":"").
                         (isset($module["iconbox_heading"])?" iconbox_heading=\"".$module["iconbox_heading"]."\"":"").
                         (isset($module["iconbox_number"])?" iconbox_number=\"".$module["iconbox_number"]."\"":"").
                         (isset($module["scroll_type"])?" spy=\"".$module["scroll_type"]."\"":"").
                         (isset($module["scroll_delay"])?" scroll_delay=\"".$module["scroll_delay"]."\"":"").
                        "]".$module["iconbox_text"]."[/dt_iconbox]";

                break;
            case 'dt_accordion':
                        if(isset($module["heading_text"]) && $module["heading_text"]!=''){

                             $shortcode.="[section_header use_decoration=\"0\" main_heading=\"".$module['heading_text']."\"".
                             (isset($module['heading_color'])?' color="#'.$module['heading_color'].'"':'').
                             (isset($module['heading_alignment'])?' text_align="'.$module['heading_alignment'].'"':'')."][/section_header]";
                        }

                        $shortcode.="[dt_accordion".
                             (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'')."]";


                        if (is_array($module["module_items"])) {
                            foreach ($module["module_items"] as $acckey => $acc_item) {
                                $shortcode .= "[dt_accordion_item title='".$acc_item['title']."' expanded_state='".$acc_item['expanded_state']."']".$acc_item['description']."[/dt_accordion_item]";
                            }
                        }


                        $shortcode.="[/dt_accordion]";
                break;
            case 'dt_subslider':
                        if(isset($module["heading_text"]) && $module["heading_text"]!=''){

                             $shortcode.="[section_header use_decoration=\"0\" main_heading=\"".$module['heading_text']."\"".
                             (isset($module['heading_color'])?' color="#'.$module['heading_color'].'"':'').
                             (isset($module['heading_alignment'])?' text_align="'.$module['heading_alignment'].'"':'')."][/section_header]";
                        }
                        $shortcode.="[dt_subslider".
                             (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'')."]";


                        if (is_array($module["module_items"])) {
                            foreach ($module["module_items"] as $acckey => $acc_item) {
                                $shortcode .= "[dt_subslider_item title=\"".$acc_item['title']."\"".
                                              (isset($acc_item["subtitle"])?" sub_title=\"".$acc_item["subtitle"]."\"":"").
                                              (isset($acc_item["linktarget"])?" linktarget=\"".$acc_item["linktarget"]."\"":"").
                                              (isset($acc_item["link"])?" link=\"".$acc_item["link"]."\"":"").
                                              ((isset($acc_item["slider_image"]) && $image_id=detheme_get_image_id($acc_item['slider_image'])) ?" slider_image=\"".$image_id."\"":"").
                                              (isset($acc_item["linklabel"])?" linklabel=\"".$acc_item["linklabel"]."\"":"").
                                              "]".$acc_item['description']."[/dt_subslider_item]";
                            }
                        }

                        $shortcode.="[/dt_subslider]";

                break;
            case 'dt_widget':
                        if(isset($module["heading_text"]) && $module["heading_text"]!=''){

                             $shortcode.="[section_header use_decoration=\"0\" main_heading=\"".$module['heading_text']."\"".
                             (isset($module['heading_color'])?' color="#'.$module['heading_color'].'"':'').
                             (isset($module['heading_alignment'])?' text_align="'.$module['heading_alignment'].'"':'')."][/section_header]";
                        }

                        $shortcode.="[dt_widget".
                             (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'').
                             (isset($module['sidebar'])?' position="'.$module['sidebar'].'"':'').
                             (isset($module['customclass'])?' el_class="'.$module['customclass'].'"':'')."]";
                        $shortcode.="[/dt_widget]";


                break;
            case 'dt_wooproduct':

                        if(isset($module["heading_text"]) && $module["heading_text"]!=''){

                             $shortcode.="[section_header use_decoration=\"0\" main_heading=\"".$module['heading_text']."\"".
                             (isset($module['heading_color'])?' color="#'.$module['heading_color'].'"':'').
                             (isset($module['heading_alignment'])?' text_align="'.$module['heading_alignment'].'"':'')."][/section_header]";
                        }

                        $compile_cats = array();

                        if (isset($module["selected_categories"]) && (is_array($module["selected_categories"]))) {
                            foreach ($module["selected_categories"] as $catkey => $catvalue) {
                                array_push($compile_cats, $catkey);
                            }
                        }

                        $shortcode.="[dt_wooproduct".
                             (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'').
                             (isset($module['posts_per_page'])?' posts_per_page="'.$module['posts_per_page'].'"':'').
                             ((isset($module['filter']) && $module['filter']=='on')?' filter="on"':'').
                             (isset($module['spy'])?' spy="'.$module['spy'].'"':'').
                             (isset($module['scroll_delay'])?' scroll_delay="'.$module['scroll_delay'].'"':'').
                             (count($compile_cats)?" selected_categories=\"".@implode(",", $compile_cats)."\"":"").
                             (isset($module['view_type'])?' view_type="'.$module['view_type'].'"':'')."]";
                        $shortcode.="[/dt_wooproduct]";


                break;
            case 'dt_promotion':
                        $shortcode.="[dt_promotion".
                             (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'').
                             (isset($module['button_label'])?' button_label="'.$module['button_label'].'"':'').
                             (isset($module['button_link'])?' button_link="'.$module['button_link'].'"':'').
                             ((isset($module["bg_image"]) && $image_id=detheme_get_image_id($module['bg_image'])) ?" bg_image=\"".$image_id."\"":"")."]";

                        if(isset($module['description'])){
                            $shortcode.=$module['description'];
                        }

                        $shortcode.="[/dt_promotion]";
                break;
            case 'dt_contact_form':
                        if(isset($module["heading_text"]) && $module["heading_text"]!=''){

                             $shortcode.="[section_header use_decoration=\"1\" layout_type=\"section-heading-krypton\" main_heading=\"".$module['heading_text']."\"".
                             (isset($module['heading_color'])?' color="#'.$module['heading_color'].'"':'').
                             (isset($module['heading_alignment'])?' text_align="'.$module['heading_alignment'].'"':'')."][/section_header]";
                        }

                        $shortcode.="[dt_contact_form".
                             (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'').
                             (isset($module['heading_color'])?' font_color="#'.$module['heading_color'].'"':'').'][/dt_contact_form]';
                break;
            case 'dt_map':
                        $shortcode.="[krypton_map".
                             (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'').
                             (isset($module['map_type'])?' map_type="'.$module['map_type'].'"':'').'][/krypton_map]';
                break;
            case 'dt_linechart':
                        if(isset($module["heading_text"]) && $module["heading_text"]!=''){

                             $shortcode.="[section_header use_decoration=\"0\" main_heading=\"".$module['heading_text']."\"".
                             (isset($module['heading_color'])?' color="#'.$module['heading_color'].'"':'').
                             (isset($module['heading_alignment'])?' text_align="'.$module['heading_alignment'].'"':'')."][/section_header]";
                        }
                        $shortcode.="[dt_linechart".
                             (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'').
                             (isset($module['diagram_size'])?' size="'.$module['diagram_size'].'"':'').
                             (isset($module['diagram_color'])?' color="#'.$module['diagram_color'].'"':'').
                             (isset($module['label_font_size'])?' lblfsize="'.$module['label_font_size'].'"':'').
                             (isset($module['label_color'])?' lblcolor="#'.$module['label_color'].'"':'').
                             (isset($module['show_label'])?' show_label="'.$module['show_label'].'"':'').']';

                         if (isset($module["module_items"]) && is_array($module["module_items"])) {
                            foreach ($module["module_items"] as $diagkey => $diag_item) {
                            if($diag_item['datavalue']){

                                $shortcode.="[dt_linechart_item value=\"".trim($diag_item['datavalue'])."\"]".trim($diag_item['title'])."[/dt_linechart_item]";
                             }

                            }

                          }


                        $shortcode.='[/dt_linechart]';


                break;
            case 'dt_team':
                        if(isset($module["heading_text"]) && $module["heading_text"]!=''){

                             $shortcode.="[section_header use_decoration=\"0\" main_heading=\"".$module['heading_text']."\"".
                             (isset($module['heading_color'])?' color="#'.$module['heading_color'].'"':'').
                             (isset($module['heading_alignment'])?' text_align="'.$module['heading_alignment'].'"':'')."][/section_header]";
                        }

                        $shortcode.="[dt_team".
                             (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'').
                             (isset($module['custom_class'])?' el_class="'.$module['custom_class'].'"':'').
                             (isset($module['order'])?' order="'.strtolower($module['order']).'"':'').
                             (isset($module['scroll_type'])?' spy="'.$module['scroll_type'].'"':'').
                             (isset($module['scroll_delay'])?' scroll_delay="'.$module['scroll_delay'].'"':'').
                             (isset($module['items_per_line'])?' items_per_line="'.$module['items_per_line'].'"':'').
                             (isset($module["cpt_ids"]) && is_array($module["cpt_ids"])?' cpt_ids="'.@implode(",", array_keys($module["cpt_ids"])).'"':'').
                             (isset($module['items_per_page'])?' items_per_page="'.$module['items_per_page'].'"':'').']';
                        $shortcode.='[/dt_team]';
                break;
            case 'dt_testimonial':
                        if(isset($module["heading_text"]) && $module["heading_text"]!=''){

                             $shortcode.="[section_header use_decoration=\"0\" main_heading=\"".$module['heading_text']."\"".
                             (isset($module['heading_color'])?' color="#'.$module['heading_color'].'"':'').
                             (isset($module['heading_alignment'])?' text_align="'.$module['heading_alignment'].'"':'')."][/section_header]";
                        }
                        $shortcode.="[dt_testimonial".
                             (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'').
                             (isset($module['slide_speed'])?' slide_speed="'.$module['slide_speed'].'"':'').
                             (isset($module['sorting_type'])?' sorting_type="'.strtolower($module['sorting_type']).'"':'').
                             (isset($module["cpt_ids"]) && is_array($module["cpt_ids"])?' cpt_ids="'.@implode(",", array_keys($module["cpt_ids"])).'"':'').']';
                        $shortcode.='[/dt_testimonial]';
                break;
            case 'content':

                         $post=get_post(get_the_ID());
                        if(isset($module["heading_text"]) && $module["heading_text"]!=''){

                             $shortcode.="[section_header use_decoration=\"0\" main_heading=\"".$module['heading_text']."\"".
                             (isset($module['heading_color'])?' color="#'.$module['heading_color'].'"':'').
                             (isset($module['heading_alignment'])?' text_align="'.$module['heading_alignment'].'"':'')."][/section_header]";
                        }
                        $shortcode.="[dt_text_html".
                             (isset($module['padding_bottom'])?' m_bottom="'.$module['padding_bottom'].'"':'').
                             (isset($module['custom_class'])?' el_class="'.$module['custom_class'].'"':'').']';
                        $shortcode.=($post?$post->post_content:"").'[/dt_text_html]';

                break;
            default:
                        if(isset($module["heading_text"]) && $module["heading_text"]!=''){

                             $shortcode.="[section_header use_decoration=\"0\" main_heading=\"".$module['heading_text']."\"".
                             (isset($module['heading_color'])?' color="#'.$module['heading_color'].'"':'').
                             (isset($module['heading_alignment'])?' text_align="'.$module['heading_alignment'].'"':'')."][/section_header]";
                        }
                break;

        }

        if(!in_array($module['name'],array('dt_section_start','dt_section_end','dt_section_separator'))){
            $row_width+=$column_width;
            $shortcode.="[/dt_inner_column]";
        }

        if($row_width >=12){
             $shortcode.="[/dt_inner_row]";
             $row_width=0;
    
            if(!$is_section){
                $shortcode.="[/dt_column][/dt_row]";
            }


        }

        if($shortcode!='') {
            $shortcodes[$modul_id]=$shortcode;
            $modul_id++;
        }

    }

    if($row_width > 0 ){

        $row_width_need=12 - $row_width;

        if(!$is_section){
            $shortcodes['end_block']="[dt_inner_column column=\"".$row_width_need."\"][/dt_inner_column][/dt_inner_row][/dt_column][/dt_row]";
        }     


    }

    return @join('',$shortcodes);



}


function krypton_shortcode_migration($post_id){

    global $post;



    $pagebuilder = get_post_meta($post_id, "pagebuilder", true);

    if($pagebuilder){

    /* begin conversion */
       $content=convert_gt3_to_shortcode((isset($pagebuilder['modules']) ? $pagebuilder['modules'] : array()));
        if($post = get_post( $post_id )){
           $post->post_content=$content;

           update_post_meta($post_id, "_pagebuilder", $pagebuilder);

           return wp_update_post( $post );

        }
     }

    return false;
}

function krypton_migration(){

    global $post;

    if( !isset( $post ) || 'page' != $post->post_type || !current_user_can('edit_post',$post->ID) || !empty($_REQUEST['post_status']))
        return;

    $krypton_skip_migration=get_post_meta($post->ID, "krypton_skip_migration",true);

    if(isset( $_GET['krypton_migration_nonce']) && wp_verify_nonce( $_GET['krypton_migration_nonce'], 'krypton_migration' )){

        if(isset( $_GET['krypton_migration']) && 'true'==$_GET['krypton_migration']){

            if(krypton_shortcode_migration($post->ID)){

                delete_post_meta($post->ID, "pagebuilder");
?>
<div id="message" class="updated">
    <p><?php _e( 'Converting page content success.', 'Krypton' ); ?></p>
</div>
<?php
            }
            else{
?>
<div id="message" class="error">
    <p><?php _e( 'Converting page content fail, GT3 shortcode not found.', 'Krypton' ); ?></p>
</div>
<?php
            }

        }

        if(isset( $_GET['krypton_migration_rolback']) && 'true'==$_GET['krypton_migration_rolback']){
            $old_builder=get_post_meta($post->ID, "_pagebuilder", true);

            if(update_post_meta($post->ID, "pagebuilder", $old_builder)){
                delete_post_meta($post->ID, "_pagebuilder");
            }
        }

        if(isset( $_GET['krypton_migration_permanen']) && 'true'==$_GET['krypton_migration_permanen']){
            delete_post_meta($post->ID, "_pagebuilder");
        }


        if(isset( $_GET['krypton_skip_migration']) && 'true'==$_GET['krypton_skip_migration']){
            $krypton_skip_migration=update_post_meta($post->ID, "krypton_skip_migration", 'true');
        }

    }

    if(get_post_meta($post->ID, "pagebuilder", true) && !$krypton_skip_migration){?>
<div id="message" class="updated">
    <p><?php _e( 'This page was built using GT3 Page Builder ( detheme version ). Do you want to convert the page layout and start using DT Page Builder ?', 'Krypton' ); ?></p>
    <p class="submit">
     <a href="<?php  echo esc_url( wp_nonce_url( remove_query_arg( array('krypton_skip_migration','krypton_migration_rolback','krypton_migration_permanen'), add_query_arg( 'krypton_migration', 'true' )), 'krypton_migration', 'krypton_migration_nonce' ) );?>" class="button-primary button"><?php _e( 'Convert Please', 'Krypton' ); ?></a>
     <a  class="button" href="<?php echo esc_url( wp_nonce_url( remove_query_arg ( array('krypton_migration','krypton_migration_rolback','krypton_migration_permanen'), add_query_arg( 'krypton_skip_migration', 'true' )), 'krypton_migration', 'krypton_migration_nonce' ) ); ?>" target="_parent"><?php _e( 'No, thanks and do not ask again', 'Krypton' );?></a>
</a>
    </p>
</div>
<?php }
      else if(get_post_meta($post->ID, "_pagebuilder", true)){
?>
<div id="message" class="updated">
    <p><?php _e( 'This page has been converted from GT3 Page Builder to DT Page Builder. Do you want to keep this page in DT Page Builder layout?', 'Krypton' ); ?></p>
    <p class="submit">
     <a href="<?php  echo esc_url( wp_nonce_url( remove_query_arg(array('krypton_migration_rolback','krypton_migration','krypton_skip_migration'), add_query_arg( 'krypton_migration_permanen', 'true' )), 'krypton_migration', 'krypton_migration_nonce' ) );?>" class="button-primary button"><?php _e( 'Yes, everything is perfect. Make it permanent', 'Krypton' ); ?></a>
     <a  class="button" href="<?php echo esc_url( wp_nonce_url( remove_query_arg ( array('krypton_migration_permanen','krypton_migration','krypton_skip_migration'), add_query_arg( 'krypton_migration_rolback', 'true' )), 'krypton_migration', 'krypton_migration_nonce' ) ); ?>" target="_parent"><?php _e( 'No, everything is broken. Bring my GT3 page builder version back', 'Krypton' );?></a>
</a>
    </p>
</div>
<?php

      }
}

add_action('admin_notices','krypton_migration');

}// end is_plugin_active
?>
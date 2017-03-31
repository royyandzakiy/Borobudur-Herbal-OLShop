<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_map extends DElement{

    function render($atts, $content = null, $base=""){

        extract( shortcode_atts( array(
            'lat'=>-7.2852292,
            'lang'=>112.6809869,
            'zoom'=>7,
            'zoomcontrol'=>true,
            'pancontrol'=>true,
            'streetcontrol'=>true,
            'scrollcontrol'=>true,
            'height'=>'400px',
            'width'=>'',
            'style'=>'pastel',
            'marker'=>'default',
            'image_marker'=>'',
            'title'=>'',
            'el_id'=>'',
            'el_class'=>''
        ), $atts ,'dt_map') );


        $height=abs((int)$height)."px";

        $dt_el_id=getCssID();

       wp_enqueue_script('gmap',"https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAXXCx5pSNgkEifSuRdoPvaJ2K7bhdhwRg",array('jquery'));

        $mapStyle=array(
            'shades'=>'[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]}]',
            'midnight'=>'[{"featureType":"water","stylers":[{"color":"#021019"}]},{"featureType":"landscape","stylers":[{"color":"#08304b"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#0c4152"},{"lightness":5}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#0b434f"},{"lightness":25}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#0b3d51"},{"lightness":16}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#000000"},{"lightness":13}]},{"featureType":"transit","stylers":[{"color":"#146474"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#144b53"},{"lightness":14},{"weight":1.4}]}]',
            'bluewater'=>'[{"featureType":"water","stylers":[{"color":"#46bcec"},{"visibility":"on"}]},{"featureType":"landscape","stylers":[{"color":"#f2f2f2"}]},{"featureType":"road","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]}]',
            'lightmonochrome'=>'[{"featureType":"water","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":-78},{"lightness":67},{"visibility":"simplified"}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#e9ebed"},{"saturation":-90},{"lightness":-8},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":10},{"lightness":69},{"visibility":"on"}]},{"featureType":"administrative.locality","elementType":"all","stylers":[{"hue":"#2c2e33"},{"saturation":7},{"lightness":19},{"visibility":"on"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":-2},{"visibility":"simplified"}]}]',
            'neutralblue'=>'[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#193341"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#29768a"},{"lightness":-37}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#3e606f"},{"weight":2},{"gamma":0.84}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"#1a3541"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#2c5a71"}]}]',
            'avocadoworld'=>'[{"featureType":"water","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"#aee2e0"}]},{"featureType":"landscape","elementType":"geometry.fill","stylers":[{"color":"#abce83"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"color":"#769E72"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#7B8758"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"color":"#EBF4A4"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#8dab68"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#5B5B3F"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ABCE83"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#A4C67D"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#9BBF72"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#EBF4A4"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#87ae79"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#7f2200"},{"visibility":"off"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"},{"visibility":"on"},{"weight":4.1}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#495421"}]},{"featureType":"administrative.neighborhood","elementType":"labels","stylers":[{"visibility":"off"}]}]',
            'nature'=>'[{"featureType":"landscape","stylers":[{"hue":"#FFA800"},{"saturation":0},{"lightness":0},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#53FF00"},{"saturation":-73},{"lightness":40},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#FBFF00"},{"saturation":0},{"lightness":0},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#00FFFD"},{"saturation":0},{"lightness":30},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#00BFFF"},{"saturation":6},{"lightness":8},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#679714"},{"saturation":33.4},{"lightness":-25.4},{"gamma":1}]}]',
            'pastel'=>'[{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":60}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"lightness":30}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ef8c25"},{"lightness":40}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#b6c54c"},{"lightness":40},{"saturation":-40}]},{}]'
            );


        $mapOptions=array();
        $mapOptions['zoom']='zoom: '.$zoom;
        $markerOption="";

        if($marker!=='default'){

            $image_url=get_dt_plugin_dir_url().'images/map_marker.png';

            if($image_marker){

                $imageMarker = wp_get_attachment_image_src(trim($image_marker),'full',false); 
                if(!empty($imageMarker[0])){
                            $image_url=$imageMarker[0];
                }

            }

            $markerOption='var iconMarker = {url: \''.$image_url.'\'};';

        }

        if(!$zoomcontrol){$mapOptions['zoomControl']='zoomControl:false';}
        if(!$pancontrol){$mapOptions['panControl']='panControl:false';}
        if(!$streetcontrol){$mapOptions['streetViewControl']='streetViewControl:false';}
        if(!$scrollcontrol){$mapOptions['scrollwheel']='scrollwheel:false';}

        $mapscript="<div id=\"map-canvas".$dt_el_id."\" class=\"google-map\" style=\"height:".$height.((!empty($width))?";width:".$width."":"")."\"></div>";


        $mapscript.='<script type="text/javascript">';
        $mapscript.='jQuery(document).ready(function($) {
                    try {
                        var map,center = new google.maps.LatLng('.$lat.','.$lang.'),'.(isset($mapStyle[$style])?"style=".$mapStyle[$style].",":"").'
                        mapOptions = {center: center,mapTypeControl: false,'.@implode(',',$mapOptions).(isset($mapStyle[$style])?",styles:style":"").'};
                        '.$markerOption.'
                        
                        map = new google.maps.Map(document.getElementById(\'map-canvas'.$dt_el_id.'\'),mapOptions);
                        var marker = new google.maps.Marker({
                            position: center,
                            map: map,
                          '.(!empty($markerOption)?"icon: iconMarker":"").'  
                        });
                        
                    } catch ($err) {
                    }
            });
    </script>'."\n";


        $css_style=getCssMargin($atts);


        if(''==$el_id && ''!=$css_style){

            $el_id="map".getCssID().time().rand(11,99);
        }


        $compile="<div ";
        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        $compile.=(''!=$el_class)?"class=\"".$el_class."\"":"";
        $compile.=">";

        if(""!=$css_style){
          
          global $DEstyle;

          $DEstyle[]="#$el_id {".$css_style."}";
        }

        $compile.=$mapscript;
        $compile.="</div>";

       return $compile;

    }
}

add_dt_element('dt_map',
 array( 
    'title' => __( 'Google Map', 'detheme_builder' ),
    'icon'  => 'dashicons-location',
    'order'=>12,
    'options' => array(
        array( 
        'heading' => __( 'Module Title', 'detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'default' => __( 'Google Map', 'detheme_builder' ),
        'type' => 'textfield'
         ),
          array( 
            'heading' => __( 'Extra css Class', 'detheme_builder' ),
            'param_name' => 'el_class',
            'type' => 'textfield',
            'value'=>"",
            ),
          array( 
            'heading' => __( 'Anchor ID', 'detheme_builder' ),
            'param_name' => 'el_id',
            'type' => 'textfield',
            "description" => __("Enter anchor ID without pound '#' sign", "detheme_builder"),
          ),
         array( 
          'heading' => __( 'Margin Top', 'detheme_builder' ),
          'param_name' => 'm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Margin Bottom', 'detheme_builder' ),
          'param_name' => 'm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Margin Left', 'detheme_builder' ),
          'param_name' => 'm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Margin Right', 'detheme_builder' ),
          'param_name' => 'm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
        ),
        array( 
        'heading' => __( 'Latitude', 'detheme_builder' ),
        'param_name' => 'lat',
        'param_holder_class'=>'latitude-label',
        'description' => __( 'put your latitude coordinate your location, ex: -7.2852292', 'detheme_builder' ),
        'class' => '',
        'value'=>'-7.2852292',
        'type' => 'textfield',
        'default'=>'-7.2852292'
         ),     
        array( 
        'heading' => __( 'Longitude', 'detheme_builder' ),
        'param_name' => 'lang',
        'param_holder_class'=>'longitude-label',
        'description' => __( 'put your longitude coordinate your location, ex: 112.6809869', 'detheme_builder' ),
        'class' => '',
        'value'=>'112.6809869',
        'type' => 'textfield',
        'default'=>'112.6809869'
         ),     
        array( 
        'heading' => __( 'Zoom Level', 'detheme_builder' ),
        'param_name' => 'zoom',
        'param_holder_class'=>'zoom-label',
        'description' => __( 'zoom level your map, higher value present more detail.', 'detheme_builder' ),
        'class' => '',
        'value'=>array(7,8,9,10,11,12,13,14,15,16,17,18,19,20,21),
        'type' => 'dropdown',
        'default'=>'15'
         ),     
        array( 
        'heading' => __( 'Zoom Control', 'detheme_builder' ),
        'param_name' => 'zoomcontrol',
        'param_holder_class'=>'zoom-control-label',
        'description' => __( 'Show/hide zoom control', 'detheme_builder' ),
        'class' => '',
        'value'=>array(1=>__('Show','detheme_builder'),0=>__('Hidden','detheme_builder')),
        'type' => 'radio',
        'default'=>'1'
         ),     
        array( 
        'heading' => __( 'Pan Control', 'detheme_builder' ),
        'param_name' => 'pancontrol',
        'param_holder_class'=>'pan-control-label',
        'description' => __( 'Show/hide pan control', 'detheme_builder' ),
        'class' => '',
        'value'=>array(1=>__('Show','detheme_builder'),0=>__('Hidden','detheme_builder')),
        'type' => 'radio',
        'default'=>'1'
         ),     
        array( 
        'heading' => __( 'Street View Control', 'detheme_builder' ),
        'param_name' => 'streetcontrol',
        'param_holder_class'=>'street-control-label',
        'description' => __( 'Show/hide street view control', 'detheme_builder' ),
        'class' => '',
        'value'=>array(1=>__('Show','detheme_builder'),0=>__('Hidden','detheme_builder')),
        'type' => 'radio',
        'default'=>'1'
         ),     
        array( 
        'heading' => __( 'Mouse Scroll Wheel', 'detheme_builder' ),
        'param_name' => 'scrollcontrol',
        'param_holder_class'=>'mouse-scroll-label',
        'description' => __( 'Disable/enable mouse scroll to control zoom', 'detheme_builder' ),
        'class' => '',
        'value'=>array(1=>__('Enable','detheme_builder'),0=>__('Disable','detheme_builder')),
        'type' => 'radio',
        'default'=>'1'
         ),     
        array( 
        'heading' => __( 'Map Height', 'detheme_builder' ),
        'param_name' => 'height',
        'param_holder_class'=>'map-height-label',
        'type' => 'textfield',
        'default'=>'400px'
         ),     
        array( 
        'heading' => __( 'Map Width', 'detheme_builder' ),
        'param_name' => 'width',
        'param_holder_class'=>'map-width-label',
        'type' => 'textfield',
        'value'=>'',
         ),     
        array( 
        'heading' => __( 'Map Marker', 'detheme_builder' ),
        'param_name' => 'marker',
        'param_holder_class'=>'map-marker-label',
        'type' => 'radio',
        'value'=>array(
            'default'=>__('Default','detheme_builder'),
            'image'=>__('Custom Image','detheme_builder'),
            ),
        'default'=>'default'
         ),    
        array( 
        'heading' => __( 'Image Marker', 'detheme_builder' ),
        'param_name' => 'image_marker',
        'class' => '',
        'value' => '',
        'type' => 'image',
        'description'=>__('Select image as marker your location on the map','detheme_builder'),
        'dependency' => array( 'element' => 'marker', 'value' => array( 'image') )       
         ),
        array( 
        'heading' => __( 'Map Style', 'detheme_builder' ),
        'param_name' => 'style',
        'param_holder_class'=>'map-style-label',
        'type' => 'select_layout',
        'value'=>array(
            'shades'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/shades.png" alt="'.__('Shades of Grey','detheme_builder').'" />',
            'midnight'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/midnight.png" alt="'.__('Midnight Commander','detheme_builder').'" />',
            'bluewater'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/bluewater.png" alt="'.__('Blue water','detheme_builder').'" />',
            'lightmonochrome'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/lightmonochrome.png" alt="'.__('Light Monochrome','detheme_builder').'" />',
            'neutralblue'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/neutralblue.png" alt="'.__('Neutral Blue','detheme_builder').'" />',
            'avocadoworld'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/avocadoworld.png" alt="'.__('Avocado World','detheme_builder').'" />',
            'nature'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/nature.png" alt="'.__('Nature','detheme_builder').'" />',
            'pastel'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/pastel.png" alt="'.__('Pastel Tones','detheme_builder').'" />'
            ),
        'default'=>'pastel'
         )     
    )

 ) );


function preview_dt_map($output,$content,$atts){

    extract( shortcode_atts( array(
      'style' => 'pastel',
    ), $atts ,'dt_map'));

    $styles=array(
            'shades'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/shades.png" alt="'.__('Shades of Grey','detheme_builder').'" />',
            'midnight'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/midnight.png" alt="'.__('Midnight Commander','detheme_builder').'" />',
            'bluewater'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/bluewater.png" alt="'.__('Blue water','detheme_builder').'" />',
            'lightmonochrome'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/lightmonochrome.png" alt="'.__('Light Monochrome','detheme_builder').'" />',
            'neutralblue'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/neutralblue.png" alt="'.__('Neutral Blue','detheme_builder').'" />',
            'avocadoworld'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/avocadoworld.png" alt="'.__('Avocado World','detheme_builder').'" />',
            'nature'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/nature.png" alt="'.__('Nature','detheme_builder').'" />',
            'pastel'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/pastel.png" alt="'.__('Pastel Tones','detheme_builder').'" />'
    );

    $output=$styles[$style];

    return $output;
}

add_dt_element_preview('dt_map','preview_dt_map');

?>

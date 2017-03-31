<?php 
defined('ABSPATH') or die();

global $krypton_config,$krypton_Scripts;


$slidedata=$krypton_config['shopslide'];

if(isset($slidedata) && is_array($slidedata) && count($slidedata) && $krypton_config['show-shop-slide'] && (!empty($slidedata[0]['title'])
	|| !empty($slidedata[0]['attachment_id']) || !empty($slidedata[0]['text_2'])
	|| !empty($slidedata[0]['text_3']) || !empty($slidedata[0]['text_4']))):


$slider=array();
$background=array();
$preloadTheseImages=array();


$defaults = array(
    'title' => '',
    'sort' => '',
    'url' => '',
    'image'=>'',
    'thumb' => '',
    'slideurl' => '',
    'slidelabel' => '',
    'attachment_id' => '',
    'height' => '',
    'width' => '',
    'direction'=>'from-left',
    'titledirection'=>'from-top',
    'titlemove'=>'0','titlemovemobile'=>'0',
    'text_2' => '',
    'text_2move'=>'0','text_2movemobile'=>'0',
    'text_2direction'=>'from-top',
    'buttonmove'=>'0','buttonmovemobile'=>'0',
    'text_3' => '',
    'text_3move'=>'0','text_3movemobile'=>'0',
    'text_3direction'=>'from-top',
    'text_2' => '',
    'text_4move'=>'0','text_4movemobile'=>'0',
    'text_4direction'=>'from-top',
    'buttondirection'=>'from-top',
    'title_font'=>'','title_fontweight'=>'','title_fontstyle'=>'','title_fontcolor'=>'',
    'text_2_font'=>'','text_2_fontweight'=>'','text_2_fontstyle'=>'','text_2_fontcolor'=>'',
    'text_3_font'=>'','text_3_fontweight'=>'','text_3_fontstyle'=>'','text_3_fontcolor'=>'',
    'text_4_font'=>'','text_4_fontweight'=>'','text_4_fontstyle'=>'','text_4_fontcolor'=>'',
    'button_font'=>'','button_fontweight'=>'','button_fontstyle'=>'','button_fontcolor'=>''
);

                    
foreach ($slidedata as $index => $slide) {

	$slide = wp_parse_args( $slide, $defaults );

	$slideidentifier=$index+1;

	$img=$slide['image'];


	$titlemovemobile=(int)$slide['titlemovemobile'];
	$titlemove=(int)$slide['titlemove'];
	$slidetitle=$slide['title'];
	$titleFont=$slide['title_font'];
	$titlefontweight=$slide['title_fontweight'];
	$titlefontstyle=$slide['title_fontstyle'];
	$titlefontcolor=$slide['title_fontcolor'];


	$contentmove=(int)$slide['text_2move'];
	$contentmovemobile=(int)$slide['text_2movemobile'];
	$text_2Font=$slide['text_2_font'];
	$text_2fontweight=$slide['text_2_fontweight'];
	$text_2fontstyle=$slide['text_2_fontstyle'];
	$text_2fontcolor=$slide['text_2_fontcolor'];

	$text_3movemobile=(int)$slide['text_3movemobile'];
	$text_3move=(int)$slide['text_3move'];
	$text_3Font=$slide['text_3_font'];
	$text_3fontweight=$slide['text_3_fontweight'];
	$text_3fontstyle=$slide['text_3_fontstyle'];
	$text_3fontcolor=$slide['text_3_fontcolor'];

	$text_4movemobile=(int)$slide['text_4movemobile'];
	$text_4move=(int)$slide['text_4move'];
	$text_4Font=$slide['text_4_font'];
	$text_4fontweight=$slide['text_4_fontweight'];
	$text_4fontstyle=$slide['text_4_fontstyle'];
	$text_4fontcolor=$slide['text_4_fontcolor'];

	$buttonmovemobile=(int)$slide['buttonmovemobile'];
	$buttonmove=(int)$slide['buttonmove'];
	$buttonFont=$slide['button_font'];
	$buttonfontweight=$slide['button_fontweight'];
	$buttonfontstyle=$slide['button_fontstyle'];
	$buttonfontcolor=$slide['button_fontcolor'];


	if(!isset($slide['text_3direction'])){$slide['text_3direction']='fade';}
	if(!isset($slide['text_4direction'])){$slide['text_4direction']='fade';}
	if(!isset($slide['titledirection'])){$slide['titledirection']='fade';}
	if(!isset($slide['text_2direction'])){$slide['text_2direction']='fade';}
	if(!isset($slide['buttondirection'])){$slide['buttondirection']='fade';}


	$customstyle="";

	if(!empty($text_3fontstyle)){
		$customstyle.="font-style:".$text_3fontstyle.";";
	}

	if(!empty($text_3fontcolor)){
		$customstyle.="color:".$text_3fontcolor.";";
	}


	if(!empty($text_3Font)){
		$customstyle.="font-size:".$text_3Font."px;";
	}

	if(!empty($text_3fontweight)){
		$customstyle.="font-weight:".$text_3fontweight.";";
	}

	if(!empty($customstyle)){

		$background[]=".slide".$slideidentifier." .shop-slider-text-3 {".$customstyle."}";
	}


	if('0'!==$text_3move && !empty($text_3move)){


		if('fade'==$slide['text_3direction']){
			$background[]=".slide".$slideidentifier." .shop-slider-text-3 {margin-top: ".$text_3move."px;opacity:0;}";
			$background[]=".slide".$slideidentifier.".animate-in .shop-slider-text-3 {margin-top: ".$text_3move."px;opacity:1	}";
		}else{
			$margintop=('from-bottom'==$slide['text_3direction'])?$text_3move+100 : $text_3move-100;
			$background[]=".slide".$slideidentifier.".animate-in .shop-slider-text-3 {margin-top: ".$text_3move."px;}";
			$background[]=".slide".$slideidentifier." .shop-slider-text-3 {margin-top: ".$margintop."px;}";
		}

		if(!empty($text_3movemobile)){

			$background[]="@media all and (max-width: 480px) {.slide".$slideidentifier.".animate-in .shop-slider-text-3 {margin-top: ".$text_3movemobile."px;}}";
		}
	}

	$customstyle="";

	if(!empty($text_4fontstyle)){
		$customstyle.="font-style:".$text_4fontstyle.";";
	}

	if(!empty($text_4fontcolor)){
		$customstyle.="color:".$text_4fontcolor.";";
	}

	if(!empty($text_4Font)){
		$customstyle.="font-size:".$text_4Font."px;";
	}

	if(!empty($text_4fontweight)){
		$customstyle.="font-weight:".$text_4fontweight.";";
	}

	if(!empty($customstyle)){

		$background[]=".slide".$slideidentifier." .shop-slider-text-4 {".$customstyle."}";
	}

	if('0'!==$text_4move && !empty($text_4move)){


		if('fade'==$slide['text_4direction']){
			$background[]=".slide".$slideidentifier." .shop-slider-text-4 {margin-top: ".$text_4move."px;opacity:0;}";
			$background[]=".slide".$slideidentifier.".animate-in .shop-slider-text-4 {margin-top: ".$text_4move."px;opacity:1	}";
		}else{
			$margintop=('from-bottom'==$slide['text_4direction'])?$text_4move+100 : $text_4move-100;
			$background[]=".slide".$slideidentifier.".animate-in .shop-slider-text-4 {margin-top: ".$text_4move."px;}";
			$background[]=".slide".$slideidentifier." .shop-slider-text-4 {margin-top: ".$margintop."px;}";
		}

		if(!empty($text_3movemobile)){

			$background[]="@media all and (max-width: 480px) {.slide".$slideidentifier.".animate-in .shop-slider-text-4 {margin-top: ".$text_3movemobile."px;}}";
		}
	}

	$customstyle="";

	if(!empty($titlefontstyle)){
		$customstyle.="font-style:".$titlefontstyle.";";
	}

	if(!empty($titlefontcolor)){
		$customstyle.="color:".$titlefontcolor.";";
	}

	if(!empty($titleFont)){
		$customstyle.="font-size:".$titleFont."px;";
	}

	if(!empty($titlefontweight)){
		$customstyle.="font-weight:".$titlefontweight.";";
	}

	if(!empty($customstyle)){

		$background[]=".slide".$slideidentifier." .shop-slider-text-1 {".$customstyle."}";
	}


	if('0'!==$titlemove && !empty($titlemove)){


		if('fade'==$slide['titledirection']){
			$background[]=".slide".$slideidentifier." .shop-slider-text-1 {margin-top: ".$titlemove."px;opacity:0;}";
			$background[]=".slide".$slideidentifier.".animate-in .shop-slider-text-1 {margin-top: ".$titlemove."px;opacity:1	}";
		}else{
			$margintop=('from-bottom'==$slide['titledirection'])?$titlemove+100 : $titlemove-100;
			$background[]=".slide".$slideidentifier.".animate-in .shop-slider-text-1 {margin-top: ".$titlemove."px;}";
			$background[]=".slide".$slideidentifier." .shop-slider-text-1 {margin-top: ".$margintop."px;}";
		}
		if(!empty($titlemovemobile)){
			$background[]="@media all and (max-width: 480px) {.slide".$slideidentifier.".animate-in .shop-slider-text-1 {margin-top: ".$titlemovemobile."px;}}";
		}
	}

	$customstyle="";

	if(!empty($text_2fontstyle)){
		$customstyle.="font-style:".$text_2fontstyle.";";
	}

	if(!empty($text_2fontcolor)){
		$customstyle.="color:".$text_2fontcolor.";";
	}

	if(!empty($text_2Font)){
		$customstyle.="font-size:".$text_2Font."px;";
	}

	if(!empty($text_2fontweight)){
		$customstyle.="font-weight:".$text_2fontweight.";";
	}

	if(!empty($customstyle)){

		$background[]=".slide".$slideidentifier." .shop-slider-text-2 {".$customstyle."}";
	}


	if('0'!==$contentmove && !empty($contentmove)){


		if('fade'==$slide['text_2direction']){
			$background[]=".slide".$slideidentifier." .shop-slider-text-2 {margin-top: ".$contentmove."px;opacity:0;}";
			$background[]=".slide".$slideidentifier.".animate-in .shop-slider-text-2 {margin-top: ".$contentmove."px;opacity:1	}";
		}else{
			$margintop=('from-bottom'==$slide['text_2direction'])?$contentmove+100 : $contentmove-100;
			$background[]=".slide".$slideidentifier.".animate-in .shop-slider-text-2 {margin-top: ".$contentmove."px;}";
			$background[]=".slide".$slideidentifier." .shop-slider-text-2 {margin-top: ".$margintop."px;}";
		}
		if(!empty($contentmovemobile)){
			$background[]="@media all and (max-width: 480px) {.slide".$slideidentifier.".animate-in .shop-slider-text-2 {margin-top: ".$contentmovemobile."px;}}";
		}
	}

	$customstyle="";

	if(!empty($buttonfontstyle)){
		$customstyle.="font-style:".$buttonfontstyle.";";
	}

	if(!empty($buttonfontcolor)){
		$customstyle.="color:".$buttonfontcolor.";border-color:".$buttonfontcolor.";";
	}


	if(!empty($buttonFont)){
		$customstyle.="font-size:".$buttonFont."px;";
	}

	if(!empty($buttonfontweight)){
		$customstyle.="font-weight:".$buttonfontweight.";";
	}

	if(!empty($customstyle)){

		$background[]=".slide".$slideidentifier." .shop-slide-button a.btn-cta{".$customstyle."}";
	}

	if('0'!==$buttonmove && !empty($buttonmove)){


		if('fade'==$slide['buttondirection']){
			$background[]=".slide".$slideidentifier." .shop-slide-button {margin-top: ".$buttonmove."px;opacity:0}";
			$background[]=".slide".$slideidentifier.".animate-in .shop-slide-button {margin-top: ".$buttonmove."px;opacity:1	}";
		}else{
			$margintop=('from-bottom'==$slide['buttondirection'])?$buttonmove+100 : $buttonmove-100;
			$background[]=".slide".$slideidentifier.".animate-in .shop-slide-button {margin-top: ".$buttonmove."px;}";
			$background[]=".slide".$slideidentifier." .shop-slide-button {margin-top: ".$margintop."px;}";
		}

		if(!empty($buttonmovemobile)){
			$background[]="@media all and (max-width: 480px) {.slide".$slideidentifier.".animate-in .shop-slide-button {margin-top: ".$buttonmovemobile."px;}}";
		}
	}


	$background[]=".slide".$slideidentifier." .slide-bg{	background:url(".$img."); }";


	$preloadTheseImages[$index]=$img;
	$slideDir=(isset($slide['direction']) && !empty($slide['direction']))?$slide['direction']:'from-left';

	$slidetitle=function_exists('icl_t') && isset($slidetitle) && !empty($slidetitle)	?	icl_t('krypton', $slidetitle, $slidetitle):$slidetitle;
	$slide['slidelabel']=function_exists('icl_t') && isset($slide['slidelabel']) && !empty($slide['slidelabel'])	?	icl_t('krypton', $slide['slidelabel'], $slide['slidelabel']):$slide['slidelabel'];
	$slide['text_2']=function_exists('icl_t') && isset($slide['text_2']) && !empty($slide['text_2'])	?	icl_t('krypton', $slide['text_2'], $slide['text_2']):$slide['text_2'];
	$slide['text_3']=function_exists('icl_t') && isset($slide['text_3']) && !empty($slide['text_3'])	?	icl_t('krypton', $slide['text_3'], $slide['text_3']):$slide['text_3'];
	$slide['text_4']=function_exists('icl_t') && isset($slide['text_4']) && !empty($slide['text_4'])	?	icl_t('krypton', $slide['text_4'], $slide['text_4']):$slide['text_4'];

	$content='<li class="slide-frame slide'.$slideidentifier.'">
				<div class="slide-bg slide-bg'.$slideidentifier.' '.$slideDir.'"></div>
				'.((!empty($slidetitle))?'<div class="shop-slider-text-1">'.$slidetitle.'</div>':'').
				((!empty($slide['text_2']))?'
				<div class="shop-slider-text-2">'.$slide['text_2'].'</div>':'').
				((!empty($slide['text_3']))?'<div class="shop-slider-text-3">'.$slide['text_3'].'</div>':'').
				((!empty($slide['text_4']))?'<div class="shop-slider-text-4">'.$slide['text_4'].'</div>':'').
				((!empty($slide['slidelabel']))?'<div class="shop-slide-button">
						<a href="'.$slide['slideurl'].'" class="btn-cta">'.$slide['slidelabel'].'</a>
				</div>':'').'				
			</li>';


	$slider[$index]=$content;

}

$script='$(document).ready(function(){

        \'use strict\';
        var options = {
			autoPlay: false,
			nextButton: true,
			prevButton: true,
			navigationSkip: true,
			animateStartingFrameIn: true,
			autoPlayDelay:3000,
			pauseOnHover : true,
			transitionThreshold:1500,
			preloader: true,
            preloadTheseImages: ["'.@implode("\",\"",$preloadTheseImages).'"]
            ,
            reverseAnimationsWhenNavigatingBackwards : false,   
            preventDelayWhenReversingAnimations : true
        };
        try{
            var sequence = $("#sequence-shop").sequence(options).data("sequence");
        }
        catch(err){}    
});';

array_push($krypton_Scripts, $script);

?>
<style type="text/css">
<?php print @implode(" ",$background)."\n";?>
</style>
<div class="shop-slider">
	<div id="sequence-shop">
		<span class="sequence-prev"><i class="icon-left-open-big"></i></span>
		<span class="sequence-next"><i class="icon-right-open-big"></i></span>
		<ul class="sequence-canvas">
			<?php print @implode("\n",$slider);?>
		</ul>
	</div>
</div>
<?php 
endif; ?>
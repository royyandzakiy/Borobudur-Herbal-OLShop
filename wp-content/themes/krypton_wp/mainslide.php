<?php 
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 1.0
 * @version 3.0.0
 */

global $krypton_config,$krypton_Scripts;

$slidedata=$krypton_config['homeslide'];

if(isset($slidedata) 
	&& is_array($slidedata) 
	&& count($slidedata) 
	&& $krypton_config['showslide'] 
	&& (!empty($slidedata[0]['title'])
		|| !empty($slidedata[0]['attachment_id']) 
		|| !empty($slidedata[0]['description'])
		|| !empty($slidedata[0]['logo_id']) 
		|| !empty($slidedata[0]['slidelabel'])
		)
):

$slider=array();
$background=array();
$preloadTheseImages=array();
foreach ($slidedata as $index => $slide) {

	$slideidentifier=$index+1;

	$img=$slide['image'];
	$logo=$slide['logo_id'];
	$logowidth=(int)$slide['logowidth'];
	$logoheight=(int)$slide['logoheight'];
	$logomove=(int)$slide['logomove'];
	$titlemove=(int)$slide['titlemove'];
	$contentmove=(int)$slide['contentmove'];
	$buttonmove=(int)$slide['buttonmove'];

	$logomovemobile=(int)$slide['logomovemobile'];
	$titlemovemobile=(int)$slide['titlemovemobile'];
	$contentmovemobile=(int)$slide['contentmovemobile'];
	$buttonmovemobile=(int)$slide['buttonmovemobile'];


	if(!isset($slide['logodirection'])){$slide['logodirection']='fade';}
	if(!isset($slide['titledirection'])){$slide['titledirection']='fade';}
	if(!isset($slide['contentdirection'])){$slide['contentdirection']='fade';}
	if(!isset($slide['buttondirection'])){$slide['buttondirection']='fade';}


	if('0'!==$logomove && !empty($logomove)){
		if('fade'==$slide['logodirection']){
			$background[]="#sequence .slide".$slideidentifier." .slide-logo {margin-top: ".$logomove."px;opacity:0}";
			$background[]="#sequence .slide".$slideidentifier.".animate-in .slide-logo {margin-top: ".$logomove."px;opacity:1	}";
		}else{
			$margintop=('from-bottom'==$slide['logodirection'])?$logomove+100 : $logomove-100;
			$background[]="#sequence .slide".$slideidentifier.".animate-in .slide-logo {margin-top: ".$logomove."px;}";
			$background[]="#sequence .slide".$slideidentifier." .slide-logo {margin-top: ".$margintop."px;}";
		}

		if(!empty($logomovemobile)){

			$background[]="@media all and (max-width: 480px) {#sequence .slide".$slideidentifier.".animate-in .slide-logo {margin-top: ".$logomovemobile."px;}}";
		}
	}
	if('0'!==$titlemove && !empty($titlemove)){

		if('fade'==$slide['titledirection']){
			$background[]="#sequence .slide".$slideidentifier." .slide-title {margin-top: ".$titlemove."px;opacity:0}";
			$background[]="#sequence .slide".$slideidentifier.".animate-in .slide-title {margin-top: ".$titlemove."px;opacity:1	}";
		}else{
			$margintop=('from-bottom'==$slide['titledirection'])?$titlemove+100 : $titlemove-100;
			$background[]="#sequence .slide".$slideidentifier.".animate-in .slide-title {margin-top: ".$titlemove."px;}";
			$background[]="#sequence .slide".$slideidentifier." .slide-title {margin-top: ".$margintop."px;}";
		}
		if(!empty($titlemovemobile)){
			$background[]="@media all and (max-width: 480px) {#sequence .slide".$slideidentifier.".animate-in .slide-title {margin-top: ".$titlemovemobile."px;}}";
		}
	}

	if('0'!==$contentmove && !empty($contentmove)){
		if('fade'==$slide['contentdirection']){
			$background[]="#sequence .slide".$slideidentifier." .slide-text {margin-top: ".$contentmove."px;opacity:0}";
			$background[]="#sequence .slide".$slideidentifier.".animate-in .slide-text {margin-top: ".$contentmove."px;opacity:1	}";
		}else{
			$margintop=('from-bottom'==$slide['contentdirection'])?$contentmove+100 : $contentmove-100;
			$background[]="#sequence .slide".$slideidentifier.".animate-in .slide-text {margin-top: ".$contentmove."px;}";
			$background[]="#sequence .slide".$slideidentifier." .slide-text {margin-top: ".$margintop."px;}";
		}
		if(!empty($contentmovemobile)){
			$background[]="@media all and (max-width: 480px) {#sequence .slide".$slideidentifier.".animate-in .slide-text {margin-top: ".$contentmovemobile."px;}}";
		}
	}

	if('0'!==$buttonmove && !empty($buttonmove)){
		if('fade'==$slide['buttondirection']){
			$background[]="#sequence .slide".$slideidentifier." .slide-button {margin-top: ".$buttonmove."px;opacity:0}";
			$background[]="#sequence .slide".$slideidentifier.".animate-in .slide-button {margin-top: ".$buttonmove."px;opacity:1	}";
		}else{
			$margintop=('from-bottom'==$slide['buttondirection'])?$buttonmove+100 : $buttonmove-100;
			$background[]="#sequence .slide".$slideidentifier.".animate-in .slide-button {margin-top: ".$buttonmove."px;}";
			$background[]="#sequence .slide".$slideidentifier." .slide-button {margin-top: ".$margintop."px;}";
		}

		if(!empty($buttonmovemobile)){
			$background[]="@media all and (max-width: 480px) {#sequence .slide".$slideidentifier.".animate-in .slide-button {margin-top: ".$buttonmovemobile."px;}}";
		}
	}


	$logoimage=wp_get_attachment_image_src($logo,'full',false); 
	$logo_alt_image = get_post_meta($logo, '_wp_attachment_image_alt', true);

	$background[]=".slide".$slideidentifier." .slide-bg{	background:url(".esc_url($img)."); }";


	$preloadTheseImages[$index]=$img;
	$slideDir=(isset($slide['direction']) && !empty($slide['direction']))?$slide['direction']:'from-left';

	$slide['title']=function_exists('icl_t') && isset($slide['title']) && !empty($slide['title'])	?	icl_t('krypton', $slide['title'], $slide['title']):$slide['title'];
	$slide['slidelabel']=function_exists('icl_t') && isset($slide['slidelabel']) && !empty($slide['slidelabel'])	?	icl_t('krypton', $slide['slidelabel'], $slide['slidelabel']):$slide['slidelabel'];
	$slide['description']=function_exists('icl_t') && isset($slide['description']) && !empty($slide['description'])	?	icl_t('krypton', $slide['description'], $slide['description']):$slide['description'];


	$content='<li class="slide-frame slide'.$slideidentifier.'">
				<div class="slide-bg slide-bg'.$slideidentifier.' '.$slideDir.'"></div>
				<div class="slide-logo">
					'.(($logoimage[0] && !empty($logoimage[0]))?'<img class="img-responsive" '.(($logowidth)?" width=\"".$logowidth."\"":"").' '.(($logoheight)?" height=\"".$logoheight."\"":"").' src="'.$logoimage[0].'" alt="'.esc_attr($logo_alt_image).'">':"").'
				</div>
				<div class="slide-title">
					<p>'.$slide['title'].'</p>
				</div>
				<div class="slide-text">
					<p>'.$slide['description'].'</p>
				</div>'.((!empty($slide['slidelabel']))?'<div class="slide-button">
						<a href="'.esc_url($slide['slideurl']).'" class="btn-cta">'.$slide['slidelabel'].'</a>
				</div>':'').'				
			</li>';


	$slider[$index]=$content;

}

$script='jQuery(document).ready(function($){

        \'use strict\';
        var options = {
            autoPlay: true,
            nextButton: true,
            prevButton: true,
            navigationSkip: true,
            animateStartingFrameIn: true,
            autoPlayDelay:3000,
            pauseOnHover : false,
            transitionThreshold:1500,
            preloader: true,
            preloadTheseImages: ["'.@implode("\",\"",$preloadTheseImages).'"]
            ,
            reverseAnimationsWhenNavigatingBackwards : false,   
            preventDelayWhenReversingAnimations : true
        };
        try{
            var sequence = $("#sequence").sequence(options).data("sequence");
        }
        catch(err){}    
});';

array_push($krypton_Scripts, $script);

?>
<style type="text/css">
<?php print @implode("\n",$background)."\n";?>
</style>
<div class="mainbanner">
	<div id="sequence">
		<span class="sequence-prev"><i class="icon-left-open-big"></i></span>
		<span class="sequence-next"><i class="icon-right-open-big"></i></span>
		<ul class="sequence-canvas">
			<?php print @implode("\n",$slider);?>
		</ul>
	</div>
</div>
<?php endif; ?>
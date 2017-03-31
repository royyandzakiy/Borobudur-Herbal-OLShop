<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */


$template = get_option( 'template' );

switch( $template ) {
	case 'twentyeleven' :
		echo '</div></div>';
		break;
	case 'twentytwelve' :
		echo '</div></div>';
		break;
	case 'twentythirteen' :
		echo '</div></div>';
		break;
	case 'twentyfourteen' :
		echo '</div></div></div>';
		get_sidebar( 'content' );
		break;
	default :
		global $krypton_config;

		switch ($krypton_config['layout']) {
			case 1:
				$sidebar_position = "nosidebar";
				$col_class = "col-sm-12";
				break;
			case 2:
				$sidebar_position = "sidebar-left";
				$col_class = "col-sm-8";
				break;
			case 3:
				$sidebar_position = "sidebar-right";
				$col_class = "col-sm-8";
				break;
			default:
				$sidebar_position = "sidebar-left";
				$col_class = "col-sm-8";
		}
?>
<?php if ('sidebar-right'==$sidebar_position) { ?>
			</div>
			<div class="col-sm-4 sidebar">
			<?php dynamic_sidebar("sidebar");?>
			</div>
<?php }
	elseif ($sidebar_position=='sidebar-left') { ?>
			</div>
			<div class="col-sm-4 sidebar col-sm-pull-8">
			<?php dynamic_sidebar("sidebar");?>
			</div>
<?php }
	 else {
			echo '</div>'; //</div class="col-sm-8">
	}

		echo '</div>'; //</div class="row">
		echo '</div>'; //</div class="container">
		echo '</div>'; //</div class="dt-category-view

		break;
}
<?php
defined('DTPB_BASENAME') or die();
$wp_filesystem=new WP_Filesystem_Direct(array());

if($dirlist=$wp_filesystem->dirlist(DTPB_DIR."lib/elements")){

      foreach ($dirlist as $dirname => $dirattr) {
         if($dirattr['type']=='f' && preg_match("/(\.php)$/", $dirname) ){
            @require_once(DTPB_DIR."lib/elements/".$dirname);
          }


      }
}
?>

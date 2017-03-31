<?php

$file_name = array(
    'inkthemes-functions',
    'customizer',
    'themes-page'
);
foreach ($file_name as $files):
    if (file_exists(FUNCPATH . $files . '.php')):
        require_once(FUNCPATH . $files . '.php');
    endif;
endforeach;

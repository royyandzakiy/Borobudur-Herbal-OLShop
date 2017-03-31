<?php
    require_once( '../../../wp-load.php' );
    require( ABSPATH . WPINC . '/pluggable.php' );

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

    $args=wp_parse_args($_POST,$default);


    $total = $args['captcha'];
    $name = $args['inputFullname'];
    $email = $args['inputEmail'];
    $phone = $args['inputPhone'];
    $message = $args['inputMessage'];


    $captcha_error = captcha_validation($args['num1'], $args['num2'], $total);

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
    
?>

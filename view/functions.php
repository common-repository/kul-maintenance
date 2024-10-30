<?php

function get_kul_logo($kul_logo = '')
{
    if (!empty($kul_logo)) {
        return '<img src="' . stripslashes($kul_logo) . '" />';
    } else {
        return '<img src="' . KUL_MAINTENANCE_URI . 'view/images/logo.png" />';
    }
}

function the_kul_logo($kul_logo)
{
    if (function_exists("get_kul_logo")) {
        echo get_kul_logo($kul_logo);
    }
}

function get_kul_image_url($kul_logo = '')
{
    if (!empty($kul_logo)) {
        return $kul_logo;
    } else {
        return '';
    }
}

function get_the_kul_title($title = '')
{
    if (empty($title)) {
        $page_title = wp_title('|', false);
    } else {
        $page_title = $title;
    }
    return $page_title;
}

function the_kul_title($title)
{
    if (function_exists("get_the_kul_title")) {
        echo get_the_kul_title($title);
    }
}

add_action('kul_head', 'kul_head_style');
add_action('kul_site_block', 'kul_site_block');
function kul_site_block()
{
    $kul_option = kul_get_options();
    $kul_site_index = '';
    if (isset($kul_option['kul_site_index'])) {
        $kul_site_index = wp_kses_post($kul_option['kul_site_index']);
    }
    if (!empty($kul_site_index)) {
        echo '  <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
    }
}

function kul_head_style()
{
    global $wp_styles;
    wp_register_style('kul-maintenance1', KUL_MAINTENANCE_URI . 'view/css/bootstrap.css');
    wp_register_style('kul-maintenance2', KUL_MAINTENANCE_URI . 'view/css/style.css');
    wp_register_style('kul-maintenance3', KUL_MAINTENANCE_URI . 'view/css/font-awesome.css');
    wp_register_style('kul-maintenance4', KUL_MAINTENANCE_URI . 'view/css/component.css');
    $wp_styles->do_items('kul-maintenance1');
    $wp_styles->do_items('kul-maintenance2');
    $wp_styles->do_items('kul-maintenance3');
    $wp_styles->do_items('kul-maintenance4');
}

add_action('kul_footer', 'kul_footer_script');
function kul_footer_script()
{
    global $wp_scripts;

    wp_register_script('boootstrap_kul', KUL_MAINTENANCE_URI . 'view/js/bootstrap.min.js', 'jquery');
    wp_register_script('backstretch_kul', KUL_MAINTENANCE_URI . 'view/js/jquery.backstretch.js', 'jquery');
    $wp_scripts->do_items('jquery');
    $wp_scripts->do_items('boootstrap_kul');
    $wp_scripts->do_items('backstretch_kul');
}

add_action('kul_head_hover', 'kul_head_hover');
function kul_head_hover()
{
    $kul_option = kul_get_options();

    ?>
    <style type="text/css">
        body {
            margin: 0;
            color: <?php echo $kul_option['font_color'] ?>;
        }

        a {
            color: <?php echo $kul_option['hyperlink_color']; ?>
        }

        a:hover {
            color: <?php echo $kul_option['hover_color'] ?>;
        }

        .social_media ul li a:hover {
            border-color: <?php echo $kul_option['hover_color'] ?>;
        }

        .social_media ul li a:hover .fa {
            color: <?php echo $kul_option['hover_color'] ?>;
        }

        .frm_hoder p.btn_hldr input.sbt_button:hover {
            background: <?php echo $kul_option['hover_color'] ?>;
        }
    </style>
    <?php

}

add_action('kul_custom_css', 'kul_load_custom_css');
function kul_load_custom_css()
{
    $kul_option = kul_get_options();
    if (isset($kul_option['custom_css'])) {
        ?>
        <style>
            <?php echo $kul_option['custom_css'];?>
        </style>
        <?php

    }
}


//contact form ajax
add_action('kul_head_font', 'kul_head_font');

function kul_head_font()
{
    $kul_option = kul_get_options();
    $body_font_family = $kul_option['body_font_family'];
    $background_color = $kul_option['background_color'];
    ?>
    <style type="text/css">
        .slider_overlay {
            background: <?php echo $background_color; ?>;
        }
    </style>
    <?php

    if (check_google_font($body_font_family)) {
        ?>
        <link href='http://fonts.googleapis.com/css?family=<?php echo $body_font_family; ?>' rel='stylesheet'
              type='text/css'>
        <style type="text/css">
            body {
                background: <?php echo $background_color; ?>;
                font-family: '<?php echo $body_font_family; ?>', sans-serif;
            }
        </style>
    <?php } else {
        ?>
        <style type="text/css">
            body {
                background: <?php echo $background_color; ?>;
                font-family: <?php echo $body_font_family; ?>, sans-serif;
            }
        </style>
    <?php }
}

add_action('wp_ajax_kul_contact_action', 'kul_contact_action');
add_action('wp_ajax_nopriv_kul_contact_action', 'kul_contact_action');

function kul_contact_action()
{
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $message = $_POST['message'];
    $kul_option = kul_get_options();
    $email_template = $kul_option['email_template'];
    $contact_email = $kul_option['contact_email'];
    $email_subject = $kul_option['email_subject'];
    if (!empty($contact_email)) {
        $send_to = $contact_email;
    } else {
        $send_to = get_option('admin_email');
    }
    if ($email_template) {
        $email_template = str_replace('%name%', $fullname, $email_template);
        $email_template = str_replace('%email%', $email, $email_template);
        $email_template = str_replace('%message%', $message, $email_template);
        $email_content = $email_template;
    } else {
        ob_start();

        ?>
        Name: <?php echo $fullname; ?><br/>
        Email: <?php echo $email; ?><br/>
        Message: <br/><br/>
        <?php

        echo nl2br(stripslashes($message));

        $email_content = ob_get_contents();
        ob_clean();
    }
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: ' . $fullname . '<' . $email . '>';


    @wp_mail($send_to, $email_subject, $email_content, $headers);
}

function check_google_font($font_name)
{
    global $google_fonts;
    if (in_array($font_name, $google_fonts)) {
        return true;
    }
    return false;
}

add_action('kul_footer_last', 'kul_footer_last');
function kul_footer_last()
{
    $kul_option = kul_get_options();
    ?>

    <script type="text/javascript">
        var slide_path = "<?php echo KUL_MAINTENANCE_URI ?>view/";
        var admin_ajax = "<?php echo admin_url('admin-ajax.php'); ?>";
        jQuery(document).ready(function ($) {
            // console.log(  );
            jQuery('.main_container').css('height', jQuery(window).height());


            $('.contact_form').on('submit', function (e) {

                $('.contact_form *').removeClass('error');
                $('#email_success').hide();
                $('#error_msg').hide();

                var name = $('input[name=fullname]');
                var email = $('input[name=email]');
                var message = $('textarea[name=message]');

                if (name.val() == '' || email.val() == '' || message.val() == '' || !validateEmail(email.val())) {

                    if (name.val() == '') {
                        name.addClass('error');
                    }

                    if (email.val() == '') {
                        email.addClass('error');
                    }

                    if (message.val() == '') {
                        message.addClass('error');
                    }

                    if (!validateEmail(email.val())) {
                        email.addClass('error');
                    }

                    $('#error_msg').slideDown('slow');

                } else {

                    $('#error_msg').hide();

                    var formData = $('.contact_form').serializeArray();


                    jQuery.post(admin_ajax, formData, function (response) {

                        $('.contact_form').trigger("reset");
                        $('#email_success').slideDown('slow');
                        $('#error_msg').hide();
                    });

                }

                e.preventDefault();

            });
        });

        function validateEmail(email) {
            var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            return re.test(email);
        }
    </script>
    <script type="text/javascript">
        window.onresize = function (event) {

            jQuery('.main_container').css('height', jQuery(window).height());
        };
    </script>
    <?php

    $slider_status = kul_get_slider_status();
    if ($slider_status == 'true'):
        $slider_1 = $kul_option['slider_1'];
        $slider_2 = $kul_option['slider_2'];
        $slider_3 = $kul_option['slider_3'];
        $slider_4 = $kul_option['slider_4'];
        if (!empty($slider_1) || !empty($slider_1) || !empty($slider_2) || !empty($slider_3)) {
            if (!empty($slider_1)) {
                $arry[] = stripslashes($slider_1);
            }
            if (!empty($slider_2)) {
                $arry[] = stripslashes($slider_2);
            }
            if (!empty($slider_3)) {
                $arry[] = stripslashes($slider_3);
            }
            if (!empty($slider_4)) {
                $arry[] = stripslashes($slider_4);
            }

            ?>
            <!-- === for slider == -->
            <script>
                jQuery.backstretch(
                    <?php echo json_encode($arry); ?>
                    , {
                        fade: 750,
                        duration: 4000
                    });
            </script>
            <!-- === for slider == -->
        <?php }
    endif;
}

add_action('kul_slider', 'kul_slider');
function kul_slider()
{
    $slider_status = kul_get_slider_status();
    if ($slider_status == 'true'):
        ?>
        <div class="slider_overlay"></div>
    <?php
    endif;
}

add_action('kul_logo', 'kul_logo');
function kul_logo()
{
    $kul_option = kul_get_options();
    $kul_logo = $kul_option['kul_logo'];
    ?>
    <div class="logo"><?php the_kul_logo($kul_logo); ?></div>
    <?php

}

add_action('kul_heading', 'kul_heading');
function kul_heading()
{
    $kul_option = kul_get_options();
    $kul_heading = $kul_option['kul_heading'];
    ?>
    <div class="heading">

        <h1><?php echo $kul_heading; ?></h1>
    </div>
    <?php

}

add_action('kul_description', 'kul_description');
function kul_description()
{
    $kul_option = kul_get_options();
    $kul_description = $kul_option['kul_description'];
    ?>
    <div class="comp_para">
        <?php echo apply_filters('the_editor', $kul_description); ?>
    </div>
    <?php

}

add_action('kul_form', 'kul_form');
function kul_form()
{
    $kul_option = kul_get_options();
    $kul_hide_form = '';
    if (isset($kul_option['kul_hide_form'])) {
        $kul_hide_form = wp_kses_post($kul_option['kul_hide_form']);
    }
    if (empty($kul_hide_form)) {
        ?>
        <div class="frm_hoder">
            <div class="form_ttl">
                <p>Please leave us a message</p>
                <p id="email_success" style="display:none;">Thank You!!</p>
                <p id="error_msg" style="display:none;">There was an error!!</p>
            </div>

            <form action="" method="post" class="contact_form">

                <input type="hidden" value="kul_contact_action" name="action"/>
                <p><input type="text" placeholder="Full name" name="fullname"/></p>
                <p><input type="text" placeholder="Email Address" name="email"/></p>
                <p><textarea placeholder="Your Message" name="message"></textarea></p>
                <p class="btn_hldr"><input class="sbt_button" type="submit" value="submit"/></p>
            </form>
        </div>
        <?php

    }
}

add_action('kul_social', 'kul_social');
function kul_social()
{
    $kul_option = kul_get_options();
    $facebook_link = $kul_option['facebook_link'];
    $twitter_link = $kul_option['twitter_link'];
    $linkedin_link = $kul_option['linkedin_link'];
    $youtube_link = $kul_option['youtube_link'];
    $instagram_link = $kul_option['instagram_link'];
    $flickr_link = $kul_option['flickr_link'];
    ?>
    <div class="social_media">
        <ul>
            <?php

            if (!empty($facebook_link)):
                ?>
                <li><a href="<?php echo $facebook_link; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                </li> <?php endif; ?>
            <?php

            if (!empty($twitter_link)):
                ?>
                <li><a href="<?php echo $twitter_link; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                </li><?php endif; ?>
            <?php

            if (!empty($linkedin_link)):
                ?>
                <li><a href="<?php echo $linkedin_link; ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
                </li><?php endif; ?>
            <?php

            if (!empty($youtube_link)):
                ?>
                <li><a href="<?php echo $youtube_link; ?>" target="_blank"><i class="fa fa-youtube"></i></a>
                </li><?php endif; ?>
            <?php

            if (!empty($instagram_link)):
                ?>
                <li><a href="<?php echo $instagram_link; ?>" target="_blank"><i class="fa fa-instagram"></i></a>
                </li><?php endif; ?>
            <?php

            if (!empty($flickr_link)):
                ?>
                <li><a href="<?php echo $flickr_link; ?>" target="_blank"><i class="fa fa-flickr"></i></a>
                </li><?php endif; ?>
        </ul>
    </div>
    <?php

}

add_action('kul_copyright', 'kul_copyright');
function kul_copyright()
{
    $kul_option = kul_get_options();
    $kul_footer_text = $kul_option['kul_footer_text'];
    ?>
    <div class="copryright">
        <p><?php echo wp_kses_post($kul_footer_text); ?></p>
    </div>
    <?php

}

add_action('kul_title', 'kul_title');
function kul_title()
{
    $kul_option = kul_get_options();

    $kul_title = $kul_option['kul_title'];
    ?>
    <title><?php the_kul_title($kul_title); ?></title>
    <?php

}


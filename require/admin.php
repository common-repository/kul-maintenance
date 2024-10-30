<?php

add_action('admin_menu', 'kul_maintenance_admin');
function kul_maintenance_admin()
{
    global $kul_maintenance_variable;
    $kul_maintenance_variable->options_page = add_menu_page(
        'Kul Maintenance',
        'Kul Maintenance',
        'manage_options',
        'kul-maintenance',
        'manage_kul_options',
        KUL_MAINTENANCE_URI . 'images/kul-icon.png'
    );

    add_action("admin_init", 'kul_update_changes');
    add_action("admin_print_styles-{$kul_maintenance_variable->options_page}", 'kul_admin_print_custom_styles');
    add_action("admin_head-{$kul_maintenance_variable->options_page}", 'kul_maintenance_scripts');
}

function kul_admin_print_custom_styles()
{
    if (function_exists('wp_enqueue_media')) {
        wp_enqueue_media();
    } else {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');
    }
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('kul_upload', KUL_MAINTENANCE_URI . 'js/kul_upload.js');
    wp_enqueue_script('kul_switchery', KUL_MAINTENANCE_URI . 'js/switchery.min.js');
    wp_enqueue_script('kul_int_js', KUL_MAINTENANCE_URI . 'js/init.js', array('kul_switchery'), false, true);
    wp_enqueue_style('kul-maintenance', KUL_MAINTENANCE_URI . 'css/kul-admin.css');
    wp_enqueue_style('kul-switcher-css', KUL_MAINTENANCE_URI . 'css/switchery.css');


    wp_enqueue_script(
        'kul-maintenance',
        KUL_MAINTENANCE_URI . 'js/colorpic-init.js',
        array('wp-color-picker'),
        false,
        true
    );
}

function kul_update_changes()
{
    if (!empty($_POST['kulm_options']) && check_admin_referer('kul_maintenance_edit', 'kul_maintenance_nonce')) {
        if (!isset($_POST['kulm_options']['status'])) {
            $_POST['kulm_options']['status'] = 0;
        } else {
            $_POST['kulm_options']['status'] = 1;
        }

        if (isset($_POST['kulm_options']['htmlcss'])) {
            $_POST['kulm_options']['htmlcss'] = wp_kses_post(stripslashes($_POST['kulm_options']['htmlcss']));
        }
        if (isset($_POST['kul_description'])) {
            $_POST['kulm_options']['kul_description'] = $_POST['kul_description'];
        }

        if (isset($_POST['kulm_options'])) {
            update_option('kul_maintenance_options', $_POST['kulm_options']);
        }
    }
}

function kul_maintenance_meta_boxes()
{
    global $kul_maintenance_variable;
    add_meta_box(
        'kul-maintenance-general',
        __('General Settings', 'maintenance'),
        'add_general_fields',
        $kul_maintenance_variable->options_page,
        'main',
        'default'
    );
    add_meta_box(
        'kul-maintenance-stying',
        __('Styling and CSS', 'maintenance'),
        'add_styling_css_fields',
        $kul_maintenance_variable->options_page,
        'main',
        'default'
    );
    //add_meta_box( 'kul-maintenance-social',    __( 'Social Media and Email', 'maintenance' ), 'add_social_email_fields', $kul_maintenance_variable->options_page, 'main', 'default');
}

//add_action('add_meta_boxes', 'kul_maintenance_meta_boxes', 10);

function add_general_fields()
{
    $kul_option = kul_get_options();


    $kul_title = $kul_heading = $kul_description = $kul_site_index = $kul_footer_text = $kul_hide_form = '';


    if (isset($kul_option['kul_title'])) {
        $kul_title = wp_kses_post($kul_option['kul_title']);
    }
    if (isset($kul_option['kul_heading'])) {
        $kul_heading = wp_kses_post($kul_option['kul_heading']);
    }
    if (isset($kul_option['kul_description'])) {
        $kul_description = wp_kses_post($kul_option['kul_description']);
    }
    if (isset($kul_option['kul_footer_text'])) {
        $kul_footer_text = wp_kses_post($kul_option['kul_footer_text']);
    }
    if (isset($kul_option['kul_site_index'])) {
        $kul_site_index = wp_kses_post($kul_option['kul_site_index']);
    }
    if (isset($kul_option['kul_hide_form'])) {
        $kul_hide_form = wp_kses_post($kul_option['kul_hide_form']);
    }

    ?>
    <div class="kul-tab" id="tab-general">
        <table class="form-table">
            <tbody>
            <?php

            kul_get_input_field(__('Page title', 'kul-maintenance'), 'kul_title', 'kul_title', $kul_title);
            kul_get_input_field(__('Headline', 'kul-maintenance'), 'kul_heading', 'kul_heading', $kul_heading);
            kul_get_editor(
                __('Description', 'kul-maintenance'),
                'kul_description',
                'kul_description',
                $kul_description
            );
            kul_get_textarea(
                __('Footer Text', 'kul-maintenance'),
                'kul_footer_text',
                'kul_footer_text',
                $kul_footer_text,
                '',
                '',
                5
            );
            kul_get_image_field(
                __('Logo', 'kul-maintenance'),
                'kul_logo',
                'kul_logo',
                $kul_option['kul_logo'],
                'boxes box-logo',
                __('Upload Logo', 'kul-maintenance'),
                'upload_logo upload_btn button'
            );
            kul_get_checkbox_field(
                __('Discourage Site index', 'kul-maintenance'),
                '',
                'kul_site_index',
                'kul_site_index',
                $kul_site_index
            );
            kul_get_checkbox_field(
                __('Hide Form', 'kul-maintenance'),
                '',
                'kul_hide_form',
                'kul_hide_form',
                $kul_hide_form
            );
            ?>
            </tbody>
        </table>
    </div>
    <?php

}

function add_styling_css_fields()
{
    $kul_option = kul_get_options();

    $background_color = esc_attr($kul_option['background_color']);
    $font_color = esc_attr($kul_option['font_color']);
    $hover_color = esc_attr($kul_option['hover_color']);
    $hyperlink_color = esc_attr($kul_option['hyperlink_color']);

    if (isset($kul_option['custom_css'])) {
        $custom_css = wp_kses_post($kul_option['custom_css']);
    }


    ?>
    <div class="kul-tab hidden" id="tab-design">
        <table class="form-table">
            <tbody>
            <?php

            kul_get_color_field(
                __('Background color', 'kul-maintenance'),
                'background_color',
                'background_color',
                $background_color,
                '#3e3e3e'
            );
            kul_get_color_field(
                __('Font color', 'kul-maintenance'),
                'font_color',
                'font_color',
                $font_color,
                '#ffffff'
            );
            kul_get_color_field(
                __('Hyperlink color', 'kul-maintenance'),
                'hyperlink_color',
                'hyperlink_color',
                $hyperlink_color,
                '#fcf100'
            );
            kul_get_color_field(
                __('Hover color', 'kul-maintenance'),
                'hover_color',
                'hover_color',
                $hover_color,
                '#fcf100'
            );
            kul_get_fonts_field(
                __('Font family', 'kul-maintenance'),
                'body_font_family',
                'body_font_family',
                esc_attr($kul_option['body_font_family'])
            );
            kul_get_textarea(__('Custom Css', 'kul-maintenance'), 'custom_css', 'custom_css', $custom_css);
            ?>
            </tbody>
        </table>
    </div>
    <?php

}

function add_social_fields()
{
    $kul_option = kul_get_options();

    $contact_email = $email_template = $facebook_link = $twitter_link = $linkedin_link = $youtube_link = $instagram_link = $flickr_link = '';
    if (isset($kul_option['contact_email'])) {
        $contact_email = wp_kses_post($kul_option['contact_email']);
    }
    if (isset($kul_option['email_subject'])) {
        $email_subject = wp_kses_post($kul_option['email_subject']);
    }
    if (isset($kul_option['email_template'])) {
        $email_template = wp_kses_post($kul_option['email_template']);
    }
    if (isset($kul_option['facebook_link'])) {
        $facebook_link = wp_kses_post($kul_option['facebook_link']);
    }
    if (isset($kul_option['twitter_link'])) {
        $twitter_link = wp_kses_post($kul_option['twitter_link']);
    }
    if (isset($kul_option['linkedin_link'])) {
        $linkedin_link = wp_kses_post($kul_option['linkedin_link']);
    }
    if (isset($kul_option['youtube_link'])) {
        $youtube_link = wp_kses_post($kul_option['youtube_link']);
    }
    if (isset($kul_option['instagram_link'])) {
        $instagram_link = wp_kses_post($kul_option['instagram_link']);
    }
    if (isset($kul_option['flickr_link'])) {
        $flickr_link = wp_kses_post($kul_option['flickr_link']);
    }


    ?>
    <div class="kul-tab hidden" id="tab-social">
        <table class="form-table">
            <tbody>
            <?php

            kul_get_input_field(
                __('Contact Email', 'kul-maintenance'),
                'contact_email',
                'contact_email',
                $contact_email,
                '',
                'You can use multiple email like abcd@example.com, xyz@example.com'
            );
            kul_get_input_field(
                __('Email Subject', 'kul-maintenance'),
                'email_subject',
                'email_subject',
                $email_subject
            );
            kul_get_textarea(
                __('Email Template', 'kul-maintenance'),
                'email_template',
                'email_template',
                $email_template,
                '1'
            );
            kul_get_input_field(
                __('Facebook Link', 'kul-maintenance'),
                'facebook_link',
                'facebook_link',
                $facebook_link
            );
            kul_get_input_field(__('Twitter Link', 'kul-maintenance'), 'twitter_link', 'twitter_link', $twitter_link);
            kul_get_input_field(
                __('LinkedIn Link', 'kul-maintenance'),
                'linkedin_link',
                'linkedin_link',
                $linkedin_link
            );
            kul_get_input_field(__('Youtube Link', 'kul-maintenance'), 'youtube_link', 'youtube_link', $youtube_link);
            kul_get_input_field(
                __('Instagram Link', 'kul-maintenance'),
                'instagram_link',
                'instagram_link',
                $instagram_link
            );
            kul_get_input_field(__('Flickr Link', 'kul-maintenance'), 'flickr_link', 'flickr_link', $flickr_link);
            ?>
            </tbody>
        </table>
    </div>
    <?php

}

function add_slider_fields()
{
    $kul_option = kul_get_options();
    $slider_status = kul_get_slider_status();
    ?>
    <div class="kul-tab hidden" id="tab-slider">
        <table class="form-table">
            <tbody>
            <div class="slider_active">
                <label>Slider Active</label>
                <input type="checkbox" id="slider_status" name="kulm_options[slider_status]"
                       class="js-switch1" <?php if ($slider_status == 'true') {
                    echo "checked";
                } ?>/>
                <span class="kul_status_text<?php if ($slider_status == 'true') echo ' on' ?>"><?php if ($slider_status == 'true') {
                        echo "Active";
                    } else {
                        echo "Inactive";
                    } ?></span>
            </div>
            <div><span class="image_dimen">Recommended Dimension: Since we are using Backstretch js you can use any image dimension with minimum width of 1280px and height 800px. </span>
            </div>

            <?php

            kul_get_image_field(
                __('Slider 1', 'kul-maintenance'),
                'slider_1',
                'slider_1',
                $kul_option['slider_1'],
                'boxes box-slider',
                __('Upload Slider', 'kul-maintenance'),
                'upload_slider upload_btn button'
            );
            kul_get_image_field(
                __('Slider 2', 'kul-maintenance'),
                'slider_2',
                'slider_2',
                $kul_option['slider_2'],
                'boxes box-slider',
                __('Upload Slider', 'kul-maintenance'),
                'upload_slider upload_btn button'
            );
            kul_get_image_field(
                __('Slider 3', 'kul-maintenance'),
                'slider_3',
                'slider_3',
                $kul_option['slider_3'],
                'boxes box-slider',
                __('Upload Slider', 'kul-maintenance'),
                'upload_slider upload_btn button'
            );
            kul_get_image_field(
                __('Slider 4', 'kul-maintenance'),
                'slider_4',
                'slider_4',
                $kul_option['slider_4'],
                'boxes box-slider',
                __('Upload Slider', 'kul-maintenance'),
                'upload_slider upload_btn button'
            );
            ?>
            </tbody>
        </table>
    </div>
    <?php

}

function manage_kul_options()
{
    $status = kul_get_status();
    ?>


    <div class="wrap">
        <form method="post" enctype="multipart/form-data" name="kul-maintenance-form">
            <?php wp_nonce_field('kul_maintenance_edit', 'kul_maintenance_nonce'); ?>
            <h2 class="kul-admin-title">Kul Maintenance</h2>
            <input type="checkbox" id="status" name="kulm_options[status]"
                   class="js-switch" <?php if ($status == 'true') {
                echo "checked";
            } ?>/>
            <span id="kul_status_text"
                  class="kul_status_text<?php if ($status == 'true') echo ' on' ?>"><?php if ($status == 'true') {
                    echo "ON";
                } else {
                    echo "OFF";
                } ?></span>
            <div class="clear"></div>
            <div id="poststuff">
                <div class="metabox-holder">
                    <div id="kul-maintenance-fields" class="postbox-container content-left">
                        <h2 class="nav-tab-wrapper">
                            <a href="#general" class="nav-tab nav-tab-active">General</a>
                            <a href="#design" class="nav-tab">Design</a>
                            <a href="#social" class="nav-tab">Social</a>
                            <a href="#slider" class="nav-tab">Slider</a>
                        </h2>
                        <?php add_general_fields(); ?>
                        <?php add_styling_css_fields() ?>
                        <?php add_social_fields() ?>
                        <?php add_slider_fields() ?>
                        <?php submit_button(__('Save changes', 'kul-maintenance'), 'primary'); ?>
                    </div>
                    <div id="kul-maintenance-right" class="postbox-container kul-admin-right">
                        <?php get_sidebar_info(); ?>
                        <?php get_support_info(); ?>
                    </div>
                </div>
            </div>


        </form>
    </div>
    <?php


}

<?php

global $global_fonts;
global $google_fonts;
$global_fonts = array(
    "Arial, Helvetica, sans-serif" => "Arial, Helvetica, sans-serif",
    "Arial Black, Gadget, sans-serif" => "Arial Black, Gadget, sans-serif",
    "Bookman Old Style, serif" => "Bookman Old Style, serif",
    "Comic Sans MS, cursive" => "Comic Sans MS, cursive",
    "Courier, monospace" => "Courier, monospace",
    "Garamond, serif" => "Garamond, serif",
    "Georgia, serif" => "Georgia, serif",
    "Impact, Charcoal, sans-serif" => "Impact, Charcoal, sans-serif",
    "Lucida Console, Monaco, monospace" => "Lucida Console, Monaco, monospace",
    "Lucida Sans Unicode, Lucida Grande, sans-serif" => "Lucida Sans Unicode, Lucida Grande, sans-serif",
    "MS Sans Serif, Geneva, sans-serif" => "MS Sans Serif, Geneva, sans-serif",
    "MS Serif, New York, sans-serif" => "MS Serif, New York, sans-serif",
    "Palatino Linotype, Book Antiqua, Palatino, serif" => "Palatino Linotype, Book Antiqua, Palatino, serif",
    "Tahoma,Geneva, sans-serif" => "Tahoma, Geneva, sans-serif",
    "Times New Roman, Times,serif" => "Times New Roman, Times, serif",
    "Trebuchet MS, Helvetica, sans-serif" => "Trebuchet MS, Helvetica, sans-serif",
    "Verdana, Geneva, sans-serif" => "Verdana, Geneva, sans-serif",
);
$google_fonts = array(
    "Open Sans" => "Open Sans",
    "Abel" => "Abel",
    "Roboto " => "Roboto",
    "Lato" => "Lato",
    "Oswald" => "Oswald",
    "Roboto Condensed" => "Roboto Condensed",
    "Lora" => "Lora",
    "Source Sans Pro" => "Source Sans Pro",
    "Montserrat" => "Montserrat",
    "PT Sans" => "PT Sans",
    "Open Sans Condensed" => "Open Sans Condensed",
    "Raleway" => "Raleway",
    "Droid Sans" => "Droid Sans",
    "Ubuntu" => "Ubuntu",
    "Roboto Slab" => "Roboto Slab",
    "Droid Serif" => "Droid Serif",
    "Merriweather" => "Merriweather",
    "Arimo" => "Arimo",
    "PT Sans Narrow" => "PT Sans Narrow",
    "Noto Sans" => "Noto Sans"
);

function kul_get_input_field($title, $id, $name, $value, $placeholder = '', $desc = '')
{
    $kul_out_field = '';
    $kul_out_field .= '<tr valign="top">';
    $kul_out_field .= '<th scope="row">' . esc_attr($title) . '</th>';
    $kul_out_field .= '<td>';
    if ($desc) {
        $kul_out_field .= $desc;
    }
    $kul_out_field .= '<fieldset>';
    $kul_out_field .= '<input type="text" id="' . esc_attr(
            $id
        ) . '" name="kulm_options[' . $name . ']" value="' . wp_kses_post(
            stripslashes($value)
        ) . '" placeholder="' . $placeholder . '"/>';
    $kul_out_field .= '</fieldset>';
    $kul_out_field .= '</td>';
    $kul_out_field .= '</tr>';
    echo $kul_out_field;
}

function kul_get_textarea($title, $id, $name, $value, $help = '', $col = 30, $row = 10)
{
    $kul_out_field = '';
    $kul_out_field .= '<tr valign="top">';
    $kul_out_field .= '<th scope="row">' . esc_attr($title) . '</th>';
    $kul_out_field .= '<td>';
    if ($help) {
        $kul_out_field .= "you can use these mail-tags '%name%', '%email%', '%message%'";
    }
    $kul_out_field .= '<fieldset>';
    $kul_out_field .= '<textarea name="kulm_options[' . $name . ']" id="' . esc_attr(
            $id
        ) . '" cols="' . $col . '" rows="' . $row . '">' . wp_kses_post(stripslashes($value)) . '</textarea>';
    $kul_out_field .= '</fieldset>';
    $kul_out_field .= '</td>';
    $kul_out_field .= '</tr>';
    echo $kul_out_field;
}

function kul_get_editor($title, $id, $name, $value, $help = '', $col = 30, $row = 10)
{
    $kul_out_field = '';
    $kul_out_field .= '<tr valign="top">';
    $kul_out_field .= '<th scope="row">' . esc_attr($title) . '</th>';
    $kul_out_field .= '<td>';
    if ($help) {
        $kul_out_field .= "you can use these mail-tags '%name%', '%email%', '%message%'";
    }
    $kul_out_field .= '<fieldset>';
    echo $kul_out_field;
    $settings = array(
        'textarea_rows' => 6,
        'media_buttons' => false,
        'teeny' => true,
        'tinymce' => true
    );
    wp_editor($value, $id, $settings);
    $kul_out_field .= '<textarea name="kulm_options[' . $name . ']" id="' . esc_attr(
            $id
        ) . '" cols="' . $col . '" rows="' . $row . '">' . wp_kses_post(stripslashes($value)) . '</textarea>';
    $kul_out_field1 = '</fieldset>';
    $kul_out_field1 .= '</td>';
    $kul_out_field1 .= '</tr>';
    echo $kul_out_field1;
}

function kul_get_image_field($title, $id, $name, $value, $class, $name_btn, $class_btn)
{
    $kul_out_field = '';

    $kul_out_field .= '<tr valign="top">';
    $kul_out_field .= '<th scope="row">' . esc_attr($title) . '</th>';
    $kul_out_field .= '<td>';
    $kul_out_field .= '<filedset>';
    $kul_out_field .= '<input type="hidden" id="' . esc_attr(
            $id
        ) . '" name="kulm_options[' . $name . ']" value="' . esc_attr($value) . '" />';
    $kul_out_field .= '<div class="img-container">';
    $url = '';


    $kul_out_field .= '<div class="' . esc_attr($class) . '" style="background-image:url(' . $value . ')">';
    if ($value) {
        $kul_out_field .= '<input class="button button-primary delete-img remove" type="button" value="x" />';
    }
    $kul_out_field .= '</div>';
    $kul_out_field .= '<input type="button" class="' . esc_attr($class_btn) . '" value="' . esc_attr($name_btn) . '"/>';
    $kul_out_field .= '</div>';
    $kul_out_field .= '</filedset>';
    $kul_out_field .= '</td>';
    $kul_out_field .= '</tr>';
    echo $kul_out_field;
}

function kul_get_checkbox_field($title, $label, $id, $name, $value)
{
    $kul_out_field = '';
    $kul_out_field .= '<tr valign="top">';
    $kul_out_field .= '<th scope="row">' . esc_attr($title) . '</th>';
    $kul_out_field .= '<td>';
    $kul_out_field .= '<filedset>';
    $kul_out_field .= '<label for=' . esc_attr($id) . '>';
    $kul_out_field .= '<input type="checkbox"  id="' . esc_attr(
            $id
        ) . '" name="kulm_options[' . $name . ']" value="1" ' . checked(true, $value, false) . '/>';
    $kul_out_field .= $label;
    $kul_out_field .= '</label>';
    $kul_out_field .= '</filedset>';
    $kul_out_field .= '</td>';
    $kul_out_field .= '</tr>';
    echo $kul_out_field;
}

function kul_get_color_field($title, $id, $name, $value, $default_color)
{
    $kul_out_field = '';
    $kul_out_field .= '<tr valign="top">';
    $kul_out_field .= '<th scope="row">' . esc_attr($title) . '</th>';
    $kul_out_field .= '<td>';
    $kul_out_field .= '<filedset>';
    $kul_out_field .= '<input type="text" id="' . esc_attr(
            $id
        ) . '" name="kulm_options[' . $name . ']" data-default-color="' . esc_attr(
            $default_color
        ) . '" value="' . wp_kses_post(stripslashes($value)) . '" />';
    $kul_out_field .= '<filedset>';
    $kul_out_field .= '</td>';
    $kul_out_field .= '</tr>';
    echo $kul_out_field;
}


function kul_get_fonts_field($title, $id, $name, $value)
{
    global $standart_fonts;
    global $google_fonts;
    $kul_out_field = '';
    $kul_out_field .= '<tr valign="top">';
    $kul_out_field .= '<th scope="row">' . esc_attr($title) . '</th>';
    $kul_out_field .= '<td>';
    $kul_out_field .= '<fieldset>';
    if (!empty($standart_fonts)) {
        $kul_out_field1 .= '<optgroup label="' . __('Standard Fonts', 'anaglyph-framework') . '">';
        foreach ($standart_fonts as $key => $options) {
            $kul_out_field1 .= '<option value="' . $key . '" ' . selected(
                    $value,
                    $key,
                    false
                ) . '>' . $options . '</option>';
        }
    }

    if (!empty($google_fonts)) {
        $kul_out_field1 .= '<optgroup label="' . __('Google Web Fonts', 'anaglyph-framework') . '">';
        foreach ($google_fonts as $key => $options) {
            $kul_out_field1 .= '<option value="' . $key . '" ' . selected(
                    $value,
                    $key,
                    false
                ) . '>' . $key . '</option>';
        }
    }

    if (!empty($kul_out_field)) {
        $kul_out_field .= '<select class="select2_customize" name="kulm_options[' . $name . ']" id="' . esc_attr(
                $id
            ) . '">';
        $kul_out_field .= $kul_out_field1;
        $kul_out_field .= '</select>';
    }

    $kul_out_field .= '<fieldset>';
    $kul_out_field .= '</td>';
    $kul_out_field .= '</tr>';
    echo $kul_out_field;
}


function get_sidebar_info()
{
    ?>
    <div class="sidebar_box info_box postbox">
        <h3 class="hndle ui-sortable-handle"><?php _e('Plugin Info', 'kul-maintenance'); ?></h3>
        <div class="inside">

            <ul>
                <li><?php _e('Name', 'kul-maintenance'); ?> : Kul Maintenance</li>
                <li><?php _e('Author', 'kul-maintenance'); ?> : Kaushal Dip Subba</li>
            </ul>
        </div>
    </div>
    <?php

}

function get_support_info()
{
    ?>
    <div class="sidebar_box info_box postbox">
        <h3 class="hndle ui-sortable-handle"><?php _e('Support', 'kul-maintenance'); ?></h3>
        <div class="inside">

            <div id="sidebar-promo" class="sidebar-promo">
                <h4 class="support">Do you have any queries?</h4>
                <p>You may find answers at
                    <a href="http://wordpress.org/support/plugin/kul-maintenance" target="_blank">
                        support forum</a>.<br>
                    You can <a href="mailto:kulchan.kaushal@gmail.com?subject=Kul Maintenance plugin" target="_blank">contact
                        us</a>
                    for customization requests and suggestions.
                </p>
                <p>Wanna help grow this plugin, feel free to bag some coins
                    <a href="https://www.paypal.me/kulmaintenance" target="_blank">
                        Donate</a>.<br>

                </p>
            </div>
        </div>
    </div>
    <?php

}

function kul_get_options()
{
    $options = (array)get_option('kul_maintenance_options');

    return $options;
}

function kul_maintenance_scripts()
{
    ?>
    <script type="text/javascript">
        //<![CDATA[
        jQuery(document).ready(function ($) {
            $('a.nav-tab').click(function () {
                var tab_id = $(this).attr('href').replace('#', '#tab-');


                // active tab
                $(".nav-tab").removeClass('nav-tab-active');
                $(this).addClass('nav-tab-active');

                // active tab content
                $('.kul-tab').addClass('hidden');
                $('#kul-maintenance-fields div' + tab_id).removeClass('hidden');
            });
        });
        //]]>
    </script>
    <?php

}


/* redirection check*/

function kul_run_redirection()
{
    $kul_option = kul_get_options();
    $status = kul_get_status();
    if (!is_user_logged_in() && ($status == 'true')) {
        if (file_exists(KUL_MAINTENANCE_VIEW . 'maintenance.php')) {
            include_once KUL_MAINTENANCE_VIEW . 'maintenance.php';
            exit;
        }
    }
}


/* switchery enable status ajax */

add_action('wp_ajax_kul_maintenance_status', 'kul_maintenance_status');


function kul_maintenance_status()
{
    $status = $_POST['status'];

    update_option('kul_maintenance_status', $status);
    exit;
}

function kul_get_status()
{
    $options = get_option('kul_maintenance_status');
    return $options;
}

/* switchery enable status ajax for slider */

add_action('wp_ajax_kul_maintenance_slider_status', 'kul_maintenance_slider_status');


function kul_maintenance_slider_status()
{
    $status = $_POST['status'];

    update_option('kul_maintenance_slider_status', $status);
    exit;
}

function kul_get_slider_status()
{
    $options = get_option('kul_maintenance_slider_status');
    return $options;
}
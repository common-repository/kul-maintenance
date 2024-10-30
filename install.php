<?php

$email_subject = 'Contact Inquery Form';
$contact_email = get_option('admin_email');
$email_template = "Name: %name%\r\nEmail: %email%\r\nMessage:  %message%\r\n\r\nThis message is send from " . site_url(
    );
$logo = trailingslashit(plugin_dir_url(__FILE__)) . 'view/images/logo.png';
$slider1 = trailingslashit(plugin_dir_url(__FILE__)) . 'view/images/slide1.jpg';
$slider2 = trailingslashit(plugin_dir_url(__FILE__)) . 'view/images/slide2.jpg';
$slider3 = trailingslashit(plugin_dir_url(__FILE__)) . 'view/images/slide3.jpg';
$slider4 = trailingslashit(plugin_dir_url(__FILE__)) . 'view/images/slide4.jpg';
$json_p = '{"status":1,"kul_title":"Maintenance Mode","kul_heading":"Maintenance Mode","kul_description":"Sorry for inconvenience, we are making few changes to in our website We will be back soon If you have any question contact us from below.","kul_footer_text":"\u00a9 Copyright <a href=\"yourdomain.com\">yourdomain.com<\/a>","admin_bar_enabled":"1","background_color":"#000000","font_color":"#ffffff","hyperlink_color":"#0066E4","hover_color":"#0066E4","body_font_family":"Abel","custom_css":"","facebook_link":"#","twitter_link":"#","linkedin_link":"#","youtube_link":"#","instagram_link":"#","flickr_link":"#"}';
$kul_option = json_decode($json_p);
$kul_option->contact_email = $contact_email;
$kul_option->email_subject = $email_subject;
$kul_option->email_template = $email_template;
$kul_option->kul_logo = $logo;
$kul_option->slider_1 = $slider1;
$kul_option->slider_2 = $slider2;
$kul_option->slider_3 = $slider3;
$kul_option->slider_4 = $slider4;

update_option('kul_maintenance_options', $kul_option);
update_option('kul_maintenance_slider_status', 'true');


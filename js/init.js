var elem = document.querySelector('.js-switch');
var init = new Switchery(elem, {secondaryColor: '#e50000'});
elem.onchange = function () {
    if (elem.checked) {
        jQuery('#kul_status_text').text("ON");

        jQuery('#kul_status_text').addClass("on");
    } else {
        jQuery('#kul_status_text').text("OFF");

        jQuery('#kul_status_text').removeClass("on");
    }
    var formData = {
        'action': 'kul_maintenance_status',
        'status': elem.checked
    };

    jQuery.post(ajaxurl, formData, function (response) {

    });
};

var elem1 = document.querySelector('.js-switch1');
var init = new Switchery(elem1, {size: 'small', secondaryColor: '#e50000'});
elem1.onchange = function () {
    if (elem1.checked) {
        jQuery('.slider_active .kul_status_text').text("Active");

        jQuery('.slider_active .kul_status_text').addClass("on");
    } else {
        jQuery('.slider_active .kul_status_text').text("Inactive");

        jQuery('.slider_active .kul_status_text').removeClass("on");
    }
    var formData = {
        'action': 'kul_maintenance_slider_status',
        'status': elem1.checked
    };

    jQuery.post(ajaxurl, formData, function (response) {

    });
};
jQuery(function ($) {
    var hash = window.location.hash;
    if (hash != '') {
        $('.nav-tab-wrapper').children().removeClass('nav-tab-active');
        $('.nav-tab-wrapper a[href="' + hash + '"]').addClass('nav-tab-active');

        $('.kul-tab').addClass('hidden');
        $('#kul-maintenance-fields div' + hash.replace('#', '#tab-')).removeClass('hidden');
    }


})
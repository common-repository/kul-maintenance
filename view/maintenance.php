<!doctype html>
<html lang="en">
<head>
    <?php

    do_action('kul_title');
    ?>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <?php

    do_action('kul_head');
    ?>
    <?php

    do_action('kul_head');
    ?>
    <?php

    do_action('kul_head_font');
    ?>
    <!-- color changes -->
    <?php

    do_action('kul_head_hover');
    ?>
    <!-- color changes -->
    <!---custom css -->
    <?php

    do_action('kul_custom_css');
    ?>
    <?php

    do_action('kul_site_block');
    ?>
</head>
<body>

<!-- ======== slider overlay ======= -->
<?php

do_action('kul_slider');
?>

<!-- ======== slider overlay ======= -->
<div class="main_container">
    <div class="content_holder">
        <div class="container">
            <div class="row">
                <?php

                do_action('kul_logo');
                ?>
                <?php

                do_action('kul_heading');
                ?>
                <?php

                do_action('kul_description');
                ?>
                <?php

                do_action('kul_form');
                ?>
                <?php

                do_action('kul_social');
                ?>
                <?php

                do_action('kul_copyright');
                ?>
            </div>
        </div>

        <!-- container ends -->


    </div>
</div>
<?php

do_action('kul_footer');
?>

<!-- ======== for height main container ======== -->
<?php do_action('kul_footer_last'); ?>
</body>
</html>
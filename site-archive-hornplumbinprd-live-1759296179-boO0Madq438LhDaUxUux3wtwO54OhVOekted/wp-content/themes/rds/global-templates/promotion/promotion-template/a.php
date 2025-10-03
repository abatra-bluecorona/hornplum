<?php
$enable_sidebar = $args["enable_sidebar"];
$widget_id = 32541;
$category_name = is_array($args["category_taxonomy"]) ? $args["category_taxonomy"] : [$args["category_taxonomy"]];
$get_rds_template_data_array = RDS_TEMPLATE_DATA;
$promotion_pagination = $enable_sidebar === "yes" ? 6 : 9;
$paged = get_query_var("paged") ? get_query_var("paged") : -1;
$current_date = date("m/d/Y");
$saved_date = get_option('custom_selected_date');
if (empty($category_name) || in_array("all", $category_name)) {
    query_posts([
        "post_type" => "bc_promotions",
        "posts_per_page" => $promotion_pagination,
        "paged" => $paged,
        "order" => "DESC",
        "post_status" => "publish",
        "meta_query" => [
            "relation" => "AND",
            [
                "key" => "promotion_landing_page_setting",
                "value" => "0",
            ],
            [
                "key" => "promotion_expiry_date1",
                "value" => $current_date,
                "compare" => ">=",
            ],
        ],
        "meta_value" => $current_date,
        "meta_compare" => ">=",
    ]);
} else {
    $abc = query_posts([
        "post_type" => "bc_promotions",
        "posts_per_page" => $promotion_pagination,
        "paged" => $paged,
        "order" => "DESC",
        "post_status" => "publish",
        "meta_query" => [
            "relation" => "AND",
            [
                "key" => "promotion_landing_page_setting",
                "value" => "0",
            ],
            [
                "key" => "promotion_expiry_date1",
                "value" => $current_date,
                "compare" => ">=",
            ],
        ],
        "tax_query" => [
            [
                "taxonomy" => "bc_promotion_category",
                "field" => "name",
                "terms" => $category_name,
                "operator" => "IN",
            ],
        ],
    ]);
}

global $wp_query;
?>
<main>
    <div class="w-100 d-block">
        <div class="d-flex flex-column">
            <div class="d-block order-1 order-lg-1">
                <!-- Subpage content area starts -->
                <div class="container-fluid pt-4 order-1 order-lg-1 pb-lg-2 pb-4 my-2 px-lg-3 px-0">
                    <div class="container subpage_full_content pb-lg-5 px-lg-3 px-0">
                        <div class="row pb-lg-0 mx-0">
                            <h1 class="mb-4 mt-2"><?php the_title(); ?></h1>
                            <div class="<?php echo $enable_sidebar === "yes" ? "col-12 col-lg-8 order-lg-1 order-1" : "col-12 col-lg-12 order-lg-1 order-1"; ?>">
                                <div class="row px-3">
                                    <?php
                                    $i = 0;
                                    if (have_posts()):
                                        while (have_posts()):
                                            the_post();
                                            if (function_exists("get_promotion_query")) {
                                                $get_rds_template_data_array = RDS_TEMPLATE_DATA;
                                                $promotion_type = get_post_meta(get_the_ID(), "promotion_type", true);
                                                $noexpiry = get_post_meta(get_the_ID(), "promotion_noexpiry", true);
                                                $colorCode = get_post_meta(get_the_ID(), "promotion_color", true);
                                                $date = get_post_meta(get_the_ID(), "promotion_expiry_date1", true);
                                                $open_new_tab = get_post_meta(get_the_ID(), "promotion_open_new_tab", true);

                                                if (strtotime($date) >= strtotime(current_time("m/d/Y")) || $noexpiry == 1) {

                                                    $title = get_post_meta(get_the_ID(), "promotion_title1", true);
                                                    $color = get_post_meta(get_the_ID(), "promotion_color", true);
                                                    $subheading = get_post_meta(get_the_ID(), "promotion_subheading", true);
                                                    $heading = get_post_meta(get_the_ID(), "promotion_heading", true);
                                                    $footer_heading = get_post_meta(get_the_ID(), "promotion_footer_heading", true);
                                                    $requestButtonLink = get_post_meta($post->ID, "request_button_link", true);
                                                    $requestButtonTitle = get_post_meta($post->ID, "request_button_title", true);
                                                    ?>
                                                    <div class="<?php echo $enable_sidebar === "yes" ? "col-lg-6 mb-lg-5 mb-4 pb-lg-3" : "col-lg-4 mb-lg-5 mb-4"; ?>">
                                                        <div class="h-coupan-100 color_primary_bg p-lg-3 p-3" style="background-color: <?php echo esc_attr($colorCode); ?>;">
                                                            <div class="coupon_name border-dashed-5 border-lg-dashed-5 h-coupan-100 py-4 p-4 px-lg-0 text-center">
                                                                <?php if (!empty($heading)) { ?>
                                                                    <span class="d-block text-center px-lg-0 px-3 pt-lg-0 pt-2 coupon_subtitle coupon_heading"><?php echo esc_html($heading); ?></span>
                                                                <?php } ?>
                                                                <?php if (!empty($subheading)) { ?>
                                                                    <span class="d-block text-center py-2 px-lg-0 px-2 pt-lg-0 pt-2 my-lg-1 coupon_sub_heading"><?php echo esc_html($subheading); ?></span>
                                                                <?php } ?>
                                                                <?php if (!empty($title)) { ?>
                                                                    <h4 class="mb-0 pb-lg-3 pt-lg-0 py-3 coupon_title coupon_offer"><?php echo esc_html($title); ?></h4>
                                                                <?php } ?>
                                                                <?php if (!empty($requestButtonLink) || !empty($requestButtonTitle)) { ?>
                                                                    <a data-bs-toggle="<?php echo empty($requestButtonLink) ? "modal" : ""; ?>" data-bs-target="<?php echo empty($requestButtonLink) ? "#slider_request_coupon_form" : ""; ?>" <?php echo empty($requestButtonLink) ? 'onclick="couponButtonClick(this);"' : 'href="' . esc_url($requestButtonLink) . '"'; ?> <?php echo empty($requestButtonTitle) ? 'aria-label="Request Service"' : 'aria-label="' . esc_attr($requestButtonTitle) . '"'; ?> class="btn btn-secondary mw-226 request_service_button" <?php echo $open_new_tab == 1 ? 'target="_blank"' : ""; ?>>
                                                                        <?php echo empty($requestButtonTitle) ? "Request Service" : esc_html($requestButtonTitle); ?>
                                                                        <i class="icon-chevron-right text_18 line_height_18 ms-2"></i>
                                                                    </a>
                                                                <?php } ?>
                                                                <?php if ($noexpiry != 1 && !empty($date)) { ?>
                                                                    <span class="pt-lg-3 pt-2 d-block coupon_expiry"><?php echo "Expires " . esc_html($date); ?></span>
                                                                <?php } ?>
                                                                <?php if (!empty($footer_heading)) { ?>
                                                                    <span class="d-block coupon_disclaimer"><?php echo esc_html($footer_heading); ?></span>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                    <?php $i++;
                                                }
                                            }
                                        endwhile;
                                    endif;
                                    ?>
                                </div>
                                <?php if ($i >= $promotion_pagination || $wp_query->max_num_pages > 1) { ?>
                                    <div class="row">
                                        <div class="col-md-12 d-flex align-items-center justify-content-center mt-lg-0 mt-3">
                                            <?php understrap_pagination(["prev_text" => '<i class="icon-angles-left4"></i>', "next_text" => '<i class="icon-angles-right4"></i>']); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php if ($enable_sidebar === "yes") { ?>
                                <div class="col-lg-4 pt-lg-0 pt-4 px-0 order-lg-2 order-2 overflow-hidden sidebar">
                                    <div class="d-flex flex-column w-100">
                                        <?php echo do_shortcode('[elementor-template id="40126"]'); ?>
                                        <?php echo do_shortcode('[elementor-template id="40147"]'); ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- Subpage content area ends -->
            </div>
        </div>
    </div>
</main>
<?php 
   get_template_part('page-templates/common/bc-promotion-popup', null, $args); 
?>
<?php wp_reset_query(); ?>

            <script>
                 jQuery(".promotionC_icon").click(function () {
                        var text = jQuery(this).html().trim();
                        currentText = jQuery(this).text();

                        if (currentText == "More info ") {
                            jQuery(this).html(text.replace('More info ', 'Less info '));
                            if (jQuery('body').hasClass('elementor-editor-active')) {
                             jQuery(this).find('i').toggleClass('icon-plus1 icon-minus1');
                         }
                        } else {
                            jQuery(this).html(text.replace('Less info ', 'More info '));
                             if (jQuery('body').hasClass('elementor-editor-active')) {
                                  jQuery(this).find('i').toggleClass('icon-minus1 icon-plus1');
                              }
                        }
                    });
            </script>
                <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery(".rds_gform_submit").click(function () {
                console.log(jQuery(this).closest("form").find(".coupon-name input").val());
                var promotiontitleValue = jQuery(this).closest("form").find(".coupon-name input").val();
                if (promotiontitleValue != "") {
                    setTimeout(function () {
                        jQuery('.bc-promotion-title').text(promotiontitleValue);
                    }, 500);
                }
            });
            setInterval(function () {
                    var promotiontitleValue = jQuery('#input_9_10').val();
                    jQuery('.bc-promotion-title').text(promotiontitleValue);
            }, 500);
        });
        function couponButtonClick(attr) {
            var CouponTitle = jQuery(attr).parent('.coupon_name').find('.coupon_title').text();
            var CouponsubTitle = jQuery(attr).parent('.coupon_name').find('.coupon_subtitle').text();
            var Couponsubheading = jQuery(attr).parent('.coupon_name').find('.coupon_sub_heading ').text();
            console.log(CouponTitle + " " + CouponsubTitle + " " + Couponsubheading)
            jQuery(".coupon-name").find('input:text').val(CouponTitle + " " + CouponsubTitle + " " + Couponsubheading);
            jQuery(".bc-promotion-title").text(CouponTitle + " " + CouponsubTitle + " " + Couponsubheading);
        }

    </script>
<?php if (function_exists('get_promotion_query')) {
    // $query = get_promotion_query(3);
    $category_name = $args['category_taxonomy'];
    $current_date = date('m/d/Y');
    if (empty($category_name) || in_array("all", $category_name)) {
        query_posts([
            "post_type" => "bc_promotions",
            "posts_per_page" => "3",
            // "paged" => $paged,
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
         "posts_per_page" => "3",
        //  "paged" => $paged,
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


            if (have_posts()) {?>
    <div class="sidebar_coupon pt-lg-5 mt-4 pb-lg-4 px-lg-0 px-2 mx-lg-0 mx-1 order-lg-2 order-2">
    <?php if (!empty($args['page_templates']['subpage']['sidebar']['promotion']['heading'])): ?>
        <span class="font_default text_semibold text_28 line_height_33 text-center d-block pb-lg-3 sm_text_26 pb-4 sm_line_height_31">
            <?php echo $args['page_templates']['subpage']['sidebar']['promotion']['heading']; ?>
        </span>
    <?php endif; ?>
    
    <div class="swiper coupon-swiper">
        <div class="swiper-wrapper">
            <?php while (have_posts()) : the_post();
                $promotion_type = get_post_meta(get_the_ID(), 'promotion_type', TRUE);
                $noexpiry = get_post_meta(get_the_ID(), 'promotion_noexpiry', true);
                $colorCode = get_post_meta(get_the_ID(), 'promotion_color', true);
                $date = get_post_meta(get_the_ID(), 'promotion_expiry_date1', true);
                
                if (strtotime($date) >= strtotime(current_time('m/d/Y')) || $noexpiry == 1) {
                    $title = get_post_meta(get_the_ID(), 'promotion_title1', true);
                    $color = get_post_meta(get_the_ID(), 'promotion_color', true);
                    $subheading = get_post_meta(get_the_ID(), 'promotion_subheading', true);
                    $heading = get_post_meta(get_the_ID(), 'promotion_heading', true);
                    $footer_heading = get_post_meta(get_the_ID(), 'promotion_footer_heading', true);
                    $requestButtonLink = get_post_meta($post->ID, 'request_button_link', true);
                    $open_new_tab = get_post_meta(get_the_ID(), 'promotion_open_new_tab', true);
                    $requestButtonTitle = get_post_meta($post->ID, 'request_button_title', true);
            ?>
                    <div class="swiper-slide h-auto color_primary_bg p-lg-2 p-3" style="background-color: <?php echo $colorCode; ?>;">
                        <div class="coupon_name border-dashed-5 h-100 py-4 p-4 px-lg-0 text-center">
                            <?php if (!empty($heading)): ?>
                                <span class="d-block text-center px-lg-0 px-3 pt-lg-0 pt-2 coupon_subtitle coupon_heading">
                                    <?php echo $heading; ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (!empty($subheading)): ?>
                                <span class="d-block text-center py-2 px-lg-0 px-2 pt-lg-0 pt-2 my-lg-1 coupon_sub_heading">
                                    <?php echo $subheading; ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (!empty($title)): ?>
                                <h4 class="mb-0 pb-lg-3 pt-lg-0 py-3 coupon_title coupon_offer">
                                    <?php echo $title; ?>
                                </h4>
                            <?php endif; ?>
                            
                            <a data-bs-toggle="<?php echo (empty($requestButtonLink) ? 'modal' : ''); ?>" 
                               data-bs-target="<?php echo (empty($requestButtonLink) ? '#slider_request_coupon_form' : ''); ?>" 
                               <?php echo (empty($requestButtonLink) ? 'onclick="couponButtonClick(this);"' : 'href="' . $requestButtonLink . '"'); ?>
                               <?php echo (empty($requestButtonTitle) ? 'aria-label="Request Service"' : 'aria-label="' . $requestButtonTitle . '"'); ?>
                               class="btn btn-secondary mw-226 request_service_button"
                               <?php echo ($open_new_tab == 1 ? 'target="_blank"' : ''); ?>>
                                <?php echo (empty($requestButtonTitle) ? 'Request Service' : $requestButtonTitle); ?> 
                                <i class="icon-chevron-right text_18 line_height_18 ms-2"></i>
                            </a>
                            
                            <?php if ($noexpiry != 1 && !empty($date)): ?>
                                <span class="pt-lg-3 pt-2 d-block coupon_expiry">
                                    <?php echo 'Expires ' . $date; ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (!empty($footer_heading)): ?>
                                <span class="d-block coupon_disclaimer">
                                    <?php echo $footer_heading; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>  
                <?php } endwhile; ?>
        </div>
    </div>
    
    <div class="swiper-pagination coupon-pagination pagination-variation-a position-relative pb-3"></div>
    
    <div class="text-center see_all_button mb-4 pb-2">
        <?php if (!empty($args['page_templates']['subpage']['sidebar']['promotion']['button_link']) && !empty($args['page_templates']['subpage']['sidebar']['promotion']['button_text'])): ?>
            <a href="<?php echo get_home_url() . $args['page_templates']['subpage']['sidebar']['promotion']['button_link']; ?>" class="btn btn-primary mw-232">
                <?php echo $args['page_templates']['subpage']['sidebar']['promotion']['button_text']; ?> 
                <i class="icon-chevron-right text_18 line_height_18 ms-2 d-lg-inline-block d-none"></i>
            </a>
        <?php endif; ?>
    </div>
</div>
<?php 
   get_template_part('page-templates/common/bc-promotion-popup', null, $args); 
?>

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
	    var swiperSubpageA = new Swiper(".coupon-swiper", {
                spaceBetween: 10,
                slidesPerView: 1,
                loop: true,
                autoplay: {
                    delay: 8000,
                    disableOnInteraction: false,
                  },
                pagination: {
                    el: ".coupon-pagination",
                    clickable: true,
                },

            });
			            var mySwiper = document.querySelector('.coupon-swiper').swiper
                document.querySelectorAll('.request_service_button').forEach(function(button) {
                    button.addEventListener('click', function() {
                        if (document.getElementById('slider_request_coupon_form').classList.contains('show')) {
                            mySwiper.autoplay.stop();
                        }
                    });
                });

                document.querySelector('.coupon-popup-close').addEventListener('click', function() {
                    if (!document.getElementById('slider_request_coupon_form').classList.contains('show')) {
                        mySwiper.autoplay.start();
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
    <?php } wp_reset_query(); 
} ?>

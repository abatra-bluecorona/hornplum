<?php 
if (empty($args["globals"]["promotion"])){
    global $rdsTemplateDataGlobal;
    $args = $rdsTemplateDataGlobal;
}
?>
<div class="modal fade request_form px-lg-0 px-0 pt-5 pt-md-0 987987" id="slider_request_coupon_form" tabindex="-1" role="dialog" data-bs-backdrop="false" data-bs-keyboard="false" aria-labelledby="requestcoupon_Label" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered px-lg-0 px-2 " role="document">
      <div class="modal-content border-0 rounded-0 text-center">
         <div class="modal-header border-0 p-0">
            <button type="button" class="close coupon-popup-close position-absolute bg-transparent border-0 pb-0 px-0" data-bs-dismiss="modal" aria-label="Close" style="opacity:1; z-index: 999; color:#fff ;">
            <i class="icon-xmark1 text_30 line_height_26"></i>
            </button>
         </div>
         <div class="modal-body p-lg-4 p-2 w-100 my-auto mx-auto coupons">
            <div class="border-dashed-7 pt-lg-4 pb-lg-4 py-4 footer_form_A ui_kit_footer_form elementor-popupform">
               <?php 
               if (!empty($args["globals"]["promotion"]["popup_form_heading"])) { ?>
               <h3 class="px-lg-0 px-4"><?php echo $args["globals"]["promotion"]["popup_form_heading"]; ?></h3>
               <?php } ?>
               <?php if (!empty($args["globals"]["promotion"]["popup_form_subheading"])) { ?>
               <div class="my-md-0 mt-lg-4 mt-3 w-lg-260 mx-auto text-start text-lg-center d-flex align-items-center justify-content-center pb-4 px-lg-0 px-4">
                  <i class="icon-shield-check1 text_30 line_height_30 me-2 position-relative color_primary"></i>
                  <span class="font_alt_1 text_bold text_16 line_height_25 sm_text_16 sm_line_height_30 color_primary"><?php echo $args["globals"]["promotion"]["popup_form_subheading"]; ?></span>
               </div>
               <?php } ?>
               <div class="px-lg-5 mx-lg-4 px-4">
                  <?php
                     $form_id = $args["globals"]["promotion"]["popup_gravity_form_id"];
                     if (!empty($form_id)) {
                        echo do_shortcode("[gravityforms id=" . $form_id . " ajax=true]");
                     }
                     ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
    jQuery(document).ready(function () {
   
       jQuery(".coupon-popup-close").click(function () {
           
           jQuery(this).closest("#slider_request_coupon_form").find("form .gfield_label").each(function (k, d) {
               jQuery(d).attr("style", "");
               jQuery(d).parent('li').children('label').show();
               jQuery(d).parent('li').find('.validation_message').hide();
               jQuery(d).parent('li').removeClass('gfield_error');
               jQuery(d).parent('li').removeClass('gfield_error');
               jQuery(d).parent('li').find('input').val('');
               jQuery(d).parent('li').find('select').val('');
               jQuery(d).parent('li').children('label').removeClass('float_label');
               jQuery(d).parent("li").find(".gfield-choice-input").prop("checked", true);
           });
       });
    });
    
</script>
<?php

/**
 * Class UDCShortcode
 * @author Radoslav Zdravkovic BC
 */

 namespace USDynamicCTAs\Frontend;
 use USDynamicCTAs\Services\UDCServices;
 use BetterCollective\WPPlugins\Geolocation\Geolocation;
 use BetterCollective\WPPlugins\Geolocation\GeolocationFactory;

 class UDCShortcode {
   public $countryCode;
   public $a;
   public $getBlur;
   public $ctaHeading;
   public $ctaDescription;
   public $ctaAffiliateLink;
   public $ctaButtonText;
   public $ctaBadgeEnable;
   public $ctaBadgeSmallText;
   public $ctaBadgeBigText;
   public $ctaBonuscode;
   public $ctaBonuscodeBlur;

   // Styles Variables
   public $ctaBonuscodeTextColor;
   public $ctaTopBorderTopColor;
   public $ctaTopBorderBottomColor;
   public $ctaBadgeSidesColor;
   public $ctaBadgeCentralColor;
   public $ctaButtonTopColor;
   public $ctaButtonCentralColor;
   public $ctaButtonBottomColor;
   public $ctaBonuscodeBlurClass;
   public $ctaBonuscodeEmptyClass;

   public function __construct() {
     add_shortcode( 'cta_shortcode', array($this, 'ctaShortcodeFunction') );
     add_action( 'wp_enqueue_scripts', array($this, 'usDynamicCtasCssAndJsLoad') );

     $this->getBlur = isset($_GET['blur']) ? $_GET['blur'] : null;
   }

   public function ctaShortcodeFunction( $atts ){
     $this->a = shortcode_atts( array(
  		 'bookmaker' => '',
  	 ), $atts );

     $this->getShortcodeAttributes();

     $ctaTemplate='<div class="container dynamic-cta-block">';
     $ctaTemplate.='<style>';
     $ctaTemplate.='.dynamic-cta-block .copy-code-container .bonuscode-container .bonuscode {color:' . $this->ctaBonuscodeTextColor . ';}';
     $ctaTemplate.='.dynamic-cta-block .top-border {background: linear-gradient(' . $this->ctaTopBorderTopColor . ',' . $this->ctaTopBorderBottomColor .');}';
     $ctaTemplate.='.dynamic-cta-block .fb-top .fb-badge {background: linear-gradient(90deg,' . $this->ctaBadgeSidesColor . ',' . $this->ctaBadgeCentralColor .',' . $this->ctaBadgeSidesColor .');}';
     $ctaTemplate.='.dynamic-cta-block a.bc1 {background: linear-gradient(' . $this->ctaButtonTopColor . ' 1%,' . $this->ctaButtonCentralColor . ' 20%,' . $this->ctaButtonBottomColor .'); border: 1px solid ' . $this->ctaButtonBottomColor .';}';
     $ctaTemplate.='.dynamic-cta-block a.bc1:hover {background: linear-gradient(' . $this->ctaButtonBottomColor . ' 1%,' . $this->ctaButtonCentralColor . ' 80%,' . $this->ctaButtonTopColor .');}';
     $ctaTemplate.= '.dynamic-cta-block .copy-code-container .bonuscode-container p.blured {color: transparent; text-shadow: 0 0 13px ' . $this->ctaButtonBottomColor . ';}';
       $ctaTemplate.='.dynamic-cta-block a.bc1.copied {background: linear-gradient(' . $this->ctaBadgeCentralColor . ' 1%,' . $this->ctaBadgeSidesColor . ' 20%,' . $this->ctaTopBorderBottomColor .'); border: 1px solid ' . $this->ctaTopBorderTopColor .';}';
     $ctaTemplate.='</style>';
     $ctaTemplate.='<div class="top-border"></div>';
     $ctaTemplate.='<div class="fb-top">';
     $ctaTemplate.='<h4 class="dynamic-cta-block-heading">' . $this->ctaHeading . '</h4>';
     if($this->ctaBadgeEnable) {
         $ctaTemplate.='<div class="fb-badge">';
         $ctaTemplate.='<p class="small-text">' . $this->ctaBadgeSmallText . '</p>';
         $ctaTemplate.='<p class="big-text">' . $this->ctaBadgeBigText . '</p>';
         $ctaTemplate.='</div>';
     }
     $ctaTemplate.='</div>';
     $ctaTemplate.='<p class="dynamic-cta-block-description">' . $this->ctaDescription . '</p>';
     $ctaTemplate.='<div class="copy-code-container" bookmaker="' . $this->a['bookmaker'] . '">';
       if($this->ctaAffiliateLink && $this->ctaBonuscode) {
           $ctaTemplate.='<div class="bonuscode-container">';
           if($this->ctaBonuscodeBlur) {
               $ctaTemplate.='<p class="bonuscode blured">' . $this->ctaBonuscode . '</p>';
           } else {
               $ctaTemplate.='<p class="bonuscode">' . $this->ctaBonuscode . '</p>';
           }
           $ctaTemplate.='</div>';
           $ctaTemplate.='<a class="btn btn-md bgc1 bgc1ah bc1 bc1ah  btn- btn-none copy-bonus-code" href="' . $this->ctaAffiliateLink . '" rel="nofollow">';
           $ctaTemplate.='<span class="btn-inner">' . $this->ctaButtonText . '</span>';
           $ctaTemplate.='</a>';
       } elseif($this->ctaAffiliateLink) {
           $ctaTemplate.='<a class="btn btn-md bgc1 bgc1ah bc1 bc1ah  btn- btn-none no-bonuscode-button" href="' . $this->ctaAffiliateLink . '" rel="nofollow">';
           $ctaTemplate.='<span class="btn-inner">' . $this->ctaButtonText . '</span>';
           $ctaTemplate.='</a>';
       } elseif ($this->ctaBonuscode) {
           $ctaTemplate.='<div class="bonuscode-container">';
           if($this->ctaBonuscodeBlur) {
               $ctaTemplate.='<p class="bonuscode blured">' . $this->ctaBonuscode . '</p>';
           } else {
               $ctaTemplate.='<p class="bonuscode">' . $this->ctaBonuscode . '</p>';
           }
           $ctaTemplate.='</div>';
           $ctaTemplate.='<a class="btn btn-md bgc1 bgc1ah bc1 bc1ah  btn- btn-none copy-bonus-code just-copy" rel="nofollow">';
           $ctaTemplate.='<span class="btn-inner">Copy Code</span>';
           $ctaTemplate.='</a>';
       }
     $ctaTemplate.='</div>';
     $ctaTemplate.='</div>';

     return $ctaTemplate;

   }

   public function getRegionCode(Geolocation $geoLoc) {
       $countryService = new UDCServices($geoLoc);
       $this->countryCode = $countryService->getCountry();

       return $this->countryCode;
   }

   public function getShortcodeAttributes() {
       $statesArray = [];

       include 'settings/shortcode-settings.php';

       foreach ($ctaShortcodes as $ctaShortcode) {
           if($this->a['bookmaker'] === $ctaShortcode['bookmaker_name']) {
               for ($i = 0; $i < count($ctaShortcode['cta_info']); $i++) {
                   array_push($statesArray, $ctaShortcode['cta_info'][$i]['state']);
               }


               if (in_array($this->getRegionCode(GeolocationFactory::makeService()), $statesArray)) {
                   for ($i = 0; $i < count($ctaShortcode['cta_info']); $i++) {
                       if ($ctaShortcode['cta_info'][$i]['state'] == $this->getRegionCode(GeolocationFactory::makeService())) {
                            $this->setVariables($i, $ctaShortcode, $ctaShortcodesColorSettings);
                       }
                   }
               } else {
                   for ($i = 0; $i < count($ctaShortcode['cta_info']); $i++) {
                       if ($ctaShortcode['cta_info'][$i]['make_it_default_info']) {
                           $this->setVariables($i, $ctaShortcode, $ctaShortcodesColorSettings);
                       }
                   }
               }
           }
       }
   }

     private function setVariables($i, $ctaShortcode, $ctaShortcodesColorSettings) {
         $this->ctaHeading = $ctaShortcode['cta_info'][$i]['heading'];
         $this->ctaDescription = $ctaShortcode['cta_info'][$i]['description'];
         $this->ctaAffiliateLink = $ctaShortcode['cta_info'][$i]['bonus_button']['affiliate_link'];
         $this->ctaButtonText = $ctaShortcode['cta_info'][$i]['bonus_button']['button_text'];
         $this->ctaBonuscode = $ctaShortcode['cta_info'][$i]['bonus_button']['bonuscode'];
         $this->ctaBonuscodeBlur = $ctaShortcode['cta_info'][$i]['bonus_button']['blur_bonuscode'];
         $this->ctaBadgeEnable = $ctaShortcode['cta_info'][$i]['badge']['enable'];
         $this->ctaBadgeSmallText = $ctaShortcode['cta_info'][$i]['badge']['small_text'];
         $this->ctaBadgeBigText = $ctaShortcode['cta_info'][$i]['badge']['big_text'];

         // Styles Variables Setting
         $this->ctaBonuscodeTextColor = $ctaShortcodesColorSettings['bonuscode_text_color'];
         $this->ctaTopBorderTopColor = $ctaShortcodesColorSettings['border_top_gradient']['top_color'];
         $this->ctaTopBorderBottomColor = $ctaShortcodesColorSettings['border_top_gradient']['bottom_color'];
         $this->ctaBadgeSidesColor = $ctaShortcodesColorSettings['badge_gradient']['sides_color'];
         $this->ctaBadgeCentralColor = $ctaShortcodesColorSettings['badge_gradient']['central_color'];
         $this->ctaButtonTopColor = $ctaShortcodesColorSettings['button_gradient']['top_color'];
         $this->ctaButtonCentralColor = $ctaShortcodesColorSettings['button_gradient']['central_color'];
         $this->ctaButtonBottomColor = $ctaShortcodesColorSettings['button_gradient']['bottom_color'];
     }

     public function usDynamicCtasCssAndJsLoad() {
         wp_register_style('us_dynamic_ctas_styles', plugins_url('assets/dist/us-dynamic-ctas.css', __FILE__));
         wp_enqueue_style('us_dynamic_ctas_styles');

         wp_register_script('us_dynamic_ctas_js', plugins_url('assets/dist/us-dynamic-ctas.js', __FILE__), array('jquery'), true);
         wp_enqueue_script('us_dynamic_ctas_js');

         if($this->getBlur === 'remove') {
             wp_register_script('remove-blur', plugins_url('assets/dist/remove-blur.js', __FILE__), array('jquery'), true);
             wp_enqueue_script('remove-blur');
         }
     }
 }

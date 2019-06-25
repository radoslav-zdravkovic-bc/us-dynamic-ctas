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
   public $ctaBookmakerLogo;
   public $ctaBullet1;
   public $ctaBullet2;
   public $ctaBullet3;
   public $ctaAffiliateLink;
   public $ctaButtonText;
   public $ctaBadgeEnable;
   public $ctaBadgeSmallText;
   public $ctaBadgeBigText;
   public $ctaBonuscode;
   public $ctaBonuscodeBlur;

   // Styles Variables
   public $ctaBonuscodeTextColor;
   public $ctaTopBorderColor;
   public $ctaBackgroundColor;
   public $ctaBadgeColor;
   public $ctaBadgeBackgroundColor;
   public $ctaButtonRightColor;
   public $ctaButtonLeftColor;
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
     $ctaTemplate.='.dynamic-cta-block {background:' . $this->ctaBackgroundColor . ';}';
     $ctaTemplate.='.dynamic-cta-block .copy-code-container .bonuscode-container .bonuscode {color:' . $this->ctaBonuscodeTextColor . ';}';
     $ctaTemplate.='.dynamic-cta-block p.bullet:before {color:' . $this->ctaButtonRightColor . ';}';
     $ctaTemplate.='.dynamic-cta-block .top-border {background:' . $this->ctaTopBorderColor . ';}';
     $ctaTemplate.='.dynamic-cta-block .fb-top .fb-badge {color:' . $this->ctaBadgeColor . '; background: ' . $this->ctaBadgeBackgroundColor . ';}';
     $ctaTemplate.='.dynamic-cta-block a.bc1 {background: linear-gradient(90deg, '. $this->ctaButtonLeftColor . ',' . $this->ctaButtonRightColor .');}';
     $ctaTemplate.='.dynamic-cta-block a.bc1:hover {background: linear-gradient(90deg,' . $this->ctaButtonRightColor . ' 0%,' . $this->ctaButtonLeftColor . ' 100%);}';
     $ctaTemplate.= '.dynamic-cta-block .copy-code-container .bonuscode-container p.blured {color: transparent; text-shadow: 0 0 13px ' . $this->ctaButtonRightColor . ';}';
     $ctaTemplate.='</style>';
     $ctaTemplate.='<div class="top-border"></div>';
     $ctaTemplate.='<div class="fb-top">';
     $ctaTemplate.='<img src="' . $this->ctaBookmakerLogo["url"] . '">';
     $ctaTemplate.='<h4 class="dynamic-cta-block-heading">' . $this->ctaHeading . '</h4>';
     if($this->ctaBadgeEnable) {
         $ctaTemplate.='<div class="fb-badge">';
         $ctaTemplate.='<div class="ribbon-before"></div>';
         $ctaTemplate.='<div class="ribbon-after"></div>';
         $ctaTemplate.='<p class="small-text">' . $this->ctaBadgeSmallText . '</p>';
         $ctaTemplate.='<p class="big-text">' . $this->ctaBadgeBigText . '</p>';
         $ctaTemplate.='</div>';
     }
     $ctaTemplate.='</div>';
     $ctaTemplate.='<div class="bullets-container">';
     if($this->ctaBullet1) {
         $ctaTemplate .= '<p class="bullet">' . $this->ctaBullet1 . '</p>';
     }
     if($this->ctaBullet2) {
         $ctaTemplate .= '<p class="bullet">' . $this->ctaBullet2 . '</p>';
     }
     if($this->ctaBullet3) {
         $ctaTemplate .= '<p class="bullet">' . $this->ctaBullet3 . '</p>';
     }
     $ctaTemplate.='</div>';
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
       $ctaTemplate.='<p class="dynamic-cta-block-description">' . $this->ctaDescription . '</p>';
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
           if($this->a['bookmaker'] === $ctaShortcode['bookmaker_info']['bookmaker_name']) {
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
         $this->ctaBookmakerLogo = $ctaShortcode['bookmaker_info']['bookmaker_logo'];
         $this->ctaBullet1 = $ctaShortcode['cta_info'][$i]['bullets']['bullet_1'];
         $this->ctaBullet2 = $ctaShortcode['cta_info'][$i]['bullets']['bullet_2'];
         $this->ctaBullet3 = $ctaShortcode['cta_info'][$i]['bullets']['bullet_3'];
         $this->ctaAffiliateLink = $ctaShortcode['cta_info'][$i]['bonus_button']['affiliate_link'];
         $this->ctaButtonText = $ctaShortcode['cta_info'][$i]['bonus_button']['button_text'];
         $this->ctaBonuscode = $ctaShortcode['cta_info'][$i]['bonus_button']['bonuscode'];
         $this->ctaBonuscodeBlur = $ctaShortcode['cta_info'][$i]['bonus_button']['blur_bonuscode'];
         $this->ctaBadgeEnable = $ctaShortcode['cta_info'][$i]['badge']['enable'];
         $this->ctaBadgeSmallText = $ctaShortcode['cta_info'][$i]['badge']['small_text'];
         $this->ctaBadgeBigText = $ctaShortcode['cta_info'][$i]['badge']['big_text'];

         // Styles Variables Setting
         $this->ctaBonuscodeTextColor = $ctaShortcodesColorSettings['bonuscode_text_color'];
         $this->ctaTopBorderColor = $ctaShortcodesColorSettings['border_top_color'];
         $this->ctaBackgroundColor = $ctaShortcodesColorSettings['background_color'];
         $this->ctaBadgeBackgroundColor = $ctaShortcodesColorSettings['badge_color']['background_color'];
         $this->ctaBadgeColor = $ctaShortcodesColorSettings['badge_color']['color'];
         $this->ctaButtonLeftColor = $ctaShortcodesColorSettings['button_gradient']['left_color'];
         $this->ctaButtonRightColor = $ctaShortcodesColorSettings['button_gradient']['right_color'];
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

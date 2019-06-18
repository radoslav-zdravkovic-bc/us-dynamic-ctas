<?php
namespace USDynamicCTAs;
use USDynamicCTAs\Admin\UDCAdmin;
use USDynamicCTAs\Frontend\UDCShortcode;

class UDCInit {
  public $countryCode;

  public function __construct() {
    $this->init();
  }

  private function init() {
    new UDCShortcode();
    new UDCAdmin();
  }
}

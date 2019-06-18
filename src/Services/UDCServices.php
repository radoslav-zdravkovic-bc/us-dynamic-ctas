<?php

namespace USDynamicCTAs\Services;

class UDCServices {

  public $countryRegion;

  public function __construct($bcApiService) {
    $this->countryRegion = $bcApiService->getCountryFromIp()->getRegion();
  }

  public function getCountry() {
    return $this->countryRegion;
  }
}

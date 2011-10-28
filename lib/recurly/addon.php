<?php

class Recurly_Addon extends Recurly_Resource
{
  protected static $_writeableAttributes;
  protected static $_nestedAttributes;

  function __construct() {
    $this->unit_amount_in_cents = new Recurly_CurrencyList('unit_amount_in_cents');
  }

  public static function init()
  {
    Recurly_Addon::$_writeableAttributes = array(
      'add_on_code','name','display_quantity','default_quantity','unit_amount_in_cents'
    );
    Recurly_Addon::$_nestedAttributes = array();
  }

  public static function get($planCode, $addonCode) {
    return Recurly_Base::_get(Recurly_Addon::uriForAddOn($planCode, $addonCode));
  }

  public function create() {
    $this->_save(Recurly_Client::POST, Recurly_Client::PATH_PLANS . '/' . urlencode($this->plan_code) . Recurly_Client::PATH_ADDONS);
  }

  public function delete() {
    return Recurly_Resource::_delete($this->uri());
  }

  protected function uri() {
    if (!empty($this->_href))
      return $this->getHref();
    else
      return Recurly_Addon::uriForAddOn($this->plan_code, $this->add_on_code);
  }
  protected static function uriForAddOn($planCode, $addonCode) {
    return (Recurly_Client::PATH_PLANS . '/' . urlencode($planCode) . 
            Recurly_Client::PATH_ADDONS . '/' . urlencode($addonCode));
  }

  protected function getNodeName() {
    return 'add_on';
  }
  protected function getWriteableAttributes() {
    return Recurly_Addon::$_writeableAttributes;
  }
}

Recurly_Addon::init();

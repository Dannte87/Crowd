<?php


class Cf_VirtualProduct_Model_OnShipping extends Mage_Core_Controller_Front_Action
{
  public function updateShipping(Varien_Event_Observer $observer) {
    Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('checkout/onepage/'));
    Mage::app()->getResponse()->sendResponse();
    exit;
  }
}

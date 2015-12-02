<?php


class Cf_VirtualProduct_Model_UpdatePrice extends Mage_Core_Controller_Front_Action
{
  public function updatePrice(Varien_Event_Observer $observer) {
//    $price = (float)Mage::app()->getRequest()->getPost('pay_value');
//
//    if (!$price) {
//      return null;
//    }

    $e = $observer->getEvent();
    var_dump($_POST);
    die();
//    $quoteItem = $observer->getEvent()->getQuoteItem();
//    $quoteItem->setOriginalCustomPrice($price);
//    $quoteItem->save();
  }
}

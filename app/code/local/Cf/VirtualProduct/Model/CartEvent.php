<?php


class Cf_VirtualProduct_Model_CartEvent extends Mage_Core_Controller_Front_Action
{
  public function addtocartEvent(Varien_Event_Observer $observer) {
    $cart = Mage::app()->getRequest()->getPost('cart');

    if (!empty($cart)) {
      $moneyValue = array();

      foreach ($cart as $k => $v) {
        $moneyValue[$k] = $v['money_value'];
      }

      $session = Mage::getSingleton('checkout/session');
      $session->setData('money_value', $moneyValue);

      Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('checkout/onepage/'));
      Mage::app()->getResponse()->sendResponse();

      exit;
    }
  }
}

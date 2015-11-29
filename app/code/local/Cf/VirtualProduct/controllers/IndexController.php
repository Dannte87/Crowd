<?php

class Cf_VirtualProduct_IndexController extends Mage_Core_Controller_Front_Action
{


  public function indexAction()
  {
    if(!Mage::getSingleton('customer/session')->isLoggedIn()) {
      Mage::app()->getResponse()->setRedirect(Mage::getBaseUrl());
    }

    $cat = Mage::helper('virtualproduct/Categories')->categoriesList();

    $this->loadLayout();
    $this->renderLayout();
  }

  public function addAction()
  {
    $post = $this->getRequest()->getPost();

    //TODO :: add validation and redirect
    if (!$post || empty($post)) {
      return null;
    }

    $product = new Mage_Catalog_Model_Product();
    $product->setAttributeSetId(4);// #4 is for default
    $product->setTypeId('virtual');

    $product->setName($post['idea']['name']);
    $product->setDescription($post['idea']['description']);
    $product->setShortDescription($post['idea']['shortDescription']);
    $product->setSku(time());
    $product->setWeight(4.0000);
    $product->setStatus(1);
    $product->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH);//4

    $product->setPrice(1);// # Set some price
    $product->setTaxClassId(0);// # default tax class

    $product->setStockData(array(
      'is_in_stock' => 1,
      'qty' => time()
    ));

    $product->setCategoryIds(array(4));// # some cat id's,
    $product->setWebsiteIDs(array(1));// # Website id, 1 is default

    $product->setCreatedAt(strtotime('now'));

    try {
      $product->save();
      echo "Product Created";
    }
    catch (Exception $ex) {
      //Handle the error
      echo "Product Creation Failed";
    }

    $this->loadLayout();
    $this->renderLayout();
  }
}
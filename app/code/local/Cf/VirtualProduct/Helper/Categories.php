<?php


class Cf_VirtualProduct_Helper_Categories extends Mage_Core_Helper_Abstract
{
  /**
  * array $categoryList
  * list categories of products
  */
  private $categoryItems = array();
  private $categoryData = array();

  /**
  * return array
  */
  public function categoriesList()
  {
    $rootCategoryId = Mage::app()->getStore()->getRootCategoryId();
    $rootCategory = Mage::getModel('catalog/category')->load($rootCategoryId);

    $this->getCategories($rootCategory);

    return $this->categoryItems;
  }

  protected function getCategories($category, $withSubcategories = false)
  {
    $children = $category->getChildrenCategories();

    foreach ($children as $cat) {
      $this->categoryItems[$cat->getId()] = $cat->getName();

      if($withSubcategories) {
        $this->getCategories($cat, true);
      }
    }
  }

  public function getStatisticData()
  {
    $rootCategoryId = Mage::app()->getStore()->getRootCategoryId();
    $rootCategory = Mage::getModel('catalog/category')->load($rootCategoryId);

    $this->buildStatisticData($rootCategory);

    return $this->categoryData;
  }

  protected function buildStatisticData($category, $withSubcategories = false)
  {
    $numberProducts = Mage::getModel('catalog/product')->getCollection()->getSize();
    $children = $category->getChildrenCategories();

    foreach ($children as $cat) {
      $percentage = $cat->getProductCount() / $numberProducts * 100;

      $this->categoryData[$cat->getId()] = array(
        'name' => $cat->getName(),
        'count' => round($percentage, 2),
        'type' => $this->getTypeProgressBar($percentage)
      );

      if($withSubcategories) {
        $this->buildStatisticData($cat, true);
      }
    }
  }

  protected function getTypeProgressBar($percentage)
  {
    if ($percentage < 20) {
      return 'progress-bar-info';
    }

    if ($percentage >= 20 && $percentage < 40) {
      return 'progress-bar-success';
    }

    if ($percentage >= 40 && $percentage < 60) {
      return 'progress-bar-warning';
    }

    if ($percentage >= 60) {
      return 'progress-bar-danger';
    }
  }

  public function getTopProducts() {
    $attributes = Mage::getSingleton('catalog/config')->getProductAttributes('*');
    $productsCollection = Mage::getResourceModel('catalog/product_collection');
    $productsCollection->addAttributeToSelect($attributes);
    $productsCollection->getSelect()->order('rand()');
    $productsCollection->getSelect()->limit(6);
    $productsCollection->load();

    $productData = array();
    $productMediaConfig = Mage::getModel('catalog/product_media_config');

    foreach ($productsCollection as $k => $v) {
      $image = $v->getThumbnail() == 'no_selection' ? $v->getImageUrl()
               : $productMediaConfig->getMediaUrl($v->getThumbnail());
      $productData[] = array(
        'name' => $v->getName(),
        'image' => $image,
        'shortDescription' => $v->getShortDescription(),
        'link' => $v->getProductUrl(),
      );
    }

    return $productData;
  }
}
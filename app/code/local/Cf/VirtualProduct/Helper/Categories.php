<?php


class Cf_VirtualProduct_Helper_Categories extends Mage_Core_Helper_Abstract
{
  /**
  * array $categoryList
  * list categories of products
  */
  private $categoryItems = array();


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
}
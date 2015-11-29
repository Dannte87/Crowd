<?php


class Cf_VirtualProduct_Helper_ProjectsList extends Mage_Core_Helper_Abstract
{
  public function getProjectList($category)
  {
    $projectsList = array();
    $collection   = Mage::getSingleton('catalog/category')->load($category)
                  ->getProductCollection()
                  ->addAttributeToSelect('*');

    if (!$collection) {
      return $projectsList;
    }

    $productMediaConfig = Mage::getModel('catalog/product_media_config');

    foreach ($collection as $project) {
      $image = $project->getThumbnail() == 'no_selection' ? $project->getImageUrl()
                                                          : $productMediaConfig->getMediaUrl($project->getThumbnail());
      $projectsList[] = array(
        'name' => $project->getName(),
        'shortDescription' => $project->getShortDescription(),
        'image' => $image,
        'link' => $project->getProductUrl()
      );
    }

    return $projectsList;
  }
}
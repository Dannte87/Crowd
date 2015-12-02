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
      $description = $project->getShortDescription();

      if (strlen($description) > 220) {
        $description = substr($description, 0, 250);
      }
      $projectsList[] = array(
        'name' => $project->getName(),
        'shortDescription' => $description,
        'image' => $image,
        'link' => $project->getProductUrl()
      );
    }

    return $projectsList;
  }
}
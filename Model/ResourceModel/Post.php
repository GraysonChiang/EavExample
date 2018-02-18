<?php

namespace Grayson\Post\Model\ResourceModel;

use Magento\Catalog\Model\ResourceModel\AbstractResource;

/**
 * Class Post
 * @package Grayson\Post\Model\ResourceModel
 */
class Post extends AbstractResource
{
    /**
     *
     * @return \Magento\Eav\Model\Entity\Type
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getEntityType()
    {
        if (empty($this->_type)) {

            $this->setType(\Grayson\Post\Model\Post::ENTITY);

        }
        
        return parent::getEntityType();
    }
}
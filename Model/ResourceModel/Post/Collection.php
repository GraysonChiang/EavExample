<?php

namespace Grayson\Post\Model\ResourceModel\Post;

use Grayson\Post\Model\Post;
use Grayson\Post\Model\ResourceModel\Post as ResourceModelPost;
use Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Grayson\Post\Model\ResourceModel\Post
 */
class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(Post::class, ResourceModelPost::class);
    }
}


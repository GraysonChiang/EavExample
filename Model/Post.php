<?php

namespace Grayson\Post\Model;

use Magento\Catalog\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Class Post
 * @package Grayson\Post\Model
 */
class Post extends AbstractModel implements IdentityInterface
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY = 'grayson_post';

    const CACHE_TAG = 'grayson_post';

    const STORE_ID = 'store_id';

    /* @var string */
    protected $_eventPrefix = 'grayson_post';

    /* @var string */
    protected $_eventObject = 'post';

    /* @var string */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Post::class);
    }

    /**
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}

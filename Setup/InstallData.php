<?php

namespace Grayson\Post\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Class InstallData
 * @package Grayson\Post\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * Post setup factory
     *
     * @var PostSetupFactory
     */
    private $postSetupFactory;

    /**
     * @param PostSetupFactory $postSetupFactory
     */
    public function __construct(PostSetupFactory $postSetupFactory)
    {
        $this->postSetupFactory = $postSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var \Magento\Catalog\Setup\BrandSetup $brandSetup */
        $brandSetup = $this->postSetupFactory
            ->create(
                [
                    'setup' => $setup
                ]
            );

        $brandSetup->installEntities();
    }
}

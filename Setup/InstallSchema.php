<?php

namespace Grayson\Post\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @package Grayson\Post\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    const POST_ENTITY = 'post_entity';

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $this->addEntityTable($installer, self::POST_ENTITY);
        $this->addDatetimeTable($installer, self::POST_ENTITY);
        $this->addDecimalTable($installer, self::POST_ENTITY);
        $this->addIntTable($installer, self::POST_ENTITY);
        $this->addTextTable($installer, self::POST_ENTITY);
        $this->addVarcharTable($installer, self::POST_ENTITY);

    }

    /**
     * @param SchemaSetupInterface $setup
     * @param string $entity
     * @return InstallSchema
     * @throws \Zend_Db_Exception
     */
    private function addEntityTable(SchemaSetupInterface $setup, string $entity): InstallSchemaInterface
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable($entity))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Entity ID'
            )->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT
                ],
                'Creation Time'
            )->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT_UPDATE
                ],
                'Update Time'
            );

        $setup->getConnection()->createTable($table);

        return $this;

    }


    /**
     * @param SchemaSetupInterface $setup
     * @param $entity
     * @return InstallSchema
     * @throws \Zend_Db_Exception
     */
    private function addVarcharTable(SchemaSetupInterface $setup, $entity): InstallSchemaInterface
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable($entity . '_varchar'))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Value ID'
            )->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                [
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0'
                ],
                'Attribute Id'
            )->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                [
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0'
                ],
                'Store ID'
            )->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0'
                ],
                'Entity Id'
            )->addColumn(
                'value',
                Table::TYPE_TEXT,
                256,
                [],
                'value'
            )->addIndex(
                $setup->getIdxName($entity . '_varchar',
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )->addIndex(
                $setup->getIdxName($entity . '_varchar',
                    ['store_id']),
                ['store_id']
            )->addIndex(
                $setup->getIdxName($entity . '_varchar',
                    ['attribute_id']),
                ['attribute_id']
            )->addForeignKey(
                $setup->getFkName(
                    $entity . '_varchar',
                    'attribute_id',
                    'eav_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $setup->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $setup->getFkName(
                    $entity . '_varchar',
                    'entity_id',
                    $entity,
                    'entity_id'
                ),
                'entity_id',
                $setup->getTable($entity),
                'entity_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $setup->getFkName(
                    $entity . '_varchar', 'store_id', 'store', 'store_id'
                ),
                'store_id',
                $setup->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            );
        $setup->getConnection()->createTable($table);

        return $this;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param $entity
     * @return InstallSchema
     * @throws \Zend_Db_Exception
     */
    private function addIntTable(SchemaSetupInterface $setup, $entity): InstallSchemaInterface
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable($entity . '_int'))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Value ID'
            )->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Attribute Id'
            )->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Entity Id'
            )->addColumn(
                'value',
                Table::TYPE_INTEGER,
                null,
                [],
                'value'
            )->addIndex(
                $setup->getIdxName($entity . '_int',
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )->addIndex(
                $setup->getIdxName($entity . '_int',
                    ['store_id']),
                ['store_id']
            )->addIndex(
                $setup->getIdxName($entity . '_int',
                    ['attribute_id']),
                ['attribute_id']
            )->addForeignKey(
                $setup->getFkName(
                    $entity . '_int',
                    'attribute_id',
                    'eav_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $setup->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $setup->getFkName(
                    $entity . '_int',
                    'entity_id',
                    $entity,
                    'entity_id'
                ),
                'entity_id',
                $setup->getTable($entity),
                'entity_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $setup->getFkName(
                    $entity . '_int', 'store_id', 'store', 'store_id'
                ),
                'store_id',
                $setup->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            );
        $setup->getConnection()->createTable($table);

        return $this;
    }


    /**
     * @param SchemaSetupInterface $setup
     * @param string $entity
     * @return InstallSchema
     * @throws \Zend_Db_Exception
     */
    private function addTextTable(SchemaSetupInterface $setup, string $entity): InstallSchemaInterface
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable($entity . '_text'))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Value ID'
            )->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Attribute Id'
            )->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Entity Id'
            )->addColumn(
                'value',
                Table::TYPE_TEXT,
                255,
                [],
                'value'
            )->addIndex(
                $setup->getIdxName($entity . '_text',
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )->addIndex(
                $setup->getIdxName($entity . '_text',
                    ['store_id']),
                ['store_id']
            )->addIndex(
                $setup->getIdxName($entity . '_text',
                    ['attribute_id']),
                ['attribute_id']
            )->addForeignKey(
                $setup->getFkName(
                    $entity . '_text',
                    'attribute_id',
                    'eav_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $setup->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $setup->getFkName(
                    $entity . '_text',
                    'entity_id',
                    $entity,
                    'entity_id'
                ),
                'entity_id',
                $setup->getTable($entity),
                'entity_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $setup->getFkName(
                    $entity . '_text', 'store_id', 'store', 'store_id'
                ),
                'store_id',
                $setup->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            );
        $setup->getConnection()->createTable($table);
        return $this;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param string $entity
     * @return InstallSchema
     * @throws \Zend_Db_Exception
     */
    private function addDecimalTable(SchemaSetupInterface $setup, string $entity): InstallSchemaInterface
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable($entity . '_decimal'))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Value ID'
            )->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Attribute Id'
            )->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Entity Id'
            )->addColumn(
                'value',
                Table::TYPE_DECIMAL,
                '12,4',
                [],
                'value'
            )->addIndex(
                $setup->getIdxName($entity . '_decimal',
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )->addIndex(
                $setup->getIdxName($entity . '_decimal',
                    ['store_id']),
                ['store_id']
            )->addIndex(
                $setup->getIdxName($entity . '_decimal',
                    ['attribute_id']),
                ['attribute_id']
            )->addForeignKey(
                $setup->getFkName(
                    $entity . '_decimal',
                    'attribute_id',
                    'eav_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $setup->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $setup->getFkName(
                    $entity . '_decimal',
                    'entity_id',
                    $entity . '_entity',
                    'entity_id'
                ),
                'entity_id',
                $setup->getTable($entity),
                'entity_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $setup->getFkName(
                    $entity . '_decimal', 'store_id', 'store', 'store_id'
                ),
                'store_id',
                $setup->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            );

        $setup->getConnection()->createTable($table);

        return $this;

    }


    /**
     * @param SchemaSetupInterface $setup
     * @param string $entity
     * @return InstallSchema
     * @throws \Zend_Db_Exception
     */
    private function addDatetimeTable(SchemaSetupInterface $setup, string $entity): InstallSchemaInterface
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable($entity . '_datetime')
            )->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Value ID'
            )->addColumn(
                'attribute_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Attribute Id'
            )->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Entity Id'
            )->addColumn(
                'value',
                Table::TYPE_DATETIME,
                null,
                [],
                'value'
            )->addIndex(
                $setup->getIdxName($entity . '_decimal',
                    ['entity_id', 'attribute_id', 'store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )->addIndex(
                $setup->getIdxName($entity . '_datetime',
                    ['store_id']),
                ['store_id']
            )->addIndex(
                $setup->getIdxName($entity . '_datetime',
                    ['attribute_id']),
                ['attribute_id']
            )->addForeignKey(
                $setup->getFkName(
                    $entity . '_datetime',
                    'attribute_id',
                    'eav_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $setup->getTable('eav_attribute'),
                'attribute_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $setup->getFkName(
                    $entity . '_datetime',
                    'entity_id',
                    $entity,
                    'entity_id'
                ),
                'entity_id',
                $setup->getTable($entity),
                'entity_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $setup->getFkName(
                    $entity . '_datetime', 'store_id', 'store', 'store_id'
                ),
                'store_id',
                $setup->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            );
        $setup->getConnection()->createTable($table);

        return $this;
    }


}
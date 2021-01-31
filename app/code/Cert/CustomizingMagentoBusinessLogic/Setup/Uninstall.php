<?php
declare(strict_types=1);

namespace Cert\CustomizingMagentoBusinessLogic\Setup;

use Magento\Eav\Model\Config as EavConfig;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

class Uninstall implements UninstallInterface
{

    private $eavSetupFactory;
    /**
     * @var EavConfig
     */
    private $eavConfig;

    public function __construct(EavSetupFactory $eavSetupFactory, EavConfig $eavConfig)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->removeAttribute('customer', 'interests');
        $setup->endSetup();
    }

}

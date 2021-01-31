<?php

use Cert\CustomizingMagentoBusinessLogic\Setup\InstallData;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\App\Bootstrap;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

require __DIR__ . '/app/bootstrap.php';

$params = $_SERVER;
$bootstrap = Bootstrap::create(BP, $params);
$om = $bootstrap->getObjectManager();
/** @var InstallData $installer */
$installer = $om->get(InstallData::class);
$eavSetupFactory = $om->get(EavSetupFactory::class);
//$config = $om->get(EavConfig::class);
$setup = $om->get(ModuleDataSetupInterface::class);

$eavsetup = $eavSetupFactory->create(['setup' => $setup]);
$eavsetup->removeAttribute('customer', 'interests');

<?php

use Magento\Framework\App\Bootstrap;
use Magento\Eav\Model\Config as EavConfig;

require __DIR__ . '/app/bootstrap.php';

$params = $_SERVER;
$bootstrap = Bootstrap::create(BP, $params);
$om = $bootstrap->getObjectManager();
/** @var EavConfig $eavConfig */
$eavConfig = $om->get(EavConfig::class);
$customAttr = $eavConfig->getAttribute('customer', 'custom_customer_attribute');
$customAttr->setData('is_required', 1);
$customAttr->setData('note', 'Edited Type whatever you want');
$customAttr->getResource()->save($customAttr);

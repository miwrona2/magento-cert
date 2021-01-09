<?php

use Cert\CustomizingMagentoBusinessLogic\Model\Product\Manager;
use Magento\Framework\App\Bootstrap;

require __DIR__ . '/app/bootstrap.php';

$params = $_SERVER;
$bootstrap = Bootstrap::create(BP, $params);
$om = $bootstrap->getObjectManager();
/** @var Manager $manager */
$manager = $om->get(Manager::class);
$productList = $manager->getFirstProductForGivenTypeUsingCollection('simple');
print_r(gettype($productList));

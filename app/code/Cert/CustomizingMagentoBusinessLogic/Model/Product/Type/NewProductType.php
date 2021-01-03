<?php
declare(strict_types=1);

namespace Cert\CustomizingMagentoBusinessLogic\Model\Product\Type;

use Magento\Catalog\Model\Product\Type\AbstractType;

class NewProductType extends AbstractType
{
    public function deleteTypeSpecificData(\Magento\Catalog\Model\Product $product)
    {
    }
}

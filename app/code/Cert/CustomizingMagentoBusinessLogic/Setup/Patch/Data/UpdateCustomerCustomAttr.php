<?php
declare(strict_types=1);

namespace Cert\CustomizingMagentoBusinessLogic\Setup\Patch\Data;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Model\ResourceModel\Attribute;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class UpdateCustomerCustomAttr implements DataPatchInterface
{
    /** @var CustomerSetupFactory */
    private $customerSetupFactory;

    /** @var ModuleDataSetupInterface */
    private $setup;

    /** @var Attribute */
    private $customerAttrResModel;

    /**
     * AddCustomerCustomAttr constructor.
     * @param CustomerSetupFactory $customerSetupFactory
     * @param ModuleDataSetupInterface $setup
     * @param Attribute $customerAttrResModel
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        ModuleDataSetupInterface $setup,
        Attribute $customerAttrResModel
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->setup = $setup;
        $this->customerAttrResModel = $customerAttrResModel;
    }

    public function apply(): void
    {
        /**
         * TODO make const in
         * app/code/Cert/CustomizingMagentoBusinessLogic/Setup/Patch/Data/AddCustomerCustomAttr.php
         * and create dependency here
         */
        $attributeCode = 'custom_customer_attribute';
        $customerSetup = $this->customerSetupFactory->create([$this->setup]);
        $entityTypeId = CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER;
        $attribute = $customerSetup->getEavConfig()->getAttribute($entityTypeId, $attributeCode);
        $customerSetup->updateAttribute($entityTypeId, $attribute->getAttributeId(), 'backend_type', 'text', 1);
//        $customerSetup->updateAttribute($entityTypeId, $attribute->getAttributeId(), 'sort_order', 1000);
        $this->customerAttrResModel->save($attribute);
    }

    public function getAliases(): array
    {
        return [];
    }

    public static function getDependencies(): array
    {
        return [
            AddCustomerCustomAttr::class
        ];
    }
}

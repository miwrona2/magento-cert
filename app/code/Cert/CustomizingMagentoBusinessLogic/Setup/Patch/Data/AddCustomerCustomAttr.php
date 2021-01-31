<?php
declare(strict_types=1);

namespace Cert\CustomizingMagentoBusinessLogic\Setup\Patch\Data;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Model\ResourceModel\Attribute;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class AddCustomerCustomAttr implements DataPatchInterface, PatchRevertableInterface
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
        $attributeCode = 'custom_customer_attribute';
        $customerSetup = $this->customerSetupFactory->create([$this->setup]);
        $entityTypeId = CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER;
        $customerSetup->addAttribute($entityTypeId, $attributeCode, [
            'label' => 'Custom Attribute',
            'required' => 1,
            'user_defined' => 1,
            'note' => 'Type whatever you want',
            'system' => 0,
            'position' => 1,
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute($entityTypeId, $attributeCode);
        $attribute->setData('used_in_forms', [
            'adminhtml_customer',
            'customer_account_create',
            'customer_account_edit'
        ]);

        $attribute->setData('validate_rules', [
            'input_validation' => 1,
            'min_text_length' => 3,
            'max_text_length' => 30,

        ]);
        $this->customerAttrResModel->save($attribute);
    }

    public function revert(): void
    {
        $customerSetup = $this->customerSetupFactory->create([$this->setup]);
        $customerSetup->removeAttribute('customer', 'custom_customer_attribute');
    }

    public function getAliases(): array
    {
        return [];
    }

    public static function getDependencies(): array
    {
        return [];
    }
}

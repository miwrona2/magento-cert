<?php
declare(strict_types=1);

namespace Cert\CustomizingMagentoBusinessLogic\Setup\Patch\Data;

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

    /**
     * AddCustomerCustomAttr constructor.
     * @param CustomerSetupFactory $customerSetupFactory
     * @param ModuleDataSetupInterface $setup
     */
    public function __construct(CustomerSetupFactory $customerSetupFactory, ModuleDataSetupInterface $setup)
    {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->setup = $setup;
    }

    public function apply(): void
    {
        $customerSetup = $this->customerSetupFactory->create([$this->setup]);
        $customerSetup->addAttribute('customer', 'custom_customer_attribute', []);
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

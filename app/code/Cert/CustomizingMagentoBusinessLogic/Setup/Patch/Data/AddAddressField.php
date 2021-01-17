<?php
declare(strict_types=1);

namespace Cert\CustomizingMagentoBusinessLogic\Setup\Patch\Data;

use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\ResourceModel\Config;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class AddAddressField implements DataPatchInterface, PatchRevertableInterface
{
    private const ATTR_CODE = 'intercom_code';

    /** @var CustomerSetupFactory */
    private $customerSetupFactory;

    /** @var ModuleDataSetupInterface */
    private $setup;

    /** @var Config */
    private $resourceModel;

    /**
     * AddAddressField constructor.
     * @param CustomerSetupFactory $customerSetupFactory
     * @param ModuleDataSetupInterface $setup
     * @param Config $resourceModel
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        ModuleDataSetupInterface $setup,
        Config $resourceModel
    ) {

        $this->customerSetupFactory = $customerSetupFactory;
        $this->setup = $setup;
        $this->resourceModel = $resourceModel;
    }

    public function apply(): void
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->setup]);
        $customerSetup->addAttribute('customer_address', self::ATTR_CODE, [
            'label' => 'Intercom Code',
            'input' => 'text',
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'source' => '',
            'required' => false,
            'position' => 90,
            'visible' => true,
            'system' => false,
            'is_used_in_grid' => false,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
            'is_searchable_in_grid' => false,
            'frontend_input' => 'hidden',
            'backend' => ''
        ]);

        $attribute = $customerSetup->getEavConfig()
            ->getAttribute('customer_address', self::ATTR_CODE)
            ->addData(
                [
                    'used_in_forms' => [
                        'adminhtml_customer_address',
                        'adminhtml_customer',
                        'customer_address_edit',
                        'customer_register_address',
                        'customer_address',
                    ]
                ]
            );
        $this->resourceModel->save($attribute);
    }

    public function revert(): void
    {
        $eav = $this->customerSetupFactory->create(['setup' => $this->setup]);
        $eav->removeAttribute('customer_address', self::ATTR_CODE);
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

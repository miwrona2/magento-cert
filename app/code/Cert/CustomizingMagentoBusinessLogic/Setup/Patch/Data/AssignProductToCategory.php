<?php
declare(strict_types=1);

namespace Cert\CustomizingMagentoBusinessLogic\Setup\Patch\Data;

use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Model\CategoryLinkRepository;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class AssignProductToCategory implements DataPatchInterface, PatchRevertableInterface
{
    private const PRODUCTS_SKU = 'michals-bag';
    /** @var CategoryLinkManagementInterface */
    private $linkManagement;

    /** @var CategoryLinkRepository */
    private $categoryLinkRepository;

    /**
     * AssignProductToCategory constructor.
     * @param CategoryLinkManagementInterface $linkManagement
     * @param CategoryLinkRepository $categoryLinkRepository
     */
    public function __construct(
        CategoryLinkManagementInterface $linkManagement,
        CategoryLinkRepository $categoryLinkRepository
    ) {
        $this->linkManagement = $linkManagement;
        $this->categoryLinkRepository = $categoryLinkRepository;
    }


    /** @inheritdoc */
    public static function getDependencies(): array
    {
        return [];
    }

    /** @inheritdoc */
    public function getAliases(): array
    {
        return [];
    }

    /** @inheritdoc */
    public function apply()
    {
        $this->linkManagement->assignProductToCategories(self::PRODUCTS_SKU, [3, 4]);
    }

    /** @inheritdoc */
    public function revert()
    {
        $this->categoryLinkRepository->deleteByIds(3, self::PRODUCTS_SKU);
        $this->categoryLinkRepository->deleteByIds(4, self::PRODUCTS_SKU);
    }

}

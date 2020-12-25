<?php
declare(strict_types=1);

namespace Cert\CustomizingMagentoBusinessLogic\Setup\Patch\Data;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Catalog\Api\Data\CategoryInterfaceFactory;
use Magento\Framework\Registry;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class AddCategory implements DataPatchInterface, PatchRevertableInterface
{
    /** @var CategoryInterfaceFactory */
    private $factory;

    /** @var CategoryRepositoryInterface */
    private $repository;

    /** @var Registry */
    private $registry;

    /**
     * AddCategory constructor.
     * @param CategoryInterfaceFactory $factory
     * @param CategoryRepositoryInterface $repository
     */
    public function __construct(
        CategoryInterfaceFactory $factory,
        CategoryRepositoryInterface $repository,
        Registry $registry
    ) {
        $this->factory = $factory;
        $this->repository = $repository;
        $this->registry = $registry;
    }

    /** @inheridoc */
    public function getAliases(): array
    {
        return [];
    }

    /** @inheridoc */
    public static function getDependencies(): array
    {
        return [];
    }

    /** @inheridoc */
    public function apply(): void
    {
        /** @var CategoryInterface $category */
        $category = $this->factory->create();
        $category->setName("Category added programmatically");
        $category->setIsActive(1);
        $this->repository->save($category);
    }

    /** @inheridoc */
    public function revert(): void
    {
        /** @var CategoryInterface $category */
        $categoryCollection = $this->factory->create()->getCollection();
        $category = $categoryCollection
            ->addFieldToFilter('name', "Category added programmatically")
            ->getFirstItem();
        $this->registry->register('isSecureArea', true);
        $this->repository->delete($category);
    }
}

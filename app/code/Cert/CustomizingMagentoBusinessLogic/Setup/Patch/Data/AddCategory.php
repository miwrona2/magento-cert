<?php
declare(strict_types=1);

namespace Cert\CustomizingMagentoBusinessLogic\Setup\Patch\Data;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Catalog\Api\Data\CategoryInterfaceFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddCategory implements DataPatchInterface
{
    /** @var CategoryInterfaceFactory */
    private $factory;

    /** @var CategoryRepositoryInterface */
    private $repository;

    /**
     * AddCategory constructor.
     * @param CategoryInterfaceFactory $factory
     * @param CategoryRepositoryInterface $repository
     */
    public function __construct(CategoryInterfaceFactory $factory, CategoryRepositoryInterface $repository)
    {
        $this->factory = $factory;
        $this->repository = $repository;
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

}

<?php
declare(strict_types=1);

namespace Cert\CustomizingMagentoBusinessLogic\Model\Product;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class Manager
{
    private $productRepository;
    private $searchCriteriaBuilder;
    private $productCollectionFactory;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        CollectionFactory $collectionFactory
    ) {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->productCollectionFactory = $collectionFactory;
    }

    public function getProductsList(string $type): array
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(ProductInterface::TYPE_ID, $type)
            ->create();
        return $this->productRepository->getList($searchCriteria)->getItems();
    }

    /*
     * This way is not the best, because all products are loading and only after that result is limited to one
     */
    public function getFirstProductForGivenType(string $type): ProductInterface
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(\Magento\Catalog\Api\Data\ProductInterface::TYPE_ID, $type)
            ->create();
        $items = $this->productRepository->getList($searchCriteria)->getItems();
        $arrayKeyFirst = array_key_first($items);
        return $items[$arrayKeyFirst];
    }

    /*
     * This way is better when getting only one product
     */
    public function getFirstProductForGivenTypeUsingCollection(string $type): ProductInterface
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addFilter('type_id', $type);
        return $collection->getFirstItem();
    }
}

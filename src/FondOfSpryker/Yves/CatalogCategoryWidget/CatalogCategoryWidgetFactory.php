<?php

namespace FondOfSpryker\Yves\CatalogCategoryWidget;

use FondOfSpryker\Yves\CatalogCategoryWidget\Dependency\Client\CatalogCategoryWidgetToCatalogCategoryClientInterface;
use FondOfSpryker\Yves\CatalogCategoryWidget\Dependency\Client\CatalogCategoryWidgetToCategoryStoreStorageClientInterface;
use Spryker\Shared\Kernel\Store;
use Spryker\Yves\Kernel\AbstractFactory;

class CatalogCategoryWidgetFactory extends AbstractFactory
{
    /**
     * @return CatalogCategoryWidgetToCategoryStoreStorageClientInterface;
     * @throws
     *
     */
    public function getCategoryStoreStorageClient(): CatalogCategoryWidgetToCategoryStoreStorageClientInterface
    {
        return $this->getProvidedDependency(CatalogCategoryWidgetDependencyProvider::CLIENT_CATEGORY_STORE_STORAGE);
    }

    /**
     * @throws
     *
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getStore(): Store
    {
        return $this->getProvidedDependency(CatalogCategoryWidgetDependencyProvider::STORE);
    }
}

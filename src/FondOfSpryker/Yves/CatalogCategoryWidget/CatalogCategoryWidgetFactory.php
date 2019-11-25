<?php

namespace FondOfSpryker\Yves\CatalogCategoryWidget;

use FondOfSpryker\Yves\CatalogCategoryWidget\Dependency\Client\CatalogPageWidgetToCategoryStoreStorageClientInterface;
use Spryker\Shared\Kernel\Store;
use Spryker\Yves\Kernel\AbstractFactory;

class CatalogCategoryWidgetFactory extends AbstractFactory
{
    /**
     * @throws
     *
     * @return CatalogPageWidgetToCategoryStoreStorageClientInterface;
     */
    public function getCategoryStoreStorageClient(): CatalogPageWidgetToCategoryStoreStorageClientInterface
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

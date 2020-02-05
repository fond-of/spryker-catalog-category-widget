<?php

namespace FondOfSpryker\Yves\CatalogCategoryWidget;

use FondOfSpryker\Yves\CatalogCategoryWidget\Dependency\Client\CatalogCategoryWidgetToCategoryStoreStorageClientBridge;
use Spryker\Shared\Kernel\Store;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class CatalogCategoryWidgetDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_CATEGORY_STORE_STORAGE = 'CLIENT_CATEGORY_STORE_STORAGE';
    public const CLIENT_CATALOG_CATEGORY = 'CLIENT_CATALOG_CATEGORY';
    public const STORE = 'STORE';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container)
    {
        $container = parent::provideDependencies($container);
        $container = $this->addCategoryStoreStorageClient($container);
        $container = $this->addStore($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCategoryStoreStorageClient(Container $container): Container
    {
        $container[static::CLIENT_CATEGORY_STORE_STORAGE] = function (Container $container) {
            return new CatalogCategoryWidgetToCategoryStoreStorageClientBridge(
                $container->getLocator()->categoryStoreStorage()->client()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addStore(Container $container): Container
    {
        $container[static::STORE] = function () {
            return $this->getStore();
        };

        return $container;
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    protected function getStore(): Store
    {
        return Store::getInstance();
    }
}

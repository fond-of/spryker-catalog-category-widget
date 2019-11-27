<?php

namespace FondOfSpryker\Yves\CatalogCategoryWidget\Dependency\Client;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;

interface CatalogCategoryWidgetToCategoryStoreStorageClientInterface
{
    /**
     * @param int $idCategoryStorageNode
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\CategoryNodeStorageTransfer
     */
    public function getCategoryNodeById(int $idCategoryStorageNode, string $localeName): CategoryNodeStorageTransfer;
}

<?php

namespace FondOfSpryker\Yves\CatalogCategoryWidget\Dependency\Client;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Spryker\Client\CategoryStorage\CategoryStorageClientInterface;

class CatalogPageWidgetToCategoryStoreStorageClientBridge implements CatalogPageWidgetToCategoryStoreStorageClientInterface
{
    /**
     * @var \Spryker\Client\CategoryStorage\CategoryStorageClientInterface
     */
    protected $categoryClient;

    /**
     * @param \Spryker\Client\CategoryStorage\CategoryStorageClientInterface $categoryClient
     */
    public function __construct(CategoryStorageClientInterface $categoryClient)
    {
        $this->categoryClient = $categoryClient;
    }

    /**
     * @param int $idCategoryStorageNode
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\CategoryNodeStorageTransfer
     */
    public function getCategoryNodeById(int $idCategoryStorageNode, string $localeName): CategoryNodeStorageTransfer
    {
        return $this->categoryClient->getCategoryNodeById($idCategoryStorageNode, $localeName);
    }
}

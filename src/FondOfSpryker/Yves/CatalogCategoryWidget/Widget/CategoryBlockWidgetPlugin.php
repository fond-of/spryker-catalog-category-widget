<?php

namespace FondOfSpryker\Yves\CatalogCategoryWidget\Widget;

use FondOfSpryker\Yves\CatalogCategoryWidget\Dependency\Plugin\CategoryWidget\CategoryBlockWidgetPluginInterface;
use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidgetPlugin;

/**
 * @method \FondOfSpryker\Yves\CatalogCategoryWidget\CatalogCategoryWidgetFactory getFactory()
 * @method \FondOfSpryker\Client\CatalogCategoryWidget\CatalogCategoryWidgetClientInterface getClient()
 */
class CategoryBlockWidgetPlugin extends AbstractWidgetPlugin implements CategoryBlockWidgetPluginInterface
{
    /**
     * @api
     *
     * @param int $idCategory
     * @param string $locale
     * @param bool $render
     *
     * @return void
     */
    public function initialize(int $idCategory, string $locale, bool $render = true): void
    {
        $categoryNode = $this->getFactory()
            ->getCategoryStoreStorageClient()
            ->getCategoryNodeById($idCategory, $locale);

        if (!$categoryNode) {
            return;
        }

        $storeTransfer = $this->getFactory()->getStore();
        $storeName = explode("_", $storeTransfer->getStoreName())[0];
        $this->addParameter('storename', strtolower($storeName));

        if ($categoryNode->getParents()->count() > 1 || $categoryNode->getParents()->count() === 0) {
            $this->addParameter('categories', []);
            $this->addParameter('parentCategory', $categoryNode);
            $this->addParameter('idCategory', $idCategory);
            $this->addParameter('render', $render);

            return;
        }

        if ($categoryNode->getChildren()->count() > 0) {
            $this->addParameter('categories', $categoryNode->getChildren());
            $this->addParameter('parentCategory', $categoryNode);
            $this->addParameter('idCategory', $idCategory);
            $this->addParameter('render', $render);

            return;
        }

        if ($categoryNode->getChildren()->count() === 0 && $categoryNode->getParents()->count() === 1) {
            $parent = $this->getFullParent($categoryNode, $locale);
            $children = $parent->getChildren();

            foreach ($parent->getChildren() as $child) {
                $a = $child;
            }

            $this->addParameter('categories', $parent->getChildren());
            $this->addParameter('parentCategory', $parent);
            $this->addParameter('idCategory', $idCategory);
            $this->addParameter('render', $render);

            return;
        }
    }

    /**
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer $categoryNodeStorageTransfer
     * @param string $locale
     *
     * @return \Generated\Shared\Transfer\CategoryNodeStorageTransfer
     */
    protected function getFullParent(CategoryNodeStorageTransfer $categoryNodeStorageTransfer, string $locale): CategoryNodeStorageTransfer
    {
        if ($categoryNodeStorageTransfer->getParents()->count() !== 1) {
            return $categoryNodeStorageTransfer;
        }

        /** @var \Generated\Shared\Transfer\CategoryNodeStorageTransfer $parent */
        $parent = $categoryNodeStorageTransfer->getParents()[0];

        return $this->getFactory()
            ->getCategoryStoreStorageClient()
            ->getCategoryNodeById($parent->getNodeId(), $locale);
    }

    /**
     * @return string
     */
    public static function getName()
    {
        return static::NAME;
    }

    /**
     * @return string
     */
    public static function getTemplate()
    {
        return '@CatalogCategoryWidget/views/catalog-category-widget/catalog-category-widget.twig';
    }
}

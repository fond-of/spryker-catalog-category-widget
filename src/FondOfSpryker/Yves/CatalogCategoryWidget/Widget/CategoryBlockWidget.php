<?php

namespace FondOfSpryker\Yves\CatalogCategoryWidget\Widget;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidget;

/**
 * @method \FondOfSpryker\Yves\CatalogCategoryWidget\CatalogCategoryWidgetFactory getFactory()
 */
class CategoryBlockWidget extends AbstractWidget
{
    public const NAME = 'CategoryBlockWidgetPlugin';

    /**
     * @param int $idCategory
     * @param string $locale
     * @param bool $render
     */
    public function __construct(int $idCategory, string $locale, bool $render = true)
    {
        $categoryNode = $this->getFactory()
            ->getCategoryStoreStorageClient()
            ->getCategoryNodeById($idCategory, $locale);

        $this->init($categoryNode, $idCategory, $render, $locale);
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
     * @api
     *
     * @return string
     */
    public static function getName(): string
    {
        return static::NAME;
    }

    /**
     * @return string
     */
    public static function getTemplate(): string
    {
        return '@CatalogCategoryWidget/views/catalog-category-widget/catalog-category-widget.twig';
    }

    /**
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer $categoryNode
     * @param int $idCategory
     * @param bool $render
     * @param string $locale
     *
     * @return void
     */
    protected function init(
        CategoryNodeStorageTransfer $categoryNode,
        int $idCategory,
        bool $render,
        string $locale
    ): void {
        $storeTransfer = $this->getFactory()->getStore();
        $storeName = explode('_', $storeTransfer->getStoreName())[0];
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
}

<?php

namespace FondOfSpryker\Yves\CatalogCategoryWidget\Widget;

use FondOfSpryker\Yves\CatalogCategoryWidget\Dependency\Plugin\CategoryWidget\CategoryBlockWidgetPluginInterface;
use Spryker\Yves\Kernel\Widget\AbstractWidgetPlugin;

/**
 * @method \FondOfSpryker\Yves\CatalogCategoryWidget\CatalogCategoryWidgetFactory getFactory()
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

        if (count($categoryNode->getChildren()) > 0) {
            $this->addParameter('categories', $categoryNode->getChildren());
            $this->addParameter('parentCategory', $categoryNode);
            $this->addParameter('idCategory', $idCategory);
            $this->addParameter('render', $render);

            return;
        }

        if (count($categoryNode->getChildren()) === 0) {
            $this->addParameter('categories', $categoryNode->getParents()[0]->getChildren());
            $this->addParameter('parentCategory', $categoryNode->getParents()[0]);
            $this->addParameter('idCategory', $idCategory);
            $this->addParameter('render', $render);

            return;
        }
    }

    /**
     * Specification:
     * - Returns the name of the widget as it's used in templates.
     *
     * @api
     *
     * @return string
     */
    public static function getName()
    {
        return static::NAME;
    }

    /**
     * Specification:
     * - Returns the the template file path to render the widget.
     *
     * @api
     *
     * @return string
     */
    public static function getTemplate()
    {
        return '@CatalogCategoryWidget/views/catalog-category-widget/catalog-category-widget.twig';
    }
}

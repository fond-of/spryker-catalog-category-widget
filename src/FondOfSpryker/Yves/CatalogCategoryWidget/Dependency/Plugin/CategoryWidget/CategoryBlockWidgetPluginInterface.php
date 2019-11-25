<?php

namespace FondOfSpryker\Yves\CatalogCategoryWidget\Dependency\Plugin\CategoryWidget;

use Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface;

interface CategoryBlockWidgetPluginInterface extends WidgetPluginInterface
{
    public const NAME = 'CategoryBlockWidgetPlugin';

    /**
     * @api
     *
     * @param int $idCategory
     * @param string $locale
     * @param bool $render
     *
     * @return void
     */
    public function initialize(int $idCategory, string $locale, bool $render = true): void;
}

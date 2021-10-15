<?php
namespace Jaimin\Breadcrumb\Block;

use Magento\Catalog\Helper\Data;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\Store;
use Magento\Theme\Block\Html\Breadcrumbs as MagentoBreadcrumbs;

class Breadcrumbs extends MagentoBreadcrumbs
{
    /**
     * Catalog data
     *
     * @var Data
     */
    protected $_catalogData = null;

    /**
     * @param Context $context
     * @param Data $catalogData
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $catalogData,
        Registry $registry,
        array $data = []
    ) {
        $this->_catalogData = $catalogData;
        $this->registry = $registry;
        parent::__construct($context, $data);
    }


    public function getCrumbs()
    {
        return $this->_crumbs;
    }

    /**
     * Preparing layout
     *
     * @return MagentoBreadcrumbs
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    protected function _prepareLayout()
    {
        $title = [];
        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb(
                'home',
                [
                    'label' => __('Home'),
                    'title' => __('Go to Home Page'),
                    'link' => $this->_storeManager->getStore()->getBaseUrl()
                ]
            );
            $path = $this->_catalogData->getBreadcrumbPath();
            $product = $this->registry->registry('current_product');

            if ($product && count($path) == 1) {
                $categoryCollection = clone $product->getCategoryCollection();
                $categoryCollection->clear();
                $categoryCollection->addAttributeToSort('level', $categoryCollection::SORT_ORDER_DESC)->addAttributeToFilter('path', ['like' => "1/" . $this->_storeManager->getStore()->getRootCategoryId() . "/%"]);
                $categoryCollection->setPageSize(1);
                $breadcrumbCategories = $categoryCollection->getFirstItem()->getParentCategories();
                foreach ($breadcrumbCategories as $category) {
                    $catbreadcrumb = ["label" => $category->getName(), "link" => $category->getUrl()];
                    $breadcrumbsBlock->addCrumb("category" . $category->getId(), $catbreadcrumb);
                    $title[] = $category->getName();
                }
            } else {
                foreach ($path as $name => $breadcrumb) {
                    $breadcrumbsBlock->addCrumb($name, $breadcrumb);
                    $title[] = $breadcrumb['label'];
                }
            }
            $this->pageConfig->getTitle()->set(join($this->getTitleSeparator(), array_reverse($title)));

            return parent::_prepareLayout();
        }
        $path = $this->_catalogData->getBreadcrumbPath();

        foreach ($path as $name => $breadcrumb) {
            $title[] = $breadcrumb['label'];
        }
        $this->pageConfig->getTitle()->set(join($this->getTitleSeparator(), array_reverse($title)));

        return parent::_prepareLayout();
    }
}

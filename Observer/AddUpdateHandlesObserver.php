<?php
/**
 * Mavenbird Technologies Private Limited
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://mavenbird.com/Mavenbird-Module-License.txt
 *
 * =================================================================
 *
 * @category   Mavenbird
 * @package    Mavenbird_Quickview
 * @author     Mavenbird Team
 * @copyright  Copyright (c) 2018-2024 Mavenbird Technologies Private Limited ( http://mavenbird.com )
 * @license    http://mavenbird.com/Mavenbird-Module-License.txt
 */
namespace Mavenbird\Quickview\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Request\Http;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Event\Observer;
use Magento\Store\Model\ScopeInterface;

class AddUpdateHandlesObserver implements ObserverInterface
{
    public const XML_PATH_QUICKVIEW_REMOVE_TAB = 'mavenbird_quickview/general/remove_product_tab';
    public const XML_PATH_QUICKVIEW_REMOVE_ADDTO_COMPARE = 'mavenbird_quickview/general/remove_addto_compare';
    public const XML_PATH_QUICKVIEW_REMOVE_ADDTO_WISHLIST = 'mavenbird_quickview/general/remove_addto_wishlist';
    public const XML_PATH_QUICKVIEW_REMOVE_REVIEWS = 'mavenbird_quickview/general/remove_reviews';
    public const XML_PATH_QUICKVIEW_REMOVE_PRODUCT_RELATED = 'mavenbird_quickview/general/remove_product_related';
    public const XML_PATH_QUICKVIEW_REMOVE_PRODUCT_UPSELL = 'mavenbird_quickview/general/remove_product_upsell';
    public const XML_PATH_QUICKVIEW_REMOVE_PRODUCT_INFOR_MAILTO = 'mavenbird_quickview/general/remove_product_info_mailto';
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Http $request,
        StoreManagerInterface $storeManager,
        ProductRepositoryInterface $productRepository
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
    }
    
    /**
     * Add New Layout handle
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(Observer $observer)
    {
        $layout = $observer->getData('layout');
        $fullActionName = $observer->getData('full_action_name');
        
        if ($fullActionName != 'mavenbird_quickview_catalog_product_view') {
            return $this;
        }

        $productId= $this->request->getParam('id');
        if (isset($productId)) {
            try {
                $product = $this->productRepository->getById(
                    $productId,
                    false,
                    $this->storeManager->getStore()->getId()
                );
            } catch (NoSuchEntityException $e) {
                return false;
            }

            $productType = $product->getTypeId();

            $layout->getUpdate()->addHandle('mavenbird_quickview_catalog_product_view_type_' . $productType);
        }
        $this->quickViewRemove($layout);
        return $this;
    }

    /**
     * Quick View Removes
     *
     * @param mixed $layout
     * @return void
     */
    protected function quickViewRemove($layout)
    {
        $removeTab = $this->scopeConfig->getValue(
            self::XML_PATH_QUICKVIEW_REMOVE_TAB,
            ScopeInterface::SCOPE_STORE
        );
        if ($removeTab == 0) {
            $layout->getUpdate()->addHandle('mavenbird_quickview_removeproduct_tab');
        }
        $removeAddToCompare = $this->scopeConfig->getValue(
            self::XML_PATH_QUICKVIEW_REMOVE_ADDTO_COMPARE,
            ScopeInterface::SCOPE_STORE
        );
        if ($removeAddToCompare == 0) {
            $layout->getUpdate()->addHandle('mavenbird_quickview_remove_addtocompare');
        }
        $removeAddToWishList = $this->scopeConfig->getValue(
            self::XML_PATH_QUICKVIEW_REMOVE_ADDTO_WISHLIST,
            ScopeInterface::SCOPE_STORE
        );
        if ($removeAddToWishList == 0) {
            $layout->getUpdate()->addHandle('mavenbird_quickview_remove_addtowishlist');
        }
        $removeReviews = $this->scopeConfig->getValue(
            self::XML_PATH_QUICKVIEW_REMOVE_REVIEWS,
            ScopeInterface::SCOPE_STORE
        );
        if ($removeReviews == 0) {
            $layout->getUpdate()->addHandle('mavenbird_quickview_remove_reviews');
        }
        $removeProductRelated = $this->scopeConfig->getValue(
            self::XML_PATH_QUICKVIEW_REMOVE_PRODUCT_RELATED,
            ScopeInterface::SCOPE_STORE
        );
        if ($removeProductRelated == 0) {
            $layout->getUpdate()->addHandle('mavenbird_quickview_remove_product_related');
        }
        $removeProductUpsell = $this->scopeConfig->getValue(
            self::XML_PATH_QUICKVIEW_REMOVE_PRODUCT_UPSELL,
            ScopeInterface::SCOPE_STORE
        );
        if ($removeProductUpsell == 0) {
            $layout->getUpdate()->addHandle('mavenbird_quickview_remove_product_upsell');
        }
        $removeProductInfoMailto = $this->scopeConfig->getValue(
            self::XML_PATH_QUICKVIEW_REMOVE_PRODUCT_INFOR_MAILTO,
            ScopeInterface::SCOPE_STORE
        );
        if ($removeProductInfoMailto == 0) {
            $layout->getUpdate()->addHandle('mavenbird_quickview_remove_product_info_mailto');
        }
    }
}

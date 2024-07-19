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
namespace Mavenbird\Quickview\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

/**
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Data extends AbstractHelper
{
    /**
     * @var $scopeConfig
     */
    protected $scopeConfig;

    /**
     * @var $quickviewOptions
     */
    protected $quickviewOptions;

    /**
     * @var $urlInterface
     */
    protected $urlInterface;

    /**
     * @var $scopeStore
     */
    public $scopeStore = ScopeInterface::SCOPE_STORE;

    /**
     * Data Constructor
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
        $this->scopeConfig = $context->getScopeConfig();
        $this->urlInterface = $context->getUrlBuilder();
    }

    /**
     * Get Btn Text Colors
     *
     * @return mixed
     */
    public function getBtnTextColor()
    {
        $color = $this->scopeConfig->getValue('mavenbird_quickview/success_popup_design/button_text_color', ScopeInterface::SCOPE_STORE);

        $color = ($color == '') ? '' : $color;
        return $color;
    }

    /**
     * Get Btn Backgrounds
     *
     * @return mixed
     */
    public function getBtnBackground()
    {
        $backGround = $this->scopeConfig->getValue('mavenbird_quickview/success_popup_design/background_color', ScopeInterface::SCOPE_STORE);

        $backGround = ($backGround == '') ? '' : $backGround;
        return $backGround;
    }

    /**
     * Get Button Texts
     *
     * @return mixed
     */
    public function getButtonText()
    {
        $buttonText = $this->scopeConfig->getValue('mavenbird_quickview/success_popup_design/button_text', ScopeInterface::SCOPE_STORE);

        $buttonText = ($buttonText == '') ? __('Quick View') : $buttonText;
        return $buttonText;
    }

    /**
     * Enableds
     *
     * @return mixed
     */
    public function enabled()
    {
        $isEnabled = $this->scopeConfig->getValue('mavenbird_quickview/general/enable_product_listing', ScopeInterface::SCOPE_STORE);
        $isEnabled = ($isEnabled == '') ? '' : $isEnabled;
        return $isEnabled;
    }

    /**
     * Get Urls
     *
     * @return mixed
     */
    public function getUrl()
    {
        $productUrl = $this->urlInterface->getUrl('mavenbird_quickview/catalog_product/view/');
        return $productUrl;
    }

    /**
     * Get Base Urls
     *
     * @return mixed
     */
    public function getBaseUrl()
    {
        $baseUrl = $this->urlInterface->getUrl();
        return $baseUrl;
    }

    /**
     * Get Remove Reviews
     *
     * @return mixed
     */
    public function getRemoveReview()
    {
        $data = $this->scopeConfig->getValue(
            'mavenbird_quickview/general/remove_reviews',
            ScopeInterface::SCOPE_STORE
        );
        return $data;
    }

    /**
     * Get Remove More Infos
     *
     * @return mixed
     */
    public function getRemoveMoreInfo()
    {
        $data = $this->scopeConfig->getValue(
            'mavenbird_quickview/general/remove_product_tab',
            ScopeInterface::SCOPE_STORE
        );
        return $data;
    }

    /**
     * Get Sku Templates
     *
     * @return string
     */
    public function getSkuTemplate()
    {
        $this->quickviewOptions = $this->scopeConfig->getValue('mavenbird_quickview', ScopeInterface::SCOPE_STORE);
        $removeSku = $this->quickviewOptions['general']['remove_sku'];
        if (!$removeSku) {
            return 'Magento_Catalog::product/view/attribute.phtml';
        }

        return '';
    }

    /**
     * Get Customs CSS
     *
     * @return string
     */
    public function getCustomCSS()
    {
        $this->quickviewOptions = $this->scopeConfig->getValue('mavenbird_quickview', ScopeInterface::SCOPE_STORE);
        return trim($this->quickviewOptions['general']['custom_css']);
    }

    /**
     * Get Closes Seconds
     *
     * @return string
     */
    public function getCloseSeconds()
    {
        $this->quickviewOptions = $this->scopeConfig->getValue('mavenbird_quickview', ScopeInterface::SCOPE_STORE);
        return trim($this->quickviewOptions['general']['close_quickview']);
    }

    /**
     * Get Product Images Wrapper
     *
     * @return mixed
     */
    public function getProductImageWrapper()
    {
        $result = $this->scopeConfig->getValue('mavenbird_quickview/seting_theme/product_image_wrapper', $this->scopeStore);
        if ($result == null) {
            $result = 'product-image-wrapper';
        }
        return $result;
    }

    /**
     * Get Product Item Infos
     *
     * @return mixed
     */
    public function getProductItemInfo()
    {
        $result = $this->scopeConfig->getValue('mavenbird_quickview/seting_theme/product_item_info', $this->scopeStore);
        if ($result == null) {
            $result = 'product-item-info';
        }
        return $result;
    }
}

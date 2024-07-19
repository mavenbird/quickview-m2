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
namespace Mavenbird\Quickview\Controller\Catalog\Product;

use Magento\Catalog\Controller\Product\Compare\Add as SampleAdd;
use Magento\Framework\Escaper;
use Magento\Catalog\Helper\Product\Compare;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Add extends SampleAdd
{
    /**
     * @var $compare
     */
    protected $compare;

    /**
     * @var $escaper
     */
    protected $escaper;

    /**
     * Constructs
     *
     * @param \Magento\Framework\Escaper $escaper
     * @param \Magento\Catalog\Helper\Product\Compare $compare
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        Escaper $escaper,
        Compare $compare,
        Context $context
    ) {
        $this->escaper = $escaper;
        $this->compare = $compare;
        parent :: __construct($context, $escaper, $compare);
    }

    /**
     * Executes
     *
     * @return mixed
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        if (!$this->_formKeyValidator->validate($this->getRequest())) {
            return $resultRedirect->setRefererUrl();
        }

        $productId = (int)$this->getRequest()->getParam('product');
        if ($productId && ($this->_customerVisitor->getId() || $this->_customerSession->isLoggedIn())) {
            $storeId = $this->_storeManager->getStore()->getId();
            try {
                $product = $this->productRepository->getById($productId, false, $storeId);
            } catch (\Exception $e) {
                $product = null;
            }

            if ($product) {
                $this->_catalogProductCompareList->addProduct($product);
                $productName = $this->escaper->escapeHtml($product->getName());
                $this->messageManager->addSuccess(__('You added product %1 to the comparison list.', $productName));
                $this->_eventManager->dispatch('catalog_product_compare_add_product', ['product' => $product]);
            }

            $this->compare->calculate();
        }
        $params = $this->getRequest()->getParams();
        if (isset($params['mavenbirdquickview']) && $params['mavenbirdquickview'] == 1) {
            return $resultRedirect->setPath($product->getUrlModel()->getUrl($product));
        }
        return $resultRedirect->setRefererOrBaseUrl();
    }
}

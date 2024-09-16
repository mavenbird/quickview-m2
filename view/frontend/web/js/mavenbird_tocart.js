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
define([
    'jquery',
    'Mavenbird_Quickview/js/mavenbird_tocart',
    'mage/mage',
    'Magento_Catalog/product/view/validation',
    'Magento_Catalog/js/catalog-add-to-cart'
], function ($) {
    'use strict';

    $.widget('mavenbird.mavenbird_tocart', {
        _create: function () {
            'use strict';
            $('#product_addtocart_form').mage('validation', {
                radioCheckboxClosest: '.nested',
                submitHandler: function (form) {
                    var widget = $(form).catalogAddToCart({
                        bindSubmit: false
                    });
                    widget.catalogAddToCart('submitForm', $(form));
                    return false;
                }
            });
            $('#ajax-goto a').click(function(e){
                e.preventDefault();
                window.top.location.href = $(this).attr('href');
                
                return false;
            });
        }
    });
    return $.mavenbird.mavenbird_tocart;
});

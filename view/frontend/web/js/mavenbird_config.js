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
    'mage/mage',
    'Mavenbird_Quickview/js/jquery.magnific-popup.min'
], function ($) {
    "use strict";
    $.widget('mavenbird.mavenbird_config', {
        options: {
            productUrl: '',
            buttonText: '',
            isEnabled: false,
            baseUrl: '',
            productImageWrapper: '',
            productItemInfo: ''
        },

        _create: function () {
            this.renderButton();
            this._EventListener();
        },

        renderButton: function () {
            var $widget = this,
                id_product,
                productImageWrapper = '.' + this.options.productImageWrapper,
                productItemInfo = '.' + this.options.productItemInfo;
            if($widget.options.isEnabled == 1){
                $(productImageWrapper).each(function(){
                   
                    if ($(this).parents(productItemInfo).find('.actions-primary input[name="product"]').val() !='') {
                        id_product = $(this).parents(productItemInfo).find('.actions-primary input[name="product"]').val();
                    }
                    if (!id_product) {
                        id_product = $(this).parents(productItemInfo).find('.price-box').data('product-id');
                    }
                    if (id_product) {
                        $(this).append('<div id="quickview-'+ id_product +'" class="mavenbird-bt-quickview"><a class="mavenbird-quickview" data-quickview-url="'+$widget.options.productUrl+'id/'+ id_product +'" href="javascript:void(0);" ><span>'+$widget.options.buttonText+'</span></a></div>');
                    }
                })
            }
        },

        _EventListener: function () {
            var $widget = this;
            if($widget.options.isEnabled == 1){

                $('a.mailto').click(function(e){
                    e.preventDefault();
                    window.top.location.href = $(this).attr('href');    
                    return true;
                });

                $('body, #layer-product-list').on('contentUpdated', function () {
                    $('.mavenbird-bt-quickview').remove();
                    $widget.renderButton();
                });

                $(document).on('click','.mavenbird-quickview', function() {
                    var prodUrl = $(this).attr('data-quickview-url');
                    if (prodUrl.length) {
                        $widget.openPopup(prodUrl);
                    }
                });
            }
        },

        openPopup: function (prodUrl) {
            var $widget = this,
                url = $widget.options.baseUrl + 'mavenbird_quickview/index/updatecart';

            if (!prodUrl.length) {
                return false;
            }

            $.magnificPopup.open({
                items: {
                  src: prodUrl
                },
                type: 'iframe',
                closeOnBgClick: false,
                scrolling: false,
                preloader: true,
                tLoading: '',
                callbacks: {
                    open: function() {
                      $('.mfp-preloader').css('display', 'block');
                      $("iframe.mfp-iframe").contents().find("html").addClass("mavenbird_loader");
                    },
                    beforeClose: function() {
                        $('[data-block="minicart"]').trigger('contentLoading');
                        $.ajax({
                            url: url,
                            method: "POST"
                        });
                    },
                    close: function() {
                      $('.mfp-preloader').css('display', 'none');
                    }
                }
            });
        }
    });
    return $.mavenbird.mavenbird_config;
});

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
var config = {
    map: {
        '*': {
            mavenbird_fancybox: 'Mavenbird_Quickview/js/jquery.fancybox',
            mavenbird_config: 'Mavenbird_Quickview/js/mavenbird_config',
            magnificPopup: 'Mavenbird_Quickview/js/jquery.magnific-popup.min',
            mavenbird_tocart: 'Mavenbird_Quickview/js/mavenbird_tocart'
        }
    },
    shim: {
        magnificPopup: {
            deps: ['jquery']
        }
    }
};

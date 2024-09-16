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
namespace Mavenbird\Quickview\Controller\Index;

use Magento\Framework\App\Action\Action;

class Updatecart extends Action
{
    /**
     * Execute
     *
     * @return void
     */
    public function execute()
    {
        if (!$this->getRequest()->isAjax()) {
            $this->_redirect('/');
            return;
        }

        $jsonData = json_encode(['result' => true]);
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody($jsonData);
    }
}

<?php
    /**
     * Inchoo
     *
     * NOTICE OF LICENSE
     *
     * This source file is subject to the Open Software License (OSL 3.0)
     * that is bundled with this package in the file LICENSE.txt.
     * It is also available through the world-wide-web at this URL:
     * http://opensource.org/licenses/osl-3.0.php
     * If you did not receive a copy of the license and are unable to
     * obtain it through the world-wide-web, please send an email
     * to license@magentocommerce.com so we can send you a copy immediately.
     *
     * DISCLAIMER
     *
     * Please do not edit or add to this file if you wish to upgrade
     * Magento or this extension to newer versions in the future.
     * Inchoo developers (Inchooer's) give their best to conform to
     * "non-obtrusive, best Magento practices" style of coding.
     * However, Inchoo does not guarantee functional accuracy of
     * specific extension behavior. Additionally we take no responsibility
     * for any possible issue(s) resulting from extension usage.
     * We reserve the full right not to provide any kind of support for our free extensions.
     * Thank you for your understanding.
     *
     * @category    Inchoo
     * @package     Inchoo_AdminOrderNotifier
     * @author      Branko Ajzele <ajzele@gmail.com>
     * @copyright   Copyright (c) Inchoo (http://inchoo.net/)
     * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
     */
class Inchoo_AdminOrderNotifier_Model_Observer extends Mage_Core_Helper_Abstract
{
    public function sendNotificationEmailToAdmin($observer)
    {  
		Mage::log("Notificar a tiendas: ",null,"notificar.log");
        $invoice = $observer->getEvent()->getInvoice();
		$order = $invoice->getOrder();
        $storeId = $order->getStoreId();
		$invoice_count=0;
		foreach ($order->getInvoiceCollection() as $inv){
			$invoice_count++;
		}
        $helper = Mage::helper('inchoo_adminOrderNotifier');
		$comments = $invoice->getCommentsCollection()->getItems();
		$notificar_tiendas=true;
		foreach ($comments as $comment) { // Si ponemos algún comentario en la factura NO notificará
			$notificar_tiendas=false;
		}
		foreach ($order->getStatusHistoryCollection(true) as $_item):
			if ($_item->getStatusLabel()=='26.- Reservar en Tienda' || $_item->getStatusLabel()=='Pending Payment Confirmation' || $_item->getStatusLabel()=='Pendiente Confirmación de Pago'):
				$order->addStatusHistoryComment("Estado que ha activado la condición: ".$_item->getStatusLabel());
				$notificar_tiendas=false;	
			endif;
		endforeach;
		Mage::log("Notificar a tiendas: ".$notificar_tiendas,null,"notificar.log");
        if (!$helper->isModuleEnabled($storeId) || ($invoice_count>1) || $notificar_tiendas==false) {
            return;
        }

        try {
			$templateId = $helper->getEmailTemplate($storeId);
			
            $mailer = Mage::getModel('core/email_template_mailer');

            if ($helper->getNotifyGeneralEmail()) {
                $emailInfo = Mage::getModel('core/email_info');
                $emailInfo->addTo($helper->getStoreEmailAddressSenderOption('general', 'email'), $helper->getStoreEmailAddressSenderOption('general', 'name'));
                $mailer->addEmailInfo($emailInfo);
            }

            if ($helper->getNotifySalesEmail()) {
                $emailInfo = Mage::getModel('core/email_info');
                $emailInfo->addTo($helper->getStoreEmailAddressSenderOption('sales', 'email'), $helper->getStoreEmailAddressSenderOption('sales', 'name'));
                $mailer->addEmailInfo($emailInfo);
            }

            if ($helper->getNotifySupportEmail()) {
                $emailInfo = Mage::getModel('core/email_info');
                $emailInfo->addTo($helper->getStoreEmailAddressSenderOption('support', 'email'), $helper->getStoreEmailAddressSenderOption('support', 'name'));
                $mailer->addEmailInfo($emailInfo);
            }

            if ($helper->getNotifyCustom1Email()) {
                $emailInfo = Mage::getModel('core/email_info');
                $emailInfo->addTo($helper->getStoreEmailAddressSenderOption('custom1', 'email'), $helper->getStoreEmailAddressSenderOption('custom1', 'name'));
                $mailer->addEmailInfo($emailInfo);
            }

            if ($helper->getNotifyCustom2Email()) {
                $emailInfo = Mage::getModel('core/email_info');
                $emailInfo->addTo($helper->getStoreEmailAddressSenderOption('custom2', 'email'), $helper->getStoreEmailAddressSenderOption('custom2', 'name'));
                $mailer->addEmailInfo($emailInfo);
            }

            foreach ($helper->getNotifyEmails() as $entry) {
                $emailInfo = Mage::getModel('core/email_info');
                $emailInfo->addTo($entry['email'], $entry['name']);
                $mailer->addEmailInfo($emailInfo);
            }

            $mailer->setSender(array(
                'name' => $helper->getStoreEmailAddressSenderOption('general', 'name'),
                'email' => $helper->getStoreEmailAddressSenderOption('general', 'email'),
            ));

            $mailer->setStoreId($storeId);
            $mailer->setTemplateId($templateId);
            $mailer->setTemplateParams(array(
                'order' => $order,
            ));
			
			
			
            $mailer->send();
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }
}
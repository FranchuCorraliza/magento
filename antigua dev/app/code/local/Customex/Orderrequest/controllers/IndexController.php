<?php
class Customex_Orderrequest_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	// $productId = $this->getRequest()->getParam('id');
		// $customer = Mage::getSingleton('customer/session')->getCustomer();
		
		// var_dump(Mage::helper('orderrequest')->getAdminRecipientEmail());die('daf');
		// $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
		$this->loadLayout();     
		$this->renderLayout();
    }
	
	
	public function imagecaptchaAction() {
		require_once(Mage::getBaseDir('lib') . DS .'captcha'. DS .'class.simplecaptcha.php');
		$config['BackgroundImage'] = Mage::getBaseDir('lib') . DS .'captcha'. DS . "white.png";
		$config['BackgroundColor'] = "FF0000";
		$config['Height']=30;
		$config['Width']=100;
		$config['Font_Size']=23;
		$config['Font']= Mage::getBaseDir('lib') . DS .'captcha'. DS . "ARLRDBD.TTF";
		$config['TextMinimumAngle']=0;
		$config['TextMaximumAngle']=0;
		$config['TextColor']='000000';
		$config['TextLength']=4;
		$config['Transparency']=80;
		$captcha = new SimpleCaptcha($config);
		$_SESSION['captcha_code'] = $captcha->Code;
	}
	
	
	public function refreshcaptchaAction() {
		$result = Mage::getModel('core/url')->getUrl('*/*/imageCaptcha/') .  now();//rand(5,20);
		echo $result;
	}
	
	
	protected function isValidCaptcha($data) {
	
		if(!isset($_SESSION['captcha_code'])) {
			return false;
		}
		
		$captchaCode = trim($_SESSION['captcha_code']);
		$captchaText = trim($data['captcha_text']);
		if(strtolower($captchaText) != strtolower($captchaCode)) {
			return false;
		}
		return true;

		
	}
	
	public function submitAction() {
		$data = $this->getRequest()->getPost();
		$error = false;
		if($data) {
			$product = Mage::getModel('catalog/product')->setStoreId(0)->load($data['product_id']);
			try {
				if(!$this->isValidCaptcha($data)) {
					throw new Exception();
				} else {
					
					/* $storeIds[] = 0;
					$stores = Mage::app()->getStores();
					foreach($stores as $store) {
						$storeIds[] = $store->getId();
					}
					 */

					$model = Mage::getModel('orderrequest/orderrequest');
					$data['store_id'] = Mage::app()->getStore()->getId();
					$data['status']	  = 1;
					$data['created_time']	  = now();
					$data['updated_time']	  = now();
					$data['product_name']     = $product->getName();
					$data['manufacturer']	  = $product->getAttributeText('manufacturer');
					$data['reference']		  = $product->getSku();
					$data['product_url']	  = $product->getUrlInStore();
					$data['order_by_request'] = $product->getAttributeText('no_shop_button');
					
					$orderrequest = $this->getLayout()->createBlock('orderrequest/sendtocustomer')
											->setInformation($data)
											->setTemplate('orderrequest/email/sendtocustomer.phtml')
											->toHtml(); 
											
					$customercontact = $this->getLayout()->createBlock('orderrequest/sendtoadmin')
											->setInformation($data)
											->setTemplate('orderrequest/email/sendtoadmin.phtml')
											->toHtml();
											
					/* foreach($storeIds as $storeId) {
						$data['store_id'] = $storeId;
						$model->setData($data);
						$model->save();
					} */
					
					/*$model->setData($data)->save()
							->sendMailToCustomer($model, $orderrequest)
							->sendMailToAdmin($model, $customercontact)
							; 
					*/
					$model->setData($data);
					$model->sendMailToCustomer($model, $orderrequest);		
					$model->sendMailToAdmin($model, $customercontact);		
							
					Mage::getSingleton('catalog/session')->addSuccess(Mage::helper('orderrequest')->getSuccessMessage());
       				$this->_redirectUrl($product->getProductUrl());
					return;
				}
			} catch (Exception $e) {
				Mage::getSingleton('catalog/session')->addError(Mage::helper('orderrequest')->getErrorMessage());
                $this->_redirectUrl($product->getProductUrl());
                return;
			}
		} 
		// $html = "";
		// if(!$error) {
		
			// $html = 'Your contact for product has been sent. We will notify you as soon as. Thank you!';
			
		// } else {
			
			// $error = 'Your contact for product has not been sent. Please try again.';
			
		// }
		// $this->loadLayout(); 
		// $this->_initLayoutMessages('customer/session');
		
		// $results = array();
		// $results['error'] = $error;
		// $results['html'] = $html;
		// $this->getResponse()->setBody(Zend_Json::encode($results));
		
	}
}
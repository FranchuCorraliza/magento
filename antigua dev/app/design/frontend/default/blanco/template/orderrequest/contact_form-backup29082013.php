<?php 
	
	$productId = $this->getRequest()->getParam('id');
	$customer = $this->getCustomer();
	
	$address 	= $customer->getDefaultBillingAddress();
?>
<?php if($this->getRequest()->getParam('stock')!='0'): ?>
<div class="box-collateral productcontact">
	<a name="product-contact-form"></a>
	<h2><?php echo $this->__('Product contact'); ?></h2>
	<div id="messages_product_view"><?php echo $this->getMessagesBlock()->getGroupedHtml() ?></div>
	<!--<ul class="messages" style="display:none;" id="productcontact_message">
		<li class="success-msg">
			<ul><li><?php echo $this->__('Your contact for product has been sent. We will notify you as soon as. Thank you!'); ?></li></ul>
		</li>
	</ul>-->
	
	<form action="<?php echo $this->getUrl('productcontact/index/submit'); ?>" id="productcontactForm" method="post" target="_top">
		<input type="hidden" name="product_id" value="<?php echo $productId; ?>"/>
		<div class="fieldset">
			<h2 class="legend"><?php echo Mage::helper('productcontact')->__('Contact Information') ?></h2>
			<ul class="form-list">
				<li class="fields">
					<?php if(Mage::helper('productcontact')->isShowPersonalName()): ?>
						<div class="field">
							<label for="personal_name" class="required"><?php if(Mage::helper('productcontact')->isRequirePersonalName()): ?><em>*</em><?php endif; ?><?php echo Mage::helper('productcontact')->__('Personal Name') ?></label>
							<div class="input-box">
								<?php if(Mage::helper('productcontact')->isRequirePersonalName()): ?>
									<input name="personal_name" id="personal_name" title="<?php echo Mage::helper('productcontact')->__('Personal Name') ?>" value="<?php if($customer->getId()) echo $this->htmlEscape($customer->getName()); ?>" class="input-text required-entry" type="text" />
								<?php else: ?>
									<input name="personal_name" id="personal_name" title="<?php echo Mage::helper('productcontact')->__('Personal Name') ?>" value="<?php if($customer->getId()) echo $this->htmlEscape($customer->getName()); ?>" class="input-text" type="text" />
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
                    <?php if(Mage::helper('productcontact')->isShowEmail()): ?>
						<div class="field">
							<label for="customer_email" class="required"><?php if(Mage::helper('productcontact')->isRequireEmail()): ?><em>*</em><?php endif; ?><?php echo Mage::helper('productcontact')->__('Email') ?></label>
							<div class="input-box">
								<?php if(Mage::helper('productcontact')->isRequireEmail()): ?>
									<input name="customer_email" id="customer_email" title="<?php echo Mage::helper('productcontact')->__('Email') ?>" value="<?php echo $this->htmlEscape($customer->getEmail()) ?>" class="input-text required-entry validate-email" type="text" />
								<?php else: ?>
									<input name="customer_email" id="customer_email" title="<?php echo Mage::helper('productcontact')->__('Email') ?>" value="<?php echo $this->htmlEscape($customer->getEmail()) ?>" class="input-text" type="text" />
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</li>
				
				<li class="wide">
                        <div class="captcha-field">
							<img src="<?php echo $this->getUrl('productcontact/index/imagecaptcha');?>" id="captcha_image" /><br/>
						<span><a href="" onclick="refreshImage();return false;"><?php echo $this->__("Refresh"); ?></a></span>

						</div>

						<div class="field">
                            <div class=""><label class="required"><?php echo $this->__('Enter the text shown on image');?><em>*</em></label></div>
                            <div class="">
                                <input type="text" name="captcha_text" class="required-entry input-text captcha-input" id="captcha_text" value="" /></div>
           				</div>

				</li>
				<li class="wide">
                	<div class="field">
					<?php if(Mage::helper('productcontact')->isShowDetail()): ?>
						<label for="detail" class="required"><?php if(Mage::helper('productcontact')->isRequireDetail()): ?><em>*</em><?php endif; ?><?php echo Mage::helper('contacts')->__('Detail') ?></label>
						<div class="input-box">
							<?php if(Mage::helper('productcontact')->isRequireDetail()): ?>
								<textarea name="detail" id="detail" title="<?php echo Mage::helper('contacts')->__('Detail') ?>" class="required-entry input-text" cols="5" rows="3"></textarea>
							<?php else: ?>
								<textarea name="detail" id="detail" title="<?php echo Mage::helper('contacts')->__('Detail') ?>" class="input-text" cols="5" rows="3"></textarea>
							<?php endif; ?>
						</div>
					<?php endif; ?>	
                    </div>
				</li>
			</ul>
		</div>
		<div class="buttons-set">
			
			<p class="required"><?php echo Mage::helper('contacts')->__('* Required Fields') ?></p>
			<input type="text" name="hideit" id="hideit" value="" style="display:none !important;" />	
			<button type="submit"  title="<?php echo Mage::helper('contacts')->__('Submit') ?>" class="button"><span><span><?php echo Mage::helper('contacts')->__('Submit') ?></span></span></button>
		</div>
	</form>
</div>
<?php else: ?>
<?php 
$product = Mage::getModel('catalog/product')->load($productId);
$productAttributeOptions = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);
$attributeOptions = array();
foreach ($productAttributeOptions as $productAttribute) {
    foreach ($productAttribute['values'] as $attribute) {
        $attributeOptions[$productAttribute['label']][$attribute['value_index']] = $attribute['store_label'];
    }
}
?>

<div class="box-collateral productcontact">
	<a name="product-contact-form"></a>
	<h2><?php echo $this->__('Order By Request'); ?></h2>
	<div id="messages_product_view">
	
	<?php echo $this->getMessagesBlock()->getGroupedHtml() ?>
        
    </div>
    <!--<ul class="messages" style="display:none;" id="productcontact_message">
		<li class="success-msg">
			<ul><li><?php echo $this->__('Your contact for product has been sent. We will notify you as soon as. Thank you!'); ?></li></ul>
		</li>
	</ul>-->
	
	<form action="<?php echo $this->getUrl('productcontact/index/submit'); ?>" id="productcontactForm" method="post" target="_top">
    	<input type="hidden" name="product_id" value="<?php echo $productId; ?>"/>
		<div class="fieldset">
		
		<?php if ((!((count($attributeOptions['color'])==1) && ($attributeOptions['color']['1039']=='UNICO'))) || (!((count($attributeOptions['talla'])==1) && ($attributeOptions['talla']['1025']=='UNICA')))): ?>
		<h2 class="legend"><?php echo Mage::helper('productcontact')->__('Options product') ?></h2>  
        <ul class="form-list">
				<li class="fields">      
                    <div class="options-products">
                        <?php if (!((count($attributeOptions['color'])==1) && ($attributeOptions['color']['1039']=='UNICO'))): ?>
                        <div class="field">
                        <label for="color" class="required"><?php echo Mage::helper('productcontact')->__('Colour') ?>:</label>
						
							<div class="input-box">
    	                        <select name="color">
        	                        <?php foreach ($attributeOptions['color'] as $option) : ?>
            	                    <option><?php echo $option ?></option>
                	                <?php endforeach; ?>
                    	        </select>
                        	</div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!((count($attributeOptions['talla'])==1) && ($attributeOptions['talla']['1025']=='UNICA'))): ?>
						<div class="field">
                        <label for="talla" class="required"><?php echo Mage::helper('productcontact')->__('Size') ?>:</label>
							<div class="input-box">
                            <select name="talla">
                                <?php foreach ($attributeOptions['talla'] as $option) : ?>
                                <option><?php echo $option ?></option>
                                <?php endforeach; ?>
                            </select>            
                        	</div>
                        </div>
						<?php endif; ?>
			<?php endif; ?>
            </div>
            </li>
            </ul>                       
			<h2 class="legend" style="margin-top:30px;"><?php echo Mage::helper('productcontact')->__('Contact Information') ?></h2>

			<ul class="form-list">
				<li class="fields">
					<?php if(Mage::helper('productcontact')->isShowPersonalName()): ?>
						<div class="field">
							<label for="personal_name" class="required"><?php if(Mage::helper('productcontact')->isRequirePersonalName()): ?><em>*</em><?php endif; ?><?php echo Mage::helper('productcontact')->__('Personal Name') ?></label>
							<div class="input-box">
								<?php if(Mage::helper('productcontact')->isRequirePersonalName()): ?>
									<input name="personal_name" id="personal_name" title="<?php echo Mage::helper('productcontact')->__('Personal Name') ?>" value="<?php if($customer->getId()) echo $this->htmlEscape($customer->getName()); ?>" class="input-text required-entry" type="text" />
								<?php else: ?>
									<input name="personal_name" id="personal_name" title="<?php echo Mage::helper('productcontact')->__('Personal Name') ?>" value="<?php if($customer->getId()) echo $this->htmlEscape($customer->getName()); ?>" class="input-text" type="text" />
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
                                        
                    <?php if(Mage::helper('productcontact')->isShowEmail()): ?>
						<div class="field">
							<label for="customer_email" class="required"><?php if(Mage::helper('productcontact')->isRequireEmail()): ?><em>*</em><?php endif; ?><?php echo Mage::helper('productcontact')->__('Email') ?></label>
							<div class="input-box">
								<?php if(Mage::helper('productcontact')->isRequireEmail()): ?>
									<input name="customer_email" id="customer_email" title="<?php echo Mage::helper('productcontact')->__('Email') ?>" value="<?php echo $this->htmlEscape($customer->getEmail()) ?>" class="input-text required-entry validate-email" type="text" />
								<?php else: ?>
									<input name="customer_email" id="customer_email" title="<?php echo Mage::helper('productcontact')->__('Email') ?>" value="<?php echo $this->htmlEscape($customer->getEmail()) ?>" class="input-text" type="text" />
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
                    
                    
				</li>
				
              <li class="fields">
              <?php if(Mage::helper('productcontact')->isShowPhone()): ?>
						<div class="field">
							<label for="phone" class="required"><?php if(Mage::helper('productcontact')->isRequirePhone()): ?><em>*</em><?php endif; ?><?php echo Mage::helper('productcontact')->__('Phone') ?></label>
							<div class="input-box">
								<?php if(Mage::helper('productcontact')->isRequirePhone()): ?>
									<input name="phone" id="phone" title="<?php echo Mage::helper('productcontact')->__('Phone') ?>" value="<?php if($address) echo $this->htmlEscape($address->getTelephone()) ?>" class="input-text required-entry" type="text" />
								<?php else: ?>	
									<input name="phone" id="phone" title="<?php echo Mage::helper('productcontact')->__('Phone') ?>" value="<?php if($address) echo $this->htmlEscape($address->getTelephone()) ?>" class="input-text" type="text" />
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
              
                        <div class="field">
                            <div class=""><label class="required"><?php echo $this->__('Enter the text shown on image');?><em>*</em></label></div>
                            <div class="">
                                <input type="text" name="captcha_text" class="required-entry input-text captcha-input" id="captcha_text" value="" /></div>
           				</div>
                        <div class="captcha-field">
							<img src="<?php echo $this->getUrl('productcontact/index/imagecaptcha');?>" id="captcha_image" /><br/>
						<span><a href="" onclick="refreshImage();return false;"><?php echo $this->__("Refresh"); ?></a></span>

						</div>

				</li>
				<li class="wide">
                	<div class="field">
					<?php if(Mage::helper('productcontact')->isShowDetail()): ?>
						<label for="detail" class="required"><?php if(Mage::helper('productcontact')->isRequireDetail()): ?><em>*</em><?php endif; ?><?php echo Mage::helper('contacts')->__('Detail') ?></label>
						<div class="input-box">
							<?php if(Mage::helper('productcontact')->isRequireDetail()): ?>
								<textarea name="detail" id="detail" title="<?php echo Mage::helper('contacts')->__('Detail') ?>" class="required-entry input-text" cols="5" rows="3"></textarea>
							<?php else: ?>
								<textarea name="detail" id="detail" title="<?php echo Mage::helper('contacts')->__('Detail') ?>" class="input-text" cols="5" rows="3"></textarea>
							<?php endif; ?>
						</div>
					<?php endif; ?>	
                    </div>
				</li>
			</ul>
		</div>
		<div class="buttons-set">
			
			<p class="required"><?php echo Mage::helper('contacts')->__('* Required Fields') ?></p>
			<input type="text" name="hideit" id="hideit" value="" style="display:none !important;" />	
			<button type="submit"  title="<?php echo Mage::helper('contacts')->__('Submit') ?>" class="button"><span><span><?php echo Mage::helper('contacts')->__('Submit') ?></span></span></button>
		</div>
	</form>
</div>
<?php endif; ?>
<script type="text/javascript">
//<![CDATA[
    var contactForm = new VarienForm('productcontactForm', true);
	
	function refreshImage() {	
		url = '<?php echo $this->getUrl('productcontact/index/refreshcaptcha');?>';			
		$('captcha_image').src = '';

		capchaRefesh = new Ajax.Request(url, {

			method: 'get',

			onSuccess: function(transport) {

				imageCapcha = new Image();

				imageCapcha.src = transport.responseText;

				$('captcha_image').src = imageCapcha.src;

			}

		});
	}
	
	// var productcontact = new Productcontact('productcontactForm', '<?php echo $this->getUrl('productcontact/index/submit');?>' );
	
</script>

<?php
    $_product = $this->getProduct();
    $_helper = $this->helper('catalog/output');
    $now = date("Y-m-d H:m:s");     
    $use_zoom = themeOptions('use_zoom'); 
    $use_carousel = themeOptions('use_carousel');
    $_layout = themeOptions('layout'); 
	$galleryImages = $this->getGalleryImages();
    $thumbs_count = count($this->getGalleryImages());
    $_i_thumbs = 0;
?>
<?php 
    switch($_layout){
        case 'horizontal':
            $_mainWidth = 483;
            $_mainHeight = 398;
            $_smWidth = 68;
            $_smHeight = 68;
            $_carWidth = 430;
            $_zoomLeft = $_mainWidth + 17;
            $_zoomWidth = 450;
        break;
        case 'vertical':
            $_mainWidth = 328;
            $_mainHeight = 398;
            $_smWidth = 68;
            $_smHeight = 68;
            $_carWidth = 258;
            $_zoomLeft = $_mainWidth + 17;
            $_zoomWidth = 450;
        break;
        default:
            $_mainWidth = 398;
            $_mainHeight = 398;
            $_smWidth = 68;
            $_smHeight = 68;
            $_carWidth = 344;
            $_zoomLeft = $_mainWidth + 17;
            $_zoomWidth = 536;        
        break;
    }
?>
<style>
    .product-view .product-img-box .more-views { width:<?php echo $_carWidth ?>px; }
    #zoom-window { left: <?php echo $_zoomLeft ?>px; width: <?php echo $_zoomWidth ?>px; }
</style>
<div class="zoom-container layout_<?php echo $_layout ?>">
    
    <?php include('labels.phtml') ?>
    <div class="main-image" >   
        <a id="zoom" class="<?php if(!$use_zoom): ?> lightbox<?php endif;?> main-thumbnail" href="<?php echo $this->helper('catalog/image')->init($_product, 'image') ?>">
            <?php
                $_img = '<img id="image" class="zoom-image" src="'.$this->helper('catalog/image')->init($_product, 'image')->resize($_mainWidth,$_mainHeight).'" width="'.$_mainWidth.'" height="'.$_mainHeight.'" alt="'.$this->htmlEscape($this->getImageLabel()).'" title="'.$this->htmlEscape($this->getImageLabel()).'" />';
                echo $_helper->productAttribute($_product, $_img, 'image');
            ?>
            
        </a> 
        <?php if($use_zoom): ?>
        <div class="lightbox-btn">
            <a id="zoom" class="lightbox" href="<?php echo $this->helper('catalog/image')->init($_product, 'image') ?>">
                <?php echo $this->__('Enlarge') ?>
            </a>        
        </div>
        <?php endif;?>
    </div> 
  
  
  
  
    <div class="more-views <?php if($use_carousel && $thumbs_count > 4): ?>style="height:80px;"<?php endif; ?>">
        <div id="ul-moreviews" class="zoom-gallery slider">
        <?php if($thumbs_count == 0): ?>
            <div class="slide last">
                <a class="zoom-thumbnail<?php if(!$use_zoom): ?> lightbox<?php endif;?>" href="<?php echo $this->helper('catalog/image')->init($_product, 'image') ?>" data-easyzoom-source="<?php echo $this->helper('catalog/image')->init($_product, 'image')->resize($_mainWidth,$_mainHeight) ?>">
                    <?php
                        $_img = '<img class="zoom-image" src="'.$this->helper('catalog/image')->init($_product, 'thumbnail')->resize($_smWidth,$_smHeight).'" width="'.$_smWidth.'" height="'.$_smHeight.'" alt="'.$this->htmlEscape($this->getImageLabel()).'" title="'.$this->htmlEscape($this->getImageLabel()).'" />';
                        echo $_helper->productAttribute($_product, $_img, 'image');
                    ?>
                </a>   
            </div>   
        <?php endif; ?>
        
        <?php if ($thumbs_count > 0): ?>  
			<?php $producto = Mage::getModel('catalog/product')->load($_product->getId()); ?>
			<?php /*
			<div class="slide">
			<a class="zoom-thumbnail<?php if(!$use_zoom): ?> lightbox<?php endif;?>"  href="<?php echo $producto->getImageUrl(); ?>" data-easyzoom-source="<?php echo $this->getBaseUrl()."".$producto->getImageUrl(); ?>" title="<?php echo "titulo"; ?>"><img width="68px" height="68px" src="<?php echo $producto->getImageUrl(); ?>" /></a>
			</div>
			<div class="slide">
			<a class="zoom-thumbnail<?php if(!$use_zoom): ?> lightbox<?php endif;?>"  href="<?php echo $this->getBaseUrl()."".$producto->getCampoCuatro(); ?>" data-easyzoom-source="<?php echo $this->getBaseUrl()."".$producto->getCampoCuatro(); ?>" title="<?php echo "titulo"; ?>"><img width="68px" height="68px" src="<?php echo $this->getBaseUrl()."".$producto->getCampoCuatro(); ?>" /></a>
            </div>			
			<div class="slide last">
			<a class="zoom-thumbnail<?php if(!$use_zoom): ?> lightbox<?php endif;?>"  href="<?php echo $this->getBaseUrl()."".$producto->getCampoCinco(); ?>" data-easyzoom-source="<?php echo $this->getBaseUrl()."".$producto->getCampoCinco(); ?>" title="<?php echo "titulo"; ?>"><img width="68px" height="68px" src="<?php echo $this->getBaseUrl()."".$producto->getCampoCinco(); ?>" /></a>
			</div>*/ ?>
        <?php echo Mage::helper('colorselectorplus')->getMoreViews($producto); ?>    
        <?php endif; ?>
        </div>              
    </div>
	<?php if($use_carousel && $thumbs_count > 4): ?>
        <div class="more-views-arrow prev">&nbsp;</div>
        <div class="more-views-arrow next">&nbsp;</div>                 
    <?php endif;?>  
</div>    
    
	<script type="text/javascript">    
    	
    <?php if($use_zoom): ?>
        // Start easyZoom
    	jQuery('#zoom')
    		.easyZoom({
    			parent: 'div.zoom-container',
    			preload: '',
                lightboxBtn: '.lightbox-btn .lightbox'
    		})
    		.data('easyZoom')
    		.gallery('a.zoom-thumbnail');
    <?php endif;?>
    
    <?php if($use_carousel && $thumbs_count > 4): ?>	 
        jQuery('.more-views').iosSlider({
            desktopClickDrag: true,
            snapToChildren: true,
            infiniteSlider: false,
            navNextSelector: '.more-views-arrow.next',
            navPrevSelector: '.more-views-arrow.prev'
        });                         
    <?php endif;?>
    
     // Start lightbox
    jQuery('a.lightbox').lightBox({
        imageLoading    : '<?php echo $this->getSkinUrl('images/lightbox-ico-loading.gif') ?>',
        imageBtnClose   : '<?php echo $this->getSkinUrl('images/lightbox-btn-close.gif') ?>',
        imageBtnNext    : '<?php echo $this->getSkinUrl('images/lightbox-btn-next.gif') ?>',
        imageBtnPrev    : '<?php echo $this->getSkinUrl('images/lightbox-btn-prev.gif') ?>',
        imageBlank      : '<?php echo $this->getSkinUrl('images/lightbox-blank.gif') ?>',
        fixedNavigation : true
    });        
	</script>   

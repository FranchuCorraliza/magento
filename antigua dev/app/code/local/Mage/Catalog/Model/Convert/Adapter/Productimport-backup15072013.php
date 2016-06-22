<?php
/**
* Product_import.php
* 
* @copyright  copyright (c) 2009 toniyecla[at]gmail.com
* @license    http://opensource.org/licenses/osl-3.0.php open software license (OSL 3.0)
*/

class Mage_Catalog_Model_Convert_Adapter_Productimport
extends Mage_Catalog_Model_Convert_Adapter_Product
 {
    
    /**
    * Save product (import)
    * 
    * @param array $importData 
    * @throws Mage_Core_Exception
    * @return bool 
    */
    public function saveRow( array $importData )
    
    {
        $product = $this -> getProductModel();
        $product -> setData( array() );

/* Añadimos este código para asignar las categorías correctas en función de la familia, sección y departamento de cada producto */
		if (isset($importData['departamento']) && isset($importData['seccion']) && isset($importData['familia'])){	
			switch ($importData['departamento']){
				case '1':
						switch ($importData['seccion']){
							case '1':
									switch ($importData['familia']){
										case '1':
												$categorias=array('23','24','25');
											break;
										case '2':
												$categorias=array('23','24','26');
											break;
										case '3':
												$categorias=array('23','24','27');
											break;
										case '4':
												$categorias=array('23','24','36');
											break;
										case '5':
												$categorias=array('23','24','30');
											break;
										case '6':
												$categorias=array('23','24','35');
											break;
										case '7':
												$categorias=array('23','24','31');
											break;
										case '8':
												$categorias=array('23','24','29');
											break;
										case '9':
												$categorias=array('23','24','37');
											break;
										case '10':
												$categorias=array('23','24','38');
											break;
										case '11':
												$categorias=array('23','24','155');
											break;
										case '12':
												$categorias=array('23','24','32');
											break;
										case '13':
												$categorias=array('23','24','28');
											break;
										case '14':
												$categorias=array('23','24','40');
											break;
										case '15':
												$categorias=array('23','24','33');
											break;
										case '16':
												$categorias=array('23','24','42');
											break;
										case '17':
												$categorias=array('23','24','44');
											break;
									}
								break;
							case '2':
									switch ($importData['familia']){
										case '1':
												$categorias=array('23','45','49');
											break;
										case '2':
												$categorias=array('23','45','47');
											break;
										case '3':
												$categorias=array('23','45','46');
											break;
										case '4':
												$categorias=array('23','45','54');
											break;
										case '5':
												$categorias=array('23','45','53');
											break;
										case '6':
												$categorias=array('23','45','48');
											break;
										case '7':
												$categorias=array('23','45','156');
											break;
										case '8':
												$categorias=array('23','45','57');
											break;
									}
								break;
							case '3':
									switch ($importData['familia']){
										case '1':
												$categorias=array('23','59','60');
											break;
										case '2':
												$categorias=array('23','59','176');
											break;
										case '3':
												$categorias=array('23','59','177');
											break;
										case '4':
												$categorias=array('23','59','178');
											break;
										case '5':
												$categorias=array('23','59','179');
											break;
										case '6':
												$categorias=array('23','59','180');
											break;
										case '7':
												$categorias=array('23','59','181');
											break;
										case '8':
												$categorias=array('23','59','182');
											break;
									}
								break;
							case '4':
									switch ($importData['familia']){
										case '1':
												$categorias=array('23','61','152');
											break;
										case '2':
												$categorias=array('23','61','183');
											break;
										case '3':
												$categorias=array('23','61','184');
											break;
										case '4':
												$categorias=array('23','61','185');
											break;
										case '5':
												$categorias=array('23','61','186');
											break;
										case '6':
												$categorias=array('23','61','187');
											break;
										case '7':
												$categorias=array('23','61','188');
											break;
										case '8':
												$categorias=array('23','61','189');
											break;
										case '9':
												$categorias=array('23','61','190');
											break;
									}
								break;
							}
					break;
				case '2':
						switch ($importData['seccion']){
							case '1':
									switch ($importData['familia']){
										case '1':
												$categorias=array('62','63','64');
											break;
										case '2':
												$categorias=array('62','63','65');
											break;
										case '3':
												$categorias=array('62','63','66');
											break;
										case '4':
												$categorias=array('62','63','67');
											break;
										case '5':
												$categorias=array('62','63','68');
											break;
										case '6':
												$categorias=array('62','63','70');
											break;
										case '7':
												$categorias=array('62','63','71');
											break;
										case '8':
												$categorias=array('62','63','69');
											break;
										case '9':
												$categorias=array('62','63','72');
											break;
										case '10':
												$categorias=array('62','63','73');
											break;
										case '11':
												$categorias=array('62','63','77');
											break;
									}
								break;
							case '2':
									switch ($importData['familia']){
										case '1':
												$categorias=array('62','78','84');
											break;
										case '2':
												$categorias=array('62','78','81');
											break;
										case '3':
												$categorias=array('62','78','80');
											break;
										case '4':
												$categorias=array('62','78','87');
											break;
										case '5':
												$categorias=array('62','78','82');
											break;
										case '6':
												$categorias=array('62','78','83');
											break;
										case '7':
												$categorias=array('62','78','153');
											break;
										case '8':
												$categorias=array('62','78','90');
											break;
										case '9':
												$categorias=array('62','78','79');
											break;
									}
								break;
							case '3':
									switch ($importData['familia']){
										case '1':
												$categorias=array('62','92','93');
											break;
										case '2':
												$categorias=array('62','92','191');
											break;
										case '3':
												$categorias=array('62','92','192');
											break;
										case '4':
												$categorias=array('62','92','193');
											break;
										case '5':
												$categorias=array('62','92','194');
											break;
									}
								break;
							case '4':
									switch ($importData['familia']){
										case '1':
												$categorias=array('62','94','95');
											break;
										case '2':
												$categorias=array('62','94','195');
											break;
										case '3':
												$categorias=array('62','94','196');
											break;
										case '4':
												$categorias=array('62','94','197');
											break;
										case '5':
												$categorias=array('62','94','198');
											break;
										case '6':
												$categorias=array('62','94','199');
											break;
										case '7':
												$categorias=array('62','94','200');
											break;
										case '8':
												$categorias=array('62','94','201');
											break;
									}
								break;
							}
					break;
				case '4':
						switch ($importData['seccion']){
							case '1':
									switch ($importData['familia']){
										case '1':
												$categorias=array('101','171','102');
											break;
										case '2':
												$categorias=array('101','171','104');
											break;
										case '3':
												$categorias=array('101','171','105');
											break;
										case '4':
												$categorias=array('101','171','120');
											break;
										case '5':
												$categorias=array('101','171','121');
											break;
										case '6':
												$categorias=array('101','171','116');
											break;
										case '7':
												$categorias=array('101','171','115');
											break;
										case '8':
												$categorias=array('101','171','119');
											break;
										case '9':
												$categorias=array('101','171','112');
											break;
										case '10':
												$categorias=array('101','171','167');
											break;
										case '11':
												$categorias=array('101','171','168');
											break;
										case '12':
												$categorias=array('101','171','111');
											break;
										case '13':
												$categorias=array('101','171','110');
											break;
										case '14':
												$categorias=array('101','171','117');
											break;
										case '15':
												$categorias=array('101','171','113');
											break;
										case '16':
												$categorias=array('101','171','118');
											break;
									}
								break;
							case '2':
									switch ($importData['familia']){
										case '1':
												$categorias=array('101','161','162');
											break;
										case '2':
												$categorias=array('101','161','163');
											break;
									}
								break;
							case '3':
									switch ($importData['familia']){
										case '1':
												$categorias=array('101','158','159');
											break;
										case '2':
												$categorias=array('101','158','160');
											break;
									}
								break;
							case '4':
									switch ($importData['familia']){
										case '1':
												$categorias=array('101','106','169');
											break;
										case '2':
												$categorias=array('101','106','170');
											break;
										case '3':
												$categorias=array('101','106','108');
											break;
										case '4':
												$categorias=array('101','106','109');
											break;
										case '5':
												$categorias=array('101','106','205');
										}
								break;
							case '5':
									switch ($importData['familia']){
										case '1':
												$categorias=array('101','96','164');
											break;
										case '2':
												$categorias=array('101','96','97');
											break;
										case '3':
												$categorias=array('101','96','166');
											break;
										case '4':
												$categorias=array('101','96','165');
											break;
										case '5':
												$categorias=array('101','96','99');
											break;
										}
								break;	
							}
					break;
				case '7':
						switch ($importData['seccion']){
							case '1':
									switch ($importData['familia']){
										case '1':
												$categorias=array('122','123','124');
											break;
										case '2':
												$categorias=array('122','123','125');
											break;
										case '3':
												$categorias=array('122','123','126');
											break;
										case '4':
												$categorias=array('122','123','127');
											break;
										case '5':
												$categorias=array('122','123','128');
											break;
										case '6':
												$categorias=array('122','123','129');
											break;
										case '7':
												$categorias=array('122','123','130');
											break;
										case '8':
												$categorias=array('122','123','132');
											break;
										case '9':
												$categorias=array('122','123','133');
											break;
										case '10':
												$categorias=array('122','123','134');
											break;
										case '11':
												$categorias=array('122','123','135');
											break;
										case '12':
												$categorias=array('122','123','136');
											break;
										case '13':
												$categorias=array('122','123','137');
											break;
										case '14':
												$categorias=array('122','123','138');
											break;
										case '15':
												$categorias=array('122','123','140');
											break;
									}
								break;
							case '2':
									switch ($importData['familia']){
										case '1':
												$categorias=array('122','142','144');
											break;
										case '2':
												$categorias=array('122','142','145');
											break;
									}
								break;
							case '3':
									switch ($importData['familia']){
										case '1':
												$categorias=array('122','148','149');
											break;
									}
								break;
							case '4':
									switch ($importData['familia']){
										case '1':
												$categorias=array('122','150','151');
											break;
										
										}
								break;		
							}
					break;
				}
			
			
						
	}
        
		if ( $stockItem = $product -> getStockItem() ) {
            $stockItem -> setData( array() );
            } 
        
        if ( empty( $importData['store'] ) ) {
            if ( !is_null( $this -> getBatchParams( 'store' ) ) ) {
                $store = $this -> getStoreById( $this -> getBatchParams( 'store' ) );
                } else {
                $message = Mage :: helper( 'catalog' ) -> __( 'Skip import row, required field "%s" not defined', 'store' );
                Mage :: throwException( $message );
                } 
            } else {
            $store = $this -> getStoreByCode( $importData['store'] );
            } 
        
        if ( $store === false ) {
            $message = Mage :: helper( 'catalog' ) -> __( 'Skip import row, store "%s" field not exists', $importData['store'] );
            Mage :: throwException( $message );
            } 
        
        if ( empty( $importData['sku'] ) ) {
            $message = Mage :: helper( 'catalog' ) -> __( 'Skip import row, required field "%s" not defined', 'sku' );
            Mage :: throwException( $message );
            } 
        
        $product -> setStoreId( $store -> getId() );
        $productId = $product -> getIdBySku( $importData['sku'] );
        $new = true; // fix for duplicating attributes error
        if ( $productId ) {
            $product -> load( $productId );
            $new = false; // fix for duplicating attributes error
            } 
        $productTypes = $this -> getProductTypes();
        $productAttributeSets = $this -> getProductAttributeSets();
        
        // delete disabled products
        if ( $importData['status'] == 'Disabled' ) {
            $product = Mage :: getSingleton( 'catalog/product' ) -> load( $productId );
            $this -> _removeFile( Mage :: getSingleton( 'catalog/product_media_config' ) -> getMediaPath( $product -> getData( 'image' ) ) );
            $this -> _removeFile( Mage :: getSingleton( 'catalog/product_media_config' ) -> getMediaPath( $product -> getData( 'small_image' ) ) );
            $this -> _removeFile( Mage :: getSingleton( 'catalog/product_media_config' ) -> getMediaPath( $product -> getData( 'thumbnail' ) ) );
            $media_gallery = $product -> getData( 'media_gallery' );
            foreach ( $media_gallery['images'] as $image ) {
                $this -> _removeFile( Mage :: getSingleton( 'catalog/product_media_config' ) -> getMediaPath( $image['file'] ) );
                } 
            $product -> delete();
            return true;
            } 
        
        if ( empty( $importData['type'] ) || !isset( $productTypes[strtolower( $importData['type'] )] ) ) {
            $value = isset( $importData['type'] ) ? $importData['type'] : '';
            $message = Mage :: helper( 'catalog' ) -> __( 'Skip import row, is not valid value "%s" for field "%s"', $value, 'type' );
            Mage :: throwException( $message );
            } 
        $product -> setTypeId( $productTypes[strtolower( $importData['type'] )] );
        
        if ( empty( $importData['attribute_set'] ) || !isset( $productAttributeSets[$importData['attribute_set']] ) ) {
            $value = isset( $importData['attribute_set'] ) ? $importData['attribute_set'] : '';
            $message = Mage :: helper( 'catalog' ) -> __( 'Skip import row, is not valid value "%s" for field "%s"', $value, 'attribute_set' );
            Mage :: throwException( $message );
            } 
        $product -> setAttributeSetId( $productAttributeSets[$importData['attribute_set']] );
        
        foreach ( $this -> _requiredFields as $field ) {
            $attribute = $this -> getAttribute( $field );
            if ( !isset( $importData[$field] ) && $attribute && $attribute -> getIsRequired() ) {
                $message = Mage :: helper( 'catalog' ) -> __( 'Skip import row, required field "%s" for new products not defined', $field );
                Mage :: throwException( $message );
                } 
            } 
        
        if ( $importData['type'] == 'configurable' ) {
            $product -> setCanSaveConfigurableAttributes( true );
            $configAttributeCodes = $this -> userCSVDataAsArray( $importData['config_attributes'] );
            $usingAttributeIds = array();
            foreach( $configAttributeCodes as $attributeCode ) {
                $attribute = $product -> getResource() -> getAttribute( $attributeCode );
                if ( $product -> getTypeInstance() -> canUseAttribute( $attribute ) ) {
                    if ( $new ) { // fix for duplicating attributes error
                        $usingAttributeIds[] = $attribute -> getAttributeId();
                        } 
                    } 
                } 
            if ( !empty( $usingAttributeIds ) ) {
                $product -> getTypeInstance() -> setUsedProductAttributeIds( $usingAttributeIds );
                $product -> setConfigurableAttributesData( $product -> getTypeInstance() -> getConfigurableAttributesAsArray() );
                $product -> setCanSaveConfigurableAttributes( true );
                $product -> setCanSaveCustomOptions( true );
                } 
            if ( isset( $importData['associated'] ) ) {
                $product -> setConfigurableProductsData( $this -> skusToIds( $importData['associated'], $product ) );
                } 
            } 
        
        if ( isset( $importData['related'] ) ) {
            $linkIds = $this -> skusToIds( $importData['related'], $product );
            if ( !empty( $linkIds ) ) {
                $product -> setRelatedLinkData( $linkIds );
                } 
            } 
        
        if ( isset( $importData['upsell'] ) ) {
            $linkIds = $this -> skusToIds( $importData['upsell'], $product );
            if ( !empty( $linkIds ) ) {
                $product -> setUpSellLinkData( $linkIds );
                } 
            } 
        
        if ( isset( $importData['crosssell'] ) ) {
            $linkIds = $this -> skusToIds( $importData['crosssell'], $product );
            if ( !empty( $linkIds ) ) {
                $product -> setCrossSellLinkData( $linkIds );
                } 
            } 
        
        if ( isset( $importData['grouped'] ) ) {
            $linkIds = $this -> skusToIds( $importData['grouped'], $product );
            if ( !empty( $linkIds ) ) {
                $product -> setGroupedLinkData( $linkIds );
                } 
            } 
        
		if ( isset( $importData['category_ids'] ) ) {
			
            $product -> setCategoryIds( $importData['category_ids'] );
            } 
        
        
        if ( isset( $importData['categories'] ) ) {
            
            if ( isset( $importData['store'] ) ) {
                $cat_store = $this -> _stores[$importData['store']];
                } else {
                $message = Mage :: helper( 'catalog' ) -> __( 'Skip import row, required field "store" for new products not defined', $field );
                Mage :: throwException( $message );
                } 
            
            $categoryIds = $this -> _addCategories( $importData['categories'], $cat_store );
            if ( $categoryIds ) {
                $product -> setCategoryIds( $categoryIds );
                } 
            
            } 
        
        foreach ( $this -> _ignoreFields as $field ) {
            if ( isset( $importData[$field] ) ) {
                unset( $importData[$field] );
                } 
            } 
        
        if ( $store -> getId() != 0 ) {
            $websiteIds = $product -> getWebsiteIds();
            if ( !is_array( $websiteIds ) ) {
                $websiteIds = array();
                } 
            if ( !in_array( $store -> getWebsiteId(), $websiteIds ) ) {
                $websiteIds[] = $store -> getWebsiteId();
                } 
            $product -> setWebsiteIds( $websiteIds );
            } 
        
        if ( isset( $importData['websites'] ) ) {
            $websiteIds = $product -> getWebsiteIds();
            if ( !is_array( $websiteIds ) ) {
                $websiteIds = array();
                } 
            $websiteCodes = split( ',', $importData['websites'] );
            foreach ( $websiteCodes as $websiteCode ) {
                try {
                    $website = Mage :: app() -> getWebsite( trim( $websiteCode ) );
                    if ( !in_array( $website -> getId(), $websiteIds ) ) {
                        $websiteIds[] = $website -> getId();
                        } 
                    } 
                catch ( Exception $e ) {
                    } 
                } 
            $product -> setWebsiteIds( $websiteIds );
            unset( $websiteIds );
            } 
			
		
        
        foreach ( $importData as $field => $value ) {
            //if ( in_array( $field, $this -> _inventorySimpleFields ) ) {
            if ( in_array( $field, $this -> _inventoryFields ) ) { 
                continue;
                } 
            if ( in_array( $field, $this -> _imageFields ) ) {
                continue;
                } 
            
            $attribute = $this -> getAttribute( $field );
            if ( !$attribute ) {
                continue;
                } 
            
            $isArray = false;
            $setValue = $value;
            
            if ( $attribute -> getFrontendInput() == 'multiselect' ) {
                $value = split( self :: MULTI_DELIMITER, $value );
                $isArray = true;
                $setValue = array();
                } 
            
            if ( $value && $attribute -> getBackendType() == 'decimal' ) {
                $setValue = $this -> getNumber( $value );
                } 
            
            if ( $attribute -> usesSource() ) {
                $options = $attribute -> getSource() -> getAllOptions( false );
                
                if ( $isArray ) {
                    foreach ( $options as $item ) {
                        if ( in_array( $item['label'], $value ) ) {
                            $setValue[] = $item['value'];
                            } 
                        } 
                    } 
                else {
                    $setValue = null;
                    foreach ( $options as $item ) {
                        if ( $item['label'] == $value ) {
                            $setValue = $item['value'];
                            } 
                        } 
                    } 
                } 
            
            $product -> setData( $field, $setValue );
            } 
        
        if ( !$product -> getVisibility() ) {
            $product -> setVisibility( Mage_Catalog_Model_Product_Visibility :: VISIBILITY_NOT_VISIBLE );
            } 
        
        $stockData = array();
        //$inventoryFields = $product -> getTypeId() == 'simple' ? $this -> _inventorySimpleFields : $this -> _inventoryOtherFields; 
        $inventoryFields = isset($this->_inventoryFieldsProductTypes[$product->getTypeId()])
            ? $this->_inventoryFieldsProductTypes[$product->getTypeId()]
            : array(); 
            
        foreach ( $inventoryFields as $field ) {
        	//secho "entro simple";
            if ( isset( $importData[$field] ) ) {
                if ( in_array( $field, $this -> _toNumber ) ) {
                    $stockData[$field] = $this -> getNumber( $importData[$field] );
                    } 
                else {
                    $stockData[$field] = $importData[$field];
                    } 
                } 
            } 
        $product -> setStockData( $stockData );
        
        $imageData = array();
        foreach ( $this -> _imageFields as $field ) {
            if ( !empty( $importData[$field] ) && $importData[$field] != 'no_selection' ) {
                if ( !isset( $imageData[$importData[$field]] ) ) {
                    $imageData[$importData[$field]] = array();
                    } 
                $imageData[$importData[$field]][] = $field;
                } 
            } 
        
        foreach ( $imageData as $file => $fields ) {
            try {
                $product -> addImageToMediaGallery( Mage :: getBaseDir( 'media' ) . DS . 'import/' . $file, $fields, false );
                } 
            catch ( Exception $e ) {
                } 
            } 
        
        
        
        if ( !empty( $importData['gallery'] ) ) {
            $galleryData = explode( ',', $importData["gallery"] );
            foreach( $galleryData as $gallery_img ) {
                try {
                    $product -> addImageToMediaGallery( Mage :: getBaseDir( 'media' ) . DS . 'import' . $gallery_img, null, false, false );
                    } 
                catch ( Exception $e ) {
                    } 
                } 
            } 



$finrutaimagen = substr($importData['rutaimagen'],strlen(strtolower($importData['rutaimagen']))-5);
$finrutaimagen3 = substr($importData['campo_cinco'],strlen(strtolower($importData['campo_cinco']))-5);
			if ( !($product -> getMediaGalleryImages())  /* Si aún no se ha subido ninguna fotografía */
			|| (($product -> getMediaGalleryImages() -> getSize()==1) && $finrutaimagen=='1.jpg') /* Si se va ha subir la 2ª imagen del producto */
			|| (($product -> getMediaGalleryImages() -> getSize()==2) && $finrutaimagen3=='2.jpg')){	 /* Si se va ha subir la 3ª imagen del producto*/
			
			 //añadido par alas imagenes   
				$ruta = Mage :: getBaseDir( 'media' ) . DS . 'import/' . str_replace("/media/import","",$importData['rutaimagen']); //modificado para pillar la imagen de ELITE
				//print_r($ruta); 
			}
				if (file_exists($ruta)) {
					$mediaAttributes = array ('image','thumbnail','small_image');
					//$product -> addImageToMediaGallery( $ruta , 'image', true );  
					$product ->addImageToMediaGallery($ruta,$mediaAttributes,  false, false );
				 }
        $product -> setIsMassupdate( true );
        $product -> setExcludeUrlRewrite( true );
        $product -> setCategoryIds($categorias);
		$product->setWebsiteIDs(array(1));
        $product -> save();
        
        return true;
        } 
    
    protected function userCSVDataAsArray( $data )
    
    {
       //return explode( ',', str_replace( " ", "", $data ) );
       return explode( ',',$data);
        } 
    
    protected function skusToIds( $userData, $product )
    
    {
        $productIds = array();
        
        foreach ($this->userCSVDataAsArray($userData) as $oneSku ) {
        	//print_r($oneSku);
            if ( ( $a_sku = ( int )$product -> getIdBySku( $oneSku ) ) > 0 ) {

                parse_str( "position=", $productIds[$a_sku] );
                } 
            } 
        return $productIds;
        } 
    
    protected $_categoryCache = array();
    
    protected function _addCategories( $categories, $store )
    
    {
        // $rootId = $store->getRootCategoryId();
        // $rootId = Mage::app()->getStore()->getRootCategoryId();
        $rootId = 2; // our store's root category id
		
        if ( !$rootId ) {
            return array();
            } 
        $rootPath = '1/' . $rootId;
        if ( empty( $this -> _categoryCache[$store -> getId()] ) ) {
            $collection = Mage :: getModel( 'catalog/category' ) -> getCollection()
             -> setStore( $store )
             -> addAttributeToSelect( 'name' );
            $collection -> getSelect() -> where( "path like '" . $rootPath . "/%'" );
            
            foreach ( $collection as $cat ) {
                try {
                    $pathArr = explode( '/', $cat -> getPath() );
                    $namePath = '';
                    for ( $i = 2, $l = sizeof( $pathArr ); $i < $l; $i++ ) {
                        $name = $collection -> getItemById( $pathArr[$i] ) -> getName();
                        $namePath .= ( empty( $namePath ) ? '' : '/' ) . trim( $name );
                        } 
                    $cat -> setNamePath( $namePath );
                    } 
                catch ( Exception $e ) {
                    echo "ERROR: Cat - ";
                    print_r( $cat );
                    continue;
                    } 
                } 
            
            $cache = array();
            foreach ( $collection as $cat ) {
                $cache[strtolower( $cat -> getNamePath() )] = $cat;
                $cat -> unsNamePath();
                } 
            $this -> _categoryCache[$store -> getId()] = $cache;
            } 
        $cache = &$this -> _categoryCache[$store -> getId()];
        
        $catIds = array();
        foreach ( explode( ',', $categories ) as $categoryPathStr ) {
            //COMENTAMOS ESTO PORQUE ESTA DANDO PROBLEMAS CON LAS CATEGORIAS CON S AL FINAL
			$categoryPathStr = preg_replace( '#s*/s*#', '/', trim( $categoryPathStr ) );
            if ( !empty( $cache[$categoryPathStr] ) ) {
                $catIds[] = $cache[$categoryPathStr] -> getId();
                continue;
                } 
            $path = $rootPath;
            $namePath = '';
            foreach ( explode( '/', $categoryPathStr ) as $catName ) {
                $namePath .= ( empty( $namePath ) ? '' : '/' ) . strtolower( $catName );
                if ( empty( $cache[$namePath] ) ) {
                    $cat = Mage :: getModel( 'catalog/category' )
                     -> setStoreId( $store -> getId() )
                     -> setPath( $path )
                     -> setName( $catName )
                     -> setIsActive( 1 )
                     -> save();
                    $cache[$namePath] = $cat;
                    } 
                $catId = $cache[$namePath] -> getId();
                $path .= '/' . $catId;
                } 
            if ( $catId ) {
                $catIds[] = $catId;
                } 
            } 
        return join( ',', $catIds );
        } 
    
    protected function _removeFile( $file )
    
    {
        if ( file_exists( $file ) ) {
            if ( unlink( $file ) ) {
                return true;
                } 
            } 
        return false;
        } 
    }
    

<?php

class Magestore_Manufacturer_Model_Manufacturer extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('manufacturer/manufacturer');
    }
	
	public function getFeaturedManufacturer()
	{
		$listManufacturer = array();
		$activeStoreID =  Mage::app()->getStore()->getId();
		
		$this->_featured_manufacturer_collection = Mage::getResourceModel('manufacturer/manufacturer_collection')
		->addFieldToFilter("store_id",array("=" => $activeStoreID));
		
		foreach($this->_featured_manufacturer_collection as $manufacturer)
		{
			$manufacturer = $manufacturer->loadDataManufacturer($manufacturer);
			if(($manufacturer->getFeatured() == 1) AND ($manufacturer->getStatus() == 1) )
				$listManufacturer[] = $manufacturer;
		}
		//var_dump($listManufacturer);
		return $listManufacturer;
	}
	
	public function _getManufacturersInStock()
	{
		$simple_products = Mage::getModel('catalog/product')->getCollection()
        ->addAttributeToSelect('refproveedor')
		->addAttributeToSelect('manufacturer')
        ->addAttributeToFilter('type_id', Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE) //Tipo Simple
		->addStoreFilter(Mage::app()->getStore()->getId()); //Tienda en la que estemos
		Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($simple_products);
		$manufacturers_in_stock = array();
		foreach($simple_products as $product){
			if (!in_array($product->getData('manufacturer'),$manufacturers_in_stock)){ //si no esta en el listado de marcas
				$manufacturers_in_stock[]=$product->getData('manufacturer'); //insertamos marca del articulo con stock
			}
		}
		//$manufacturers_in_stock[]="646";
		return $manufacturers_in_stock;
	}
	
	
	
	public function getManufacturers($begin)
	{
		$listManufacturer = array();
		
		$activeStoreID =  Mage::app()->getStore()->getId();
		
		$this->_featured_manufacturer_collection = Mage::getResourceModel('manufacturer/manufacturer_collection')
		->addFieldToFilter("name_store",array("like"=>$begin."%"))
		->addFieldToFilter("store_id",array("=" => $activeStoreID))->setOrder('name', 'ASC');
		
	//	$this->_featured_manufacturer_collection ->load();
		$manufacturers_in_stock=$this->_getManufacturersInStock();
		 
		foreach($this->_featured_manufacturer_collection as $manufacturer)
		{
			$manufacturer = $this->loadDataManufacturer($manufacturer);
			
			if($manufacturer->getStatus() ==1){
				$capitalLetter=strtoupper($manufacturer->getManufacturerMagentoName())[0];
				if (is_numeric($capitalLetter)){
					$capitalLetter='#';
				}
				
				if (in_array($manufacturer->getData('option_id'),$manufacturers_in_stock, true)){
					$listManufacturer[$capitalLetter][$manufacturer->getManufacturerMagentoName()]= array($manufacturer,'1');
					
				}else{
					$listManufacturer[$capitalLetter][$manufacturer->getManufacturerMagentoName()]= array($manufacturer,'0');
					
				}
			}
		}
		ksort($listManufacturer);
		$this->_featured_manufacturer_collection = $listManufacturer;
		
		
		return $listManufacturer;
	}
	
	public function getChildrenCategoryHtml($node,  $result = "") {
        if (is_numeric($node)) {
            $node = $this->getNodeById($node);
        }
        if (!$node)
            return $result;

		$result .="<ul>";	
        foreach ($node->getChildren() as $child) {
            
			$result .= "<li>" . $child->getId();
			if ($child->getChildren()) {
				$result .= $this->getChildren($child, $result);
			}
           
		   $result .= "</li>";
            
        }
		$result.="</ul>";
		echo($result);
        return $result;
    }
	
	public function getManufacturerCategories($manufacturer)
	{
		$manufacturer_resource = Mage::getResourceModel('manufacturer/manufacturer');
		$category_ids = $manufacturer_resource->getCategoriesByManufacturer($manufacturer);
		
		$category_model = Mage::getModel('catalog/category');
		
		$categories = array();	
		$listCatID = array();	
		for($i = 0; $i < count($category_ids); $i++)
		{
			$category_ids[$i]['category_id'] = intval($category_ids[$i]['category_id']);
			$categories[$i] = Mage::getModel('catalog/category')->load($category_ids[$i]['category_id']);
			$listCatID[] =  $category_ids[$i]['category_id'];
		}
		
		for($i=0;$i<count($category_ids);$i++)
		{
			$categoryParentID = $categories[$i]->getParentId();
	
			if($categoryParentID > 3)
			{
				$categoryParent = Mage::getModel('catalog/category')->load($categoryParentID);
				
				if(!in_array($categoryParentID,$listCatID))
				{
					$listCatID[] = $categoryParentID;
					$categories[] = $categoryParent;
				}
			}
		}
				
		return $categories;
	}

	
	public function getCategoryProductCount($manufacturer,$category_id)
	{
		$product_count = Mage::getResourceModel('manufacturer/manufacturer')->getCategoryProductCount($manufacturer,$category_id);
		return $product_count;
	}
	
	public function getProductCollection(){
        
		if (is_null($this->_productCollection)) {
			
            $this->_productCollection = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                ->addMinimalPrice()
                ->addTaxPercents()
                ->addStoreFilter();
								
                Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($this->_productCollection);
                Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($this->_productCollection);						
        }
		
		//$this->_productCollection->load();
		
        return $this->_productCollection;
    }
	
	public function addFilters($catid=null,$id=null)
	{	
		$reference_attribute_code = Mage::helper('manufacturer')->getAttributeCode();
		if($id)
		{			
			$manufactuerer = Mage::getSingleton("manufacturer/manufacturer")->load($id);
			$option_id = Mage::getResourceModel("manufacturer/manufacturer")->getManufacturerOptionIdByName($manufactuerer->getName());
			$this->getProductCollection()->addFieldToFilter($reference_attribute_code,$option_id);
		}
		
		if(is_numeric($catid))
		{						
			$category = Mage::getModel("catalog/category")->load($catid);
			if($category)
				$this->getProductCollection()->addCategoryFilter($category);
		}
		
	}
	
	public function updateUrlKey()
	{	
		$id = $this->getId();
		$url_key = $this->getData('url_key');	
		$urlrewrite = Mage::getModel("manufacturer/urlrewrite")->load("manufacturer/".$id,"id_path");
		/*
		$urlrewrite = Mage::getModel("manufacturer/urlrewrite")->load("manufacturer/".$id,"id_path");
		$oldUrlrewrite =  Mage::getModel("manufacturer/urlrewrite")->load($url_key,"request_path");
		if($oldUrlrewrite->getId()){
			if(!$urlrewrite->getId())
				$oldUrlrewrite->delete();				
			elseif($oldUrlrewrite->getId() != $urlrewrite->getId())
				$oldUrlrewrite->delete();
		}	
		*/
		//set urlKey 
		//
		//{
			//get a random product
		if($this->getData('store_id')==0)
		{
			$product_id = Mage::getResourceModel("manufacturer/manufacturer")->getFirstProductId();
			$urlrewrite->setData("id_path","manufacturer/".$id);
			$urlrewrite->setData("request_path",$this->getData('url_key'));
		
			$urlrewrite->setData("target_path",'manufacturer/index/view/id/'. $id );
			$urlrewrite->setData("product_id",$product_id);
			//var_dump($urlrewrite);
			//die();		
			try{
			
				$urlrewrite->save();				
			} catch (Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());	
			}
		}
	}
	
	function deleteStore()
	{
		Mage::getResourceModel("manufacturer/manufacturer")->deleteStore($this);
	}
	
	function loadDataManufacturer($manufacturer)
	{
		if($manufacturer->getData('store_id') != 0)
		{
			$adminManufacturer = Mage::getResourceModel('manufacturer/manufacturer')->getStoreManufacturer($manufacturer->getId(),0);
			if($manufacturer->getData('default_name_store'))
				$manufacturer->setData('name_store',$adminManufacturer->getData('name'));
			if($manufacturer->getData('default_page_title'))
				$manufacturer->setData('page_title',$adminManufacturer->getData('page_title'));
			if($manufacturer->getData('default_description'))
				$manufacturer->setData('description',$adminManufacturer->getData('description'));
			if($manufacturer->getData('default_meta_keywords'))
				$manufacturer->setData('meta_keywords',$adminManufacturer->getData('meta_keywords'));
			if($manufacturer->getData('default_meta_description'))
				$manufacturer->setData('meta_description',$adminManufacturer->getData('meta_description'));				
			if($manufacturer->getData('default_status'))		
				$manufacturer->setData('status',$adminManufacturer->getData('status'));		
			if($manufacturer->getData('default_featured'))
				$manufacturer->setData('featured',$adminManufacturer->getData('featured'));
			if($manufacturer->getData('default_image'))
				$manufacturer->setData('image',$adminManufacturer->getData('image'));	
			if($manufacturer->getData('default_description_short'))
				$manufacturer->setData('description_short',$adminManufacturer->getData('description_short'));					
			if($manufacturer->getData('default_titulodesc1'))
				$manufacturer->setData('titulodesc1',$adminManufacturer->getData('titulodesc1'));
			if($manufacturer->getData('default_descripcion1'))
				$manufacturer->setData('descripcion1',$adminManufacturer->getData('descripcion1'));
			if($manufacturer->getData('default_titulodesc2'))
				$manufacturer->setData('titulodesc2',$adminManufacturer->getData('titulodesc2'));
			if($manufacturer->getData('default_descripcion2'))
				$manufacturer->setData('descripcion2',$adminManufacturer->getData('descripcion2'));
			if($manufacturer->getData('default_genero'))
				$manufacturer->setData('genero',$adminManufacturer->getData('genero'));
			if($manufacturer->getData('default_idlinea1'))
				$manufacturer->setData('idlinea1',$adminManufacturer->getData('idlinea1'));
			if($manufacturer->getData('default_idlinea2'))
				$manufacturer->setData('idlinea2',$adminManufacturer->getData('idlinea2'));
			if($manufacturer->getData('default_idlinea3'))
				$manufacturer->setData('idlinea3',$adminManufacturer->getData('idlinea3'));
			if($manufacturer->getData('default_idlinea4'))
				$manufacturer->setData('idlinea4',$adminManufacturer->getData('idlinea4'));
			if($manufacturer->getData('default_theicons'))
				$manufacturer->setData('theicons',$adminManufacturer->getData('theicons'));
			if($manufacturer->getData('default_imagemanufacturer2'))
				$manufacturer->setData('imagemanufacturer2',$adminManufacturer->getData('imagemanufacturer2'));
			if($manufacturer->getData('default_imagelinea1'))
				$manufacturer->setData('imagelinea1',$adminManufacturer->getData('imagelinea1'));
			if($manufacturer->getData('default_imagelinea2'))
				$manufacturer->setData('imagelinea2',$adminManufacturer->getData('imagelinea2'));
			if($manufacturer->getData('default_imagelinea3'))
				$manufacturer->setData('imagelinea3',$adminManufacturer->getData('imagelinea3'));
			if($manufacturer->getData('default_imagelinea4'))
				$manufacturer->setData('imagelinea4',$adminManufacturer->getData('imagelinea4'));
			if($manufacturer->getData('default_imagerunway'))
				$manufacturer->setData('imagerunway',$adminManufacturer->getData('imagerunway'));
			if($manufacturer->getData('default_idsubcat'))
				$manufacturer->setData('idsubcat',$adminManufacturer->getData('idsubcat'));
			if($manufacturer->getData('default_newdesigner'))
				$manufacturer->setData('newdesigner',$adminManufacturer->getData('newdesigner'));
			if($manufacturer->getData('default_genero'))
				$manufacturer->setData('genero',$adminManufacturer->getData('genero'));
			if($manufacturer->getData('default_tipologia'))
				$manufacturer->setData('tipologia',$adminManufacturer->getData('tipologia'));
		}
		
		return $manufacturer;
	}
	
	public function getUrlKey()
	{
		//$activeStoreID =  Mage::app()->getStore()->getId();
		$storeManu = Mage::getResourceModel('manufacturer/manufacturer')->getStoreManufacturer($this->getId(),0);
		
		return $storeManu->getData('url_key');
	}
	
	public function getManufacturerID($adminManufacturerID)
	{
		$activeStoreID =  Mage::app()->getStore()->getId();
		$manufacturer = Mage::getResourceModel('manufacturer/manufacturer')->getStoreManufacturer($adminManufacturerID,$activeStoreID);
		
		return $manufacturer->getId();	
	}
	
	public function getManufacturerMagentoName()
	{
		$resource = Mage::getSingleton('core/resource');
     	$readConnection = $resource->getConnection('core_read');
		$query = 'SELECT Option_id FROM ' . $resource->getTableName('manufacturer/manufacturer').' WHERE name_store LIKE "'.$this->getData('name_store').'"';
		$manufacturerId = $readConnection->fetchOne($query);
		return Mage::getModel('catalog/product')->getResource()->getAttribute("manufacturer")->getSource()->getOptionText($manufacturerId);
		
	}
	/*
	public function getFeatured()
	{
		$manufacturer = Mage::getResourceModel('manufacturer/manufacturer')->getStoreManufacturer($this->getId(),0);
		
		return $manufacturer->getData('featured');	
	}	

	public function getStatus()
	{
		$manufacturer = Mage::getResourceModel('manufacturer/manufacturer')->getStoreManufacturer($this->getId(),0);
		
		return $manufacturer->getData('status');	
	}		
	
	public function getImage()
	{
		$storeManu = Mage::getResourceModel('manufacturer/manufacturer')->getStoreManufacturer($this->getId(),0);
		
		return $storeManu->getData('image');		
	}
	*/
}
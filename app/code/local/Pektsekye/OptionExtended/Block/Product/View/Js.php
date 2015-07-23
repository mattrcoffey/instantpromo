<?php
class Pektsekye_OptionExtended_Block_Product_View_Js extends  Mage_Catalog_Block_Product_View_Options
{
	protected $config = array();
	protected $thumbnailDirUrl = '';		
	protected $pickerImageDirUrl = '';
				
	protected function _construct()
    { 	
    
		$children = array();		
		$sd = array();	
		$configValues = array();
		$inPreConfigured = $this->getProduct()->hasPreconfiguredValues();
		$storeId = Mage::app()->getStore()->getId();						
		$product_id = $this->getProduct()->getId();
		$filter = Mage::getModel('core/email_template_filter');


		$options = $this->getProduct()->getOptions();

		foreach ($options as $option){
		  if (!is_null($option->getLayout())){
			  $id = (int) $option->getOptionId();
			  	
			  if (!is_null($option->getRowId()))					
				  $option_id_by_row_id[$option->getTemplateId()][(int) $option->getRowId()] = $id;

			  $this->config[0][$id][0] = $option->getNote() != '' ? $filter->filter($option->getNote()) : '';	
			  $this->config[0][$id][1] = $option->getLayout();					
			  $this->config[0][$id][2] = (int) $option->getPopup();	
			  
				if ($inPreConfigured){
					$configValues[$id] = array();			
					if (is_null($option->getRowId())){
						$configValue = $this->getProduct()->getPreconfiguredValues()->getData('options/' . $id);	
						if (!is_null($configValue))
							$configValues[$id] = (array) $configValue;					
					}
				} else { 
					$sd[$option->getTemplateId()][$id] = explode(',', $option->getSelectedByDefault());
				}	

				
			  if (!is_null($option->getValues())){			  			  
		      foreach ($option->getValues() as $value) {
			      $valueId = (int) $value->getOptionTypeId();
			      $this->prepareImages($value->getImage());	
			      
			      $rowId = (int) $value->getRowId();				      		
				    $valueId_by_row_id[$value->getTemplateId()][$rowId] = $valueId;
            				    
			      $children[$value->getTemplateId()][$valueId] = explode(',', $value->getChildren());						
			      $this->config[1][$valueId][0] = $value->getImage();						
			      $this->config[1][$valueId][1] = $value->getDescription() != '' ? $filter->filter($value->getDescription()) : '';	
			      $this->config[1][$valueId][2] = array();	
			      $this->config[1][$valueId][3] = array();				
		      }
			  }		
			}		  						
		}

				
		$options = Mage::getModel('optionextended/option')
			->getCollection()
			->joinNotes($storeId)				
			->addFieldToFilter('product_id', $product_id);		
		foreach ($options as $option){
			$id = (int) $option->getOptionId();
		
			if (!is_null($option->getRowId()))					
				$option_id_by_row_id['orig'][(int) $option->getRowId()] = $id;
	
			$this->config[0][$id][0] = $option->getNote() != '' ? $filter->filter($option->getNote()) : '';	
			$this->config[0][$id][1] = $option->getLayout();					
			$this->config[0][$id][2] = (int) $option->getPopup();	
			
			if ($inPreConfigured){
				$configValues[$id] = array();			
				if (is_null($option->getRowId())){
					$configValue = $this->getProduct()->getPreconfiguredValues()->getData('options/' . $id);	
					if (!is_null($configValue))
						$configValues[$id] = (array) $configValue;					
				}
			} else { 
				$sd['orig'][$id] = explode(',', $option->getSelectedByDefault());
			}			
							  						
		}	
		
		$values = Mage::getModel('optionextended/value')
			->getCollection()
			->joinDescriptions($storeId)				
			->addFieldToFilter('product_id', $product_id);	
		foreach ($values as $value) {
			$valueId = (int) $value->getOptionTypeId();
			$this->prepareImages($value->getImage());	
			
			$rowId = (int) $value->getRowId();							
			$valueId_by_row_id['orig'][$rowId] = $valueId;
      			
			$children['orig'][$valueId] = explode(',', $value->getChildren());						
			$this->config[1][$valueId][0] = $value->getImage();						
			$this->config[1][$valueId][1] = $value->getDescription() != '' ? $filter->filter($value->getDescription()) : '';	
			$this->config[1][$valueId][2] = array();	
			$this->config[1][$valueId][3] = array();				
		}	




		if ($inPreConfigured){
			foreach ($configValues as $optionId => $v){
				$this->config[0][$optionId][3] = array();			
				foreach($v as $valueId)
						$this->config[0][$optionId][3][] = (int) $valueId;						  		
			}		
		} else {		
			foreach ($sd as $templateId => $v){	
				foreach ($v as $optionId => $vv){
					$this->config[0][$optionId][3] = array();			  		
					foreach($vv as $rowId)
						if ($rowId != '')
							$this->config[0][$optionId][3][] = $valueId_by_row_id[$templateId][(int)$rowId];
				}
			}
		}


		foreach ($children as $templateId => $v){
		  foreach ($v as $valueId => $vv){
			  foreach ($vv as $rowId){
		      if ($rowId != ''){
				    if (isset($option_id_by_row_id[$templateId][(int)$rowId]))
					    $this->config[1][$valueId][2][] = $option_id_by_row_id[$templateId][(int)$rowId];
				    else				
					    $this->config[1][$valueId][3][] = $valueId_by_row_id[$templateId][(int)$rowId];	
					}					
			  }
		  }
		}		

	}
	
	
	
    public function getConfig()
    { 	
		return Zend_Json::encode($this->config);
    }
	
	
    public function prepareImages($image)
    { 	
		if ($image){
			$thumbnailUrl = $this->makeThumbnail($image);			
			$pickerImageUrl = $this->makePickerImage($image);
			if ($this->thumbnailDirUrl == ''){
				$this->thumbnailDirUrl = str_replace($image, '', $thumbnailUrl);					
				$this->pickerImageDirUrl = str_replace($image, '', $pickerImageUrl);								
			}	
		}
	}
		
		
    public function makeThumbnail($image)
    { 	
		$thumbnailUrl = $this->helper('catalog/image')
			->init($this->getProduct(), 'thumbnail', $image)
			->keepFrame(true)
// Uncomment the following line to set Thumbnail RGB Background Color:
//			->backgroundColor(array(246,246,246))	

// Set Thumbnail Size:			
			->resize(100,100)
			->__toString();
		return $thumbnailUrl;
	}		
		
		
    public function makePickerImage($image)
    { 	
			$pickerImageUrl = $this->helper('catalog/image')
				->init($this->getProduct(), 'thumbnail', $image)
				->keepFrame(false)
				->resize(50,50)
				->__toString();			
			return $pickerImageUrl;
		}	
		
    public function getThumbnailDirUrl()
    { 			
			return $this->thumbnailDirUrl;
	 	}	
	
	
    public function getPickerImageDirUrl()
    { 			
			return $this->pickerImageDirUrl;
	 	}

    public function getPlaceholderUrl()
    {
			return Mage::getDesign()->getSkinUrl($this->helper('catalog/image')->init($this->getProduct(), 'small_image')->getPlaceholder());
	 	}	
	
	
    public function getProductBaseMediaUrl()
    { 			
			return Mage::getSingleton('catalog/product_media_config')->getBaseMediaUrl();
	 	}	
	
    public function getInPreconfigured()
    { 			
			return $this->getProduct()->hasPreconfiguredValues() ? 'true' : 'false';
	 	}	
	 	
	 	
}

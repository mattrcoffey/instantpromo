<?php

class Pektsekye_OptionExtended_Model_Quote extends Mage_Sales_Model_Quote
{
    /**
     * Add product to quote
     *
     * return error message if product type instance can't prepare product
     *
     * @param   mixed $product
     * @return  Mage_Sales_Model_Quote_Item || string
     */
    public function addProduct(Mage_Catalog_Model_Product $product, $request=null)
    {
		  if ($product->getRequiredOptions() && $request != null && isset($request['options'])){		
			  foreach ($product->getOptions() as $option) 
				  $option->setIsRequire(false);		  
		  }
		
		  return parent::addProduct($product, $request);
    }
    
    /**
     * Advanced func to add product to quote - processing mode can be specified there.
     * Returns error message if product type instance can't prepare product.
     *
     * @param mixed $product
     * @param null|float|Varien_Object $request
     * @param null|string $processMode
     * @return Mage_Sales_Model_Quote_Item|string
     */    
    public function addProductAdvanced(Mage_Catalog_Model_Product $product, $request = null, $processMode = null)
    {
		  if ($product->getRequiredOptions() && $request != null && isset($request['options'])){		
			  foreach ($product->getOptions() as $option) 
				  $option->setIsRequire(false);		  
		  }
		  
		  return parent::addProductAdvanced($product, $request, $processMode);    
    }

}

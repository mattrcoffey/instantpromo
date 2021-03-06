<?php

/**
 * RocketWeb
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   RocketWeb
 * @package    RocketWeb_GoogleBaseFeedGenerator
 * @copyright  Copyright (c) 2012 RocketWeb (http://rocketweb.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     RocketWeb
 */

class RocketWeb_GoogleBaseFeedGenerator_Model_Map_Product_Bundle extends RocketWeb_GoogleBaseFeedGenerator_Model_Map_Product_Abstract
{
    public function getPrice($product = null)
    {
    	if (is_null($product)) {
    		$product = $this->getProduct();
    	}
    	
   		$price = $this->calcMinimalPrice($product);
    	
    	if ($price <= 0) {
			$this->skip = true;
			if ($this->getConfigVar('log_skip')) {
    			$this->log(sprintf("product id %d product sku %s, skipped - can't determine the minimal price: '%s'.", $product->getId(), $product->getSku(), $price));
    		}
		}
    	
    	return $price;
    }
    
    public function calcMinimalPrice($product) {
		$price = 0.0;
		if ($this->getConfig()->compareMagentoVersion(array('major' => 1, 'minor' => 6, 'revision' => 0, 'patch' => 0))) {
			$_prices = $product->getPriceModel()->getTotalPrices($product);
		} else {
			$_prices = $product->getPriceModel()->getPrices($product);
		}
		if (is_array($_prices)) {
			$price = min($_prices);
		} else {
			$price = $_prices;
		}

		//return $product->getMinimalPrice();
		return $price;
    }
    
    public function getSpecialPrice($product = null)
    {
    	if (is_null($product)) {
    		$product = $this->getProduct();
    	}
    	
    	$price = $this->calcMinimalPrice($product);
    	$special_price_percent = $product->getSpecialPrice();
    	if ($special_price_percent <= 0 || $special_price_percent > 100)
    		return 0;
    	$special_price = (($special_price = (100 - $special_price_percent) * $price / 100) > 0 ? $special_price : 0);
    	return $special_price;
    }
}
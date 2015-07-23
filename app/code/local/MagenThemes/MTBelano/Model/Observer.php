<?php
/**
 *
 * ------------------------------------------------------------------------------
 * @category     MT
 * @package      MT_Themes
 * ------------------------------------------------------------------------------
 * @copyright    Copyright (C) 2008-2013 MagentoThemes.net. All Rights Reserved.
 * @license      GNU General Public License version 2 or later;
 * @author       MagentoThemes.net
 * @email        support@magentothemes.net
 * ------------------------------------------------------------------------------
 *
 */
?>
<?php
/**
 * Call actions after configuration is saved
 */
class MagenThemes_MTBelano_Model_Observer
{
	/**
     * After any system config is saved
     */
	public function configSave()
	{
		$section = Mage::app()->getRequest()->getParam('section');
		if ($section == 'mtbelano_design')
		{
			$websiteCode = Mage::app()->getRequest()->getParam('website');
			$storeCode = Mage::app()->getRequest()->getParam('store');
			
			Mage::getSingleton('mtbelano/cssgen_generator')->generateCss('design', $websiteCode, $storeCode);
        }else if($section == 'mtbelano'){
            $websiteCode = Mage::app()->getRequest()->getParam('website');
            $storeCode = Mage::app()->getRequest()->getParam('store');

            Mage::getSingleton('mtbelano/cssgen_generator')->generateCss('layout', $websiteCode, $storeCode);
        }
	}
	
	/**
     * After store view is saved
     */
	public function storeEdit(Varien_Event_Observer $observer)
	{
		$store = $observer->getEvent()->getStore();
		$storeCode = $store->getCode();
		$websiteCode = $store->getWebsite()->getCode();

		Mage::getSingleton('mtbelano/cssgen_generator')->generateCss('design', $websiteCode, $storeCode);
        Mage::getSingleton('mtbelano/cssgen_generator')->generateCss('layout', $websiteCode, $storeCode);
	}
    public function catalogBlockProductCollectionBeforeToHtml(Varien_Event_Observer $observer)
    {
        $productCollection = $observer->getEvent()->getCollection();
        if ($productCollection instanceof Varien_Data_Collection) {
            $productCollection->load();
            Mage::getModel('mtbelano/collection')->appendType($productCollection);
        }

        return $this;
    }
	public function setPrevNextProductCollection()
    {
        if (Mage::app()->getRequest()->getControllerName() == 'category' && Mage::app()->getRequest()->getActionName() == 'view') {

            $products = Mage::app()->getLayout()
                ->getBlockSingleton('Mage_Catalog_Block_Product_List')
                ->getLoadedProductCollection()
                ->getColumnValues('entity_id');
            Mage::getSingleton('core/session')->setPrevNextProductCollection($products);
            unset($products);
        }
        return $this;
    }
}

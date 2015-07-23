<?php

class TM_EasyTabs_Block_Tabs extends Mage_Catalog_Block_Product_View_Tabs
{
    protected function _getCollection()
    {
        $collection = new TM_EasyTabs_Model_Config_Collection();
        $storeId    = Mage::app()->getStore()->getStoreId();
        return $collection
            ->setOrder('sort_order', Varien_Data_Collection::SORT_ORDER_ASC)
            ->addFieldToFilter('status', array('eq' => 1))
            ->addFieldToFilter('store_id', array('in' => array($storeId, 0)));
    }

    protected function _prepareLayout()
    {
        if (!Mage::getStoreConfig('tm_easytabs/general/enabled')) {
            return parent::_prepareLayout();
        }
        foreach ($this->_getCollection() as $tab) {
            $this->addTab(
                $tab->getAlias(),
                $tab->getTitle(),
                $tab->getBlock(),
                $tab->getTemplate(),
                $tab->getData()
//                array('custom_option' => $tab->getCustomOption())
            );

            //remove
            $unset = $tab->getUnset();
            if (false !== strpos($unset, '::')) {
                list($blockName, $alias) = explode('::', $unset);
                $block = $this->getLayout()->getBlock($blockName);
                if ($block) {
                    $block->unsetChild($alias);
                }
            }
        }
        return parent::_prepareLayout();
    }

    public function addTab($alias, $title, $block, $template, $attributes = array())
    {
        if (!$title || !$block || !$template) {
            return false;
        }

        $this->_tabs[] = array(
            'alias' => $alias,
            'title' => $title
        );

        $this->setChild($alias,
            $this->getLayout()
                ->createBlock($block, $alias, $attributes)
                ->setTemplate($template)
        );
    }
}

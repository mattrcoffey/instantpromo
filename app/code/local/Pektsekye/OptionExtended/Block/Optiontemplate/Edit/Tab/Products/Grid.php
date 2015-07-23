<?php

class Pektsekye_OptionExtended_Block_Optiontemplate_Edit_Tab_Products_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_productIds = array();   

    public function __construct()
    {
        parent::__construct();
        $this->setId('optionextended_edit_tab_products_grid');
        $this->setRowClickCallback('optionExtended.productGridRowClick.bind(optionExtended)');
        $this->setCheckboxCheckCallback('optionExtended.productGridCheckboxCheck.bind(optionExtended)');	              		  
        $this->setDefaultSort('product_id_filter');
        $products = $this->getSelectedProducts();
        if (!empty($products)){
          $this->setDefaultFilter(array('in_products'=>1));      
        }  
        $this->setUseAjax(true);   
    }
	
    protected function _addColumnFilterToCollection($column)
    {

        if ($column->getId() == 'in_products') {
            $productIds = $this->getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$productIds));
            }
            else {
                $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$productIds));
            }
        }
        else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

	 
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->setStore($this->getStore())
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('attribute_set_id');

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }


    protected function _prepareColumns()
    {
        $this->addColumn('in_products', array(
            'header_css_class' => 'a-center',
            'type'      => 'checkbox',
            'name'      => 'in_products',
            'values'    => $this->getSelectedProducts(),
            'align'     => 'center',
            'index'     => 'entity_id'
        ));
        
        $this->addColumn('product_id_filter',
            array(
                'header'=> Mage::helper('catalog')->__('ID'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'entity_id',
        )); 
		  
        $this->addColumn('name', array(
            'header'    => Mage::helper('sales')->__('Product Name'),
            'index'     => 'name',
            'column_css_class'=> 'name'
        ));

        $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
            ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
            ->load()
            ->toOptionHash();

        $this->addColumn('set_name',
            array(
                'header'=> Mage::helper('catalog')->__('Attrib. Set Name'),
                'width' => '100px',
                'index' => 'attribute_set_id',
                'type'  => 'options',
                'options' => $sets,
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('sales')->__('SKU'),
            'width'     => '80px',
            'index'     => 'sku',
            'column_css_class'=> 'sku'
        ));
        
        $this->addColumn('type_id',
            array(
                'header'=> Mage::helper('catalog')->__('Type'),
                'width' => '60px',
                'index' => 'type_id',
                'type'  => 'options',
                'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));
        
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('adminhtml')->__('Action'),
                'width'     => '40',               
                'type'      => 'action',
                'getter'    => 'getId',                
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('adminhtml')->__('View'),
                        'url'       => array('base'=> '*/catalog_product/edit', 'params' => array('tab'=>'product_info_tabs_customer_options')),
                        'field'     => 'id',
                        'target'=>	'_blank'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'is_system' => true,
        ));
        
        return parent::_prepareColumns();
    }   

    
    public function getGridUrl()
    {
        return $this->getUrl('*/*/productsGrid', array('_current'=>true));
    }  

    protected function getSelectedProducts()
    {
        if ($products = $this->getRequest()->getPost('products', null)) {
            return $products;
        } else {
            return Mage::registry('current_template')->getProductIds();
        }
    }


}


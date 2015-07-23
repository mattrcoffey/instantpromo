<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:24 PM
 */
class Instant_Packages_Block_Adminhtml_Package_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
{
    parent::__construct();
    $this->setId('packageGrid');
    // This is the primary key of the database
    $this->setDefaultSort('row_id');
    $this->setDefaultDir('ASC');
    $this->setSaveParametersInSession(true);
    $this->setUseAjax(true);
}

    protected function _prepareCollection()
{
    $collection = Mage::getModel('package/package')->getCollection();

    $this->setCollection($collection);

    return parent::_prepareCollection();
}

    protected function _prepareColumns()
{

    $this->addColumn('title', array(
        'header'    => Mage::helper('packages')->__('Title'),
        'align'     =>'left',
        'index'     => 'title',
    ));

    $this->addColumn('status', array(

        'header'    => Mage::helper('packages')->__('Status'),
        'align'     => 'left',
        'width'     => '80px',
        'index'     => 'status',
        'type'      => 'options',
        'options'   => array(
            1 => 'Active',
            0 => 'Inactive',
        ),
    ));

    $this->addColumn('action',
        array(
            'header' => Mage::helper('packages')->__('Action'),
            'width' => '100',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('packages')->__('Edit'),
                    'url' => array('base'=> '*/*/edit'),
                    'field' => 'id'
                )),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'is_system' => true,
        ));


    return parent::_prepareColumns();
}

    public function getRowUrl($row)
{
    return $this->getUrl('*/adminhtml_size/index', array('row_id' => $row->getId()));
}

    public function getGridUrl()
{
    return $this->getUrl('*/*/grid', array('_current'=>true));
}


}
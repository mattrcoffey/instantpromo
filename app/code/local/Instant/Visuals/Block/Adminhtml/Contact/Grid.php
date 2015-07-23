<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:24 PM
 */
class Instant_Visuals_Block_Adminhtml_Contact_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
{
    parent::__construct();
    $this->setId('contactGrid');
    // This is the primary key of the database
    $this->setDefaultSort('row_id');
    $this->setDefaultDir('ASC');
    $this->setSaveParametersInSession(true);
    $this->setUseAjax(true);
}

    protected function _prepareCollection()
{
    $collection = Mage::getModel('contact/contact')->getCollection();

    $this->setCollection($collection);

    return parent::_prepareCollection();
}

    protected function _prepareColumns()
{

    $this->addColumn('name', array(
        'header'    => Mage::helper('visuals')->__('Name'),
        'align'     =>'left',
        'index'     => 'name',
    ));
    $this->addColumn('company', array(
        'header'    => Mage::helper('visuals')->__('company'),
        'align'     =>'left',
        'index'     => 'company',
    ));

    $this->addColumn('package', array(
        'header'    => Mage::helper('visuals')->__('Package'),
        'align'     =>'left',
        'index'     => 'package',
    ));
    $this->addColumn('size', array(
        'header'    => Mage::helper('visuals')->__('size'),
        'align'     =>'left',
        'index'     => 'size',
    ));

    $this->addColumn('date_needed', array(
        'header'    => Mage::helper('visuals')->__('Date Required'),
        'align'     =>'left',
        'index'     => 'date_needed',
    ));

    $this->addColumn('status', array(

        'header'    => Mage::helper('visuals')->__('Respond'),
        'align'     => 'left',
        'width'     => '80px',
        'index'     => 'status',
        'type'      => 'options',
        'options'   => array(
            1 => 'Yes',
            0 => 'Not Yet',
        ),
    ));



    return parent::_prepareColumns();
}

    public function getRowUrl($row)
{

    return $this->getUrl('*/*/view', array('contact_id' => $row->getId()));
}

    public function getGridUrl()
{
    return $this->getUrl('*/*/grid', array('_current'=>true));
}


}
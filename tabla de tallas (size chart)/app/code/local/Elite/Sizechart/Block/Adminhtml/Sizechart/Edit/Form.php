<?php
class Elite_Sizechart_Block_Adminhtml_Sizechart_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('sizechart_form', array('legend'=>Mage::helper('sizechart')->__('Item information')));
        $fieldset->addField('tallaje', 'text', array(
        'label' => Mage::helper('sizechart')->__('tallaje'),
        'class' => 'required-entry',
        'required' => true,
        'name' => 'tallaje',
        ));
        $fieldset->addField('status', 'select', array(
        'label' => Mage::helper('sizechart')->__('Status'),
        'name' => 'status',
        'values' => array(
        array(
        'value' => 1,
        'label' => Mage::helper('sizechart')->__('Active'),
        ),
        array(
        'value' => 0,
        'label' => Mage::helper('sizechart')->__('Inactive'),
        ),
        ),
        ));
        $fieldset->addField('talla', 'editor', array(
        'name' => 'talla',
        'label' => Mage::helper('sizechart')->__('talla'),
        'title' => Mage::helper('sizechart')->__('talla'),
        'style' => 'width:98%; height:400px;',
        'wysiwyg' => false,
        'required' => true,
        ));
        if ( Mage::getSingleton('adminhtml/session')->getsizechartData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getsizechartData());
            Mage::getSingleton('adminhtml/session')->setsizechartData(null);
        } elseif ( Mage::registry('sizechart_data') ) {
            $form->setValues(Mage::registry('sizechart_data')->getData());
        }
        return parent::_prepareForm();
    }
}
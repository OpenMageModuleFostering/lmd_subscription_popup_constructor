<?php

/**
 * Created by PhpStorm.
 * User: dev
 * Date: 24.07.14
 * Time: 15:17
 */
class LMD_EasyPromoLightBox_Block_Adminhtml_Form_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {

        if (Mage::registry('lmd_easypromolightbox')) {
            $data = Mage::registry('lmd_easypromolightbox')->getData();
        }

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ));

        $form->setUseContainer(true);

        $this->setForm($form);

        $fieldset = $form->addFieldset('lightbox_form', array(
            'legend' => Mage::helper('adminhtml')->__('Notification Edit')
        ));

        $fieldset->addField('notification_name', 'text', array(
            'label' => Mage::helper('adminhtml')->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'notification_name',
            'note' => Mage::helper('adminhtml')->__('The name of lightbox. Will not be shown on frontend.'),
        ));

        $fieldset->addField('is_active', 'select', array(
            'options' => array('1' => 'Yes',
                '0' => 'No'),
            'label' => Mage::helper('adminhtml')->__('Active'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'is_active',
        ));

        $fieldset->addField('title_text', 'text', array(
            'label' => Mage::helper('adminhtml')->__('Title text'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title_text',
            'note' => Mage::helper('adminhtml')->__('Notification title.'),
        ));

        $fieldset->addField('title_text_color', 'text', array(
            'label' => Mage::helper('adminhtml')->__('Title text color'),
            'class' => 'required-entry color',
            'required' => true,
            'name' => 'title_text_color',
            'note' => Mage::helper('adminhtml')->__('HEX color code here.'),
        ));

        $fieldset->addField('notification_text', 'text', array(
            'label' => Mage::helper('adminhtml')->__('Notification text'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'notification_text',
            'note' => Mage::helper('adminhtml')->__('Notification text.'),
        ));

        $fieldset->addField('notification_text_color', 'text', array(
            'label' => Mage::helper('adminhtml')->__('Notification text color'),
            'class' => 'required-entry color',
            'required' => true,
            'name' => 'notification_text_color',
            'note' => Mage::helper('adminhtml')->__('HEX color code here.'),
        ));

        $fieldset->addField('body_type', 'select', array(
            'options' => array('1' => 'Color',
                '0' => 'Picture'),
            'label' => Mage::helper('adminhtml')->__('Background type'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'body_type',
            'onchange' => 'showhide(this)',
            'note' => Mage::helper('adminhtml')->__('Select type of background.'),
        ));

        $fieldset->addField('body_color', 'text', array(
            'label' => Mage::helper('adminhtml')->__('Background color'),
            'required' => false,
            'class' => 'color, required-entry',
            'name' => 'body_color',
            'note' => Mage::helper('adminhtml')->__('HEX color code here.'),
        ));

        if ($data['body_type'] == 0 || !$data) {
            $fieldset->addField('body_picture', 'image', array(
                'label' => Mage::helper('adminhtml')->__('Background picture'),
                'required' => false,
                'class' => 'color, required-entry',
                'name' => 'body_picture',
                'note' => Mage::helper('adminhtml')->__('Upload Your picture. NOTE: cyrillic names not allowed!'),
                'after_element_html' => "<script type=\"text/javascript\">
                                                    $('body_color').up(1).setStyle({display: 'none'});
                                        </script>"
            ));
        } else {
            $fieldset->addField('body_picture', 'image', array(
                'label' => Mage::helper('adminhtml')->__('Background picture'),
                'required' => false,
                'name' => 'body_picture',
                'note' => Mage::helper('adminhtml')->__('Upload Your picture. NOTE: cyrillic names not allowed!'),
                'after_element_html' => "<script type=\"text/javascript\">
                                                    $('body_picture').up(1).setStyle({display: 'none'});
                                        </script>"
            ));
        }

        $fieldset->addField('button_text', 'text', array(
            'label' => Mage::helper('adminhtml')->__('Button text'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'button_text',
            'note' => Mage::helper('adminhtml')->__('Text on button.'),
        ));

        $fieldset->addField('button_color', 'text', array(
            'label' => Mage::helper('adminhtml')->__('Button color'),
            'class' => 'required-entry color',
            'required' => true,
            'name' => 'button_color',
            'note' => Mage::helper('adminhtml')->__('HEX color code here.'),
        ));

        $fieldset->addField('notification_height', 'text', array(
            'label' => Mage::helper('adminhtml')->__('Notification height'),
            'class' => 'required-entry validate-digits',
            'required' => true,
            'name' => 'notification_height',
            'note' => Mage::helper('adminhtml')->__('In pixels.'),
        ));

        $fieldset->addField('notification_width', 'text', array(
            'label' => Mage::helper('adminhtml')->__('Notification width'),
            'class' => 'required-entry validate-digits',
            'required' => true,
            'name' => 'notification_width',
            'note' => Mage::helper('adminhtml')->__('In pixels.'),
        ));

        $fieldset->addField('cookies_lifetime', 'text', array(
            'label' => Mage::helper('adminhtml')->__('Cookies lifetime'),
            'class' => 'required-entry validate-digits',
            'required' => true,
            'name' => 'cookies_lifetime',
            'note' => Mage::helper('adminhtml')->__('In days.'),
        ));

        $fieldset->addField('time_to_show', 'text', array(
            'label' => Mage::helper('adminhtml')->__('Time before lightbox will shown'),
            'class' => 'required-entry validate-digits',
            'required' => true,
            'name' => 'time_to_show',
            'after_element_html' => "<script type=\"text/javascript\">
                                        function showhide(a) {
                                            var label = a.value;
                                            if (label==1) {
                                                    $('body_color').up(1).setStyle({display: 'table-row'});
                                                    $('body_color').addClassName('required-entry');
                                                    $('body_picture').up(1).setStyle({display: 'none'});
                                                    $('body_picture').removeClassName('required-entry');
                                            } else if (label==0) {
                                                    $('body_color').up(1).setStyle({display: 'none'});
                                                    $('body_color').removeClassName('required-entry');
                                                    $('body_picture').up(1).setStyle({display: 'table-row'});
                                                    $('body_picture').addClassName('required-entry');
                                            }
                                        }
                                        </script>",
            'note' => Mage::helper('adminhtml')->__('In seconds.'),
        ));

        $form->setValues($data);

        return parent::_prepareForm();
    }
}
<?php

/**
 * Copyright (C) 2015  LMD Agency (alex)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright   Copyright (c) 2015 LMD Agency (http://www.lmd-agency.com)
 * @license     http://www.gnu.org/licenses/  GNU General Public License (Version 3)
 */
class LMD_EasyPromoLightBox_Adminhtml_LightboxController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('lmd_easypromolightbox');
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_initAction();

        // Get id if available
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('lmd_easypromolightbox/lightbox');

        if ($id) {
            // Load record
            $model->load($id);

            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This notification no longer exists.'));
                $this->_redirect('*/*/');

                return;
            }
        }

        $this->_title($model->getId() ? $model->getName() : $this->__('New Notification'));

        Mage::register('lmd_easypromolightbox', $model);

        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('lmd_easypromolightbox/adminhtml_form_formcontainer')->setData('action', $this->getUrl('*/*/save')))
            ->renderLayout();
    }

    protected function _initAction()
    {
        $this->loadLayout()
            // Make the active menu match the menu config nodes (without 'children' inbetween)
            ->_setActiveMenu('lmd_easypromolightbox');

        return $this;
    }

    public function saveAction()
    {
        $model = Mage::getModel('lmd_easypromolightbox/lightbox');
        if ($data = $this->getRequest()->getPost()) {
            // Trying to save picture
            if (isset($_FILES['body_picture']['name']) && $_FILES['body_picture']['name'] != '') {
                try {
                    $uploader = new Varien_File_Uploader('body_picture');
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);
                    $path = Mage::getBaseDir('media') . '/lmd/easypromolightbox' . DS;
                    $body_picture = $_FILES['body_picture']['name'];
                    $data['body_picture'] = 'lmd/easypromolightbox/' . $body_picture;
                    $uploader->save($path, $body_picture);
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    if ($model && $model->getId()) {
                        $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    } else {
                        $this->_redirect('*/*/');
                    }
                }
            }
            //Some tricks to prevent losing picture if lightbox was modified
             elseif ($data['body_picture']['delete']) {
                $data['body_picture'] = NULL;
                if ($data['body_type'] == 0) {
                    $data['body_type'] = 1;
                    $data['body_color'] = 'FFFFFF';
                }

             } else {
                $data['body_picture'] = $data['body_picture']['value'];
             }

            $model = Mage::getModel('lmd_easypromolightbox/lightbox');
            $collection = $model->getCollection();
            $id = $this->getRequest()->getParam('id');

            if ($id) {
                $model->load($id);
            } else {
                //If we creating new lightbox, there are setting creation date
                $now = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
                $data['creation_date'] = $now;
            }
            //Setting $data array to model
            $model->setData($data);

            Mage::getSingleton('adminhtml/session')->setFormData($data);
            //Trying to save model to database
            try {

                if ($id) {
                    $model->setId($id);
                }
                $model->save();

                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('adminhtml')->__('Error saving lightbox'));
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Lightbox was successfully saved.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // The following line decides if it is a "save" or "save and continue"
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/');
                }

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                if ($model && $model->getId()) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/');
                }
            }

            return;
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('No data found to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('lmd_easypromolightbox/lightbox');

                $model->setId($this->getRequest()->getParam('id'))
                    ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Notification was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }
}
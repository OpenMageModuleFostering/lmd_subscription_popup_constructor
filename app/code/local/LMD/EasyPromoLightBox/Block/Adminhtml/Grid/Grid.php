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
class LMD_EasyPromoLightBox_Block_Adminhtml_Grid_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Set some default on the grid
     */
    public function __construct()
    {
        $this->setId('notification_grid');

        //The 'id' matches the columnId
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);

        parent::__construct();
    }
    /**
     * Set the desired collection on our grid
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('lmd_easypromolightbox/lightbox')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('adminhtml')->__('ID'),
            'align' => 'center',
            'width' => '50px',
            //must match the column
            'index' => 'entity_id',
        ));

        $this->addColumn('active', array(
            'header' => Mage::helper('adminhtml')->__('Active'),
            'align' => 'center',
            'width' => '50px',
            //must match the column
            'index' => 'is_active',
            'renderer' => 'lmd_easypromolightbox/adminhtml_grid_renderer_active',
        ));
        $this->addColumn('Name', array(
            'header' => Mage::helper('adminhtml')->__('Name'),
            'align' => 'left',
            //must match the column
            'index' => 'notification_name',
        ));
        $this->addColumn('Title', array(
            'header' => Mage::helper('adminhtml')->__('Title'),
            'align' => 'left',
            //must match the column
            'index' => 'title_text',
        ));
        $this->addColumn('Updated', array(
            'header' => Mage::helper('adminhtml')->__('Last updated'),
            'align' => 'left',
            'width' => '140px',
            //must match the column
            'index' => 'edit_date',
        ));
        $this->addColumn('Created', array(
            'header' => Mage::helper('adminhtml')->__('Created'),
            'align' => 'left',
            'width' => '140px',
            //must match the column
            'index' => 'creation_date',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
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
class LMD_EasyPromoLightBox_Block_Frontend_Lightbox extends Mage_Core_Block_Template
{
    /**
     * Set the desired array of lightboxes sorted by date of last update
     */
    public function getLigthboxInfo()
    {
        $lightbox = Mage::getModel('lmd_easypromolightbox/lightbox')
            ->getCollection()
            ->addFieldToFilter('is_active', 1)
            ->setOrder('edit_date')
            ->getData();

        return $lightbox;
    }
}
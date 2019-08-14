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
class LMD_EasyPromoLightBox_LightboxController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    /**
     * Action that subscribes customer
     */
    public function subscribeAction()
    {
        $email = $this->getRequest()->getParam('email');

        if ($email) {
            $session = Mage::getSingleton('core/session');
            $customerSession = Mage::getSingleton('customer/session');
            $customer = Mage::getSingleton('customer/session')->getCustomerId();
            //Validating email
            if (!Zend_Validate::is($email, 'EmailAddress')) {

                $result['1'] = "Please enter a valid email address.";
                $result['2'] = false;
                $this->getResponse()->clearHeaders()->setHeader('Content-type', 'application/json', true);
                $this->getResponse()->setBody(json_encode($result));
                return;
            }
            try {
                $ownerId = Mage::getModel('customer/customer')
                    ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                    ->loadByEmail($email)
                    ->getId();

                $subscriberId = Mage::getModel('newsletter/subscriber')
                    ->loadByEmail($email)
                    ->getId();

                //Validating throw already subscribed emails
                if ($ownerId !== null && $ownerId != $customerSession->getId() || $subscriberId !== null) {
                    if ($ownerId == $customer) {
                        $result['1'] = "You're already subscribed.";
                        $result['2'] = true;
                        $this->getResponse()->clearHeaders()->setHeader('Content-type', 'application/json', true);
                        $this->getResponse()->setBody(json_encode($result));
                        return;
                    }
                    $result['1'] = 'This email address is already assigned to another user.';
                    $result['2'] = false;
                    $this->getResponse()->clearHeaders()->setHeader('Content-type', 'application/json', true);
                    $this->getResponse()->setBody(json_encode($result));
                    return;
                }

                $status = Mage::getModel('newsletter/subscriber')->subscribe($email);
                if ($status == Mage_Newsletter_Model_Subscriber::STATUS_NOT_ACTIVE) {
                    $result = "Confirmation request has been sent.";
                    $this->getResponse()->clearHeaders()->setHeader('Content-type', 'application/json', true);
                    $this->getResponse()->setBody(json_encode($result));
                    return;
                } else {
                    $result['1'] = "Thank you for your subscription.";
                    $result['2'] = true;
                    $this->getResponse()->clearHeaders()->setHeader('Content-type', 'application/json', true);
                    $this->getResponse()->setBody(json_encode($result));
                    return;
                }
            } catch (Mage_Core_Exception $e) {
                $result = "There was a problem with the subscription:" . $e;
                $this->getResponse()->clearHeaders()->setHeader('Content-type', 'application/json', true);
                $this->getResponse()->setBody(json_encode($result));
            } catch (Exception $e) {
                $result = "There was a problem with the subscription" . $e;
                $this->getResponse()->clearHeaders()->setHeader('Content-type', 'application/json', true);
                $this->getResponse()->setBody(json_encode($result));
            }
        }
    }
}
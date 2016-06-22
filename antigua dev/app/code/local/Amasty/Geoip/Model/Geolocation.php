<?php

/**
 * @author Amasty Team
 * @copyright Copyright (c) 2015 Amasty (https://www.amasty.com)
 * @package Amasty_Geoip
 */
class Amasty_Geoip_Model_Geolocation extends Varien_Object
{
    public function locate($ip)
    {
        $longIP = ip2long($ip);

        $db = Mage::getSingleton('core/resource')->getConnection('core_read');
        $select = $db->select()
            ->from(array('l' => Mage::getSingleton('core/resource')->getTableName('amgeoip/location')))
            ->join(
                array('b' => Mage::getSingleton('core/resource')->getTableName('amgeoip/block')),
                'b.geoip_loc_id = l.geoip_loc_id',
                array()
            )
            ->where("$longIP between b.start_ip_num and b.end_ip_num")
            ->limit(1)
        ;

        if ($res = $db->fetchRow($select))
            $this->setData($res);

        return $this;
    }
}

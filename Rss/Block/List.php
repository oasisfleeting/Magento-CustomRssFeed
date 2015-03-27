<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 3/25/2015
 * Time: 8:49 PM
 */


class Prairiedev_Rss_Block_List extends Mage_Rss_Block_List {

    public function getRssMiscFeeds()
    {
        $this->resetRssFeed();

        $this->SalesRuleProductRssFeed();

        $this->LatestorderRssFeed();

        return $this->getRssFeeds();
    }

    public function LatestorderRssFeed()
    {
        $path = self::XML_PATH_RSS_METHODS . '/catalog/latestorder';
        if ((bool)Mage::getStoreConfig($path)) {
            $this->addRssFeed($path, $this->__('Order Details'));
        }
    }

}
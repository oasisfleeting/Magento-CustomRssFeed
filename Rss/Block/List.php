<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 3/25/2015
 * Time: 8:49 PM
 */


class Prairiedev_Rss_Block_List extends Mage_Rss_Block_List {

    const XML_PATH_RSS_METHODS = 'rss';

    protected $_rssFeeds = array();


    /**
     * Add Link elements to head
     *
     * @return Mage_Rss_Block_List
     */
    protected function _prepareLayout()
    {
        $head   = $this->getLayout()->getBlock('head');
        $feeds  = $this->getRssMiscFeeds();
        if ($head && !empty($feeds)) {
            foreach ($feeds as $feed) {
                $head->addItem('rss', $feed['url'], 'title="'.$feed['label'].'"');
            }
        }

        return parent::_prepareLayout();
    }


    public function getRssMiscFeeds()
    {
        $this->resetRssFeed();
        $this->NewProductRssFeed();
        $this->SpecialProductRssFeed();
        $this->SalesRuleProductRssFeed();
        $this->LatestorderRssFeed();

        //$this->CategoriesRssFeed();
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
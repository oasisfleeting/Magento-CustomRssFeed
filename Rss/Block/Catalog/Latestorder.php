<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 3/25/2015
 * Time: 11:28 PM
 */

class Prairiedev_Rss_Block_Catalog_Latestorder extends Mage_Rss_Block_Abstract
{

    /**
     * Cache tag constant for feed reviews
     *
     * @var string
     */
    const CACHE_TAG = 'block_html_rss_catalog_latestorder';

    protected function _construct()
    {
        $this->setCacheTags(array(self::CACHE_TAG));
        /*
        * setting cache to save the rss for 10 minutes
        */
        $this->setCacheKey('rss_catalog_latestorder');
        $this->setCacheLifetime(1);
    }


    protected function _toHtml()
    {
        $storeId = $this->_getStoreId();
        $websiteId = Mage::app()->getStore($storeId)->getWebsiteId();
        $customerGroup = $this->_getCustomerGroupId();
        $now = date('Y-m-d');
        $url = Mage::getUrl('');
        $newUrl = Mage::getUrl('rss/catalog/salesrule');
        $lang = Mage::getStoreConfig('general/locale/code');
        $title = Mage::helper('rss')->__('%s - Discounts and Coupons', Mage::app()->getStore($storeId)->getName());

        /** @var $rssObject Mage_Rss_Model_Rss */
        $rssObject = Mage::getModel('rss/rss');
        /** @var $collection Mage_SalesRule_Model_Resource_Rule_Collection */
        $collection = Mage::getModel('salesrule/rule')->getResourceCollection();

        $data = array(
            'title' => $title,
            'description' => $title,
            'link' => $newUrl,
            'charset' => 'UTF-8',
            'language' => $lang
        );
        $rssObject->_addHeader($data);

        $collection->addWebsiteGroupDateFilter($websiteId, $customerGroup, $now)
            ->addFieldToFilter('is_rss', 1)
            ->setOrder('from_date', 'desc');
        $collection->load();

        foreach ($collection as $sr) {
            $description = '<table><tr>' .
                '<td style="text-decoration:none;">' . $sr->getDescription() .
                '<br/>Discount Start Date: ' . $this->formatDate($sr->getFromDate(), 'medium') .
                ($sr->getToDate() ? ('<br/>Discount End Date: ' . $this->formatDate($sr->getToDate(), 'medium')) : '') .
                ($sr->getCouponCode() ? '<br/> Coupon Code: ' . $sr->getCouponCode() . '' : '') .
                '</td>' .
                '</tr></table>';
            $data = array(
                'title' => $sr->getName(),
                'description' => $description,
                'link' => $url);
            $rssObject->_addEntry($data);
        }

        return $rssObject->createRssXml();


    }

    /*
$newurl = Mage::getUrl('rss/catalog/latestorder');
$title = Mage::helper('rss')->__('Order Details');

$rssObj = Mage::getModel('rss/rss');
$data = array('title' => $title,
    'description' => $title,
    'link'        => $newurl,
    'charset'     => 'UTF-8',
);
$rssObj->_addHeader($data);

$order = Mage::getModel('sales/order')->load('27604');
#get all items
$items = $order->getAllItems();
$itemcount= count($items);
$data = array();
$i=0;
#loop for all order items
foreach ($items as $itemId => $item) {
    $data[$i]['name'] = $item->getName();
    $data[$i]['price'] = $item->getPrice();
    $data[$i]['sku'] = $item->getSku();
    $data[$i]['id'] = $item->getProductId();
    $data[$i]['qty'] = $item->getQtyToInvoice();
    $rssObj->_addEntry($data[$i]);
}
//var_dump($rssObj);

return $rssObj->createRssXml();
//return $rssObj;*/

}
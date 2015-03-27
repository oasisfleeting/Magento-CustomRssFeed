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
        $newurl = Mage::getUrl('rss/catalog/latestorder');
        $title = Mage::helper('rss')->__('Order Details');

        $rssObj = Mage::getModel('rss/rss');
        $data = array('title' => $title,
            'description' => $title,
            'link' => $newurl,
            'charset' => 'UTF-8',
        );
        $rssObj->_addHeader($data);

        $order = Mage::getModel('sales/order')->load('27604');
#get all items
        $items = $order->getAllItems();
        $itemcount = count($items);
        $data = array();
        $i = 0;
#loop for all order items
        foreach ($items as $itemId => $item) {
            $data[$i]['name'] = $item->getName();
            $data[$i]['price'] = $item->getPrice();
            $data[$i]['sku'] = $item->getSku();
            $data[$i]['id'] = $item->getProductId();
            $data[$i]['qty'] = $item->getQtyToInvoice();
            $rssObj->_addEntry($data[$i]);
        }

        return $rssObj->createRssXml();


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
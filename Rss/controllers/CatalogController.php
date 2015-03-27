<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 3/25/2015
 * Time: 8:05 PM
 */
require_once 'Mage/Rss/controllers/CatalogController.php';
class Prairiedev_Rss_CatalogController extends Mage_Rss_CatalogController {

    public function latestorderAction()
    {

        $this->checkFeedEnable('latestorder');
        $this->loadLayout(false);
        $this->renderLayout();
    }

}
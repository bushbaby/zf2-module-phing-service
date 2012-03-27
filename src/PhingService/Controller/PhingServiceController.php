<?php

namespace PhingService\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

class PhingServiceController extends ActionController
{

    public function indexAction()
    {
        $options = array('buildFile' => __DIR__ . '/../../../data/build-example.xml');

        $buildResult = $this->locator->get('phing-service')->build('show-defaults dist' /* target */, $options);

        $view = new ViewModel($buildResult);
        $view->setTemplate('phingservice/index');

        return $view;
    }

}

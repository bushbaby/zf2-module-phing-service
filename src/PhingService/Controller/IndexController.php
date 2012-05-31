<?php

namespace PhingService\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

class IndexController extends ActionController
{

    public function indexAction()
    {
        $options = array('buildFile' => __DIR__ . '/../../../data/build-example.xml');

        $buildResult = $this->getServiceLocator()->get('PhingService')->build('show-defaults dist' /* target */, $options);

//        print_r($this->getServiceLocator()->get('ViewManager'));
        $view = new ViewModel($buildResult);
        $view->setTerminal(true);

        return $view;
    }

}

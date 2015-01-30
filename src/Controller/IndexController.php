<?php

namespace BsbPhingService\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $options = array('buildFile' => __DIR__ . '/../../data/build-example.xml');

        $buildResult = $this
            ->getServiceLocator()
            ->get('BsbPhingService')
            ->build('show-defaults dist' /* target */, $options);

        $view = new ViewModel($buildResult);

        return $view;
    }
}

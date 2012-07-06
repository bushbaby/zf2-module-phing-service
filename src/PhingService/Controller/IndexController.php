<?php

namespace PhingService\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $options = array('buildFile' => __DIR__ . '/../../../data/build-example.xml');

        $buildResult = $this->getServiceLocator()->get('PhingService')->build('show-defaults dist' /* target */, $options);

        $view = new ViewModel($buildResult);
        $view->setTerminal(true);

        return $view;
    }

}

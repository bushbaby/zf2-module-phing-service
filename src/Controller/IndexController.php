<?php

namespace BsbPhingService\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    /**
     * Runs example phing file and returns
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        $buildResult = $this
            ->getServiceLocator()
            ->get('BsbPhingService')
            ->build('show-defaults dist' /* target */, array(
                'buildFile' => __DIR__ . '/../../data/build-example.xml'
            ));

        $view = new ViewModel();
        $view->setVariable('process', $buildResult);

        return $view;
    }
}

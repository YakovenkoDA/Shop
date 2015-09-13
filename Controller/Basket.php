<?php
class Controller_Basket extends System_Controller
{

    /**
     * Basket index view
     */
    public function indexAction()
    {
        $params = $this->_getArguments();
        if(!empty($params['remove']))
            {
            if($params['remove']=='all'){unset($_SESSION['basket']);}
            else{unset($_SESSION['basket'][$params['remove']]);}
            }
    } 
    public function  buyAction ()
    {
        
    } 
    public function  completAction ()
    {
        $userId=$this->_userId;
        $basket=$this->getSessParam('basket');
        try {
             Model_Order :: setBasket($userId,$basket);                     
            }
            catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
            }
    } 
}

<?php
class Controller_Basket extends System_Controller
{
    /**
     * Basket index view
     */
    public function indexAction()
    {
        $params = $this->_getArguments();
        /**
         * check if remove order
         */
        if(!empty($params['remove']))
            {
            if($params['remove']=='all'){unset($_SESSION['basket']);}
            else{unset($_SESSION['basket'][$params['remove']]);}
            }
    } 
   /**
    * Basket buy action
    * load order form
    */
    public function  buyAction ()
    {
    $params = $this->_getArguments();
    /**
     * check if complet bue form
     * load compleat viev
     */
    if(!empty($params['complet']))
        {
        $userId=$this->_userId;
        $basket=$this->getSessParam('basket');
        /**
         * @var Model_Order
         * set order
         */
        try {
             Model_Order :: setOrderBasket($userId,$basket);                     
            }
            catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
            }
        /**
        * load compleat viev
        * unset basket
        */
        header('location: '.URL.'/basket/complet');
        unset($_SESSION['basket']);
        }
    }
    /**
     * emty
     */
    public function  completAction ()
    {
        
    } 
}

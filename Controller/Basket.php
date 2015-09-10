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
//        if(!empty($params['ordertype'])){$this->setSessParam('ordertype',$params['ordertype']);}
//        if(!empty($params['orderby'])){$this->setSessParam('orderByProduct',$params['orderby']);}
//        else {$params['orderby']=$this->getSessParam('orderByProduct',$params['orderby']);}
//        $currentPage    = !empty($params['page']) ? $params['page'] : 1; 

//        if($this->getSessParam('limit')== NULL){$this->setSessParam('limit',5);}
//        /**
//         * set view
//         */
//        $this->view->setParam('products', $productModels);
//        $this->view->setParam('countProducts', $countProducts);        
//        $this->view->setParam('currentPage', $currentPage);        
    } 
    public function  bueAction ()
    {
        
    } 
}

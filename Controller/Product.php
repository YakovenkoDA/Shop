<?php
class Controller_Product extends System_Controller
{
    /**
     * product index view
     */
    public function indexAction()
    {
        $params = $this->_getArguments();
        /**
         * check $params 
         */
        if(!empty($params['limit'])){$this->setSessParam('limit',$params['limit']);}
        if(!empty($params['ordertype'])){$this->setSessParam('ordertype',$params['ordertype']);}
        if(!empty($params['orderby'])){$this->setSessParam('orderByProduct',$params['orderby']);}        
        else {$params['orderby']=$this->getSessParam('orderByProduct',$params['orderby']);}
        if(isset($params['category'])){$this->setSessParam('category',$params['category']);}
        
        try {
        if(!empty ($params['bye'])){Model_Basket :: setBasket($params['id']);}
        }
        catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
        }
        $currentPage    = !empty($params['page']) ? $params['page'] : 1; 
        /**
         * @var Model_Product[] $productModels
         */
        try {
        $productModels = Model_Product :: getItems($params);
        $countProducts = Model_Product :: getCountItems($this->getSessParam('category'));
        }
        catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
        }
        
        if($this->getSessParam('limit')== NULL){$this->setSessParam('limit',5);}
        /**
         * set view
         */
        $this->view->setParam('products', $productModels);
        $this->view->setParam('countProducts', $countProducts);        
        $this->view->setParam('currentPage', $currentPage);        
    }  
    public function productInfoAction()
    {
        $params = $this->_getArguments();
        /**
         * check $params 
         */
        $currentPage    = !empty($params['page']) ? $params['page'] : 1;
        $this->view->setParam('currentPage', $currentPage);
        if(!empty($params['error'])){$this->view->setParam('error',$params['error']);}
        /**
         * set view
         * if update product
         */
        if(!empty($params['id']))
        {
            $productId = $params['id'];
            /**
            * @var Model_Product[] $modelProduct
            */  
            try {
                $modelProduct = Model_Product :: getById($productId);
                $this->view->setParam('product', $modelProduct);
            }
            catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
            }
        }     
    }
}

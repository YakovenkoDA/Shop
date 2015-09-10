<?php
class Model_Order
{
    /**
     *  @var int 
     */
    public $id;
    
    /**
     *
     * @var Mdel_User
     */
    public $modelUser;
    
    /**
     *
     * @var date
     */
    public $date;    
    
    /**
     *
     * @var double 
     */
    public $amount;
    /**
     *
     * @var array Model_OrderItem
     */
    public $orderItems;


    /**
     * 
     * @param type $params
     * @return \self
     */
    public static function getItems($params)
    {
        $dbTableOrder = new Model_Db_Table_Order();
        $orderData   = $dbTableOrder->getByCriteria($params);
        
        $orderModels = array();
        
        foreach ($orderData as $item) {
            $orderModel               = new self();
            $orderModel->id           = $item->id;
            $orderModel->userId       = $item->user_id;
            if($item->user_id){
                $dbTableUser = new Model_Db_Table_User();
                $userData   = $dbTableUser->getById($item->user_id);
            $orderModel->modelUser        = reset($userData);   
            }
            $orderModel->date         = $item->date;
            $orderModel->amount       = $item->amount;
            
            $orderModels[] = $orderModel;
        }
        return $orderModels;
    }
    
    
   
    public static function getById($orderId)
    {
        $dbTableOrder     =  new Model_Db_Table_Order();
        $orderData   =  reset($dbTableOrder->getById($orderId));
        
        $orderItems= Model_OrderItem :: getOrderItems($orderId);     
        
        if($orderData) {            
            $orderModel               = new self();
            $orderModel->id           = $orderData->id;
            if($orderData->user_id){
                $dbTableUser = new Model_Db_Table_User();
                $userData   = $dbTableUser->getById($orderData->user_id);
            $orderModel->modelUser        = reset($userData);   
            }
            $orderModel->date         = $orderData->date;
            $orderModel->amount       = $orderData->amount;
            $orderModel->orderItems = $orderItems;
        }
        else {
            throw new Exception('Order not found', System_Exception::NOT_FOUND);            
        }
  
        return $orderModel;
    }
    /**
     * 
     * @return int $countItems
     */
    public static function getCountItems()
    {        
        $dbTableOrder = new Model_Db_Table_Order();
        $countItems     = $dbTableOrder->getCount();
        return $countItems;         

    }
    /**
     * if remove order
     * 
     * @param int $id
     */
    public static function remove($id)
    {
        /**
         * @var Model_Db_Table_Product $dbTableProduct
         */
        $dbTableOrder = new Model_Db_Table_Order();
        $dbTableOrder->removeByID($id);
    }
    /**
     * if insert or update product
     * 
     * @param type $id
     * @return type
     */
    public static function setOrder($id=NULL)
    {
        
    
        if(!empty($_POST['email']))
        {          
            $email = $_POST['email'];
            /**
             * @var Model_Db_Table_Producte $dbTableProduct
             */
            $dbTableUser = new Model_Db_Table_User();
            $user=  reset($dbTableUser->selectByEmail($email));
            
            /**
             *@return $error
             */  
            if(empty($user)){return $error=4;}
        }
        /**
         * @return int $error
         */
         else  { return $error=4;}
        if(!empty($_POST['product1']))
        {   
            $i=1;
            $amount=0;
            $products=array();
            while(!empty($_POST['product'.$i]))
            {            
            $product=$_POST['product'.$i];
            $quantity=$_POST['quantity'.$i];
            /**
             * @var Model_Db_Table_Producte $dbTableProduct
             */
            $dbTableProduct = new Model_Db_Table_Product();
            $resalt=reset($dbTableProduct->selectByName($product));
            /**
             *@return $error
             */
            if(empty($resalt)){return $error=5;}
            $products[$resalt->id]=$quantity;
            $amount+=$resalt->price*$quantity;
            ++$i;
            }             
        }
        /**
         * @return int $error
         */
         else  { return $error=5;}
         if(!empty($_POST['date']))
         {
             $date=trim( $_POST['date']);
             $data=explode('-',$date);
             if(!checkdate($data[1], $data[2], $data[0])){return $error=2;}
         }
         else {return $error=2;}
         
    /**
     * @var Model_Product $modelProduct
     */
    $modelOrder = new self();    
    $modelOrder->id           = $id;
    $modelOrder->modelUser    = $user;   
    $modelOrder->date         = $date;
    $modelOrder->amount        = $amount;
    $modelOrder->orderItems  = $products;
    
    $dbTableOrder = new Model_Db_Table_Order();         
    $dbTableOrder->create($modelOrder);            
    }
}
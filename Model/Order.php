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
     * @var date
     */
    public $date;      
    /**
     * @var double 
     */
    public $amount;
    /**
     * @var array Model_OrderItem
     */
    public $orderItems;

    /**
     * get order by params
     * 
     * @param array $params
     * @return \self
     */
    public static function getItems($params)
    {
        /**
         * @var Model_Db_Table_Order $dbTableOrder
         */
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
    
    /**
     * get order by id
     * 
     * @param int $orderId
     * @return \self
     * @throws Exception
     */
   
    public static function getById($orderId)
    {
        /**
         * @var Model_Db_Table_Order $dbTableOrder
         */
        $dbTableOrder     =  new Model_Db_Table_Order();
        $orderData   =  reset($dbTableOrder->getById($orderId));
        /**
         * @var Model_OrderItem $orderItems
         */
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
* get count of order
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
* if insert or update order
* 
* @param int $id
* can
* @return int $error
 */
public static function setOrder($id=NULL)
    {
        /**
         * check email
         * create 
         * @var  object  $user 
         */
        if(!empty($_POST['email']))
        {          
            $email = $_POST['email'];
            /**
             * @var Model_Db_Table_User $dbTableUser
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
         /**
          * check product
          * create 
          * @var array $products
          * @var number $amount
          */
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
         /**
          * check date
          */
         if(!empty($_POST['date']))
         {
             $date=trim( $_POST['date']);
             $data=explode('-',$date);
             if(!checkdate($data[1], $data[2], $data[0])){return $error=2;}
         }
          /**
          *@return $error
          */
         else {return $error=2;}
         
    /**
     * create /self
     */
    $modelOrder = new self();    
    $modelOrder->id           = $id;
    $modelOrder->modelUser    = $user;   
    $modelOrder->date         = $date;
    $modelOrder->amount        = $amount;
    $modelOrder->orderItems  = $products;
    /**
     * @var Model_Db_Table_Order $dbTableOrder
     */
    $dbTableOrder = new Model_Db_Table_Order();         
    $dbTableOrder->create($modelOrder);            
    }
/**
 * insert order
 * 
 * @param int $id
 * @param array $basket (serialize)
 */
public static function setOrderBasket($id,$basket)
    {
         /**
          * check $id
          */
         $userId=empty($id)?202:$id;
         $date = date("Y-m-d");
         
         $amount=0;
         $products=array();
         foreach ($basket as $item)
             {
             $product=  unserialize($item);
             $amount+=$product->price*$product->count;
             $products[$product->id]=$product->count;
             }
            /**
             * get connection
             * insert data
             */ 
            $connection = System_Registry::get('db');
            $sth = $connection->prepare('INSERT INTO `order` (user_id,date,amount) VALUES (?,?,?)');
            $sth->execute(array($userId,$date,$amount)); 
            $orderId = $connection->lastInsertId();
     
            foreach ($products as $product=>$quantity){
                $sth = $connection->prepare('INSERT INTO order_item (order_id,product_id,quantity) VALUES (?,?,?)');
                $sth->execute(array($orderId,$product,$quantity)); 
                
                }
    }
}
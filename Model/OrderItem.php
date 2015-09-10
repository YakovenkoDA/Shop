<?php
class Model_OrderItem
{
    public $orderId;
    public $modelProduct;
    public $quantity;
    
    public static function getOrderItems($orderId)
        {
        $connection = System_Registry::get('db');
        $sql    = 'select * from order_item where order_id = '.$orderId;       
        $sth    = $connection->prepare($sql);
        $sth->execute();
        $orderData = $sth->fetchAll(PDO::FETCH_OBJ);
         
        $orderItems=array();
        foreach ($orderData as $item){
          $orderItem = new self();
          $orderItem->orderId = $item->order_id;
          if($item->product_id){
              $dbTableProduct = new Model_Db_Table_Product();
              $productData   = $dbTableProduct->getById($item->product_id);             
          $orderItem->modelProduct = reset($productData);
          }
          $orderItem->quantity = $item->quantity;          
          $orderItems[] = $orderItem;  
        }
        return $orderItems;
        }
}

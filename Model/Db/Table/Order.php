<?php
class Model_Db_Table_Order extends System_Db_Table
{
    protected $_name = '`order`';
/**
 * update or insert order
 * 
 * @param Model_Order $orderModel
 * 
 */
    public function create($orderModel)
    {        
        $id             = $orderModel->id ;
        $user           = $orderModel->modelUser ;
        $date           = $orderModel->date;
        $amount         = $orderModel->amount;
        $products       = $orderModel->orderItems;

        if(!empty($id))
            {            
            $sth = $this->_connection->prepare('UPDATE ' . $this->_name . ' SET user_id=?,date=?,amount=? where id='.$id);
            $sth->execute(array($user->id,$date,$amount)); 
            $str= $this->_connection->prepare('DELETE from order_item where order_id=?');
            $str->execute(array($id)); 
            }
            else 
            {
            $sth = $this->_connection->prepare('INSERT INTO ' . $this->_name . ' (user_id,date,amount) VALUES (?,?,?)');
            $sth->execute(array($user->id,$date,$amount)); 
            $id = $this->_connection->lastInsertId();
            }
        
            foreach ($products as $product=>$quantity){
                $sth = $this->_connection->prepare('INSERT INTO order_item (order_id,product_id,quantity) VALUES (?,?,?)');
                $sth->execute(array($id,$product,$quantity)); 
                
                }
    }
    
 }
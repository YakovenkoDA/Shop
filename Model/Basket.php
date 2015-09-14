<?php
class Model_Basket
{  
    /**
     *  @var int 
     */
    public $id;
    
    /**
     *
     * @var string  
     */
    public $name;   
    /**
     *
     * @var string 
     */
    public $img;    
    /**
     *
     * @var double 
     */
    public $price;
    /**
     *
     * @var int 
     */
    public $count;
    
    public static function setBasket($id)
    {
        $count=(int)$_POST['quantity'];       
        if(empty($count) || $count<1){$count=1;}
        if(isset($_SESSION['basket'][$id]))
                {
                $modelProduct=  unserialize($_SESSION['basket'][$id]);
                $modelProduct->count+=$count;
                $_SESSION['basket'][$id]=  serialize($modelProduct);                
                }
            else{
                $productTable     =  new Model_Db_Table_Product();
                 $productData   =  reset($productTable->getById($id));
                 if($productData){
                        $modelProduct  = new self();
                        $modelProduct->id           = $productData->id;
                        $modelProduct->img          = $productData->img;
                        $modelProduct->name         = $productData->name;
                        $modelProduct->price        = $productData->price;
                        $modelProduct->count        = $count;
                        
                        $_SESSION['basket'][$id]=  serialize($modelProduct);
                        
                    }        
                    else {throw new Exception('Product not found', System_Exception::NOT_FOUND);}
                }
    }
    
   
}
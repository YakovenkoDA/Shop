<?php
class Model_Product
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
    public $description;
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
    public $total;
    /**
     *
     * @var int
     */
    public $category;
    
    /**
     * get product by psrams
     * 
     * @param type $params
     * @return \self
     */
    public static function getItems($params)
    {
        /**
         * @var Model_Db_Table_Product $dbTableProduct
         */
        $dbTableProduct = new Model_Db_Table_Product();
        $productsData   = $dbTableProduct->getByCriteria($params);
             
        foreach ($productsData as $item) {
            $productModel               = new self();
            $productModel->id           = $item->id;
            $productModel->name         = $item->name;
            $productModel->description  = $item->description;
            $productModel->img          = $item->img;
            $productModel->price        = $item->price;
            $productModel->total        = $item->total;
            $productModel->category        = $item->category;
            $productModels[] = $productModel;
        }
        
        return $productModels;
    }

    /**
     * get product by id
     * 
     * @param int $productId
     * @return Model_Product
     * @throws Exception
     */
    public static function getById($productId)
    {
        /**
         * @var Model_Db_Table_Product $productTable
         */
        $productTable     =  new Model_Db_Table_Product();
        $productData   =  reset($productTable->getById($productId));
                
        if($productData) {
            $modelProduct  = new self();
            $modelProduct->id           = $productData->id;
            $modelProduct->img          = $productData->img;
            $modelProduct->name         = $productData->name;
            $modelProduct->description  = $productData->description;
            $modelProduct->price        = $productData->price;
            $modelProduct->total        = $productData->total;
            $modelProduct->category     = $productData->category;   
            return $modelProduct;
        }
        else {
            throw new Exception('Product not found', System_Exception::NOT_FOUND);
        }
    }
    /**
     * get product count
     * 
     * @return int $countItems
     */
    public static function getCountItems($category=0)
    {
        if(empty($category))
       {
        /**
         * @var Model_Db_Table_Product $dbTableProduct
         */    
        $dbTableProduct = new Model_Db_Table_Product();
        $countItems     = $dbTableProduct->getCount();
        return $countItems;         
        }
        /**
         * if have category
         */
        $connection = System_Registry::get('db');
        $sql    = 'select count(*) from product where category = '.$category;       
        $sth    = $connection->prepare($sql);
        $sth->execute();
        
        $countItems = reset($sth->fetchAll(PDO::FETCH_COLUMN));
       
        return $countItems;
    }
    /**
     * if remove product
     * 
     * @param int $id
     */
    public static function remove($id)
    {
        /**
         * @var Model_Db_Table_Product $dbTableProduct
         */
        $dbTableProduct = new Model_Db_Table_Product();
        $dbTableProduct->removeByID($id);
    }
    /**
     * if insert or update product
     * 
     * @param type $id
     * @return type
     */
    public static function setProduct($id=NULL)
    {
        if(!empty($_POST['name']))
        {       
            $id   = trim($id);
            $name = trim($_POST['name']);
            /**
             * @var Model_Db_Table_Producte $dbTableProduct
             */
            $dbTableProduct = new Model_Db_Table_Product();
            $resalt=$dbTableProduct->selectByName($name,$id);
            /**
             *@return $error
             */
            if($resalt != NULL){return $error=1;}
            /**
            *upload file
            *@return $error
            */
            $pathImg = SITE_PATH.'img/Products/'.$_POST['category'].'/';
            if(empty($_POST['file']) && !file_exists($pathImg.$_POST['file']))
            {
                if(!empty($_FILES['img']['name']))
                    {
                    $pathImg.= $_FILES['img']['name'];
                    if($_FILES['img']['error']!=0){return $error=6;}
                    if(file_exists($pathImg)){return $error=7;}
                    move_uploaded_file($_FILES['img']['tmp_name'],$pathImg);
                    $_POST['file']=$_FILES['img']['name'];
                    }
            }
        }
        /**
         * @return int $error
         */
         else
            {
            return $error=1;
            }
    /**
     * @var Model_Product $modelProduct
     */
    $modelProduct = new self();    
    $modelProduct->id           = $id;
    $modelProduct->name         = $name;
    $modelProduct->price        = !empty($_POST['price']) ? trim($_POST['price']) : 0;
    $modelProduct->category        = !empty($_POST['category']) ? trim($_POST['category']) : 0;
    $modelProduct->total        = !empty($_POST['total']) ? trim($_POST['total']) : 0;
    $modelProduct->description  = !empty($_POST['description']) ? $_POST['description'] : ' ';
    $modelProduct->img          = !empty($_POST['file']) ? $_POST['file'] : ' ';
    
    $dbTableProduct->create($modelProduct);            
    }
}
<?php

class Product extends AppModel {
    public $name = 'Product';
   public $hasMany = array(
        'ProductImage' => array(
            'className' => 'ProductImage',
            'foreignKey' => 'product_id'),
        
    );
   public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => false,
            'conditions'=>'Product.category_id = Category.id'
            ),
       
        
    );
   


}

<?php
//items2.php

$myItem = new Item(1, "Plain Burger", "Comes with lettuce tomato and onion", 8.99);
$myItem->addExtra("Mushrooms");
$myItem->addExtra("Peppers");
$myItem->addExtra("Avocado");
$config->items[] = $myItem;



$myItem = new Item(2, "Cheeseburger", "Comes with lettuce tomato onion and cheese", 10.99);
$myItem->addExtra("Mushrooms");
$myItem->addExtra("Peppers");
$myItem->addExtra("Avocado");
$config->items[] = $myItem;



$myItem = new Item(3, "Bacon Cheeseburger", "Comes with L-T-O cheese and bacon", 12.99);
$myItem->addExtra("Mushrooms");
$myItem->addExtra("Peppers");
$myItem->addExtra("Avocado");
$config->items[] = $myItem;




/*echo '<pre>';
var_dump($items);
echo '</pre>';*/

class Item
{
    public $ID = 0;
    public $Name = '';
    public $Description = '';
    public $Price = 0;
    public $Extras = array();
    
    public function __construct($ID, $Name, $Description, $Price)
    {
        $this->ID = $ID;
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Price = $Price;
        
    }#end item constructor
    
        public function addExtra($extra)
    {
        $this->Extras[] = $extra;
    }#end addExtra
    
}
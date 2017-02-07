<?php
//food truck items

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

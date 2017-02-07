<?php
/**
 * burger_food_truck.php is a single page web application that allows us take a food order from a user
 *
 * This version uses no HTML directly so we can code collapse more efficiently
 *
 * Any number of additional steps or processes can be added by adding keywords to the switch 
 * statement and identifying a hidden form field in the previous step's form:
 *
 *<code>
 * <input type="hidden" name="act" value="next" />
 *</code>
 * 
 * The above live of code shows the parameter "act" being loaded with the value "next" which would be the 
 * unique identifier for the next step of a multi-step process
 *
 * @author Amy Funk <amy61789@outlook.com> James Overholtzer <overholtzerj@gmail.com> Kiara McMorris <eatlunchnow@gmail.com>
 * @version 1.2 2017/02/07
 * @link http://www.amywritescode.com/ 
 * @license http://www.apache.org/licenses/LICENSE-2.0 
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
include 'foodtruck.php';

# Read the value of 'action' whether it is passed via $_POST or $_GET with $_REQUEST
if(isset($_REQUEST['act'])){$myAction = (trim($_REQUEST['act']));}else{$myAction = "";}

switch ($myAction) 
{//check 'act' for type of process
	case "display": # 2)Display user's name!
	 	showData();
	 	break;
	default: # 1)Ask user to enter their name 
	 	showForm();
}




  /**
   * showForm() shows the form to user to input quantity for Burger Food Truck
   */
function showForm()
{# shows form so user can enter their name.  Initial scenario
    global $config;
	get_header(); #defaults to header_inc.php	
	
	echo 
	'<script type="text/javascript" src="' . VIRTUAL_PATH . 'include/util.js"></script>
	<script type="text/javascript">
		function checkForm(thisForm)
		{//check form data for valid info
			if(empty(thisForm.YourName,"Please enter the quantity you would like to order")){return false;}
			return true;//if all is passed, submit!
		}
	</script>
	<h3 align="center">' . smartTitle() . '</h3>
	<p align="center">Please enter the quantity you would like to order</p> 
	<form action="' . THIS_PAGE . '" method="post" onsubmit="return checkForm(this);">
		<table align="center">
			<tr>
				
				<td>
                ';
    /*
     ' . XXX . '
    */
    
    
    $checkCount = 1;
    
    foreach($config->items as $item)
    {
        //initialize checkboxes 
        $cbox1 = "cbox1" . strval($checkCount);
        $cbox2 = "cbox2" . strval($checkCount);
        $cbox3 = "cbox3" . strval($checkCount);
        echo '<p>' . $item->Name . '    $' . $item->Price . '    Quantity: <input type="text" name="item_' . $item->ID . '"/>  Extra Toppings: 
        <label><input type="checkbox" name="' . $cbox1 . '" value="mushroom"> Mushroom</label>
        <label><input type="checkbox" name="' . $cbox2 . '" value="peppers"> Peppers</label>
        <label><input type="checkbox" name="' . $cbox3 . '" value="avocado"> Avocado</label></p>';
        
        //adds count to checkboxes to verify which checkbox is checked
        $checkCount = $checkCount + 1;

            
     }
               echo ' 
                <!--
					<input type="text" name="YourName" /><font color="red"><b>*</b></font> <em>(alphabetic only)</em>
                    -->
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<input type="submit" value="Submit Your Order">
				</td>
			</tr>
		</table>
		<input type="hidden" name="act" value="display" />
	</form>
	';
	get_footer(); #defaults to footer_inc.php
}



  /**
   * showData() shows the form again with the Subtotal, Tax, and Total amounts included from the order placed
   * also contains a back button incase user would like to enter in another order
   */
function showData()
{#form submits here we show entered name
    global $config;
    
    echo 
	'<script type="text/javascript" src="' . VIRTUAL_PATH . 'include/util.js"></script>
	<script type="text/javascript">
		function checkForm(thisForm)
		{//check form data for valid info
			if(empty(thisForm.YourName,"")){return false;}
			return true;//if all is passed, submit!
		}
	</script>
	<h3 align="center">' . smartTitle() . '</h3>
	<p align="center">Please enter the quantity you would like to order</p> 
	<form action="' . THIS_PAGE . '" method="post" onsubmit="return checkForm(this);">
		<table align="center">
			<tr>
				
				<td>
                ';
    /*
     ' . XXX . '
    */
    
    
    
    
    foreach($config->items as $item)
    {
        //echo "<p>ID: $item->ID Name: $item->Name</p>";
        //echo '<p>Taco<input type="text" name="item_1"/></p>';
        
        echo '<p>' . $item->Name . '    $' . $item->Price . '    Quantity: <input type="text" name="item_' . $item->ID . '"/>  Extra Toppings: <label><input type="checkbox" name="cbox1" value="mushroom"> Mushroom</label>
        <label><input type="checkbox" name="cbox2" value="peppers"> Peppers</label>
        <label><input type="checkbox" name="cbox3" value="avocado"> Avocado</label></p>';
        

            
     }
                 

    
               echo ' 
                <!--
					<input type="text" name="YourName" /><font color="red"><b>*</b></font> <em>(alphabetic only)</em>
                    -->
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<!--<input type="submit" value="Submit Your Order"><em>(<font color="red"><b>*</b> required field</font>)</em>
                    -->
				</td>
			</tr>
		</table>
		<input type="hidden" name="act" value="display" />
	</form>
	';
    //initializing variables
    $counter = 1;
    $subTotal = 0;
    $checkCount = 1;
    
    //looping through items
    foreach($config->items as $item){
        
        //adds count to item
        $itemCount = "item_" . strval($counter);
        foreach($_POST as $name => $value)
        {
            //if string contains name and item count
            if(strstr($name, $itemCount)) 
            {
                //checks for numerical input
                if (is_numeric($value) || empty($value))
                {
                    //adds quanity input to variable
                    $quantity = intval($value);
                //tells user only numbers are allowed and redirects back to page    
                } else
                    {
                        feedback("Only numbers are allowed.  Please re-enter your quantity."); #will feedback to submitting page via session variable
                        myRedirect(THIS_PAGE);
                    }
                
            }
            
        }
        //calculations for item total
        $itemTotal = $item->Price * $quantity;
        
        //subtotal calculation
        $subTotal += $itemTotal;
        
        $cbox1 = "cbox1" . strval($checkCount);
        $cbox2 = "cbox2" . strval($checkCount);
        $cbox3 = "cbox3" . strval($checkCount);
        
        //adds extra values if checked
        if(isset($_POST[$cbox1]))
        {
            $subTotal += (.5 * $quantity);
        }
        if(isset($_POST[$cbox2]))
        {
            $subTotal += (.5 * $quantity);
        }
        if(isset($_POST[$cbox3]))
        {
            $subTotal += (.5 * $quantity);
        }
        
        $counter = $counter + 1;
        $checkCount = $checkCount + 1;
        
    }
    //figueres out tax amount
    $tax = $subTotal * .095;
    
    //calculates total plus tax
    $total = $subTotal + $tax;
    
    if ($total == 0){
        feedback("Please make a selection."); #will feedback to submitting page via session variable
		myRedirect(THIS_PAGE);
    }
    //prints out receipt total
    echo '<p>Subtotal: $' . $subTotal . '</p>';
    echo '<p>Tax: $' . number_format($tax, 2) . '</p>';
    echo '<p>Total: $' . number_format($total, 2) . '</p>';
    
    echo '<p align="center"><a href="' . THIS_PAGE . '">Place another order</a></p>';
    
	get_header(); #defaults to footer_inc.php
	get_footer(); #defaults to footer_inc.php
}
?>
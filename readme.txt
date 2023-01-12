// to view php variable in console
?>
	<script>
		console.log(<?= json_encode($password); ?>);
		console.log(<?= json_encode($real_password); ?>);
		console.log(<?= json_encode($check_password); ?>);
	</script>
<?php 

// login    
testing acc: 
customer:yhuey@gmail.com, yhuey, 123$hueY, ---- Tong$888
customer: cust1, password - 5*gj3Jaac ------ Hjsn5@rr
customer: jessica, password - 667Jn3#uk
customer: daniel, password - 667Jn3#uk ----- hdo4*J33
ADMIN - staff: staffhuey@gmail.com, staffhuey, Staff@123 --- stafF@999
STOCK - staff:micole, pwd: 667Jn3#uk

COURIER - staff:christ, pwd: 667Jn3#uk
MANAGEMENT - staff: maymay, pwd: Maymay8)

default password:abc1234

16 Dec 2022
customer
1. what admin can do 
2. what the customer user can do

in Customer index.php
from the PROFILE button can edit profile details. 
top nav bar

Company Name to use: FARM TREASURE
 
17 Dec 2022
Done:
differentiate customer first time login and normal login
customer can reset password
customer can update all profile data (got validation in unique column, phone number, username and email)

27 Dec 2022
Done: restructure ORDER table (insert again using query)

28 Dec 2022
cart.php
done: make delete button functionable
done: make plus minus button functionable
done:add ORDER row when customer proceed
	done: add-on: change deletecart into onclick to php, not using form
	done: add-on: form is for createorder
	unable to create 
the unprocessed ORDER should be display in admin site, please filter the role
done:connect the navigation for new page
done:after the `order` is created, please update the orderID into `cart_product` and update the hasOrder column into 1,
deduct quantity available in `product` table
orderStatus: paid, processing, shipping, delivered

5 Jan 2023 TODO:
set the thead and tr for each role, and test the sql for datatable
show modal when click the button
make query to update the order column and test run 
reload the page after admin click approve
check the cart_product again and again, if all the item in one cart is approved, then only you can upgrade the orderStatus

--calculation part for the management part

/* 
	if click accept:
		admin:
			update orderByStaff column
			$update_order_sql = "UPDATE `order` SET orderStatus='processing',orderByStaff=".$_SESSION['id'];
			update orderStatus to Processing
		stock:
			$update_order_sql = "UPDATE `order` SET orderStatus='shipping',parcelNumber='$parcelNum',preparedDate='$dateTime',preparedByStaff=".$_SESSION['id'];
			update orderStatus to Shipping
			update parcelNumber, preparedByStaff, preparedDate
		courier:
			$update_order_sql = "UPDATE `order` SET orderStatus='delivered'";
			update orderStatus to Delivered
		management:

		$update_order_sql .= " WHERE orderID=".$orderID;
*/
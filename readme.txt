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
staff: staffhuey@gmail.com, staffhuey, Staff@123 --- stafF@999
staff: tintin, Hello4$7
staff: maymay, pwd: Maymay8)
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
orderStatus: paid, processing, packed, shipping, delivered
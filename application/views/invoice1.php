<?php
	$site_settings = get_site_settings(1);
	$get_address_by_id	= get_address_by_id($address_id);
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/front/mpdf/style.css">
</head>
<body>

        <header>
            <h1>Invoice</h1>
            <address >
                <p><strong>Order From:</strong></p>
                <p><?=ucfirst(get_username($user_id))?></p>
                <p><strong>Shipped To:</strong></p>
                <p><?=ucfirst($get_address_by_id->name)?></p>
                <p><?=$get_address_by_id->address?></p>
                <p><?=$get_address_by_id->city?></p>
                <p><?=$get_address_by_id->zipcode?>, <?=get_province_name($get_address_by_id->province_id)?>, <?=get_country_name($get_address_by_id->country_id)?></p>
            </address>
            <span><img alt="" src="<?=base_url()?>upload/logo/<?=$site_settings->logo?>"></span>
        </header>

        <article>
            <table class="meta">
                <tr>
                    <th><span >Order #</span></th>
                    <td><span ><?=$order_no?></span></td>
                </tr>
                <tr>
                    <th><span >Date</span></th>
                    <td><span ><?=date('Y-m-d', strtotime($order_date))?></span></td>
                </tr>
                <tr>
                    <th><span >Payment Option</span></th>
                    <td><span ><?=$payment_option?></span></td>
                </tr>
            </table>
            <table class="inventory">
                <thead>
                    <tr>
                        <th><span >Item</span></th>
                        <!-- <th><span contenteditable>Description</span></th> -->
                        <th><span >Price</span></th>
                        <th><span >Quantity</span></th>
                        <th><span >Total</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $total_price = 0; 
                        foreach ($order_details as $data) { 
                                $unit_price = $data->price/$data->quantity;
                                $total_price = $total_price + $data->price;
                            ?>
                            <tr>
                                <td><span ><?=get_product_name($data->product_id)?></span></td>
                                <!-- <td><span contenteditable>Experience Review</span></td> -->
                                <td><span data-prefix>$</span><span ><?=number_format($unit_price, 2, '.', '')?></span></td>
                                <td><span ><?=$data->quantity?></span></td>
                                <td><span data-prefix>$</span><span><?=number_format($data->price, 2, '.', '')?></span></td>
                            </tr>
                    <?php } ?>        
                </tbody>
            </table>
            <!-- <a class="add">+</a> -->
            <table class="balance">
                <tr>
                    <th><span >Subtotal</span></th>
                    <td><span data-prefix>$</span><span><?=number_format($data->price, 2, '.', '')?></span></td>
                </tr>
                <tr>
                    <th><span >Shipping Charge</span></th>
                    <td><span data-prefix>$</span><span >0.00</span></td>
                </tr>
                <tr>
                    <th><span >Total</span></th>
                    <td><span data-prefix>$</span><span><?=number_format($data->price, 2, '.', '')?></span></td>
                </tr>
            </table>
        </article>

</body>
</html>
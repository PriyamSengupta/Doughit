<?php
	$site_settings = get_site_settings(1);
	$get_address_by_id	= get_address_by_id($address_id);
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		.invoice-title h2, .invoice-title h3 {
		    display: inline-block;
		}

		.table > tbody > tr > .no-line {
		    border-top: none;
		}

		.table > thead > tr > .no-line {
		    border-bottom: none;
		}
		
		/* .table > tbody > tr > .thick-line {
		    border-top: 2px solid !important;
		} */
	</style>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/front/css/kv-mpdf-bootstrap.css">

</head>
<body>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    		<div class="invoice-title">
			<a class="navbar-brand page-scroll" href="<?=base_url()?>"><img alt="Doughit" src="<?=base_url()?>upload/logo/<?=$site_settings->logo?>"></a>
			<h3 class="text-right">Order # <?=$order_no?></h3>
    		</div>
    		<hr>
    		<div class="row">
    			
    			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right" style="float:right">
    				<address>
					<strong>Order From:</strong><br>
    					<?=ucfirst(get_username($user_id))?><br>
        			<strong>Shipped To:</strong><br>
					<?=ucfirst($get_address_by_id->name)?><br>
    					<?=$get_address_by_id->address?><br>
    					<?=$get_address_by_id->city?><br>
    					<?=$get_address_by_id->zipcode?>, <?=get_province_name($get_address_by_id->province_id)?>, <?=get_country_name($get_address_by_id->country_id)?>
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    				<address>
    					<strong>Payment Method:</strong><br>
    					<?=$payment_option?><br>
						<?=get_user_email($user_id)?>
    				</address>
    			</div>
    			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right" style="right: 0 !important;">
    				<address>
    					<strong>Order Date:</strong><br>
    					<?=date('Y-m-d', strtotime($order_date))?><br><br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Item</strong></td>
        							<td class="text-center"><strong>Price</strong></td>
        							<td class="text-center"><strong>Quantity</strong></td>
        							<td class="text-right"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
								<?php
								$total_price = 0; 
								foreach ($order_details as $data) { 
										$unit_price = $data->price/$data->quantity;
										$total_price = $total_price + $data->price;
									?>
									<tr>
										<td><?=get_product_name($data->product_id)?></td>
										<td class="text-center">$ <?=number_format($unit_price, 2, '.', '')?></td>
										<td class="text-center"><?=$data->quantity?></td>
										<td class="text-right">$ <?=number_format($data->price, 2, '.', '')?></td>
									</tr>
								<?php } ?>
    							
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
    								<td class="thick-line text-right">$ <?=number_format($total_price, 2, '.', '')?></td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Shipping</strong></td>
    								<td class="no-line text-right">$0.00</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Total</strong></td>
    								<td class="no-line text-right">$ <?=number_format($total_price, 2, '.', '')?></td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
</body>
</html>
<?php
    $get_product_addon = get_product_addon($details->id);
    $get_product_price_array = get_product_price_array($details->id);

    $get_product_type_array = get_product_type_array($details->id);

    // echo "<pre>"; print_r($get_product_price_array);

    $path=$this->config->item('file_upload_base_url').'products/normal/';
    if($details->id != '')
    {
        $image_array = get_product_images($details->id);
        $count = count($image_array);
        $base_price = get_product_price($details->id);
    }
    else
    {
        $image_array = array();
        $count = 0;
    }

    $get_post_comments = get_post_comment($details->id);
    
    $get_related_products = get_related_products($details->id);
?>
<input type="hidden" id="product_id" value="<?=$details->id?>">
<input type="hidden" id="base_price" value="<?=$base_price?>">
<input type="hidden" id="final_price" value="<?=$base_price?>">
<input type="hidden" id="size_exists" value="<?=$details->size_exists?>">
<input type="hidden" id="user_id" <?php if($this->session->userdata('doughit_userid')) { ?> value="<?=$this->session->userdata('doughit_userid')?>" <?php } else { ?> value="" <?php } ?>>

<section class="page-banner" style="background: #121619 url(<?=base_url()?>dist/front/images/blog-9.jpg) no-repeat center / cover;">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="page-title">
                    <h1 class="page-headding"><?=$mainheader?> </h1>
                    <ul>
                        <li><a href="<?=base_url()?>" class="page-name">Home</a></li>
                        <li><a href="<?=base_url()?>order_online" class="page-name">Order Online</a></li>
                        <li><?=$mainheader?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="product-det pt-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-6 col-12">
                <div class="align-center mb-md-30">
                    <ul id="glasscase" class="gc-start">
                        <li><img src="<?=$path.$details->image?>" alt="pizzon" data-gc-caption="Your caption text" /></li>
                        <?php if(count($image_array)>0) {
                            foreach($image_array as $img){ ?>
                                <li><img src="<?=$path.$img->image?>" alt="pizzon" data-gc-caption="Your caption text"/></li>
                        <?php } } ?>
                    </ul>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 col-md-7">
                <div class="shop-detail">
                    <div class="shop-name">
                        <h3 class="title-shop"><?=$details->name?></h3>
                        <div class="price-shop">
                            <!-- <span class="filter-price filter-price-r">$ 30.50</span> -->
                            <span class="filter-price">$ <?=$base_price?></span>
                        </div>
                        <p class="shop-desc"><?=$details->description?></p>
                    </div>
                    <?php if($details->size_exists === '1') { 
                            $get_product_size = get_product_size($details->id);
                            
                        ?>

                    <div class="crust-choose">
                        <label class="title-crust">Size of Crust</label>
                        <ul class="Size">
                            <?php if(!empty($get_product_size)) {
                                    foreach ($get_product_size as $size) { ?>
                                    <?php if($size->is_default == '1') { ?>
                                        <input type="hidden" id="size_id" name="size_id"  value="<?=$size->id?>">
                                    <?php } ?>    
                                        <li <?php if($size->is_default == '1') { ?> class="tab-link current" <?php } else { ?>  class="tab-link" <?php } ?>><a href="javascript:void(0)" onclick="select_size(<?=$size->id?>)"><?=$size->name?></a></li>
                            <?php  } } ?>
                        </ul>
                    </div>

                    <?php } ?>
                    
                    <?php if(!empty($get_product_addon)) {
                            foreach ($get_product_addon as $addon) { 
                                if(!empty($addon->options)) { 
                                    if($addon->multiselect == 0) { ?>
                                        <div class="crust-choose">
                                            <label class="title-crust"><?=$addon->name?></label>
                                            <ul class="Choose">
                                            <?php foreach ($addon->options as $option) { ?>
                                                <li <?php if($option->is_default == '1') { ?> class="tab-link current" <?php } else { ?>  class="tab-link" <?php } ?>><a href="javascript:void(0)" onclick="select_type(<?=$addon->id?>,<?=$option->option_id?>,0, this)"><?=$option->option_name?></a></li>
                                            <?php } ?>    
                                            </ul>
                                        </div>
                                <?php } else { ?>

                                    <div class="toppings">
                                        <label class="title-crust"><?=$addon->name?></label>
                                        <ul class="toppings-lst">
                                            <?php foreach ($addon->options as $option) { ?>
                                                <li  <?php if($option->is_default == '1') { ?> class="highlight select" <?php } else { ?>  class="highlight" <?php } ?> onclick="select_type(<?=$addon->id?>,<?=$option->option_id?>,1, this)">
                                                    <!--<input type="checkbox" class="btn-check">-->
                                                    <span><i class="fa fa-check-circle"></i></span>
                                                    <a href="javascript:void(0)"><img src="<?=base_url()?>upload/type_option/normal/<?=$option->option_image?>" alt="" /> <br/><?=$option->option_name?></a>
                                                </li>
                                            <?php } ?>   
                                            
                                            <!-- <li>
                                                <span><i class="fa fa-check-circle"></i></span>
                                                <a href="javascript:void(0)"><img src="images/ico2.png" alt="" /> <br/>Bacon</a>
                                            </li> -->
                                        </ul>
                                    </div>
                                <?php } 
                            } 
                        } 
                    } ?>        
                                        
                    <div class="quantity-product">
                        <label class="quantity">Qty:</label>
                        <input type="number" id="qty" value="1" min="1" max="10" onclick="update_price(this)" onkeydown="return false;">
                        <a href="javascript:void(0)" class="add-cart" onclick="add_to_cart()"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Add to cart</a>
                    </div>
                    <div class="wiselist">
                        <ul class="compare">
                            <li><a href="javascript:void(0)"><i class="fa fa-heart" aria-hidden="true"></i> Add to Favourites </a></li>
                            <!-- <li><a href="#"><i class="fa fa-signal" aria-hidden="true"></i> Compare</a></li> -->
                            <!-- <li><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i> Email to Friends</a></li> -->
                        </ul>
                        <ul class="share">
                            <li class="share-title">Share This :</li>
                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="desc-tabbing pt-100">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="border-tab">
                    <ul class="panel-tab">
                        <li class="tab-link current" data-tab="tab-1"><a href="javascript:void(0)">Description</a></li>
                        <li class="tab-link" data-tab="tab-3"><a href="javascript:void(0)">Reviews</a></li>
                    </ul>
                    <div class="product-desc-tab current" id="tab-1">
                        <p><?=$details->detailed_description?></p>
                    </div>
                    <div class="product-desc-tab" id="tab-3">
                        <div id="comment_div">
                        <?php if($get_post_comments['total_comments'] == 0){?>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <p style="text-align: center">No comments yet</p>
                            </div>

                        <?php } else { ?>
                            
                            <div class="comment-part">
                                <h3><?=$get_post_comments['total_comments']?> COMMENTS</h3>
                                <ul>
                                    <?php foreach ($get_post_comments['comment_array'] as $comment) { ?>
                                        <li>
                                            <div class="comment-user">
                                                <img src="<?=$this->config->item('file_upload_base_url').'user/normal/'.get_user_image($comment->user_id)?>" alt="comment-img">
                                            </div>
                                            <div class="comment-detail">
                                                <span class="commenter">
                                                    <span><?=get_username($comment->user_id)?></span> (<?=date("F j, Y",strtotime($comment->comment_time))?>)
                                                </span>
                                                <p><?=$comment->comment?></p>
                                                <!-- <a href="#" class="reply-btn btn btn-color small">Reply</a> -->
                                            </div>
                                            <div class="clearfix"></div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            
                        <?php } ?>    
                        </div>
                        <?php if($this->session->userdata('doughit_userid')){?>
                        <div class="leave-comment-part pt-100">
                            <h3 class="reviews-head mb-30">Leave A Comment</h3>
                            <form id="post_comment_form">
                                <input type="hidden" name="comment_user_id" id="comment_user_id">
                                <input type="hidden" name="comment_product_id" id="comment_product_id">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea class="form-control" placeholder="Comment" name="comment" id="comment" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn post-comm" onclick="post_comment(<?=$this->session->userdata('doughit_userid')?>,<?=$details->id?>)">Post Comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if(count($get_related_products)>0){?>
<section class="releted-product special-menu pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="headding-part text-center pb-50">
                    <p class="headding-sub">Fresh From Doughit</p>
                    <h2 class="headding-title text-uppercase font-weight-bold">Related Products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($get_related_products as $related_product) { ?>
                <div class="col-xl-3 col-lg-3 col-md-4 text-center pt-20">
                    <div class="menu-img"><a href="<?=base_url()?>product/<?=$related_product->id?>"><img src="<?=$path.$related_product->image?>" alt="menu" class="menu-image"></a></div>
                    <a href="<?=base_url()?>product/<?=$related_product->id?>" class="menu-title text-uppercase"><?=$related_product->name?></a>
                    <p class="menu-des"><?=$related_product->description?></p>
                    <span class="menu-price">$ <?=get_product_price($related_product->id)?></span>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php } ?>

<script>
    var productID = document.getElementById('product_id').value;
    var userID = document.getElementById('user_id').value;
    var product_price_array = <?php echo json_encode($get_product_price_array) ?>;
    var product_type_array = <?php echo json_encode($get_product_type_array) ?>;
    

    // console.log(product_price_array);
    // console.log(product_type_array);

    function select_size(sizeID)
    {
        $('#qty').val(1);
        var index = product_price_array.findIndex(p => p.id == sizeID);
        var sizeDefaultPrice = parseFloat(product_price_array[index].price);
        var base_price;
        
        // console.log(sizeDefaultPrice);

        for (let i = 0; i < product_type_array.length; i++) {
            var type_id = product_type_array[i].type_id;
            if(!(Array.isArray(product_type_array[i].type_option_id)))
            {
                const type_option_id = product_type_array[i].type_option_id;
                const index2 = product_price_array[index].add_on_array.findIndex(q => q.id == type_id );                       
                const index3 = product_price_array[index].add_on_array[index2].option_array.findIndex(m => m.option_id == type_option_id );
                const type_price = product_price_array[index].add_on_array[index2].option_array[index3].option_price;
                sizeDefaultPrice = sizeDefaultPrice + parseFloat(type_price);
            }
            else
            {
                for (let j = 0; j < product_type_array[i].type_option_id.length; j++) {
                    const type_option_id = product_type_array[i].type_option_id[j];
                    const index2 = product_price_array[index].add_on_array.findIndex(q => q.id == type_id );                       
                    const index3 = product_price_array[index].add_on_array[index2].option_array.findIndex(m => m.option_id == type_option_id );
                    const type_price = product_price_array[index].add_on_array[index2].option_array[index3].option_price;
                    sizeDefaultPrice = sizeDefaultPrice + parseFloat(type_price);
                }
            }
        }
        $('#size_id').val(sizeID);
        $('#base_price').val(sizeDefaultPrice);
        $('#final_price').val(sizeDefaultPrice);
        $('.filter-price').html("$ "+sizeDefaultPrice);
    }


    function getPrice_withSize(sizeID)
    {
        // console.log("typeID: "+type_id+", optionID: "+type_option_id+", price: "+sizeDefaultPrice);
        // console.log(product_type_array);
        var sizeID = $('#size_id').val();
        var index = product_price_array.findIndex(p => p.id == sizeID);
        var sizeDefaultPrice = parseFloat(product_price_array[index].price);
        for (let i = 0; i < product_type_array.length; i++) {
            var type_id = product_type_array[i].type_id;
            if(!(Array.isArray(product_type_array[i].type_option_id)))
            {
                var type_option_id = product_type_array[i].type_option_id;
                var index2 = product_price_array[index].add_on_array.findIndex(q => q.id == type_id );                       
                var index3 = product_price_array[index].add_on_array[index2].option_array.findIndex(m => m.option_id == type_option_id );
                var type_price = product_price_array[index].add_on_array[index2].option_array[index3].option_price;
                sizeDefaultPrice = sizeDefaultPrice + parseFloat(type_price);
            }
            else
            {
                for (let j = 0; j < product_type_array[i].type_option_id.length; j++) {
                    var type_option_id = product_type_array[i].type_option_id[j];
                    var index2 = product_price_array[index].add_on_array.findIndex(q => q.id == type_id );                       
                    var index3 = product_price_array[index].add_on_array[index2].option_array.findIndex(m => m.option_id == type_option_id );
                    var type_price = product_price_array[index].add_on_array[index2].option_array[index3].option_price;
                    sizeDefaultPrice = sizeDefaultPrice + parseFloat(type_price);
                }
            }
        }
        return sizeDefaultPrice
    }

    function getPrice_withoutSize()
    {
        // console.log("typeID: "+type_id+", optionID: "+type_option_id+", price: "+sizeDefaultPrice);
        // console.log(product_type_array.length);       
        var defaultPrice = parseFloat(product_price_array.price);
        
        var base_price;
        // console.log(product_price_array.add_on_array[index].option_array);
        for (let k = 0; k < product_type_array.length; k++) {
            var typeID = product_type_array[k].type_id;
            var index = product_price_array.add_on_array.findIndex(p => p.id == typeID);
            if((Array.isArray(product_type_array[k].type_option_id)))
            {
                for (let j = 0; j < product_type_array[k].type_option_id.length; j++) {
                    var type_option_id = product_type_array[k].type_option_id[j];
                    var index2 = product_price_array.add_on_array[index].option_array.findIndex(q => q.option_id == type_option_id );                       
                    var type_price = product_price_array.add_on_array[index].option_array[index2].option_price;
                    defaultPrice = defaultPrice + parseFloat(type_price);
                }
            }
            else
            {
                var type_option_id = product_type_array[k].type_option_id;
                var index2 = product_price_array.add_on_array[index].option_array.findIndex(q => q.option_id == type_option_id );                     
                var type_price = product_price_array.add_on_array[index].option_array[index2].option_price;
                defaultPrice = defaultPrice + parseFloat(type_price);
            }

        }
        return defaultPrice;
    }

    async function select_type(typeID, optionID, multiselect, elem)
    {
        $('#qty').val(1);
        // console.log("typeID: "+typeID+", optionID: "+optionID+", price: "+sizeDefaultPrice);
        var sizeExists = $('#size_exists').val();
        // console.log(sizeExists);
        if(sizeExists == 1)
        {
            var sizeID = $('#size_id').val();
            var index = product_price_array.findIndex(p => p.id == sizeID);
            var sizeDefaultPrice = parseFloat(product_price_array[index].price);
            var base_price;
            if(multiselect === 0)
            {
                // console.log("typeID: "+typeID+", optionID: "+optionID+", price: "+sizeDefaultPrice);
                for (let i = 0; i < product_type_array.length; i++) {
                    if(!(Array.isArray(product_type_array[i].type_option_id)))
                    {
                        if( product_type_array[i].type_id == typeID){
                            product_type_array[i].type_option_id = String(optionID);
                        }
                    }
                }
                var currentPrice = await getPrice_withSize(sizeID);
                $('#base_price').val(currentPrice);
                $('#final_price').val(currentPrice);
                $('.filter-price').html("$ "+currentPrice);
            }
            else
            {
                elem.classList.toggle("select");
                var classname = elem.className;
                if(classname == "highlight select")
                {
                    // console.log("selected");
                    for (let i = 0; i < product_type_array.length; i++) {
                        if((Array.isArray(product_type_array[i].type_option_id)))
                        {
                            if( product_type_array[i].type_id == typeID){

                                if(product_type_array[i].type_option_id.indexOf(optionID) == -1)
                                {
                                    product_type_array[i].type_option_id.push(optionID)
                                }
                            }                            
                        }
                    }
                }
                else
                {
                    // console.log("not selected");
                    for (let i = 0; i < product_type_array.length; i++) {
                        if((Array.isArray(product_type_array[i].type_option_id)))
                        {
                            if( product_type_array[i].type_id == typeID){
                                
                                if(product_type_array[i].type_option_id.indexOf(optionID) != -1)
                                {
                                    product_type_array[i].type_option_id.splice(product_type_array[i].type_option_id.indexOf(optionID), 1);
                                }
                            }
                        }
                    }
                    
                }
                var currentPrice = await getPrice_withSize(sizeID);
                $('#base_price').val(currentPrice);
                $('#final_price').val(currentPrice);
                $('.filter-price').html("$ "+currentPrice);                
            }
        }
        else
        {
            if(multiselect === 0)
            {
                var index = product_price_array.add_on_array.findIndex(p => p.id == typeID);
                var defaultPrice = parseFloat(product_price_array.price);
                var base_price;

                // console.log("typeID: "+typeID+", optionID: "+optionID+", price: "+sizeDefaultPrice);
                for (let i = 0; i < product_type_array.length; i++) {
                    if(!(Array.isArray(product_type_array[i].type_option_id)))
                    {
                        if( product_type_array[i].type_id == typeID){
                            product_type_array[i].type_option_id = String(optionID);
                        }
                    }
                }
                var currentPrice = await getPrice_withoutSize(typeID);
                $('#base_price').val(currentPrice);
                $('#final_price').val(currentPrice);
                $('.filter-price').html("$ "+currentPrice);
            }
            else
            {
                elem.classList.toggle("select");
                var classname = elem.className;
                if(classname == "highlight select")
                {
                    //console.log("selected");
                    for (let i = 0; i < product_type_array.length; i++) {
                        if((Array.isArray(product_type_array[i].type_option_id)))
                        {
                            if( product_type_array[i].type_id == typeID){

                                if(product_type_array[i].type_option_id.indexOf(optionID) == -1)
                                {
                                    product_type_array[i].type_option_id.push(optionID)
                                }
                            }                            
                        }
                    }
                }
                else
                {
                    //console.log("not selected");
                    for (let i = 0; i < product_type_array.length; i++) {
                        if((Array.isArray(product_type_array[i].type_option_id)))
                        {
                            if( product_type_array[i].type_id == typeID){
                                const option_index = product_type_array[i].type_option_id.indexOf(optionID)
                                if(option_index != -1)
                                {
                                    product_type_array[i].type_option_id.splice(option_index, 1);
                                }
                            }
                        }
                    }
                }
                var currentPrice = await getPrice_withoutSize();
                $('#final_price').val(currentPrice);
                $('#base_price').val(currentPrice);
                $('.filter-price').html("$ "+currentPrice);
            }
        }
    }

    function update_price(elem)
    {
        var base_price = $('#base_price').val();
        // console.log(elem.value);
        base_price = base_price * elem.value;
        $('#final_price').val(base_price);
        $('.filter-price').html("$ "+base_price);
    }

    function add_to_cart()
    {
		$.blockUI({
        message: '<img src="<?=base_url()?>dist/admin/img/preloading-white.gif" alt="" class="img-loader-cls"/>',
			css: {
				border: 'none',
				padding: '0px',
				backgroundColor: 'transparent',
				'-webkit-border-radius': '10px',
				'-moz-border-radius': '10px',
				color: '#fff'
			}
		});
        var productID = document.getElementById('product_id').value;
        var finalPrice = document.getElementById('final_price').value;
        var sizeExists = document.getElementById('size_exists').value;
        var quantity = document.getElementById('qty').value;
        if(sizeExists == 1)
        {
            var sizeID = document.getElementById('size_id').value;
        }
        else
        {
            var sizeID = 0;
        }
		$.ajax({
				
				url: '<?php echo base_url()?>' + 'cart/add_to_cart',
				data: {'quantity' : quantity ,'product_id': productID ,'final_price' : finalPrice,'size_id' : sizeID, 'type_array' : product_type_array},
				type: 'POST', 
				dataType: "html",
				cache:false,

				error: function (xhr) {
					console.log(xhr);
				},
				success: function(xhr)
				{
                    // console.log(xhr);
                    var msg = JSON.parse(xhr);
                   
                    var redirectUrl = "<?php echo base_url().'product/'; ?>" + productID;
                    if(msg.error == 0)
                    {
                        if(msg.registered_user != 1)
                        {
                            var total_price = (parseInt(msg.price)).toFixed(2);
                            $('#cart-amnt').html(msg.quantity + " items - <span>$ " +total_price +"</span>");
                            swal(
                                'Success',
                                "Successfully added to cart",
                                'success'
                            ).then(function() {
                                window.location = redirectUrl;
                            });
                        }
                        else
                        {   
                            var redirectUrl = "<?php echo base_url().'product/'; ?>" + productID;
                            swal(
                                'Success',
                                "Successfully added to cart",
                                'success'
                            ).then(function() {
                                window.location = redirectUrl;
                            });
                        }
                    }
                    else
                    {
                        var redirectUrl = "<?php echo base_url().'product/'; ?>" + productID;
                        swal(
                            'Error',
                            "Something went wrong",
                            'error'
                        ).then(function() {
                            window.location = redirectUrl;
                        });
                    }
                    // console.log(msg);
                    
					$.unblockUI();
            		return false;
				},
				
		});
		return false;
    }

    function post_comment(user_id,product_id)
    {
        var comment = document.getElementById('comment').value;
        var formData1 = new FormData(); 
        if(comment == ""){
            alert("Please post a comment");
        }
        else{
            formData1.append('user_id', user_id);
            formData1.append('product_id', product_id);
            formData1.append('comment', comment);

            var xmlHttp = new XMLHttpRequest();
            xmlHttp.onreadystatechange = function()
            {
                if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                {
                    if(xmlHttp.responseText){
                        $('#post_comment_form').trigger("reset");
                        $('#comment_div').html(xmlHttp.responseText);
                    }
                    else{
                        alert("Error Occured");
                    }
                }
            }
            xmlHttp.open("post", "<?php echo base_url().'comment/post_comment'; ?>"); 
            xmlHttp.send(formData1); 
        }
    }
</script>
<div class="sc-dJJlpf kTDRxU">
    <p class="sc-1hez2tp-0 sc-TZjqS fhDAPo">Delivery Address</p>
    <div class="sc-kxyuPp gXbAHG"></div>
</div>
<div class="sc-cGrIXu khMiYs">
    <div>
        <?php if(count($addresses)>0){ 
            foreach ($addresses as $address) { 
                if($address->is_active == '1') {?>
                    <div class="sc-ewTrYR AQYSc">
                        <div class="sc-beROAQ xinvb"><i class="sc-rbbb40-1 iFnyeo" color="#2781E7" size="24"><svg xmlns="http://www.w3.org/2000/svg" fill="#2781E7" width="24" height="24" viewBox="0 0 20 20" aria-labelledby="icon-svg-title- icon-svg-desc-" role="img" class="sc-rbbb40-0 fmIpur"><g clip-path="url(#clip0)"><path d="M14.75 8.3125L9.25 13.8125C9.125 13.9375 8.9375 14.0625 8.75 14.0625C8.5625 14.0625 8.375 14 8.1875 13.8125L5.1875 10.8125C4.875 10.5 4.875 10.0625 5.1875 9.75C5.5 9.4375 5.9375 9.4375 6.25 9.75L8.75 12.1875L13.6875 7.25C14 6.9375 14.4375 6.9375 14.75 7.25C15.0625 7.5625 15.0625 8 14.75 8.3125ZM17.0625 2.9375C13.125 -1 6.8125 -1 2.9375 2.9375C-0.9375 6.8125 -0.9375 13.1875 2.9375 17.0625C6.875 21 13.1875 21 17.125 17.0625C21.0625 13.125 21 6.8125 17.0625 2.9375Z"></path></g><defs><clipPath id="clip0"><rect width="20" height="20"></rect></clipPath></defs></svg></i>
                        </div>
                        <div class="sc-iWdsyN igTohe">
                            <p class="sc-1hez2tp-0 sc-iupvsZ iGQBdM"><?=ucfirst($address->address_name)?></p>
                            <p class="sc-1hez2tp-0 sc-eYTUqP cAGsam"><?=$address->address?>, <?=$address->city?>, landmark- <?=$address->landmark?>, postal code- <?=$address->zipcode?>, city- <?=$address->city?>, Province- <?=get_province_name($address->province_id)?>, Country- <?=get_country_name($address->country_id)?></p>
                            <div class="sc-bXtxjY cSXkfQ">
                                <button role="button" tabindex="0" aria-disabled="false" class="sc-1kx5g6g-1 jrAmIP" onclick="set_default_address(<?=$address->id?>,<?=$address->user_id?>)"><span tabindex="-1" class="sc-1kx5g6g-2 lpnzyc"><span class="sc-1kx5g6g-3 dkwpEa">Deliver here</span></span>
                                </button>
                            </div>
                        </div>
                    </div>
        <?php } else { ?>
            <div class="sc-ewTrYR kuwulx">
                <div class="sc-beROAQ xinvb"><i class="sc-rbbb40-1 iFnyeo" color="#D02A38" size="24"><svg xmlns="http://www.w3.org/2000/svg" fill="#D02A38" width="24" height="24" viewBox="0 0 20 20" aria-labelledby="icon-svg-title- icon-svg-desc-" role="img" class="sc-rbbb40-0 fmIpur"><path d="M10 0C4.5 0 0 4.5 0 10C0 15.5 4.5 20 10 20C15.5 20 20 15.5 20 10C20 4.5 15.5 0 10 0ZM13.375 12.3125C13.6875 12.625 13.6875 13.125 13.375 13.4375C13.25 13.5625 13.0625 13.625 12.875 13.625C12.6875 13.625 12.5 13.5 12.375 13.4375L10 11.125L7.6875 13.4375C7.5625 13.5625 7.375 13.625 7.1875 13.625C7 13.625 6.8125 13.5 6.6875 13.4375C6.375 13.125 6.375 12.625 6.6875 12.3125L8.875 10L6.5625 7.6875C6.25 7.375 6.25 6.875 6.5625 6.5625C6.875 6.25 7.375 6.25 7.6875 6.5625L10 8.875L12.3125 6.5625C12.625 6.25 13.125 6.25 13.4375 6.5625C13.75 6.875 13.75 7.375 13.4375 7.6875L11.125 10L13.375 12.3125Z"></path></svg></i>
                </div>
                <div class="sc-iWdsyN igTohe">
                    <p class="sc-1hez2tp-0 sc-iupvsZ iGQBdM"><?=ucfirst($address->address_name)?></p>
                    <p class="sc-1hez2tp-0 sc-eYTUqP cAGsam"><?=$address->address?>, <?=$address->city?>, landmark- <?=$address->landmark?>, postal code- <?=$address->zipcode?>, city- <?=$address->city?>, Province- <?=get_province_name($address->province_id)?>, Country- <?=get_country_name($address->country_id)?></p>
                    <div class="sc-bXtxjY cSXkfQ">
                        <button role="button" tabindex="0" aria-disabled="false" class="sc-1kx5g6g-1 jrAmIP" onclick="set_default_address(<?=$address->id?>,<?=$address->user_id?>)"><span tabindex="-1" class="sc-1kx5g6g-2 lpnzyc"><span class="sc-1kx5g6g-3 dkwpEa">Deliver here</span></span>
                        </button>
                    </div>
                </div>
            </div>
        <?php } } } ?> 
    </div>
</div>
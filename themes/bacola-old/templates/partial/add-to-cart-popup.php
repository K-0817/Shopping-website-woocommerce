<script>
let tl_addToCartAjax = {
    prodData: {
        inCart: 0,
        maxQnt: 0,
        minQnt: 0,
        prodId: 0,
        variationId: 0,
    },
    Selectors: {
        popUpIdSelector: '#add-to-cart-popup',
        selectorProdAmount: '#js-add-2-cart-ajax-amount',
        selectorTipIsMaxQnt: '.tip-is-max-amount',
        selectorBtnPlus: '[attr-js-selecor="btn-plus"] div',
        selectorBtnMinus: '[attr-js-selecor="btn-minus"] div',
        selectorPopupImg: '#add-to-cart-popup .catalog__item-img.img-wrap img',
        selectorPopupTitle: '#add-to-cart-popup [attr-js-selecot="item-title"]',
        selectorFooterCartAmount: '[attr-js-selector="footer-cart-amount"]',
        selectorPrice: '[attr-js-selector="price-popup"]',
    },
    lastClickedChange: 0,
    clickedProdElem: null,
    closePopup: function () {
        document.querySelector(this.Selectors.popUpIdSelector).classList.add('dn');
    },
    openPopup: function (type, elem) {
        this.clickedProdElem = elem;
        { //prepare data for using
            this.prodData.inCart = elem.dataset.inCart * 1;
            this.prodData.minQnt = elem.dataset.minQnt * 1;
            this.prodData.maxQnt = elem.dataset.maxQnt * 1;
            this.prodData.prodId = elem.dataset.prodId * 1;
            this.prodData.variationId = elem.dataset.variationId * 1;
            let prodWrap = elem.closest('[attr-js-prod-wrap]');
            document.querySelector(this.Selectors.selectorPopupImg)
                .setAttribute(
                    'src',
                    prodWrap.querySelector('.catalog__item-img.img-wrap img').getAttribute('src')
                );
            document.querySelector(this.Selectors.selectorPopupTitle).innerHTML = prodWrap.querySelector('.catalog__item-title').innerHTML;
            document.querySelector(this.Selectors.selectorPrice).innerHTML = elem.querySelector('.catalog__btn-price').innerHTML;
        }
        document.querySelector(this.Selectors.popUpIdSelector).classList.remove('dn');
        document.querySelector(this.Selectors.selectorProdAmount).innerHTML = this.prodData.inCart;
        this.updateUiAfterChenges();
        this.clickPlus();
    },
    clickPlus: function () {
        this.prodData.inCart += 1;
        if (this.prodData.inCart > this.prodData.maxQnt) {
            this.prodData.inCart = this.prodData.maxQnt;
        } else {
            document.querySelector(this.Selectors.selectorProdAmount).innerHTML = this.prodData.inCart;
            this.doAjaxToUpdate();
        }
        this.updateUiAfterChenges();
    },
    clickMinus: function () {
        this.prodData.inCart -= 1;
        if (this.prodData.inCart < this.prodData.minQnt) {
            this.prodData.inCart = this.prodData.minQnt;
        } else {
            document.querySelector(this.Selectors.selectorProdAmount).innerHTML = this.prodData.inCart;
            this.doAjaxToUpdate();
        }
        this.updateUiAfterChenges();
    },
    deleteProd: function () {
        this.prodData.inCart = 0;
        this.doAjaxToUpdate();
        this.closePopup();
        tl_ItemRemoved.openPupup();
    },
    updateInCart: function () {
        this.clickedProdElem.setAttribute('data-in-cart', this.prodData.inCart);
    },
    updateUiAfterChenges: function () {
        {//reset all
            document.querySelector(this.Selectors.selectorTipIsMaxQnt).classList.add('dn');
            document.querySelector(this.Selectors.selectorBtnPlus).classList.remove('tl-disable-qnt-btn');
            document.querySelector(this.Selectors.selectorBtnMinus).classList.remove('tl-disable-qnt-btn');

        }
        if (this.prodData.inCart == this.prodData.maxQnt) {
            document.querySelector(this.Selectors.selectorTipIsMaxQnt).classList.remove('dn');
            document.querySelector(this.Selectors.selectorBtnPlus).classList.add('tl-disable-qnt-btn');
        }
        if (this.prodData.inCart == this.prodData.minQnt) {
            document.querySelector(this.Selectors.selectorBtnMinus).classList.add('tl-disable-qnt-btn');
        }

    },
    doAjaxToUpdate: function () {
        this.updateInCart();
        this.lastClickedChange = new Date().getTime() / 1000;
        jQuery.ajax({
            url: tl_config.myAjaxUrl,
            data: {
                "action": "qty_cart",
                "product_id": this.prodData.prodId,
                "variation_id": this.prodData.variationId,
                "quantity": this.prodData.inCart,
                "lastClickedChange": this.lastClickedChange
            },
            type: "POST"
        })
            .done((data) => {
                {
                    if (data.lastClickedChange == this.lastClickedChange)
                        document.querySelector(tl_addToCartAjax.Selectors.selectorFooterCartAmount).innerText = data.cart_contents_count;
                }
            });
    }
}
</script>


<div id="add-to-cart-popup" class="tl-popup-main-wrap dn">
	<div class="pp-wrap">
		<div class="pp-title location__title">item added to basket</div>
		<div class="pp-item_wrap">
			<div>
				<div class="catalog__item-img img-wrap">
					<div>
						<picture>
							<img src="" alt="Royco Bouillon Beef Cube – 4g*40 pieces">
						</picture>
					</div>
				</div>
				<div class="tl-price" attr-js-selector="price-popup">KSh 18.00</div>
			</div>
			<div class="tl-item-title" attr-js-selecot="item-title">
				Royco Boullion Beef Cube - 4g - Pamoja +-
			</div>
		</div>
		<div class="pp-amount--controll">
			<div class="change-amount-controll">
				<div 
					class="change-amount-controll--minus" 
					attr-js-selecor="btn-minus"
					onclick="tl_addToCartAjax.clickMinus()"
					>
					<div class="tl-fake-minu">-</div>
				</div>
				<div class="change-amount-controll--amount" id="js-add-2-cart-ajax-amount">XX</div>
				<div 
					class="change-amount-controll--plus" 
					attr-js-selecor="btn-plus" 
					onclick="tl_addToCartAjax.clickPlus()"
				>
					<div class="tl-fake-plus">+</div>
				</div>
			</div>
			<div class="tl-remove" onclick="tl_addToCartAjax.deleteProd(event)">
				<svg width="12px" height="14px" viewBox="0 0 12 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<title>trash-svgrepo-com@4x</title>
					<g id="🚀-BASKET-MANAGEMENT" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<g id="Item-Added-to-Basket---Popup" transform="translate(-194.000000, -193.000000)" fill="#F24750" fill-rule="nonzero">
							<g id="modal" transform="translate(20.000000, 60.000000)">
								<g id="basket-item-2" transform="translate(20.000000, 60.000000)">
									<g id="Group-6" transform="translate(0.000000, 60.000000)">
										<g id="btn-edit-details" transform="translate(140.000000, 0.000000)">
											<g id="trash-svgrepo-com" transform="translate(14.000000, 13.000000)">
												<path d="M10.5,2.625 L9.1875,2.625 L9.1875,0.875 C9.1875,0.39178125 8.79571875,0 8.3125,0 L3.0625,0 C2.57928125,0 2.1875,0.39178125 2.1875,0.875 L2.1875,2.625 L0.875,2.625 C0.39178125,2.625 0,3.01678125 0,3.5 L0,4.375 L11.375,4.375 L11.375,3.5 C11.375,3.01678125 10.9832188,2.625 10.5,2.625 Z M3.9375,2.625 L3.9375,1.75 L7.4375,1.75 L7.4375,2.625 L3.9375,2.625 Z" id="Shape"></path>
												<path d="M0.875,13.1251094 C0.875,13.6083281 1.26667188,14 1.74989063,14 L9.62521875,14 C10.1083281,14 10.5,13.6083281 10.5,13.1252187 L10.5,13.1251094 L10.5,5.25 L0.875,5.25 L0.875,13.1251094 Z M7.4375,7.4375 C7.4375,7.19589062 7.63339063,7 7.875,7 C8.11660938,7 8.3125,7.19589062 8.3125,7.4375 L8.3125,11.8125 C8.3125,12.0541094 8.11660938,12.25 7.875,12.25 C7.63339063,12.25 7.4375,12.0541094 7.4375,11.8125 L7.4375,7.4375 Z M5.25,7.4375 C5.25,7.19589062 5.44589063,7 5.6875,7 C5.92910938,7 6.125,7.19589062 6.125,7.4375 L6.125,11.8125 C6.125,12.0541094 5.92910938,12.25 5.6875,12.25 C5.44589063,12.25 5.25,12.0541094 5.25,11.8125 L5.25,7.4375 Z M3.0625,7.4375 C3.0625,7.19589062 3.25839063,7 3.5,7 C3.74160938,7 3.9375,7.19589062 3.9375,7.4375 L3.9375,11.8125 C3.9375,12.0541094 3.74160938,12.25 3.5,12.25 C3.25839063,12.25 3.0625,12.0541094 3.0625,11.8125 L3.0625,7.4375 Z" id="Shape"></path>
											</g>
										</g>
									</g>
								</g>
							</g>
						</g>
					</g>
				</svg>
				<span>
					Remove
				</span>
			</div>
		</div>
		<span class="tip-is-max-amount df"> Maximum quantity reached for this item </span>
		<div class="pp-controll-links">
			<a class="tl-start-checkout xoo-cp-btn-ch xcp-btn" href="<?php echo wc_get_checkout_url(); ?>">Start Checkout</a>
			<div>or</div>
			<a class="tl-continue-shopping" onclick="tl_addToCartAjax.closePopup()">continue shopping</a>
		</div>
	</div>
    <div onclick="tl_addToCartAjax.closePopup()" class="pp-bg"></div>
</div>
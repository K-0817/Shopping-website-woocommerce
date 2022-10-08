let tl_addToCartWrap = {
    handler_AddProduct: function (prodType, element) {
        // window.element = element;
        // console.log(prodType, element);
        tl_addToCartAjax.openPopup(prodType, element);
        // element.closest('[attr-js-prod-wrap]')
        //     .querySelector(`[attr-js-hidden-form] form [value=${prodType}]`)
        //     .closest('form')
        //     .querySelector('button')
        //     .click()
    }
}

function tl_closeShopFilter() {
    window.hideCategories();
    document.querySelector('#js-tl-header').classList.remove("dn");
}

function tl_showSelectLocationPopup() {
    document.querySelector('.site-location a').click();
}
if(window.needSelectLocation){
    setTimeout(function() { tl_showSelectLocationPopup(); }, 1000);
}

function tl_closeLocationPopup() {
    document.querySelector('#hidelc > div.location-overlay.dn').click();
}

let btnMoveTop = document.querySelector('#move-top');
if(btnMoveTop != null){
    btnMoveTop.addEventListener('click', function(e){
            e.preventDefault();
            window.scrollTo({top: 0, behavior: 'smooth'}
        );
    });
}

try{
    document.querySelectorAll('.quantity-button.plus')
    .forEach(el=>
        el.addEventListener('click', e=>(tl_changedAmounInCart(e, 1)))
    );
    document.querySelectorAll('.quantity-button.minus')
    .forEach(el=>
        el.addEventListener('click', e=>(tl_changedAmounInCart(e, -1)))
    );
    function tl_changedAmounInCart(e, changeAm){
        let inpElem = e.target.closest("div.quantity").querySelector('input.input-text.qty');
        let hasAm = parseInt(inpElem.value) + changeAm;
        let maxAm = inpElem.getAttribute('max');
        if(hasAm >= maxAm){
            e.target.closest('.tl-main-cart-content').parentElement.querySelector('.tip-is-max-amount').classList.remove('dn');
        } else{
            e.target.closest('.tl-main-cart-content').parentElement.querySelector('.tip-is-max-amount').classList.add('dn');
        }
    }
} catch(e){
    console.log('err/ maby not cart page')
}

let isShopPage = document.querySelector('.footer__list-item--home');
if(isShopPage != null){
    isShopPage.addEventListener('click', function(e){
            e.preventDefault();
            window.scrollTo({top: 0, behavior: 'smooth'}
        );
    });
}

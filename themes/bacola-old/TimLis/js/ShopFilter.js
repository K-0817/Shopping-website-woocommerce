let tl_shopFiltersControll = {
    filterActiveCategories: [],
    filterWasInit: false,
    openFilters: function () {
        this.initFilter();
        window.showCategories();
        document.querySelector('#js-tl-header').classList.add("dn");
    },
    initFilter: function () {
        if (this.filterWasInit)
            return;
        this.filterWasInit = true;
        var allCatLi = document.querySelectorAll('#js-tl-categories-wrpa > div > div.widget.widget_klb_product_categories > div > div > ul > li')
        var newParentWrap = document.querySelector('#js-tl-categories-wrpa > div > div.categories__body > div.categories__checkbox.checkbox');
        allCatLi.forEach(el => {
            newParentWrap.innerHTML += " " + this.createNewCategoryCheckbox(
                el.querySelector('[name="product_cat[]"]').getAttribute('value'),
                el.querySelector('label').textContent,
                el.querySelector('[name="product_cat[]"]').getAttribute('checked') == null ? false : true
            );
        });
        document.querySelectorAll('.widget').forEach(e => e.classList.add('dn'));
        if (window.location.search.includes('filter_cat')) {
            this.filterActiveCategories = new URLSearchParams(window.location.search).get('filter_cat').split(",");
            this.makeActiveClearBtn(this.filterActiveCategories.length != 0);
        }
    },
    createNewCategoryCheckbox: function (val, title, checked) {
        if (checked)
            this.filterActiveCategories.push(val);
        var res = `
        <label class="checkbox__label" for="checkbox-${val}" attr-js-val="${val}">
            <input 
                onclick="tl_shopFiltersControll.clickOption(${val})"
                class="checkbox__input" type="checkbox" id="checkbox-${val}" 
                name="checkbox-categories"${checked ? 'checked' : ''}
            >
            <span class="checkbox__content"></span>${title}
        </label>`;
        return res;
    },
    htmlToElements: function (html) {
        var template = document.createElement('template');
        template.innerHTML = html;
        return template.content.childNodes;
    },
    clickOption: function (prodCatId) {
        prodCatId += '';
        let activeSelectedparams = this.filterActiveCategories;
        var index = activeSelectedparams.indexOf(prodCatId)
        if (index == -1) {
            activeSelectedparams.push(prodCatId);
        } else {
            activeSelectedparams.splice(index);
        }
        this.filterActiveCategories = activeSelectedparams;
        this.makeActiveApplyBtn();
        this.makeActiveClearBtn(activeSelectedparams.length != 0);
    },
    makeActiveApplyBtn: function () {
        document.querySelector('#js-tl-categories-wrpa [attr-js-filter-shop-aplly]')
            .classList.remove('categories__btn--opacity');
    },
    makeActiveClearBtn: function (doActive) {
        try {
            if (doActive)
                document.querySelector('#js-tl-categories-wrpa [attr-js-filter-shop-clear]')
                    .classList.remove('categories__btn--opacity');
            else
                document.querySelector('#js-tl-categories-wrpa [attr-js-filter-shop-clear]')
                    .classList.add('categories__btn--opacity');
        } catch (e) {
            // window.location = window.location.origin;
        }

    },
    handlerApplyFilter: function () {
        let s = new URLSearchParams(window.location.search);
        s.set('filter_cat', this.filterActiveCategories);
        let newSearchParams = "";
        s.forEach((v, k) => {
            newSearchParams += "&";
            if (v == "") {
                if (k == "filter_cat")
                    return;
                newSearchParams += k;
            } else {
                newSearchParams += `${k}=${v}`;
            }
        });
        newSearchParams = newSearchParams.substring(1);
        // console.log(newSearchParams);
        window.location.search = newSearchParams;
    },
    handlerClearFilter: function () {
        this.filterActiveCategories = [];
        this.handlerApplyFilter();
    }
}

try {
    let categories = document.querySelector('.categories');
    let categoriesBtn = document.querySelector('.header__categories');
    let categoriesWrap = document.querySelector('.categories__wrap');
    let closeCategories = document.querySelector('.categories__act--close');
    window.MenuAllow = true;

    window.showCategories = function () {
        if (categories == null) {
            window.location = window.location.origin;
            return;
        }
        if (window.MenuAllow) {
            window.MenuAllow = false;
            categories.classList.add('categories--active');
            categories.classList.add('categories--opacity0');
            raf(function () {
                categories.classList.add('categories--opacity1');
            });

            function leftMenu() {
                categoriesWrap.classList.add('categories__wrap--left0');
                if (event.propertyName == 'right') {
                    window.MenuAllow = true; //-
                    categories.removeEventListener('transitionend', leftMenu);
                }
            }

            categories.addEventListener('transitionend', leftMenu);
        }
    }

    window.hideCategories = function () {
        let mobileActive = document.querySelector(".categories--active")
        if (window.MenuAllow) {
            if (mobileActive) {
                window.MenuAllow = false;
                categoriesWrap.classList.remove('categories__wrap--left0');

                function xxx() {
                    categories.classList.remove('categories--opacity1');
                    categories.classList.remove('categories--opacity0');
                    setTimeout(function () {
                        categories.classList.remove('categories--active');
                        window.MenuAllow = true;
                    }, 500);
                    categoriesWrap.removeEventListener('transitionend', xxx);
                }

                categoriesWrap.addEventListener('transitionend', xxx);
            }
        }
    }
    function raf(fn) {
        window.requestAnimationFrame(function () {
            window.requestAnimationFrame(function () {
                fn();
            });
        });
    }
} catch (e) {
    console.log("some err");
}
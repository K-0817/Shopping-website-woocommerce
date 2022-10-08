const selectorRealForm = '[attr-js-selector="real-sign-in-form"]';
let tl_loginController = {
  settings: {
    initialCountryCode: '254', // 254
    countDownRetriveCode: null, // cd for requst code
    cdLeftSeconds: 30,
  },
  selectors: {
    realInputField:
      '[attr-js-selector="real-sign-in-form"] [name="xoo-ml-reg-phone"]',
    realBtnContinue:
      '[attr-js-selector="real-sign-in-form"] [type="submit"]',
    realCountreCode:
      '[attr-js-selector="real-sign-in-form"] [name="xoo-ml-reg-phone-cc"]',
    fakeBtnContinue:
      '.tl-sign-in-pp [attr-js-selector="fake-continue-btn"]',
    fakeCountreCode: '[attr-js-selector="fake-select-country-code"]',
    fakeSecureCodeCode: '[attr-js-selector="fake-secaure-code"]',
    popups: {
      inputPhone: '[attr-js-selecotr="pp-input-phone"]',
      waitingSecureCode:
        '[attr-js-selecotr="pp-waining-secure-code"]',
      enterSecureCode: '[attr-js-selecotr="pp-enter-secure-code"]',
      enterSecureCodeAgain: '[attr-js-selecotr="pp-enter-secure-code-again"]',
      errorModal: '[attr-js-selecotr="error-modal"]',
      ppLoading: '[attr-js-selecotr="pp-loading"]',
      fullPhonenPopup: '#styled-fake-sign-in-form',
    },
  },
  popups: {
    closeAllPopups: function (closePopupBg) {
      jQuery(tl_loginController.selectors.popups.inputPhone).addClass(
        'dn'
      );
      jQuery(
        tl_loginController.selectors.popups.enterSecureCode
      ).addClass('dn');
      jQuery(
        tl_loginController.selectors.popups.enterSecureCodeAgain
      ).addClass('dn');
      jQuery(
        tl_loginController.selectors.popups.fakeInputPhonenPopup
      ).addClass('dn');
      jQuery(tl_loginController.selectors.popups.ppLoading).addClass(
        'dn'
      );
      jQuery(tl_loginController.selectors.popups.errorModal).addClass(
        'dn'
      );      
      if (closePopupBg) {
        jQuery(
          tl_loginController.selectors.popups.fullPhonenPopup
        ).addClass('dn');
        console.log('HARD CLOSE');
      }
    },
    openInputPhone: function () {
      jQuery(
        tl_loginController.selectors.popups.fullPhonenPopup
      ).removeClass('dn');
      jQuery(
        tl_loginController.selectors.popups.inputPhone
      ).removeClass('dn');
      clearInterval(tl_loginController.settings.countDownRetriveCode);
    },
    closeSeelctCountryCode: function () {
      jQuery('#popup-select-country-code').addClass('dn');
    },
    openSeelctCountryCode: function () {
      jQuery('#popup-select-country-code').removeClass('dn');
    },
    openWaitingPp: function () {
      tl_loginController.popups.closeAllPopups();
      jQuery(
        tl_loginController.selectors.popups.ppLoading
      ).removeClass('dn');
    },
    openEnterSecureCodePp: function () {
      clearInterval(tl_loginController.settings.countDownRetriveCode);
      jQuery('[attr-js-selector="inserted-number"]').text(
        jQuery(tl_loginController.selectors.realCountreCode).val() +
          jQuery(tl_loginController.selectors.realInputField).val()
      );
      tl_loginController.popups.closeAllPopups();
      jQuery(
        tl_loginController.selectors.popups.enterSecureCode
      ).removeClass('dn');
      const controllRetriveBtns = (canRetrive) => {
        const hidSelelctor = canRetrive
          ? tl_loginController.selectors.popups.enterSecureCode +
            ' .tl-btn__request-sms-timer'
          : tl_loginController.selectors.popups.enterSecureCode +
            ' .tl-btn__request-sms-active';
        const showSelelctor = canRetrive
          ? tl_loginController.selectors.popups.enterSecureCode +
            ' .tl-btn__request-sms-active'
          : tl_loginController.selectors.popups.enterSecureCode +
            ' .tl-btn__request-sms-timer';
        jQuery(hidSelelctor).addClass('dn');
        jQuery(showSelelctor).removeClass('dn');
      };
      controllRetriveBtns(false);

      tl_loginController.settings.cdLeftSeconds = 30;
      tl_loginController.settings.countDownRetriveCode = setInterval(
        function () {
          --tl_loginController.settings.cdLeftSeconds;
          jQuery(
            tl_loginController.selectors.popups.enterSecureCode +
              ' [attr-js-selector="countdown"]'
          ).text('00:' + tl_loginController.settings.cdLeftSeconds);
          if (tl_loginController.settings.cdLeftSeconds <= 0) {
            console.log('clear');
            clearInterval(
              tl_loginController.settings.countDownRetriveCode
            );
            controllRetriveBtns(true);
          }
        },
        1000
      );
      tl_loginController.popups.closeAllPopups();
      jQuery(
        tl_loginController.selectors.popups.enterSecureCode
      ).removeClass('dn');
    },
    openEnterSecureCodePpAgain: function () {
      clearInterval(tl_loginController.settings.countDownRetriveCode);
      jQuery('[attr-js-selector="inserted-number"]').text(
        jQuery(tl_loginController.selectors.realCountreCode).val() +
          jQuery(tl_loginController.selectors.realInputField).val()
      );
      tl_loginController.popups.closeAllPopups();
      jQuery(
        tl_loginController.selectors.popups.enterSecureCodeAgain
      ).removeClass('dn');
      const controllRetriveBtns = (canRetrive) => {
        const hidSelelctor = canRetrive
          ? tl_loginController.selectors.popups.enterSecureCodeAgain +
            ' .tl-btn__request-sms-timer'
          : tl_loginController.selectors.popups.enterSecureCodeAgain +
            ' .tl-btn__request-sms-active';
        const showSelelctor = canRetrive
          ? tl_loginController.selectors.popups.enterSecureCodeAgain +
            ' .tl-btn__request-sms-active'
          : tl_loginController.selectors.popups.enterSecureCodeAgain +
            ' .tl-btn__request-sms-timer';
        jQuery(hidSelelctor).addClass('dn');
        jQuery(showSelelctor).removeClass('dn');
      };
      controllRetriveBtns(false);

      tl_loginController.settings.cdLeftSeconds = 30;
      tl_loginController.settings.countDownRetriveCode = setInterval(
        function () {
          --tl_loginController.settings.cdLeftSeconds;
          jQuery(
            tl_loginController.selectors.popups.enterSecureCodeAgain +
              ' [attr-js-selector="countdown"]'
          ).text('00:' + tl_loginController.settings.cdLeftSeconds);
          if (tl_loginController.settings.cdLeftSeconds <= 0) {
            console.log('clear');
            clearInterval(
              tl_loginController.settings.countDownRetriveCode
            );
            controllRetriveBtns(true);
          }
        },
        1000
      );
      tl_loginController.popups.closeAllPopups();
      jQuery(
        tl_loginController.selectors.popups.enterSecureCodeAgain
      ).removeClass('dn');
    },
  },
  ppInputPhone: {
    onMobilePhoneInput: function (input) {
      input.value = input.value
        .replace(/[^0-9.]/g, '')
        .replace(/(\..*)\./g, '$1');
      jQuery(tl_loginController.selectors.realInputField)
        .val(input.value)
        .trigger('keyup');
      tl_loginController.ppInputPhone.afterMobPhoneChanged();
    },
    onCountryCodeInput: function (input) {
      input.value = input.value
        .replace(/[^0-9.]/g, '')
        .replace(/(\..*)\./g, '$1');
      input.setAttribute('size', input.value.length * 2.2);
      jQuery(tl_loginController.selectors.realCountreCode).val(
        '+' + input.value
      );
    },
    afterMobPhoneChanged: function () {
      if (tl_loginController.ppInputPhone.isValidUserPhone()) {
        jQuery(tl_loginController.selectors.fakeBtnContinue).addClass(
          'is-valid'
        ).removeClass('tl-phone-btn__disable');
      } else {
        jQuery(
          tl_loginController.selectors.fakeBtnContinue
        ).removeClass('is-valid').addClass('tl-phone-btn__disable');
      }
    },
    isValidUserPhone: function () {
      return jQuery(
        tl_loginController.selectors.realBtnContinue
      ).hasClass('active');
    },
    continue2getCode: function (event) {
      event = event || window.event;
      let isValid = event.target.classList.contains('is-valid');
      console.log('continue2getCode');

      if (isValid) {
        tl_loginController.popups.openWaitingPp();
        jQuery
          .ajax({
            url: tl_config.myAjaxUrl,
            data: {
              'xoo-ml-reg-phone-cc': jQuery(
                tl_loginController.selectors.realCountreCode
              ).val(),
              'xoo-ml-reg-phone': jQuery(
                tl_loginController.selectors.realInputField
              ).val(),
              'xoo-ml-otp-input':
                jQuery(
                  selectorRealForm + ' [name="xoo-ml-otp-input"]'
                ).val() ?? '',
              'xoo-ml-form-token': jQuery(
                selectorRealForm + ' [name="xoo-ml-form-token"]'
              ).val(),
              'xoo-ml-form-type': jQuery(
                selectorRealForm + ' [name="xoo-ml-form-type"]'
              ).val(),
              'xoo-ml-otp-form-display': jQuery(
                selectorRealForm + ' [name="xoo-ml-otp-form-display"]'
              ).val(),
              'xoo-ml-login-with-otp': jQuery(
                selectorRealForm + ' [name="xoo-ml-login-with-otp"]'
              ).val(),
              redirect: jQuery(
                selectorRealForm + ' [name="redirect"]'
              ).val(),
              action: 'xoo_ml_request_otp',
            },
            type: 'POST',
          })
          .done((data) => {
            {
              window.r = data;              
              tl_loginController.popups.closeAllPopups();
              if (data.error == 0) {
                //   tl_loginController.popups.openWaitingSecureCodePp();
                tl_loginController.popups.openEnterSecureCodePp();
              } else if (data.e_code == 'exists') {
                jQuery(tl_loginController.selectors.popups.errorModal).removeClass(
                  'dn'
                ); 
              } else {
                alert(jQuery(data.notice).text());
                tl_loginController.popups.openInputPhone();
              }
              jQuery('.tl-fake-secure-code-ipnut input').each(function() {
                jQuery(this).val('').removeClass('active');
              })
            }
          }).fail(function(data) {
            alert('Please try again later.');
            tl_loginController.popups.closeAllPopups(true);
          });        
      }
    },
    showCountryCodes: function () {
      jQuery('#menu-country-code').removeClass('disabled');
    },
    onClickCountryCode: function (contryCode) {
      contryCode = '+' + contryCode;
      jQuery(tl_loginController.selectors.realCountreCode).val(
        contryCode
      );
      jQuery('#menu-country-code').addClass('disabled');
      jQuery('#fake-prev-country-code').text(`(${contryCode})`);
    },
  },
  ppInputSecureCode: {
    changeHandler: function (elem) {
      let newVal = elem.value
        .replace(/[^0-9.]/g, '')
        .replace(/(\..*)\./g, '$1');
      newVal = newVal.substr(newVal.length - 1);
      elem.value = newVal;
      if (elem.value != '') {
        jQuery(elem).addClass('active');
        try {          
          elem.nextElementSibling.select();
          elem.nextElementSibling.selectionStart =
            elem.nextElementSibling.selectionEnd =
              elem.nextElementSibling.value.length;
        } catch (e) {}
      }
      tl_loginController.ppInputSecureCode.updateContinueBtn();
    },
    updateContinueBtn: function () {
      if (tl_loginController.ppInputSecureCode.secureCodeFull()) {
        jQuery(
          '[attr-js-selector="fake-apply-secure-code-btn"]'
        ).addClass('tl-btn__active');        
        tl_loginController.ppInputSecureCode.confirmSecureCode()
      } else {
        jQuery(
          '[attr-js-selector="fake-apply-secure-code-btn"]'
        ).removeClass('tl-btn__active');
      }
    },
    secureCodeFull: function () {
      return (
        tl_loginController.ppInputSecureCode.secureCode().length == 4
      );
    },
    secureCode: function (clearCode) {
      let code = '';
      if (clearCode) {
        jQuery('.tl-fake-secure-code-ipnut input').each(function() {
          jQuery(this).val('').removeClass('active');
        })
        return code;
      }      
      jQuery('.tl-fake-secure-code-ipnut input').each(function () {
        code += jQuery(this).val();
      });
      return code;
    },
    confirmSecureCode: function () {
      console.log('confirmSecureCode');
      if (!tl_loginController.ppInputSecureCode.secureCodeFull()) {
        console.log('NOT secureCodeFull');
        return;
      }
      tl_loginController.popups.openWaitingPp();
      jQuery
        .ajax({
          url: tl_config.myAjaxUrl,
          data: {
            otp: tl_loginController.ppInputSecureCode.secureCode(),
            token: jQuery('[name="xoo-ml-form-token"]').val(),
            action: 'xoo_ml_otp_form_submit',
            'parentFormData[xoo-ml-reg-phone-cc]': jQuery(
              selectorRealForm + ' [name="xoo-ml-reg-phone-cc"]'
            ).val(),
            'parentFormData[xoo-ml-reg-phone]': jQuery(
              selectorRealForm + ' [name="xoo-ml-reg-phone"]'
            ).val(),
            'parentFormData[xoo-ml-otp-input]': jQuery(
              selectorRealForm + ' [name="xoo-ml-form-token"]'
            ).val(),
            'parentFormData[xoo-ml-form-token]': jQuery(
              selectorRealForm + ' [name="xoo-ml-form-token"]'
            ).val(),
            'parentFormData[xoo-ml-form-type]': jQuery(
              selectorRealForm + ' [name="xoo-ml-form-type"]'
            ).val(),
            'parentFormData[xoo-ml-otp-form-display]': jQuery(
              selectorRealForm + ' [name="xoo-ml-otp-form-display"]'
            ).val(),
            'parentFormData[redirect]': jQuery(
              selectorRealForm + ' [name="redirect"]'
            ).val(),
            'parentFormData[xoo-ml-login-with-otp]': jQuery(
              selectorRealForm + ' [name="xoo-ml-login-with-otp"]'
            ).val(),
          },
          type: 'POST',
        })
        .done((data) => {
          {
            window.r = data;
            console.log(data);
            if (data.error == 0) {
              window.location.href = window.location.origin + data.redirect;
            } else {
              tl_loginController.popups.openEnterSecureCodePpAgain();   
              tl_loginController.ppInputSecureCode.secureCode(true);     
            }
          } 
        });
    },
  },
  Init: function () {
    tl_loginController.ppInputPhone.onClickCountryCode(
      tl_loginController.settings.initialCountryCode
    );
    {
      let parentToAddOptions = jQuery('#menu-country-code');
      window.allCountriesCodes = [];
      //   const allCountriesCodes = [];
      jQuery(
        '[attr-js-selector="real-sign-in-form"] select option'
      ).each(function (index) {
        if (index == 0) return;
        allCountriesCodes.push({
          val: jQuery(this).val(),
          cc: jQuery(this).attr('data-cc'),
          text: jQuery(this).text(),
        });
      });
      allCountriesCodes.sort((a, b) => a.cc.localeCompare(b.cc));
      allCountriesCodes.forEach((ccd) => {
        parentToAddOptions.append(
          `<div 
              data-val="${ccd.val}"
              data-cc="${ccd.cc}"
              onclick="tl_loginController.ppInputPhone.onClickCountryCode(${ccd.val})"
            >
              ${ccd.text}
            </div>`
        );
      });
    }
  },
};

jQuery(document).ready(function () {
  jQuery('[attr-js-selector="sign-in-link"]').click(function (event) {
    event.preventDefault();
    tl_loginController.popups.openInputPhone();
  });
  setTimeout(function () {
    tl_loginController.Init();
    if (
      jQuery('body').hasClass('woocommerce-checkout') &&
      jQuery('body').hasClass('logged-out')
    )
      tl_loginController.popups.openInputPhone();

    // tl_loginController.popups.openInputPhone();
    // tl_loginController.popups.openEnterSecureCodePp();
    // tl_loginController.popups.openInputPhone();
    // tl_loginController.popups.openWaitingPp();
    // tl_loginController.popups.openWaitingSecureCodePp();
  }, 250);
});

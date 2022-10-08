
<div attr-js-selector="real-sign-in-form" class="dn" style="position:absolute;top:34px;">
  <?php
    Xoo_Ml_Phone_Frontend::get_instance()->wc_login_with_otp_form();
  ?>
</div>
<div id="styled-fake-sign-in-form" class="dn">
    <div class="dark-bg popup-bg d n" onclick="tl_loginController.popups.closeAllPopups(true)"></div>
    <div class="tl-sign-in-pp tl-pp-root">

        <div class="modal-sign-in tl-popup-content-wrap dn" attr-js-selecotr="pp-input-phone">
            <span class="tl-popup-title">Sign In</span>
            <div>
                <div class="fake-select-country-code dn" attr-js-selector="fake-select-country-code">
                </div>
            </div>
            <div class="tl-mobile-input">                
                <div class="tl-inpt-mobile-wrap">
                    <span class="tl-inpt-mobile-wrap__title">Mobile Number*</span>
                    <div class="tl-select-full-number-wrap df">
                        <div 
                            class="tl-select-country-code df" 
                            js-selector="tl-select-country-code" 
                        >
                            <div class="df">
                                <div 
                                    id='fake-prev-country-code' 
                                    class="tl-country-code-result"
                                    onclick="tl_loginController.ppInputPhone.showCountryCodes()"
                                >initialval</div>
                                <div 
                                    id='menu-country-code' 
                                    class="disabled"    
                                ></div>
                                <?php get_template_part( 'TimLis/svg/arrow-down' ); ?>
                            </div>
                        </div>
                        <input type="tel" class="tl-main-phone-number" name="tl-main-phone-number"
                            placeholder="e.g. 7xxxxxxxx"
                            oninput="tl_loginController.ppInputPhone.onMobilePhoneInput(this);" 
                        />
                    </div>
                </div>
            </div>
            <div class="tl-text-after-phone-number">
                A 6-digit verification code will be sent via SMS to the mobile number provided above.
            </div>
            <div class="tl-phone-additional-text">
                Important: Please make sure you can recieve SMS messages on the mobile number you’ve entered and that the device is switched on to recieve the passcode.
            </div>
            <div class="tl-controll-btns-wrap">
                <div 
                    class="tl-phone-btn tl-btn__continue tl-phone-btn__disable"
                    attr-js-selector="fake-continue-btn" 
                    onclick="tl_loginController.ppInputPhone.continue2getCode(event)"
                >continue</div>
                <div 
                    class="tl-phone-btn"
                    onclick="tl_loginController.popups.closeAllPopups(true)"
                >cancel</div>
            </div>
        </div>

        <div class="modal-enter-code tl-popup-content-wrap dn" attr-js-selecotr="pp-enter-secure-code">
            <span class="tl-popup-title">Passcode sent!</span>
            <div class="tl-popup-subtitle">A code has been sent via SMS to:</div>
            <div class="tl-select-country-code" attr-js-selector="inserted-number">+99999999999</div>
            <div class="tl-signin-wrap tl-signin-wrap--secondary">Enter the 6 digit passcode sent to you via SMS:</div>
            <div class="tl-fake-secure-code-ipnut df">
                <input type="number" name="tl-secure-code-1" onkeyup="tl_loginController.ppInputSecureCode.changeHandler(this)">
                <input type="number" name="tl-secure-code-2" onkeyup="tl_loginController.ppInputSecureCode.changeHandler(this)">
                <input type="number" name="tl-secure-code-3" onkeyup="tl_loginController.ppInputSecureCode.changeHandler(this)">
                <input type="number" name="tl-secure-code-4" onkeyup="tl_loginController.ppInputSecureCode.changeHandler(this)">
            </div>
            <div class="dn">
                <label for="secure-code">Secure code:</label>
                <input type="number" id="secure-code" name="secure-code" attr-js-selector="fake-secaure-code">
            </div>
            <div class="tl-popup-subtitle">Didn’t get the SMS? </div>
            <div class="tl-btn tl-btn__request-sms tl-btn__request-sms-timer dn">Request new code in <span class="text-green" attr-js-selector="countdown">00:30</span> seconds</div>
            <div class="tl-btn tl-btn__request-sms tl-btn__request-sms-active is-valid" onclick="tl_loginController.ppInputPhone.continue2getCode(event)">Request New Code</div>
            <div class="tl-controll-btns-wrap light-top-border-line">
                <div 
                    class="text-light-gray tl-phone-btn"
                    onclick="tl_loginController.popups.closeAllPopups(true)"
                >cancel</div>
            </div>
        </div>

        <div class="modal-enter-code-again tl-popup-content-wrap dn" attr-js-selecotr="pp-enter-secure-code-again">
            <span class="tl-popup-title">Unable to sign in</span>
            <div class="tl-popup-subtitle">The passcode you entered is incorrect. You can retry entering the correct passcode below request a new code.</div>
            <div class="tl-fake-secure-code-ipnut df">
                <input type="number" name="tl-secure-code-1" onkeyup="tl_loginController.ppInputSecureCode.changeHandler(this)">
                <input type="number" name="tl-secure-code-2" onkeyup="tl_loginController.ppInputSecureCode.changeHandler(this)">
                <input type="number" name="tl-secure-code-3" onkeyup="tl_loginController.ppInputSecureCode.changeHandler(this)">
                <input type="number" name="tl-secure-code-4" onkeyup="tl_loginController.ppInputSecureCode.changeHandler(this)">
            </div>
            <div class="dn">
                <label for="secure-code">Secure code:</label>
                <input type="number" id="secure-code" name="secure-code" attr-js-selector="fake-secaure-code">
            </div>
            <div class="tl-popup-subtitle">Didn’t get the SMS? </div>
            <div class="tl-btn tl-btn__request-sms tl-btn__request-sms-timer dn">Request new code in <span class="text-green" attr-js-selector="countdown">00:30</span> seconds</div>
            <div class="tl-btn tl-btn__request-sms tl-btn__request-sms-active is-valid" onclick="tl_loginController.ppInputPhone.continue2getCode(event)">Request New Code</div>
            <div class="tl-controll-btns-wrap light-top-border-line">
                <div 
                    class="text-light-gray tl-phone-btn"
                    onclick="tl_loginController.popups.closeAllPopups(true)"
                >cancel</div>
            </div>
        </div>

        <div class="modal-error tl-popup-content-wrap dn" attr-js-selecotr="error-modal">
            <span class="tl-popup-title">Unable to sign in</span>
            <div class="tl-popup-subtitle">No account associated with this number exists on Kapu.</div>
            <div class="tl-phone-btn" onclick="tl_loginController.popups.closeAllPopups(true)">OK</div>
        </div>

        <div class="modal-enter-code tl-popup-content-wrap pp-loading dn" attr-js-selecotr="pp-loading">
            <svg class="spinner" width="60" height="54" xmlns="http://www.w3.org/2000/svg"><g fill="#68A315" fill-rule="nonzero"><rect width="6.923" height="12.462" rx="3.462" transform="translate(26.538)"/><rect width="6.923" height="12.462" rx="3.462" transform="rotate(30 17.308 78.675)"/><rect width="6.923" height="12.462" rx="3.462" transform="rotate(60 17.73 51.714)"/><rect width="6.923" height="12.462" rx="3.462" transform="rotate(90 17.885 41.423)"/><rect width="6.923" height="12.462" rx="3.462" transform="rotate(120 17.73 35.238)"/><rect width="6.923" height="12.462" rx="3.462" transform="rotate(150 17.308 30.71)"/><rect width="6.923" height="12.462" rx="3.462" transform="rotate(180 16.73 27)"/><rect width="6.923" height="12.462" rx="3.462" transform="rotate(-150 16.154 23.6)"/><rect width="6.923" height="12.462" rx="3.462" transform="rotate(-120 15.732 19.916)"/><rect width="6.923" height="12.462" rx="3.462" transform="rotate(-90 15.577 14.885)"/><rect width="6.923" height="12.462" rx="3.462" transform="rotate(-60 15.732 5.748)"/><rect width="6.923" height="12.462" rx="3.462" transform="rotate(-30 16.154 -20.368)"/></g></svg>
            <span class="tl-popup-title">Just a moment…</span>
        </div>
    </div>
    <div
        id="popup-select-country-code" 
        class="dn"
        onclick="tl_loginController.popups.closeSeelctCountryCode();"
    ></div>
</div>


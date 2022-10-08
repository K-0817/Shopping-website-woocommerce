<script>
	let tl_ItemRemoved = {
		closePopup: function(){
			document.querySelector('#popup-item-was-removed').classList.add("dn");
		},
		openPupup: function(){
			document.querySelector('#popup-item-was-removed').classList.remove("dn");
		}
	}
</script>

<div id="popup-item-was-removed" class="tl-popup-main-wrap dn">
	<div class="pp-wrap">
		<div class="df tl-wrap">
			<div class="pp-title location__title">Item has been removed</div>
			<div class="pp-item_wrap">
				<div>
					<div class="catalog__item-img img-wrap">
						<div>
							<picture>
								<div class="footer__list-icon">
									<svg viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd"
											d="M26.2494 12.1837C25.7253 11.5273 25.0102 11.1649 24.2363 11.1649H22.4681C22.3016 6.62939 19.0151 3 14.9988 3C10.9824 3 7.6959 6.62939 7.52937 11.1649H5.76121C4.98733 11.1649 4.27223 11.5273 3.74814 12.1837C3.08692 13.0065 2.84692 14.1527 3.09672 15.2547L5.21753 24.6C5.5359 26.0106 6.63304 27 7.88202 27H22.1106C23.3596 27 24.4567 26.0155 24.7751 24.6L26.9008 15.2547C27.1506 14.1527 26.9106 13.0065 26.2494 12.1837ZM14.9988 4.99837C17.9179 4.99837 20.3081 7.73143 20.4649 11.1649H9.53263C9.68937 7.73633 12.0796 4.99837 14.9988 4.99837ZM22.8306 24.1592L24.9514 14.809C25.0641 14.3143 25.2012 13.1633 24.2363 13.1633H5.76121C4.86488 13.1633 4.93345 14.3143 5.0461 14.809L7.16692 24.1592C7.27467 24.6392 7.58325 25.0016 7.88202 25.0016H22.1155C22.4143 25.0016 22.7228 24.6392 22.8306 24.1592Z" />
										<path
											d="M10.0371 15.1519C9.48368 15.1519 9.03796 15.5976 9.03796 16.151V22.3959C9.03796 22.9494 9.48368 23.3951 10.0371 23.3951C10.5906 23.3951 11.0363 22.9494 11.0363 22.3959V16.151C11.0412 15.6025 10.5906 15.1519 10.0371 15.1519Z" />
										<path
											d="M14.8812 15.1519C14.3277 15.1519 13.882 15.5976 13.882 16.151V22.3959C13.882 22.9494 14.3277 23.3951 14.8812 23.3951C15.4347 23.3951 15.8804 22.9494 15.8804 22.3959V16.151C15.8804 15.6025 15.4298 15.1519 14.8812 15.1519Z" />
										<path
											d="M19.7204 15.1519C19.1669 15.1519 18.7212 15.5976 18.7212 16.151V22.3959C18.7212 22.9494 19.1669 23.3951 19.7204 23.3951C20.2738 23.3951 20.7196 22.9494 20.7196 22.3959V16.151C20.7196 15.6025 20.2738 15.1519 19.7204 15.1519Z" />
									</svg>
								</div>				
							</picture>
						</div>
					</div>
				</div>
			<div class="pp-title location__title tl-title title-removed">
				The item has been removed
			</div>
		</div>
		</div>
			<a class="tl-start-checkout xoo-cp-btn-ch xcp-btn" onclick="tl_ItemRemoved.closePopup()">continue shopping</a>
		</div>
    <div onclick="tl_ItemRemoved.closePopup()" class="pp-bg"></div>
</div>

<? 
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");
?>

								<?$APPLICATION->IncludeComponent(
									"petrofstudio:petrofstudio.mkad",
									"",
									Array(
										"ADDITIONAL_TARIF" => "350",
										"BLIZ_VREMYA_DOSTAVKI" => "При заказе товара до 15.00 и, при наличии на складе, доставка курьером на следующий день. В остальных случаях, сроки доставки уточняйте у менеджера.",
										"COST_BY_KM" => "30",
										"COST_DELIVERY_MKAD" => "350",
										"COST_FREE_DELIVERY" => "",
										"MAX_DISTANCE" => "100",
										"SUMMA_ZAKAZ_TARIF" => ""
									)
								);?>
								
								<div class="form__row form__row_delivery form__row_cols">

									<div class="form__col form__col_adress">
									  <div class="form__row div_form">
										<label class="form__label" for="apartment">Адрес</label>
										<input id="street1" class="form__input"  type="text" disabled name="street1" value="">
									  </div>
									</div>
									<div class="form__col form__col_apartment">
									  <div class="form__row div_form">
										<label class="form__label" for="apartment">Квартира/офис</label>
										<input id="apartment1" class="form__input" data-min="1" type="text" name="apartment" value="">
									  </div>
									</div>

								</div>
								
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

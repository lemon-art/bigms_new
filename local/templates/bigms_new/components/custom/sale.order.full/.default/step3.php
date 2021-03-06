<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
use Bigms\Helpers\DeliveryHelper;

\Bitrix\Main\Loader::includeModule('sale');
if ( $_POST["DELIVERY_LOCATION"] ){
	$DELIVERY_LOCATION = $_POST["DELIVERY_LOCATION"];
}
else {
	$DELIVERY_LOCATION = 20;
}

/*
$db_dtype = CSaleDelivery::GetList(
    array(
            "SORT" => "ASC",
            "NAME" => "ASC"
        ),
    array(
            "LID" => SITE_ID,
            "ACTIVE" => "Y",
            "LOCATION" => $DELIVERY_LOCATION
        ),
    false,
    false,
    array()
);
*/

$arDeliveries = \Bitrix\Sale\Delivery\Services\Manager::getActiveList();
//var_dump($arDeliveries);
foreach ($arDeliveries as $key => $delivery) {
    if ($delivery["ID"] == "7" || $delivery["PARENT_ID"] != 0 || (DeliveryHelper::isMoscowRegion($DELIVERY_LOCATION) && $delivery["ID"] == 4)) {
        unset($arDeliveries[$key]);
    }
}


$arNotRegionsDeliveries = ['1', '2', '8'];
if (!DeliveryHelper::isMoscowRegion($DELIVERY_LOCATION)) {
    foreach ($arDeliveries as $key => $delivery) {
        if (in_array($delivery['ID'], $arNotRegionsDeliveries)) {
            unset($arDeliveries[$key]);
        }
    }
}

$arNotMoscowRegionDeliveries = ['3', '9'];
if (DeliveryHelper::isMoscowRegion($DELIVERY_LOCATION)) {
    foreach ($arDeliveries as $key => $delivery) {
        if (in_array($delivery['ID'], $arNotMoscowRegionDeliveries)) {
            unset($arDeliveries[$key]);
        }
    }
}

?>


	
                        <div data-step="3" class="form__container form__container_wide">
                          <strong class="form__title">Выберите способ доставки</strong>
                          <div class="form-radio">
                            <ul class="form-radio__list">
								<?$i = 0;?>
								<?foreach($arDeliveries as $ar_dtype):?>
								
									  <li data-trigger="dev<?=$ar_dtype["ID"]?>" data-id="<?=$ar_dtype["ID"]?>" data-price="<?=round($ar_dtype["CONFIG"]["MAIN"]["PRICE"])?>" class="form-radio__item">

										<div class="form-radio__img-wrap">
												<?if ( $ar_dtype["ID"] == 9):?>
													<?$ar_dtype["ID"] = 4;?>
												<?endif;?>
												
												<svg class="form-radio__img">
													<use xlink:href="#icon-delivery-<?=$ar_dtype["ID"]?>"></use>
												</svg>
										</div>
										<div class="form-radio__text">
										  <span class="form-radio__name"><?=$ar_dtype["NAME"]?></span>
										  <span class="form-radio__notice"><?=$ar_dtype["DESCRIPTION"]?></span>
										</div>
									  </li>
										<?$i++;?>
								<?endforeach;?>
                              
                            </ul>
							

						
                            <div data-content="dev1" class="form__container dev form__container_1 form__container_wide" style="display: none;">
                              <div class="self-delivery">
                                <ul class="self-delivery__list">
								
								  <?
									CModule::IncludeModule("iblock");
									$arSelect = array("ID", "NAME", "PREVIEW_TEXT", "PROPERTY_MAP");
									$res = CIBlockElement::GetList(array("sort" => "asc"), array("IBLOCK_ID" => 9), false, false, $arSelect);
									$i = 0;
									$arStores = Array();
									while($ar_fields = $res->GetNext()){
										$arStores[] = $ar_fields;
									}
								  ?>

										<?foreach ( $arStores as $arStore ):?>
										  <li class="self-delivery__item">
											<div class="self-delivery__row">
											  <div class="self-delivery__col self-delivery__col_address">
												<p class="self-delivery__text store_name"><?=$arStore["NAME"]?></p>
											  </div>
											  <?=$arStore["PREVIEW_TEXT"]?>

											</div>
											<div class="self-delivery__row self-delivery__row_buttons">
											  <a href="#" data-store="<?=$arStore["ID"]?>" class="self-delivery__button">Забрать в этом магазине</a>
											  <?if ( $arStore["PROPERTY_MAP_VALUE"] ):?>
													<?$arCoordinate = explode(',', $arStore["PROPERTY_MAP_VALUE"]);?>
													<a href="#" class="self-delivery__link popup-trigger" data-trigger="order_map" data-mapX="<?=$arCoordinate[0]?>" data-mapY="<?=$arCoordinate[1]?>">Показать магазин на карте</a>
											  <?endif;?>
											</div>
										  </li>
										  
										<?endforeach;?>
                                </ul>
                                <div class="self-delivery__result delivery-result" style="display: none;">
                                  <div class="delivery-result__wrap">
                                    <strong class="delivery-result__title">Вы выбрали самовывоз из магазина, по адресу:</strong>
                                    <p class="self-delivery__text delivery-result__text">Карту проезда и время работы магазина отправим на е-мейл</p>
                                  </div>
									<?foreach ( $arStores as $arStore ):?>
										  <div class="delivery-result__wrap store" id="store<?=$arStore["ID"]?>" style="display: none;">
											<strong class="delivery-result__address"><?=$arStore["NAME"]?></strong>
											<div class="self-delivery__row">
												<?=$arStore["PREVIEW_TEXT"]?>
											</div>
										  </div>
									<?endforeach;?>
									<input type="hidden" id="SKLAD" name="ORDER_PROP_17">
                                </div>
								
                              </div> 
                            </div>
                            <div data-content="dev8" class="form__container dev form__container_wide"  style="display: none;">

                              
								<?$APPLICATION->IncludeComponent(
									"petrofstudio:petrofstudio.mkad",
									"",
									Array(
										"ADDITIONAL_TARIF" => "400",
										"BLIZ_VREMYA_DOSTAVKI" => "При заказе товара до 15.00 и, при наличии на складе, доставка курьером на следующий день. В остальных случаях, сроки доставки уточняйте у менеджера.",
										"COST_BY_KM" => "30",
										"COST_DELIVERY_MKAD" => "400",
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
  
                            </div>
							
							<div data-content="dev2" class="form__container dev form__container_wide"  style="display: none;">

								<div class="form__row form__row_delivery form__row_cols">

									<div class="form__col form__col_adress">
									  <div class="form__row div_form">
										<label class="form__label" for="apartment">Адрес</label>
										<input id="street" data-min="7" class="form__input"  type="text" name="street1" value="">
									  </div>
									</div>
									<div class="form__col form__col_apartment">
									  <div class="form__row div_form">
										<label class="form__label" for="apartment">Квартира/офис</label>
										<input id="apartment" class="form__input" data-min="1" type="text" name="apartment" value="">
									  </div>
									</div>

								</div>
						  
						  
								<?/*
								<div class="form__row form__row_delivery form__row_cols">

									<div class="form__col form__col_adress">
									  <div class="form__row div_form">
										<label class="form__label" for="apartment">Адрес</label>
										<input id="street" class="form__input" data-min="10" type="text" name="street" value="">
									  </div>
									</div>
									
								</div>
								*/?>
							
							
                          </div>
                        </div>
                      		<input type="hidden" id="FULL_ADRESS" name="">
							<input type="hidden" id="DELIVERY_PRICE" value="" name="DELIVERY_PRICE">
					</div>


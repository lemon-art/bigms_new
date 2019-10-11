<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Способы оплаты");
?><div class="content-about__content">
	<div class="row">
		<div class="col-lg-20 col-md-20 col-sm-20 content-about__main">
			<div class="content-delivery__row">
 <strong class="content-delivery__subtitle">1. Наличный расчет</strong>
				<p class="content-delivery__text">
					 Оплатить наличными можно курьеру при получении товара по Москве и Московской области, либо при самовывозе в магазинах "Большой Мастер"
				</p>
			</div>
			<div class="content-delivery__row">
 <strong class="content-delivery__subtitle">2. Безналичный расчет</strong>
				<p class="content-delivery__text">
					 Оплатить товар по безналичному расчету можно только юридическим, зарегистрированным на территории РФ. Счет выставляется на электронную почту после подтверждения заказа.<br>
				</p>
			</div>
			<div class="content-delivery__row">
				<br>
			</div>
		</div>
		<div class="col-lg-6 col-lg-offset-4 col-md-6 col-md-offset-4 col-sm-6 col-sm-offset-4 content-about__nav about-nav">
			 <?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"about",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"COMPONENT_TEMPLATE" => "menu",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(),
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_TYPE" => "Y",
		"MENU_CACHE_USE_GROUPS" => "N",
		"ROOT_MENU_TYPE" => "left",
		"USE_EXT" => "N"
	),
false,
Array(
	'ACTIVE_COMPONENT' => 'Y'
)
);?>
		</div>
	</div>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
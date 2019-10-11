<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");



CModule::IncludeModule("iblock");


$arFilter = Array(
 "IBLOCK_ID"=>10, 
 "ACTIVE"   => "N"
 );
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, Array("ID"));
while($ar_fields = $res->GetNext())
{
	$el = new CIBlockElement;
	$arLoadProductArray = Array(
		"ACTIVE"         => "Y",            // активен
  );

	$PRODUCT_ID = $ar_fields['ID'];  // изменяем элемент с кодом (ID) 2
	$el->Update($PRODUCT_ID, $arLoadProductArray);
}


?>
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (isset($arParams["TEMPLATE_THEME"]) && !empty($arParams["TEMPLATE_THEME"]))
{
	$arAvailableThemes = array();
	$dir = trim(preg_replace("'[\\\\/]+'", "/", dirname(__FILE__)."/themes/"));
	if (is_dir($dir) && $directory = opendir($dir))
	{
		while (($file = readdir($directory)) !== false)
		{
			if ($file != "." && $file != ".." && is_dir($dir.$file))
				$arAvailableThemes[] = $file;
		}
		closedir($directory);
	}

	if ($arParams["TEMPLATE_THEME"] == "site")
	{
		$solution = COption::GetOptionString("main", "wizard_solution", "", SITE_ID);
		if ($solution == "eshop")
		{
			$theme = COption::GetOptionString("main", "wizard_eshop_adapt_theme_id", "blue", SITE_ID);
			$arParams["TEMPLATE_THEME"] = (in_array($theme, $arAvailableThemes)) ? $theme : "blue";
		}
	}
	else
	{
		$arParams["TEMPLATE_THEME"] = (in_array($arParams["TEMPLATE_THEME"], $arAvailableThemes)) ? $arParams["TEMPLATE_THEME"] : "blue";
	}
}
else
{
	$arParams["TEMPLATE_THEME"] = "blue";
}
$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";


$properties = CIBlockProperty::GetList(Array("sort"=>"asc"), Array('ACTIVE'=>'Y', 'IBLOCK_ID'=>$arParams['IBLOCK_ID']));
while ($prop_fields = $properties->GetNext()){
	$arResult['ITEMS'][$prop_fields['ID']]['HINT'] = $prop_fields['HINT'];
}
global $USER;
foreach(CIBlockSectionPropertyLink::GetArray($arParams['IBLOCK_ID'], 0) as $PID => $arLink){
	if ($arLink['SMART_FILTER'] != 'Y'){
		unset($arResult['ITEMS'][$PID]);
		continue;
	}
	if ($arLink['FILTER_HINT'] <> ''){
		$arResult['ITEMS'][$PID]['HINT'] = CTextParser::closeTags($arLink['FILTER_HINT']);
	}
}

$countVal = 0;
foreach($arResult['ITEMS'][59]['VALUES'] as $arItem){
	if ($arItem['VALUE'] != ''){
		$countVal++;
	}
}
if ($countVal === 0){
	$arResult['ITEMS'][59]['VALUES'] = false;
}
	//КОММЕНТАРИИ К СВОЙСТВАМ
	//открываем файл с массивом 
	$listFile = $_SERVER["DOCUMENT_ROOT"]."/tools/files/comments_prop_".$arParams['IBLOCK_ID'].".txt";
	$data = file_get_contents($listFile);
	$arPropComment = unserialize( $data );
	

	foreach($arResult["ITEMS"] as $key=>$arItem){
		if ( $arPropComment[$arParams['SECTION_ID']][$arItem["ID"]] ){
			$arResult["ITEMS"][$key]["HINT"] = $arPropComment[$arParams['SECTION_ID']][$arItem["ID"]];
		}
	}

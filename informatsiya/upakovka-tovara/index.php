<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Упаковка товара");
?><h3><span style="font-size: 24pt;">Упаковка товара</span></h3>
 <br>
 Мы уделяем упаковке товара особое внимание. Наши изделия относятся к категории хрупких товаров, поэтому главная функция упаковки - сохранить товар в целости по дороге к конечному покупателю.&nbsp;<br>
<div>
	 Наши наборы являются подарочными, поэтому к дизайну упаковки мы предъявляем особые требования. <br>
</div>
<div>
 <br>
</div>
<br>
<div>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:photogallery",
	"",
	Array(
		"ADDITIONAL_SIGHTS" => array(""),
		"ALBUM_PHOTO_SIZE" => "120",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"DATE_TIME_FORMAT_DETAIL" => "d.m.Y",
		"DATE_TIME_FORMAT_SECTION" => "d.m.Y",
		"DRAG_SORT" => "Y",
		"ELEMENTS_PAGE_ELEMENTS" => "50",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "desc",
		"IBLOCK_ID" => "24",
		"IBLOCK_TYPE" => "aspro_next_content",
		"JPEG_QUALITY" => "100",
		"JPEG_QUALITY1" => "100",
		"ORIGINAL_SIZE" => "1280",
		"PAGE_NAVIGATION_TEMPLATE" => "",
		"PATH_TO_FONT" => "default.ttf",
		"PATH_TO_USER" => "",
		"PHOTO_LIST_MODE" => "Y",
		"SECTION_LIST_THUMBNAIL_SIZE" => "100",
		"SECTION_PAGE_ELEMENTS" => "15",
		"SECTION_SORT_BY" => "UF_DATE",
		"SECTION_SORT_ORD" => "DESC",
		"SEF_MODE" => "N",
		"SET_TITLE" => "Y",
		"SHOWN_ITEMS_COUNT" => "6",
		"SHOW_LINK_ON_MAIN_PAGE" => array("id","shows","rating","comments"),
		"SHOW_NAVIGATION" => "N",
		"SHOW_TAGS" => "N",
		"THUMBNAIL_SIZE" => "100",
		"UPLOAD_MAX_FILE_SIZE" => "5000",
		"USE_COMMENTS" => "N",
		"USE_LIGHT_VIEW" => "Y",
		"USE_RATING" => "N",
		"USE_WATERMARK" => "Y",
		"VARIABLE_ALIASES" => Array("ACTION"=>"ACTION","ELEMENT_ID"=>"ELEMENT_ID","PAGE_NAME"=>"PAGE_NAME","SECTION_ID"=>"SECTION_ID"),
		"WATERMARK_MIN_PICTURE_SIZE" => "800",
		"WATERMARK_RULES" => "USER"
	)
);?>
</div>
<div>
 <br>
</div>
 <br>
 <b> </b><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
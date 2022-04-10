<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Страница не найдена");
?><style>.right_block.wide_, .right_block.wide_N{float:none !important;width:100% !important;}</style>
<div class="maxwidth-theme">
	<table class="page_not_found" width="100%" cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<td class="image">
 <br>
		</td>
		<td class="description">
			<div class="title404">
				 Ошибка 404
			</div>
			<div class="subtitle404">
				 Страница не найдена
			</div>
			<div class="descr_text404">
				 Неправильно набран адрес или такой<br>
				 страницы не существует
			</div>
 <br>
 <a href="https://ghsz.ru/company/news/">https://ghsz.ru/company/news/</a>
			<div class="back404">
				 или <a onclick="history.back()" >вернуться назад</a>
			</div>
		</td>
	</tr>
	</tbody>
	</table>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
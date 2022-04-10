						<?CNext::checkRestartBuffer();?>
						<?IncludeTemplateLangFile(__FILE__);?>
							<?if(!$isIndex):?>
								<?if($isBlog):?>
									</div> <?// class=col-md-9 col-sm-9 col-xs-8 content-md?>
									<div class="col-md-3 col-sm-3 hidden-xs hidden-sm right-menu-md">
										<div class="sidearea">
											<?$APPLICATION->ShowViewContent('under_sidebar_content');?>
											<?CNext::get_banners_position('SIDE', 'Y');?>
											<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "sect", "AREA_FILE_SUFFIX" => "sidebar", "AREA_FILE_RECURSIVE" => "Y"), false);?>
										</div>
									</div>
								</div><?endif;?>
								<?if($isHideLeftBlock):?>
									</div> <?// .maxwidth-theme?>
								<?endif;?>
								</div> <?// .container?>
							<?else:?>
								<?CNext::ShowPageType('indexblocks');?>
							<?endif;?>
							<?CNext::get_banners_position('CONTENT_BOTTOM');?>
						</div> <?// .middle?>
					<?//if(!$isHideLeftBlock && !$isBlog):?>
					<?if(($isIndex && $isShowIndexLeftBlock) || (!$isIndex && !$isHideLeftBlock) && !$isBlog):?>
						</div> <?// .right_block?>
						<?if($APPLICATION->GetProperty("HIDE_LEFT_BLOCK") != "Y" && !defined("ERROR_404")):?>
							<div class="left_block">
								<?CNext::ShowPageType('left_block');?>
							</div>
						<?endif;?>
					<?endif;?>
				<?if($isIndex):?>
					</div>
				<?elseif(!$isWidePage):?>
					</div> <?// .wrapper_inner?>
				<?endif;?>
			</div> <?// #content?>
			<?CNext::get_banners_position('FOOTER');?>
		</div><?// .wrapper?>
		<footer id="footer">
			<?if($APPLICATION->GetProperty("viewed_show") == "Y" || $is404):?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"basket",
					array(
						"COMPONENT_TEMPLATE" => "basket",
						"PATH" => SITE_DIR."include/footer/comp_viewed.php",
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "",
						"AREA_FILE_RECURSIVE" => "Y",
						"EDIT_TEMPLATE" => "standard.php",
						"PRICE_CODE" => array(
							0 => "BASE",
						),
						"STORES" => array(
							0 => "",
							1 => "",
						),
						"BIG_DATA_RCM_TYPE" => "bestsell"
					),
					false
				);?>
			<?endif;?>
			<?CNext::ShowPageType('footer');?>
		</footer>
		<div class="bx_areas">
			<?CNext::ShowPageType('bottom_counter');?>
		</div>
		<?CNext::ShowPageType('search_title_component');?>
		<?CNext::setFooterTitle();
		// CNext::showFooterBasket();?>
		<!-- Yandex.Metrika counter -->
		<script type="text/javascript" >
		(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
		m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
		(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

		ym(54359989, "init", {
				clickmap:true,
				trackLinks:true,
				accurateTrackBounce:true,
				webvisor:true
		});
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/54359989" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-133669387-22"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-133669387-22');
		</script>
	</body>
</html>
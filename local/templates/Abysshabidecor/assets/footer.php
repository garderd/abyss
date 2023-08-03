</main>
<footer>

    <div class="footer__top">
        <div class="container footer-top__content-wrapper d-flex justify-content-between align-items-start">
            <div class="footer__logo-wrapper d-flex flex-column justify-content-between">
				<div class="footer__logo">
					<a href="/">
						<img src="<?=SITE_TEMPLATE_PATH?>/assets/img/logo/logo_white1.svg" alt="logo">
					</a>
				</div>
				<?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					".default",
					array(
					"AREA_FILE_SHOW" => "file",
					"COMPONENT_TEMPLATE" => ".default",
					"PATH" => "/local/templates/Abysshabidecor/includes/number.php"
					)
				);?>
            </div>
            <div class="footer__menu">
                <?$APPLICATION->IncludeComponent(
				"bitrix:menu",
				"footer_menu_first",
				Array(
					"ALLOW_MULTI_SELECT" => "N",
					"CHILD_MENU_TYPE" => "left",
					"COMPONENT_TEMPLATE" => ".default",
					"DELAY" => "N",
					"MAX_LEVEL" => "1",
					"MENU_CACHE_GET_VARS" => "",
					"MENU_CACHE_TIME" => "3600",
					"MENU_CACHE_TYPE" => "N",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"ROOT_MENU_TYPE" => "top",
					"USE_EXT" => "Y"
				)
			);?>
            </div>
            <div class="footer__menu">
                <?$APPLICATION->IncludeComponent(
					"bitrix:menu",
					"footer_menu_second",
					Array(
						"ALLOW_MULTI_SELECT" => "N",
						"CHILD_MENU_TYPE" => "left",
						"DELAY" => "N",
						"MAX_LEVEL" => "1",
						"MENU_CACHE_GET_VARS" => array(0=>"",),
						"MENU_CACHE_TIME" => "3600",
						"MENU_CACHE_TYPE" => "N",
						"MENU_CACHE_USE_GROUPS" => "Y",
						"ROOT_MENU_TYPE" => "bottom",
						"USE_EXT" => "N"
					)
				);?>
            </div>
            <div class="footer__contacts-wrapper">
                <?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					".default",
					array(
					"AREA_FILE_SHOW" => "file",
					"COMPONENT_TEMPLATE" => ".default",
					"PATH" => "/local/templates/Abysshabidecor/includes/number.php"
					)
				);?>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container footer-bottom__content-wrapper d-flex justify-content-between">
			<div class="abyss">
				<?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					".default",
					array(
					"AREA_FILE_SHOW" => "file",
					"COMPONENT_TEMPLATE" => ".default",
					"PATH" => "/local/templates/Abysshabidecor/includes/AbyssHabidecor.php"
					)
				);?>
			</div>
			<div class="personal-link-wrapper">
				<div class="policy">
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						".default",
						array(
						"AREA_FILE_SHOW" => "file",
						"COMPONENT_TEMPLATE" => ".default",
						"PATH" => "/local/templates/Abysshabidecor/includes/policy.php"
						)
					);?>
				</div>
				<div class="personal_data">
					<?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							".default",
							array(
							"AREA_FILE_SHOW" => "file",
							"COMPONENT_TEMPLATE" => ".default",
							"PATH" => "/local/templates/Abysshabidecor/includes/personal_data.php"
							)
						);?>
				</div>
			</div>
        </div>
    </div>



</footer>

<div class="modal-window-wrapper modal-window-wrapper_login">
        <div class="modal-window">
            <?$APPLICATION->IncludeComponent(
                "bitrix:system.auth.form",
                "auth_form",
                Array(
                    "FORGOT_PASSWORD_URL" => "",
                    "PROFILE_URL" => "",
                    "REGISTER_URL" => "",
                    "SHOW_ERRORS" => "N"
                )
            );?>
            <div class="modal-window__close"></div>
        </div>
    </div>
        
     <div class="modal-window-wrapper modal-window-wrapper_register">
        <div class="modal-window">
        <?$APPLICATION->IncludeComponent(
	"bitrix:main.register", 
	"register", 
	array(
		"AUTH" => "Y",
		"REQUIRED_FIELDS" => array(
		),
		"SET_TITLE" => "N",
		"SHOW_FIELDS" => array(
		),
		"SUCCESS_PAGE" => "/personal/#personal-data",
		"USER_PROPERTY" => array(
		),
		"USER_PROPERTY_NAME" => "",
		"USE_BACKURL" => "Y",
		"COMPONENT_TEMPLATE" => "register"
	),
	false
);?> 
            <div class="modal-window__close"></div>
        </div>
    </div>

    <div class="modal-window-wrapper modal-window-wrapper_forgot">
        <div class="modal-window">
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.auth.forgotpasswd",
                "forgot_passwd",
                Array(
                    "AUTH_AUTH_URL" => "",
                    "AUTH_REGISTER_URL" => ""
                )
            );?>
            <div class="modal-window__close"></div>
        </div>
    </div>
   
</body>

</html>
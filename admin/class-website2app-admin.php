<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://website2app.com/
 * @since      1.0.0
 *
 * @package    Website2App
 * @subpackage Website2App/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Website2App
 * @subpackage Website2App/admin
 * @author     Website2App <website2app@hustledigital.com.au>
 */
class Website2App_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Wordpress Native Apps Settings fetched from Database.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $website2app    The current version of this plugin.
	 */
	private $website2app;

	/**
	 * Default Configuration File Fetched From Storage/ Or later fetched from s3bucket.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $website2app    The current version of this plugin.
	 */
	private $website2AppSettings;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->admin_notices = null;
		$this->website2AppSettings = $this->w2a_get_settings();
		$this->copyConfigifExist();
	}

	public function w2a_get_page_depth($parent_id)
	{
		$depth = -1;
		while ($parent_id > 0) {
			$page = get_post($parent_id);
			$parent_id = $page->post_parent;
			$depth++;
		}

		return $depth;
	}

	public function w2a_dropdown_pages($args)
	{
		$output = "";
		$id = $args['id'] ?? null;
		$name = $args['name'] ?? null;
		$class = $args['class'] ?? null;
		$selected = $args['selected'] ?? null;
		if ($selected) {
			$selected_arr = is_array($selected) ? $selected : [$selected];
		}else{
			$selected_arr = [];
		}
		$pages = get_pages(array('post_status' => 'publish', 'parent' => -1));
		$optionsHTML = '';
		if (!empty($pages)) {
			foreach ($pages as $page) {
				$level = $this->w2a_get_page_depth($page->ID);

				$permalink = get_permalink($page->ID);
				$pageTitle = str_repeat(" &nbsp; &nbsp; ", $level) . $page->post_title;
				$isSelected = in_array($permalink, $selected_arr) ? "selected" : "";
				$optionsHTML .= sprintf("<option class='level-%d' value='%s' %s >%s</option>", $level, $permalink, $isSelected, $pageTitle);
			}
			$output = sprintf('<select id="%s" name="%s" class="%s">%s</select>', $id, $name, $class, $optionsHTML);
		}
		echo $output;
	}

	/*
	Backward compatibility, will be removed later 
	@ function to copy the existing config file to the new location if does not exist.
	*/
	public function copyConfigifExist()
	{
		$configPath = pathinfo(W2A_CONFIG_PATH);
		//Create the directory to store the config file if it does not already exists
		if (!file_exists($configPath['dirname'])) {
			mkdir($configPath['dirname'], 0755, true);
			if (file_exists(dirname(__FILE__) . '/config.json')) {
				copy(dirname(__FILE__) . '/config.json', W2A_CONFIG_PATH);
				unlink(dirname(__FILE__) . '/config.json');
			}
		}
	}

	public function w2a_addAdminNotice($notice)
	{
		$admin_notices = $this->admin_notices;
		$admin_notices[] = $notice;
		$this->admin_notices = $admin_notices;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 *
		 * Function to define all hooks and filters for styles and respective functions defined in this class to handle them
		 * .
		 */

		$wp_scripts = wp_scripts();
		wp_enqueue_style(
			'plugin_name-admin-ui-css',
			plugin_dir_url(__FILE__) . 'css/jquery-ui.css',
			false,
			$this->version,
			false
		);

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/website2app-admin.css', array(), date("YmdHis"), 'all');
		wp_enqueue_style($this->plugin_name . '_introduction_css', plugin_dir_url(__FILE__) . 'css/introduction.css', array(), date("YmdHis"), 'all');
		wp_enqueue_style($this->plugin_name . '_general_css', plugin_dir_url(__FILE__) . 'css/general.css', array(), date("YmdHis"), 'all');
		wp_enqueue_style($this->plugin_name . '_publish_css', plugin_dir_url(__FILE__) . 'css/publish.css', array(), date("YmdHis"), 'all');
		wp_enqueue_style($this->plugin_name . '_account_css', plugin_dir_url(__FILE__) . 'css/account.css', array(), date("YmdHis"), 'all');
		wp_enqueue_style($this->plugin_name . '_bottomNav_css', plugin_dir_url(__FILE__) . 'css/bottomNav.css', array(), date("YmdHis"), 'all');
		wp_enqueue_style($this->plugin_name . '_topNav_css', plugin_dir_url(__FILE__) . 'css/topNav.css', array(), date("YmdHis"), 'all');
		wp_enqueue_style($this->plugin_name . '_prompts_css', plugin_dir_url(__FILE__) . 'css/prompts.css', array(), date("YmdHis"), 'all');
		wp_enqueue_style($this->plugin_name . '_pushnotifications_css', plugin_dir_url(__FILE__) . 'css/pushNotifications.css', array(), date("YmdHis"), 'all');
		wp_enqueue_style($this->plugin_name . '_authentication_css', plugin_dir_url(__FILE__) . 'css/authentication.css', array(), date("YmdHis"), 'all');
		wp_enqueue_style($this->plugin_name . '_analytics_css', plugin_dir_url(__FILE__) . 'css/analytics.css', array(), date("YmdHis"), 'all');
		wp_enqueue_style($this->plugin_name . '_iframe_css', plugin_dir_url(__FILE__) . 'css/iframe.css', array(), date("YmdHis"), 'all');
		wp_enqueue_style($this->plugin_name . '_select2_css', plugin_dir_url(__FILE__) . 'css/select2.css', array(), date("YmdHis"), 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 *
		 * Function to define all hooks and filters for scripts and respective functions defined in this class to handle them
		 * .
		 */
		wp_enqueue_media();
		if (get_current_screen()->id == 'website2app-settings') {
			wp_enqueue_script('jquery-ui-core'); // enqueue jQuery UI Core
			wp_enqueue_script('jquery-ui-tabs'); // enqueue jQuery UI Tabs
		}
		wp_enqueue_style('wp-color-picker');

		wp_enqueue_script('wp-color-picker-alpha', plugin_dir_url(__FILE__) . 'js/wp-color-picker-alpha.js', array('wp-color-picker'), date("YmdHis"), false);
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/website2app-admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-tabs'), date("YmdHis"), false);
		wp_enqueue_script($this->plugin_name . "_topNav", plugin_dir_url(__FILE__) . 'js/topnav.js', array('jquery'), date("YmdHis"), false);
		wp_enqueue_script($this->plugin_name . "_analytics", plugin_dir_url(__FILE__) . 'js/analytics.js', array('jquery'), date("YmdHis"), false);
		wp_enqueue_script($this->plugin_name . "_pushNotifications", plugin_dir_url(__FILE__) . 'js/pushNotifications.js', array('jquery'), date("YmdHis"), false);
		wp_enqueue_script($this->plugin_name . "_qrCodeJs", plugin_dir_url(__FILE__) . 'js/qrCodeGenerator.js', array('jquery'), date("YmdHis"), false);
		wp_enqueue_script($this->plugin_name . "_previewJs", plugin_dir_url(__FILE__) . 'js/iframePreview.js', array('jquery'), date("YmdHis"), false);
		wp_enqueue_script($this->plugin_name . "_select2Js", plugin_dir_url(__FILE__) . 'js/select2.js', array('jquery'), date("YmdHis"), false);
		wp_localize_script(
			$this->plugin_name,
			'Website2App',
			array(
				'pluginURL' => plugin_dir_url(__FILE__),
				'homeURL' => get_home_url(),
				'W2A_CONFIG_PATH' => W2A_CONFIG_PATH,
				'W2A_CONFIG_URL' => W2A_CONFIG_URL,
			)
		);

		wp_enqueue_script('wpnaImageUpload', plugin_dir_url(__FILE__) . 'js/wpnaImageUpload.js', array('jquery', $this->plugin_name), date("YmdHis"), false);
	}

	/**
	 * Register the Function to handle the saving of notification groups.
	 *
	 * @since    1.0.0
	 */

	public function handle_add_notification_group()
	{
		if (isset($_POST['addSubscriptionGroup_nonce']) && wp_verify_nonce($_POST['addSubscriptionGroup_nonce'], 'w2a_addSubscriptionGroup_nonce')) {
			// var_dump($_POST);die;
			$notice = array(
				'type' => 'success',
				'icon' => plugin_dir_url(__FILE__) . 'images/Website2App-Icon.png',
				'title' => 'Settings Saved',
				'message' => 'Success'
			);

			$this->w2a_addAdminNotice($notice);
			wp_safe_redirect(admin_url('admin.php?page=website2app-push-notification'));
			exit;
		} else {
			echo 'Nonce failed';
			die;
			wp_die(__('Invalid nonce specified', $this->plugin_name), __('Error', $this->plugin_name), array(
				'response' 	=> 403,
				'back_link' => 'admin.php?page=website2app-push-notification?tab=subscriptionGroup',
			));
		}
	}

	/**
	 * Register the Function to handle the saving of notification groups.
	 *
	 * @since    1.0.0
	 */

	public function handle_send_push_notification()
	{
		if (isset($_POST['add_push_notification_nonce']) && wp_verify_nonce($_POST['add_push_notification_nonce'], 'add_push_notification_submit_nonce')) {
			$notice = array(
				'type' => 'success',
				'icon' => plugin_dir_url(__FILE__) . 'images/Website2App-Icon.png',
				'title' => 'Settings Saved',
				'message' => 'Success'
			);

			$this->w2a_addAdminNotice($notice);
			wp_safe_redirect(admin_url('admin.php?page=website2app-push-notification?tab=send'));
			exit;
		} else {
			echo 'Nonce failed';
			die;
			wp_die(__('Invalid nonce specified', $this->plugin_name), __('Error', $this->plugin_name), array(
				'response' 	=> 403,
				'back_link' => 'admin.php?page=website2app-push-notification',
			));
		}
	}

	/**
	 * Register the Function to handle the settings form submission to store app settings in the Config File
	 *
	 * @since    1.0.0
	 */

	public function handle_settings_save()
	{
		if (isset($_POST['w2a_save_settings_nonce']) && wp_verify_nonce($_POST['w2a_save_settings_nonce'], 'w2a_save_settings_form_nonce')) {

			// echo '<pre>';
			$name = 				isset($_POST['w2a_app_name']) ? sanitize_text_field($_POST['w2a_app_name']) : '';
			$headerToHide = isset($_POST['headerToHide']) ? htmlentities($_POST['headerToHide']) : '';
			$footerToHide = isset($_POST['footerToHide']) ? htmlentities($_POST['footerToHide']) : '';
			$otherHide = 	isset($_POST['otherHide']) ? $this->sanitizeMultipleInputs($_POST['otherHide']) : null;
			$currentTab = 		isset($_POST['currentTab']) ? sanitize_text_field($_POST['currentTab']) : 0;
			$topNavTabsCurrent = 	isset($_POST['topNavTabsCurrent']) ? sanitize_text_field($_POST['topNavTabsCurrent']) : 0;


			$splash_background_color = isset($_POST['splash_backgroundColor']) ? sanitize_text_field($_POST['splash_backgroundColor']) : '';
			$splash_backgroundImage_image_url = isset($_POST['splash_backgroundImage_image_url']) ? sanitize_url($_POST['splash_backgroundImage_image_url']) : '';
			$splash = array(
				'backgroundColor' => $splash_background_color,
				'backgroundImage' => $splash_backgroundImage_image_url,
			);

			$topBarNav = array(
				'styles' => array(
					"backgroundColor" =>	isset($_POST['topBarNav_backgroundColor']) ? sanitize_text_field($_POST['topBarNav_backgroundColor']) : '',
					"statusBarTextColor" => 	isset($_POST['topbar_statusbar_textColour']) ? sanitize_text_field($_POST['topbar_statusbar_textColour']) : '',
					"bannerLogo" => 	isset($_POST['topBarNav_styles_bannerLogo_image_url']) ? sanitize_url($_POST['topBarNav_styles_bannerLogo_image_url']) : '',
					"topBarTextColor" => 	isset($_POST['topbar_textColour']) ? sanitize_text_field($_POST['topbar_textColour']) : '',
					"topBarIconColor" =>	isset($_POST['topbar_iconColor']) ? sanitize_text_field($_POST['topbar_iconColor']) : '',
				)
			);

			// $bottombarNavPages = null;
			$bottomBarNav = array(
				"styles" => array(
					"backgroundColor" => isset($_POST['bottombarNavStyle_backgroundColor']) ? sanitize_text_field($_POST['bottombarNavStyle_backgroundColor']) : '',
					"defaultIconColor" => isset($_POST['bottombarNavStyle_defaultIconColor']) ? sanitize_text_field($_POST['bottombarNavStyle_defaultIconColor']) : '',
					"activeIconColor" => isset($_POST['bottombarNavStyle_activeIconColor']) ? sanitize_text_field($_POST['bottombarNavStyle_activeIconColor']) : '',
				),
				"pages" => array(),
			);


			// var_dump($_POST['bottomBarItemText']);die;

			$bottomBarNavPages = isset($_POST['bottomBarItemText']) ? $this->sanitizeMultipleInputs($_POST['bottomBarItemText']) : null;
			// var_dump($bottomBarNavPages);
			// var_dump($this->sanitizeMultipleInputs($bottomBarNavPages));
			// die;
			if (!empty($bottomBarNavPages)) {
				$pagecount = 1;
				foreach ($bottomBarNavPages as $page) {
					$pageType = isset($_POST['bottomBarItemType_' . $pagecount]) ? sanitize_text_field($_POST['bottomBarItemType_' . $pagecount]) : null;
					if ($pageType == "page") {
						$pageUrl = isset($_POST['bottomBarItemUrlInternal_' . $pagecount]) ? sanitize_url($_POST['bottomBarItemUrlInternal_' . $pagecount]) : '';
						$isExternal = false;
					} else {
						$pageUrl = isset($_POST['bottomBarItemUrlExternal_' . $pagecount]) ? sanitize_url($_POST['bottomBarItemUrlExternal_' . $pagecount]) : '';
						$isExternal = true;
					}
					if (isset($_POST['bottomBar_' . $pagecount . '_hasEndJourneyPage']) && $_POST['bottomBar_' . $pagecount . '_hasEndJourneyPage'] == 'yes') {
						$endFlowPageIds = 	isset($_POST['bottomBarEndFlowUrl_' . $pagecount]) ? $this->sanitizeMultipleInputs($_POST['bottomBarEndFlowUrl_' . $pagecount]) : null;
						$endFlowUrl = array();
						foreach ($endFlowPageIds as $endFlowPageUrl) {
							$endFlowUrl[] = sanitize_url($endFlowPageUrl);
						}
					} else {
						$endFlowUrl = null;
					}
					$pageIcon = isset($_POST['bottomBarNavLogo_' . $pagecount . '_image_url']) ? sanitize_url($_POST['bottomBarNavLogo_' . $pagecount . '_image_url']) : '';
					$designType  = isset($_POST['topNav_' . $pagecount . '_structure']) ? sanitize_text_field($_POST['topNav_' . $pagecount . '_structure']) : '';
					$topNav = null;
					switch ($designType) {
						case 'logoOnly': {
								$topNav = array(
									"designType" => "logoOnly",
									"useLogo" => sanitize_text_field($_POST['topNav_' . $pagecount . '_logoOnly_type']) == 'logo' ? true : false,
									"logo" => isset($_POST['topNav_' . $pagecount . '_logo_image_url']) ? sanitize_url($_POST['topNav_' . $pagecount . '_logo_image_url']) : '',
									"label" => isset($_POST['topNav_' . $pagecount . '_text']) ? sanitize_text_field($_POST['topNav_' . $pagecount . '_text']) : '',
									"alignment" => isset($_POST['topNav_' . $pagecount . '_logoOnly_align']) ? sanitize_text_field($_POST['topNav_' . $pagecount . '_logoOnly_align']) : '',
								);
								break;
							}
						case 'logoLeftBurgerRight': {
								$HBItemSources = isset($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_hamburgerNavItemSource'])  ? $this->sanitizeMultipleInputs($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_hamburgerNavItemSource']) : null;
								$navInternalUrls = isset($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_hamburgerNavItem_internalURL']) ? $this->sanitizeMultipleInputs($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_hamburgerNavItem_internalURL']) : null;
								$navExternalUrls = isset($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_hamburgerNavItem_externalURL']) ? $this->sanitizeMultipleInputs($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_hamburgerNavItem_externalURL']) : null;
								$hamburgerMenuItems = array();
								if (!empty($HBItemSources)) {
									$buttonCount = 1;
									foreach ($HBItemSources as $key => $value) {
										$url = $value == 'external' ? (isset($navExternalUrls[$key]) ? $navExternalUrls[$key] : '') : (isset($navInternalUrls[$key]) ? $navInternalUrls[$key] : '');
										$title = isset($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_hamburgerNavItem_title']) ? $this->sanitizeMultipleInputs($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_hamburgerNavItem_title']) : '';
										$navIcon = isset($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_hamburgerNavItemIcon_' . $buttonCount . '_image_url']) ? sanitize_url($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_hamburgerNavItemIcon_' . $buttonCount . '_image_url']) : '';
										$hamburgerEndFlowUrl = null;
										if (isset($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_hasEndJourneyPage_' . $buttonCount]) && $_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_hasEndJourneyPage_' . $buttonCount] == 'yes') {
											$hamburgerEndFlowPageIds =  isset($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_hamburgerNavItem_' . $buttonCount . '_endFlowUrl']) ? $this->sanitizeMultipleInputs($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_hamburgerNavItem_' . $buttonCount . '_endFlowUrl']) : null;
											foreach ($hamburgerEndFlowPageIds as $hamburgerEndFlowPageUrl) {
												$hamburgerEndFlowUrl[] = sanitize_url($hamburgerEndFlowPageUrl);
											}
										}
										$hamburgerMenuItems[] = array(
											"isExternal" => $value == 'external' ? true : false,
											"icon" => $navIcon,
											"title" => $title[$key],
											"url" => $url,
											"endFlowUrl" => $hamburgerEndFlowUrl
										);
										$buttonCount++;
									}
								}
								$topNav = array(
									"designType" => "logoLeftBurgerRight",
									"useLogo" => sanitize_text_field($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_type']) == 'logo' ? true : false,
									"logo" => isset($_POST['topNav_' . $pagecount . '_logo_image_url']) ? sanitize_url($_POST['topNav_' . $pagecount . '_logo_image_url']) : '',
									"label" => isset($_POST['topNav_' . $pagecount . '_text']) ? sanitize_text_field($_POST['topNav_' . $pagecount . '_text']) : '',
									"hamburger" => [
										"backgroundColor" => isset($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_HamburgerMenuBgColor']) ? sanitize_text_field($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_HamburgerMenuBgColor']) : '',
										"menuIcon" => isset($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_HamburgerMenuIcon_image_url']) ? sanitize_url($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_HamburgerMenuIcon_image_url']) : '',
										"fontColor" => isset($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_HamburgerMenuFontColor']) ? sanitize_text_field($_POST['topNav_' . $pagecount . '_logoLeftBurgerRight_HamburgerMenuFontColor']) : '',
										"hamburgerMenuItems" => $hamburgerMenuItems
									]
								);
								break;
							}
						case 'logoLeftNavRight': {

								$navSources = $this->sanitizeMultipleInputs($_POST['topNav_' . $pagecount . '_logoLeftNavRight_Source']);
								$navInternalUrls = $this->sanitizeMultipleInputs($_POST['topNav_' . $pagecount . '_logoLeftNavRight_internalURL']);
								$navExternalUrls = $this->sanitizeMultipleInputs($_POST['topNav_' . $pagecount . '_logoLeftNavRight_externalURL']);


								$buttons = array();
								if (!empty($navSources)) {
									$buttonCount = 1;
									foreach ($navSources as $key => $value) {
										$navIcon = isset($_POST['topNav_' . $pagecount . '_logoLeftNavRight_iconImage_' . $buttonCount . '_image_url']) ? sanitize_url($_POST['topNav_' . $pagecount . '_logoLeftNavRight_iconImage_' . $buttonCount . '_image_url']) : '';
										$url = $value == 'external' ? (isset($navExternalUrls[$key]) ? sanitize_url($navExternalUrls[$key]) : '') : (isset($navInternalUrls[$key]) ? sanitize_url($navInternalUrls[$key]) : '');
										$buttons[] = array(
											"isExternal" => $value == 'external' ? true : false,
											"icon" => $navIcon,
											"url" => $url,
										);
										$buttonCount++;
									}
								}

								$topNav = array(
									"designType" => "logoLeftNavRight",
									"useLogo" => sanitize_text_field($_POST['topNav_' . $pagecount . '_logoLeftNavRight_type']) == 'logo' ? true : false,
									"logo" => isset($_POST['topNav_' . $pagecount . '_logo_image_url']) ? sanitize_url($_POST['topNav_' . $pagecount . '_logo_image_url']) : '',
									"label" => isset($_POST['topNav_' . $pagecount . '_text']) ? sanitize_text_field($_POST['topNav_' . $pagecount . '_text']) : '',
									"buttons" => $buttons
								);
								break;
							}

						case 'logoMidNavBoth': {


								$navSources = $this->sanitizeMultipleInputs($_POST['topNav_' . $pagecount . '_logoMidNavBoth_Source']);
								$navInternalUrls = $this->sanitizeMultipleInputs($_POST['topNav_' . $pagecount . '_logoMidNavBoth_internalURL']);
								$navExternalUrls = $this->sanitizeMultipleInputs($_POST['topNav_' . $pagecount . '_logoMidNavBoth_externalURL']);

								$leftButtons = array();
								$rightButtons = array();

								if (!empty($navSources)) {
									$buttonCount = 1;
									foreach ($navSources as $key => $value) {
										$url = $value == 'external' ? (isset($navExternalUrls[$key]) ? sanitize_url($navExternalUrls[$key]) : '') : (isset($navInternalUrls[$key]) ? sanitize_url($navInternalUrls[$key]) : '');

										$_iconUrl = isset($_POST['topNav_' . $pagecount . '_logoMidNavBoth_iconImage_' . $buttonCount . '_image_url']) ? sanitize_url($_POST['topNav_' . $pagecount . '_logoMidNavBoth_iconImage_' . $buttonCount . '_image_url']) : '';
										$temp = array(
											"isExternal" => $value == 'external' ? true : false,
											"icon" => $_iconUrl,
											"url" => $url,
										);
										if ($buttonCount == 1) {
											$leftButtons[] = $temp;
										} else {
											$rightButtons[] = $temp;
										}
										$buttonCount++;
									}
								}
								$topNav = array(
									"designType" => "logoMidNavBoth",
									"useLogo" => $_POST['topNav_' . $pagecount . '_logoMidNavBoth_type'] == 'logo' ? true : false,
									"logo" => isset($_POST['topNav_' . $pagecount . '_logo_image_url']) ? sanitize_url($_POST['topNav_' . $pagecount . '_logo_image_url']) : '',
									"label" => isset($_POST['topNav_' . $pagecount . '_text']) ? sanitize_text_field($_POST['topNav_' . $pagecount . '_text']) : '',
									"leftButtons" => $leftButtons,
									"rightButtons" => $rightButtons
								);
								break;
							}
					}
					$bottomBarNav["pages"][] = array(
						"url" => $pageUrl,
						"icon" => $pageIcon,
						"name" => $page,
						"isExternal" => $isExternal,
						"endFlowUrl" => $endFlowUrl,
						"topNav" => $topNav
					);
					$pagecount++;
				}
			}

			$prompts = array(
				"promptLocationService" => $_POST["promptLocationOn"] == 'true' ? true : false,
				"promptItems" => array(
					"pushNotification" => array(
						"styles" => array(
							"backgroundColor" => isset($_POST['promptPushNoti_backgroundColor']) ? sanitize_text_field($_POST['promptPushNoti_backgroundColor']) : '',
							"textColor" => isset($_POST['promptPushNoti_textColor']) ? sanitize_text_field($_POST['promptPushNoti_textColor']) : '',
							"icon" => isset($_POST['promptPushNoti_icon_image_url']) ? sanitize_url($_POST['promptPushNoti_icon_image_url']) : '',
							"title" => isset($_POST['promptPushNoti_titleText']) ? sanitize_text_field($_POST['promptPushNoti_titleText']) : '',
							"description" => isset($_POST['promptPushNoti_descText']) ? sanitize_text_field($_POST['promptPushNoti_descText']) : '',
							"acceptButtonText" => isset($_POST['promptPushNoti_acceptButtonText']) ? sanitize_text_field($_POST['promptPushNoti_acceptButtonText']) : '',
							"acceptButtonColor" => isset($_POST['promptPushNoti_acceptButtonColor']) ? sanitize_text_field($_POST['promptPushNoti_acceptButtonColor']) : '',
						)
					),
					"trackingService" => array(
						"styles" => array(
							"backgroundColor" => isset($_POST['promptTracking_backgroundColor']) ? sanitize_text_field($_POST['promptTracking_backgroundColor']) : '',
							"textColor" => isset($_POST['promptTracking_textColor']) ? sanitize_text_field($_POST['promptTracking_textColor']) : '',
							"icon" => isset($_POST['promptTracking_icon_image_url']) ? sanitize_url($_POST['promptTracking_icon_image_url']) : '',
							"title" => isset($_POST['promptTracking_titleText']) ? sanitize_text_field($_POST['promptTracking_titleText']) : '',
							"description" => isset($_POST['promptTracking_descText']) ? sanitize_text_field($_POST['promptTracking_descText']) : '',
							"acceptButtonText" => isset($_POST['promptTracking_acceptButtonText']) ? sanitize_text_field($_POST['promptTracking_acceptButtonText']) : '',
							"acceptButtonColor" => isset($_POST['promptTracking_acceptButtonColor']) ? sanitize_text_field($_POST['promptTracking_acceptButtonColor']) : '',
						)
					)
				)
			);


			$authentication = array(
				"accountRequired" => $_POST['accountRequired'] == 'yes' ? true : false,
				"authenticationPage" => isset($_POST['authenticationPage']) ? sanitize_url($_POST['authenticationPage']) : ''
			);

			// Reading the config and storing the Licence Keys
			$existingConfig = json_decode(file_get_contents(W2A_CONFIG_PATH), true);

			$appId = isset($existingConfig['appId']) ? $existingConfig['appId'] : '';
			$appSecret = isset($existingConfig['appSecret']) ? $existingConfig['appSecret'] : '';
			$siteURL = get_site_url();


			$configSaved = array(
				"appId" => $appId,
				"appSecret" => $appSecret,
				"siteURL" => $siteURL,
				"name" => $name,
				"headerToHide" => $headerToHide,
				"footerToHide" => $footerToHide,
				"otherHide" => $otherHide,
				"splash" => $splash,
				"topBarNav" => $topBarNav,
				"bottomBarNav" => $bottomBarNav,
				"prompts" => $prompts,
				"authenticationSettings" => $authentication
			);
			file_put_contents(W2A_CONFIG_PATH, json_encode($configSaved));

			// add the admin notice
			$notice = array(
				'type' => 'success',
				'icon' => plugin_dir_url(__FILE__) . 'images/Website2App-Icon.png',
				'title' => 'Settings Saved',
				'message' => 'Your settings have been saved, click the preview button to view your preview'
			);
			$this->w2a_addAdminNotice($notice);
			wp_safe_redirect(admin_url('admin.php?page=website2app-settings'));
			wp_safe_redirect(admin_url('admin.php?page=website2app-settings&section=' . $currentTab . '&topnav=' . $topNavTabsCurrent));
			exit;
		} else {
			wp_die(__('Invalid nonce specified', $this->plugin_name), __('Error', $this->plugin_name), array(
				'response' 	=> 403,
				'back_link' => 'admin.php?page=' . $this->plugin_name,
			));
		}
	}

	/**
	 * Register the Function to add custom post type for pushnotification.
	 *
	 * @since    1.0.0
	 */
	/*
	function add_pushnotification_postType(){
		register_post_type( 'pushnotification',
        array(
            'labels' => array(
                'name' => __( 'Push Notifications' ),
                'singular_name' => __( 'Push Notification' )
            ),
            'public' => false,
            'has_archive' => true,
            'rewrite' => array('slug' => 'pushnotification'),
            'show_in_rest' => true,
						'supports'=>array('custom-fields')

        )
    );
	}
	*/
	/**
	 * Register the Function to add custom post type for pushnotification group.
	 *
	 * @since    1.0.0
	 */
	function add_pushnotification_group_postType()
	{
		register_post_type(
			'pushnotification-group',
			array(
				'labels' => array(
					'name' => __('Push Notification Groups'),
					'singular_name' => __('Push Notification Group')
				),
				'public' => false,
				'has_archive' => true,
				'rewrite' => array('slug' => 'pushnotification-group'),
				'show_in_rest' => true,
				'supports' => array('custom-fields')

			)
		);
	}

	/**
	 * Register the Function to add Admin Pages for the admin area.
	 *
	 * @since    1.0.0
	 */

	public function add_admin_menu_pages()
	{
		add_menu_page(
			'Website2App',
			'Website2App',
			'manage_options',
			'website2app',
			array($this, 'website2app_dashboard'),
			plugin_dir_url(__FILE__) . "/images/Website2App-Icon.png",
			30
		);

		add_submenu_page(
			'website2app',
			'Introduction',
			'Introduction',
			'manage_options',
			'website2app',
			array($this, 'website2app_dashboard')
		);
		add_submenu_page(
			'website2app',
			'Website2App',
			'Settings',
			'manage_options',
			'website2app-settings',
			array($this, 'website2app_settings')
		);
		// add_submenu_page(
		// 			'website2app',
		// 			'Website2App',
		// 			'Account',
		// 			'manage_options',
		// 			'website2app-account',
		// 			array($this, 'website2app_account')
		// 		);
		add_submenu_page(
			'website2app',
			'Website2App',
			'Publish',
			'manage_options',
			'website2app-publish',
			array($this, 'website2app_publish')
		);
		// add_submenu_page(
		// 			'website2app',
		// 			'Website2App',
		// 			'Push Notifications',
		// 			'manage_options',
		// 			'website2app-push-notification',
		// 			array($this, 'website2app_push_notifications')
		// 		);
		// add_submenu_page(
		// 			'website2app',
		// 			'Website2App',
		// 			'Analytics',
		// 			'manage_options',
		// 			'website2app-analytics',
		// 			array($this, 'website2app_analytics')
		// 		);
	}

	/*
	Load Inroroduction Template
	*/
	public function website2app_dashboard()
	{
		include_once dirname(__FILE__) . '/partials/website2app-introduction.php';
		do_action('w2a_livechat_html');
	}

	/*
	Load Account Template
	*/
	public function website2app_account()
	{
		include_once dirname(__FILE__) . '/partials/account.php';
		do_action('w2a_livechat_html');
	}

	/*
	Load Publish Template
	*/
	public function website2app_publish()
	{
		include_once dirname(__FILE__) . '/partials/publish.php';
		do_action('w2a_livechat_html');
	}

	/*
	Load Push Notifications Template
	*/
	public function website2app_push_notifications()
	{
		include_once dirname(__FILE__) . '/partials/push-notifications.php';
		do_action('w2a_livechat_html');
	}

	/*
	Load Analytics Template
	*/
	public function website2app_analytics()
	{
		include_once dirname(__FILE__) . '/partials/analytics.php';
		do_action('w2a_livechat_html');
	}

	/*
	Function to render the Settings Page in Admin
	*/
	public function website2app_settings()
	{
		if (!current_user_can('manage_options')) {
			return;
		}
		global $website2app;
		$website2app = $this->website2app;
		$setupNotices = array();

		$setupNotices[] = array(
			'type' => 'info is-dismissable',
			'icon' => plugin_dir_url(__FILE__) . 'images/Website2App-Icon.png',
			'title' => 'Introduction to Website2App',
			'message' => 'Website2App will help you convert your website into beautiful app. All of the functionality provided must be configured carefully in order to achieve the best result.'
		);



		foreach ($setupNotices as $notice) {
			$this->w2a_addAdminNotice($notice);
		}
		include_once dirname(__FILE__) . '/partials/website2app-settings.php';
		do_action('w2a_livechat_html');
	}

	/*
	Function to show admin notices in the plugin
	*/
	public function admin_notices()
	{
		$admin_notices = $this->admin_notices;
		if (!empty($admin_notices)) {
			foreach ($admin_notices as $notice) {
				$type = $notice['type'];
				$class = 'notice notice-' . $type;
				$iconHtml = empty($notice['icon']) ? '' : '<img class="wpnaNoticeIcon" src="' . $notice["icon"] . '" />';
				$title = empty($notice['title']) ? '' : '<h1>' . $notice["title"] . '</h1>';
				$message = __($notice['message'], 'w2a');

				printf('
				<div class="notice notice-%1$s is-dismissible">
				    <div class="pluginIcon">
					    ' . $iconHtml . '
					</div>
					<div class="bannerContent">
					    ' . $title . '
					    <p>%2$s</p>
					</div>
				</div>', esc_attr($class), esc_html($message));
			}
		}
	}

	/*
	Function to fetch the configurations from saved config file, if config file is empty, create and return defatult settings
	*/
	public function w2a_get_settings()
	{
		$pluginConfiguration = null;
		if (file_exists(W2A_CONFIG_PATH)) {
			$pluginConfiguration = json_decode(file_get_contents(W2A_CONFIG_PATH), true);
		}

		// foreach ($pluginConfiguration as $ia) {
		// 	if (!is_array($ia)) {
		// 		$ia = json_decode($ia, true);
		// 	}
		// }
		// echo file_get_contents(W2A_CONFIG_PATH);die;
		// var_dump($pluginConfiguration);die;

		if ($pluginConfiguration == null) {
			$pluginConfiguration = array(
				"appId" => "",
				"appSecret" => "",
				"siteURL" => get_site_url(),
				"name" => get_bloginfo('name'),
				"headerToHide" => "",
				"footerToHide" => "",
				"otherHide" => "",
				"splash" => [
					'backgroundColor' => "",
					'backgroundImage' => "",
				],
				"topBarNav" => [
					'styles' => [
						"backgroundColor" =>	"",
						"statusBarTextColor" => 	"",
						"bannerLogo" => 	"",
						"topBarTextColor" => 	"",
						"topBarIconColor" =>	"",
					]
				],
				"bottomBarNav" => [
					"styles" => [
						"backgroundColor" => "",
						"defaultIconColor" => "",
						"activeIconColor" => "",
					],
					"pages" => [
						[
							"url" => get_site_url(),
							"icon" => plugin_dir_url(__FILE__) . "/images/Website2App-Icon.png",
							"name" => get_bloginfo('name'),
							"isExternal" => true,
							"endFlowUrl" => null,
							"topNav" => [
								"designType" => "logoOnly",
								"useLogo" => true,
								"logo" => plugin_dir_url(__FILE__) . "/images/Website2App-Icon.png",
								"label" => get_bloginfo('name'),
								"alignment" => "left",
							]
						]
					],
				],
				"prompts" => [
					"promptLocationService" => true,
					"promptItems" => [
						"pushNotification" => [
							"styles" => [
								"backgroundColor" => "",
								"textColor" => "",
								"icon" => plugin_dir_url(__FILE__) . "/images/Website2App-Icon.png",
								"title" => "",
								"description" => "",
								"acceptButtonText" => "",
								"acceptButtonColor" => "",
							]
						],
						"trackingService" => [
							"styles" => [
								"backgroundColor" => "",
								"textColor" => "",
								"icon" => plugin_dir_url(__FILE__) . "/images/Website2App-Icon.png",
								"title" => "",
								"description" => "",
								"acceptButtonText" => "",
								"acceptButtonColor" => "",
							]
						]
					]
				],
				"authenticationSettings" => [
					"accountRequired" => false,
					"authenticationPage" => ""
				]
			);
		}
		return $pluginConfiguration;
	}


	/*
	* Function to cretate the initial config file for the plugin.
	* If this is the activation on the same site, will copy the existing config.
	* If this is the activation from a new domain, it will check for existing config ( if exists copy that or create a default configuration) and create a new configuration settings
	*/
	public function initializeConfig()
	{
		$configPath = pathinfo(W2A_CONFIG_PATH);
		//Create the directory to store the config file if it does not already exists
		if (!file_exists($configPath['dirname'])) {
			mkdir($configPath['dirname'], 0755, true);
			$f = fopen(W2A_CONFIG_PATH, 'wa+');
			if (!$f) {
				error_log('Error creating the config file in initializeConfig');
			}
			fclose($f);
		}
		// Get the existing plugin configuration
		$existingConfig =  $this->w2a_get_settings();

		// If configuration already exists, copy them else create a new default config
		if (isset($existingConfig['appSecret'])) {
			$config =  $existingConfig;
			$existingSiteUrl = $config["siteURL"];
		} else {
			$existingSiteUrl = get_site_url();
			$config = [
				"appId" => "",
				"appSecret" => "",
				"siteURL" => get_site_url(),
				"name" => "",
				"headerToHide" => "",
				"footerToHide" => "",
				"otherHide" => [],
				"splash" => [
					"backgroundColor" => "",
					"backgroundImage" => ""
				],
				"topBarNav" => [
					"styles" => [
						"backgroundColor" => "",
						"statusBarTextColor" => "",
						"bannerLogo" => "",
						"topBarTextColor" => "",
						"topBarIconColor" => ""
					]
				],
				"bottomBarNav" => [
					"styles" => [
						"backgroundColor" => "",
						"defaultIconColor" => "",
						"activeIconColor" => ""
					],
					"pages" => [[
						"url" => get_site_url(),
						"icon" => "",
						"name" => "Home",
						"isExternal" => false,
						"topNav" => [
							"designType" => "",
							"useLogo" => true,
							"logo" => "",
							"label" => "",
							"hamburger" => [
								"backgroundColor" => "",
								"menuIcon" => ""
							]
						]
					]]
				],
				"prompts" => [
					"promptLocationService" => true,
					"promptItems" => [
						"pushNotification" => [
							"styles" => [
								"backgroundColor" => "",
								"textColor" => "",
								"icon" => "",
								"title" => "",
								"description" => "",
								"acceptButtonText" => "",
								"acceptButtonColor" => ""
							]
						],
						"trackingService" => [
							"styles" => [
								"backgroundColor" => "",
								"textColor" => "",
								"icon" => "",
								"title" => "",
								"description" => "",
								"acceptButtonText" => "",
								"acceptButtonColor" => ""
							]
						]
					]
				],
				"authenticationSettings" => [
					"accountRequired" => false,
					"authenticationPage" => ""
				]
			];
		}

		// Make a request to app to check if account already exists for current domain
		$url = 'https://api.website2.app/v1/account';
		$args = array(
			'method' => 'POST',
			'headers' => array(
				'website2apprequestkey' => 'sO4nl&W5sVTpBOQ#Wo07bJGMdJTZ&isi$HTe#j3x'
			),
			'body' => array('timezone' => wp_timezone_string(), 'domain' => str_replace(array("http://", "https://"), array(""), get_site_url())),
		);

		$request = wp_remote_post($url, $args);
		$body = wp_remote_retrieve_body($request);
		$response = (array)json_decode($body);

		// This will return success if this is a new domain 
		if (isset($response['success'])) {
			$appId = $response['appId'];
			$secret = $response['secret'];

			$config["appId"] = $appId;
			$config["secret"] = $secret;
		}

		// Update the old site url to the current site url
		$configSettingJSON = stripslashes(json_encode($config));
		$configSettingJSON = str_replace($existingSiteUrl, get_site_url(), $configSettingJSON);

		// Once the configuration is prepared, write to the configuration file.
		file_put_contents(W2A_CONFIG_PATH, stripslashes($configSettingJSON));
	}
	/*
	Function to output the Image Uploader Input field
	*/
	public function  w2a_image_uploadField($args)
	{
		$default = array(
			'inputName' => 'wpnaImage' . rand(),
			'imageUrl' => '',
			'uploadText' => 'Upload Image',
			'changeText' => 'Change Image',
		);
		$args = wp_parse_args($args, $default);
		extract($args);
		ob_start();
?>
<div class="wpnaImageUploadSection <?php echo esc_attr($inputName) ?>_section">
    <div class="wpnaImageUploadPreview  <?php echo esc_attr($inputName); ?>_preview"
        style="background-image: url('<?php echo esc_url($imageUrl); ?>');"></div>
    <?php
			$changeButtonStyle = ($imageUrl != '') ? '' : 'display:none';
			$uploadButtonStyle = ($imageUrl != '') ? 'display:none' : '';
			?>
    <a style="<?php echo $changeButtonStyle; ?>" href="javascript:void(0)"
        class="w2a-remove  <?php echo ($inputName); ?>_remove button">Change Image</a>
    <a style="<?php echo $uploadButtonStyle; ?>" href="#"
        class="button w2a-upload <?php echo ($inputName); ?>_upload">Upload image</a>
    <input type="hidden" name="<?php echo esc_attr($inputName); ?>_image_id" class="w2a_img_id" value="">
    <input type="hidden" name="<?php echo esc_attr($inputName); ?>_image_url" class="w2a_img_url"
        value="<?php echo esc_attr($imageUrl)  ?>">
</div>
<?php
		return ob_get_clean();
	}

	/*
	Function to fetch the ID of the Page from PageURL
	*/
	function getIDfromURL($url)
	{
		return url_to_postid($url);
	}

	/*
* Function to register the endpoint required for our plugin
*/
	function w2a_register_configuration_route()
	{
		// register_rest_route() handles more arguments but we are going to stick to the basics for now.
		register_rest_route('website2app/v1', '/config', array(
			// By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
			'methods'  => WP_REST_Server::ALLMETHODS,
			// Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
			'callback' => [$this, 'api_w2a_setup_configuration'],
			'permission_callback' => '__return_true',
		));
	}

	// Callback function for the function that handle the configuration setup post from API
	function api_w2a_setup_configuration($request)
	{
		// 630d5713fcc2c297d90f2171
		$method =  isset($_SERVER['REQUEST_METHOD']) ? sanitize_text_field($_SERVER['REQUEST_METHOD']) : '';
		$return = array();

		// rest_ensure_response() wraps the data we want to return into a WP_REST_Response, and ensures it will be properly returned.
		$domain = $request->get_header('domain');
		$secretKey = $request->get_header('appSecret');
		$newConfig = json_decode($request->get_body());

		$existingConfig =  $this->w2a_get_settings();
		if ($existingConfig['appSecret'] != $secretKey || $existingConfig['siteURL'] != $domain) {
			$return['code'] = 500;
			$return['message'] = "Verification Failed";
		} else {
			switch ($method) {
				case 'POST': {
						$update = file_put_contents(W2A_CONFIG_PATH, json_encode($newConfig));
						if ($update) {
							delete_option('Website2AppConfigMessage');
							$return['code'] = 200;
							$return['message'] = "Configuration Updated!";
						} else {
							$return['code'] = 500;
							$return['message'] = "Error writing to config file";
						}
						break;
					}
				case 'GET': {
						$return['code'] = 200;
						$return['config'] = json_encode($existingConfig);
						break;
					}
				default: {
						$return['code'] = 400;
						$return['message'] = "We have not yet implemented the " . $method . " Method!";
					}
			}
		}
		return rest_ensure_response($return);
	}

	/*
* Hooked to action w2a_validateDomain hook
* Function that runs to check if the siteurl set in the config file does not match with current siteurl. 
* If it does not match, make request for new keys and recreate the configuration.
*/
	function w2a_validateDomain()
	{
		$config = $this->w2a_get_settings();
		if ($config["siteURL"] != get_site_url()) {
			$this->initializeConfig();
		}
	}

	function sanitizeMultipleInputs($input)
	{
		$new_input = null;
		if (is_array($input)) {
			$new_input = array();
			// Loop through the input and sanitize each of the values
			foreach ($input as $key => $val) {
				if (filter_var($val, FILTER_VALIDATE_EMAIL)) {
					$new_input[$key] = sanitize_email($val);
				} elseif (filter_var($val, FILTER_VALIDATE_URL)) {
					$new_input[$key] = sanitize_url($val);
				} elseif ($val != strip_tags($val)) {
					$new_input[$key] = htmlentities($val);
				} elseif ((preg_match('/[^a-zA-Z]+/', $val, $matches))) {
					$new_input[$key] = filter_var($val, FILTER_SANITIZE_SPECIAL_CHARS);
				} else {
					$new_input[$key] = sanitize_text_field($val);
				}
			}
		} else {
			if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
				$new_input = sanitize_email($input);
			} elseif (filter_var($input, FILTER_VALIDATE_URL)) {
				$new_input = sanitize_url($input);
			} elseif ($input != strip_tags($input)) {
				$new_input = wp_kses_post($input);
			} elseif ((preg_match('/[^a-zA-Z]+/', $input, $matches))) {
				$new_input = filter_var($input, FILTER_SANITIZE_SPECIAL_CHARS);
			} else {
				$new_input = sanitize_text_field($input);
			}
		}
		return $new_input;
	}

	// function w2a_dropdown_pages_multiple($output, $pargsed_args, $pages){
	// 	if(isset($pargsed_args['multiselect']) && $pargsed_args['multiselect'] == true ){
	// 		print_r($pargsed_args);
	// 		return str_replace( '<select ', '<select multiple="multiple" ', $output );
	// 	}else{
	// 		return $output;
	// 	}
	// }

	function w2a_dropdown_pages_multiple($args)
	{

		if (isset($args['multiselect']) && $args['multiselect'] == true) {
			$echo = $args['echo'];
			$args['echo'] = 0;
			$args['walker'] = new Walker_PageDropdown_Multiple();
			$output = $this->w2a_dropdown_pages($args);
			$output = str_replace('<select ', '<select multiple="multiple" ', $output);
			echo $output;
		} else {
			//$this->w2a_dropdown_pages( $args );
		}
	}

	function w2a_renderLiveChat()
	{
		ob_start();
	?>
<div id="w2a_livechat-sticky" class="flex-row aic g10">
    <img src="<?php echo plugin_dir_url(__FILE__) . 'images/icon-help.png' ?>">
    <div class="flex-column">
        <span><b>Hit a roadblock? </b><i>Website2App</i> is brand new, so please <a
                href="https://website2app.com/support/" target="_blank">contact us</a>. We’re on hand to help!</span>
    </div>
</div>

<?php
		$liveChatHtml = ob_get_clean();
		echo html_entity_decode(esc_html($liveChatHtml));
	}
}

if (!class_exists('Walker_PageDropdown_Multiple')) {
	/**
	 * Create HTML dropdown list of pages.
	 *
	 * @package WordPress
	 * @since 2.1.0
	 * @uses Walker
	 */
	class Walker_PageDropdown_Multiple extends Walker_PageDropdown
	{
		/**
		 * @see Walker::start_el()
		 * @since 2.1.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $page Page data object.
		 * @param int $depth Depth of page in reference to parent pages. Used for padding.
		 * @param array $args Uses 'selected' argument for selected page to set selected HTML attribute for option element.
		 * @param int $id
		 */
		function start_el(&$output, $page, $depth = 0, $args = array(), $id = 0)
		{
			$pad = str_repeat(isset($args['pad']) ? $args['pad'] : '--', $depth);

			$output .= "\t<option class=\"level-$depth\" value=\"$page->ID\"";
			if (in_array($page->ID, (array) $args['selected']))
				$output .= ' selected="selected"';
			$output .= '>';
			$title = apply_filters('list_pages', $page->post_title, $page);
			$title = apply_filters('pagedropdown_multiple_title', $title, $page, $args);
			$output .= $pad . ' ' . esc_html($title);
			$output .= "</option>\n";
		}
	}
}
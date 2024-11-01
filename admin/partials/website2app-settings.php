<?php
/**
 * Renders the settings page for the plugin.
 */

// Hook to check if the siteURL in the config file matches the current domain
do_action('w2a_validateDomain');

$config = $this->w2a_get_settings();

$defaultLogo = get_theme_mod( 'custom_logo' );
$image = wp_get_attachment_image_src( $defaultLogo , 'thumbnail' );
$defaultLogoURL = '';
if($image){
  $defaultLogoURL = $image[0];
}else{
  $defaultLogoURL = '';
}
?>
<!-- ============================================================================================================================-->
<!-- ============================================================================================================================-->
<!-- ============================================================================================================================-->
<!-- ===============================Generic HTML Blocks used in Settings=========================================================-->
<!-- ============================================================================================================================-->
<!-- ============================================================================================================================-->

<div class="toNavIndividualPageSetup hide" id="topNavIndividualPageSetupGeneric">
    <h3>Upload a logo for the nav bar or enter text</h3>
    <p>The logo and text uploaded in this section will be used in the nav configuration you choose below.</p>
    <div class="topNavLogoAndText">
        <h4>Select Logo</h4>
        <?php
      $args = array(
            'inputName'=>'topNav_{{bottomBarpagecount}}_logo',
            'imageUrl'=>'',
            'uploadText'=>'Upload Icon',
            'changeText'=>'Change Icon'
          );
      echo html_entity_decode(esc_html($this->w2a_image_uploadField($args))); ?>
        <h4>Top bar text</h4>
        <p>By default we’ll load in the page title. You can edit the text to be anything you would like within 10
            characters.</p>
        <input class='topNavInput' type="text" name="topNav_{{bottomBarpagecount}}_text" value="" />
    </div>
    <h2 class='structureLabel'>How would you like your top bar navigation to be structured?</h2>





    <div class="topNavOptionsParent">
        <section data-structure='1' class="topNav_optionParent navStructureRow flex-column jc-sb ai-fe">
            <div class='settingSelect'>
                <label><input type="radio" name="topNav_{{bottomBarpagecount}}_structure" checked value="logoOnly" />
                    Logo/Text aligned left,middle or right</label>
            </div>
            <div class="settingParent">
                <h4 class='question'>Logo or Text?</h4>
                <div class='settingOption'>
                    <div data-id="1" class="optionParent">
                        <div class="optionRadio">
                            <label>
                                <input type="radio" class="conditional"
                                    name="topNav_{{bottomBarpagecount}}_logoOnly_type" value="logo"> Logo
                            </label>
                        </div>
                        <div class="conditionalSettings hide">
                        </div>
                    </div>

                    <div data-id="2" class="optionParent">
                        <div class="optionRadio"><label><input type="radio" class="conditional"
                                    name="topNav_{{bottomBarpagecount}}_logoOnly_type" value="text"> Text</label></div>
                        <div class="conditionalSettings hide">
                        </div>
                    </div>
                </div>
                <h4>Select the Logo Alignment</h4>
                <div class="alignmentOptions flex-row">
                    <label><input type="radio" class="" name="topNav_{{bottomBarpagecount}}_logoOnly_align"
                            value="left" /> Left</label>
                    <label><input type="radio" class="" name="topNav_{{bottomBarpagecount}}_logoOnly_align"
                            value="middle" /> Middle</label>
                    <label><input type="radio" class="" name="topNav_{{bottomBarpagecount}}_logoOnly_align"
                            value="right" /> Right</label>
                </div>
            </div>
        </section>
        <section data-structure='2' class="topNav_optionParent navStructureRow flex-column jc-sb ai-fe">
            <div class='settingSelect'>
                <label><input type="radio" name="topNav_{{bottomBarpagecount}}_structure" value="logoLeftBurgerRight" />
                    Logo/Text on the left and hamburger menu icon on the right</label>
            </div>
            <div class="settingParent hide">
                <div class='settingOption'>
                    <div data-id="1" class="optionParent">
                        <div class="optionRadio"><label><input type="radio" class="conditional"
                                    name="topNav_{{bottomBarpagecount}}_logoLeftBurgerRight_type" value="logo"> Logo
                            </label></div>
                        <div class="conditionalSettings hide">
                        </div>
                    </div>
                    <div data-id="2" class="optionParent">
                        <div class="optionRadio"><label><input type="radio" class="conditional"
                                    name="topNav_{{bottomBarpagecount}}_logoLeftBurgerRight_type" value="text">
                                Text</label></div>
                        <div class="conditionalSettings hide">
                        </div>
                    </div>
                    <div data-id='3' class='optionParent flex-column'>
                        <label>Hamburger Menu background color</label>
                        <input type="text" value="" data-alpha-enabled="true" data-default-color="rgba(0,0,0,0.85)"
                            class="color-picker{{bottomBarpagecount}}"
                            name="topNav_{{bottomBarpagecount}}_logoLeftBurgerRight_HamburgerMenuBgColor[]"
                            _not_required />
                        <label>Hamburger Menu Font color</label>
                        <input type="text" value="" data-alpha-enabled="true" data-default-color="rgba(0,0,0,0.85)"
                            class="color-picker{{bottomBarpagecount}}"
                            name="topNav_{{bottomBarpagecount}}_logoLeftBurgerRight_HamburgerMenuFontColor[]"
                            _not_required />
                        <label class="inputLabel">Hamburger Menu Icon</label>
                        <?php
              $args = array(
                    'inputName'=>'topNav_{{bottomBarpagecount}}_logoLeftBurgerRight_HamburgerMenuIcon',
                    'imageUrl'=>'',
                    'uploadText'=>'Select Icon',
                    'changeText'=>'Change Icon'
                  );
            echo html_entity_decode(esc_html($this->w2a_image_uploadField($args)));
            ?>
                        <label class="inputLabel">Hamburger Menu Items</label>
                        <div class="flex-column topNavPageIconItem">
                            <div class="flex-row bottomBarItemWrapTop">
                                <div class="bottomBarItemType">
                                    <select onchange="handleHamburgerMenuLinkTypeChange(this)" _not_required
                                        class="bottomBarItemType"
                                        name="topNav_{{bottomBarpagecount}}_logoLeftNavRight_hamburgerNavItemSource[]">
                                        <option value="page">Page</option>
                                        <option value="external" selected>External</option>
                                    </select>
                                </div>
                                <div class="bottomBarItemUrl flex-column">
                                    <?php
                      $this->w2a_dropdown_pages(
                                                    [
                                                      'name'=>'topNav_{{bottomBarpagecount}}_logoLeftNavRight_hamburgerNavItem_internalURL[]',
                                                      'id'=>'topNav_{{bottomBarpagecount}}_logoLeftNavRight_hamburgerNavItem_internalURL_1',
                                                      'class'=>'hide topNavItemUrlInternal',
                                                      'echo'=>'1',
                                                      'value_field'=>'guid',
                                                      'selected'=>0
                                                    ]
                                                  );?>
                                    <input type="text" class="topNavItemUrlExternal"
                                        name="topNav_{{bottomBarpagecount}}_logoLeftNavRight_hamburgerNavItem_externalURL[]"
                                        placeholder="Enter External URL" value="" />
                                </div>
                            </div>
                            <div class="flex-row flex-start bottomBarItemWrapBottom">
                                <?php
                    $args = array(
                            'inputName'=>'topNav_{{bottomBarpagecount}}_logoLeftNavRight_hamburgerNavItemIcon_1',
                            'imageUrl'=>'',
                            'uploadText'=>'Upload Icon',
                            'changeText'=>'Change Icon'
                          );
                  echo html_entity_decode(esc_html($this->w2a_image_uploadField($args))); ?>
                            </div>
                        </div>

                        <div class="addNewNavigationIcon">
                            <a href="javascript:void(0)" onclick="addTopNavHamburgerItem(this)">Add another navigation
                                icon</a>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <section id='topNav_option_{{bottomBarpagecount}}_three' data-structure='3'
            class="topNav_optionParent navStructureRow flex-column jc-sb ai-fe">
            <div class='settingSelect'>
                <label><input type="radio" name="topNav_{{bottomBarpagecount}}_structure" value="3" /> Logo/Text on the
                    left and navigation icons on the right </label>
            </div>
            <div class='settingParent hide'>
                <h3>Logo or text in top bar</h3>
                <p>Would you like your logo or text displayed in the top bar?</p>
                <div class='settingOption'>
                    <div data-id="1" class="optionParent">
                        <div class="optionRadio"><label><input type="radio" class="conditional"
                                    name="topNav_{{bottomBarpagecount}}_structure_3_type" value="logo"> Logo </label>
                        </div>
                        <div class="conditionalSettings hide">
                        </div>
                    </div>
                    <div data-id="2" class="optionParent">
                        <div class="optionRadio"><label><input type="radio" class="conditional"
                                    name="topNav_{{bottomBarpagecount}}_structure_3_type" value="text"> Text</label>
                        </div>
                        <div class="conditionalSettings hide">
                        </div>
                    </div>
                </div>

                <div class="flex-column topNavPageIconItem">
                    <div class="flex-row bottomBarItemWrapTop">
                        <div class="bottomBarItemType">
                            <select onchange="handleTopNavLinkTypeChange(this)" _not_required class="bottomBarItemType"
                                name="topNav_{{bottomBarpagecount}}_structure_3_Source_1">
                                <!-- <option disabled selected>Select a Link Type</option> -->
                                <option value="page">Page</option>
                                <option value="external">External</option>

                            </select>
                        </div>
                        <div class="bottomBarItemUrl flex-column">
                            <?php $this->w2a_dropdown_pages(
                                      [
                                        'name'=>'topNav_{{bottomBarpagecount}}_structure_3_internalURL_1',
                                        'id'=>'topNav_{{bottomBarpagecount}}_structure_3_internalURL_1',
                                        'class'=>'topNavItemUrlInternal',
                                        'echo'=>'1',
                                        'value_field'=>'guid'
                                      ]
                                    );?>
                            <input type="text" class="topNavItemUrlExternal"
                                name="topNav_{{bottomBarpagecount}}_structure_3_externalURL_1"
                                placeholder="Enter External URL" style="display:none;" />
                        </div>
                    </div>
                    <div class="flex-row flex-start bottomBarItemWrapBottom">
                        <?php
      $args = array(
              'inputName'=>'topNav_{{bottomBarpagecount}}_structure_3_iconImage',
              'imageUrl'=>'',
              'uploadText'=>'Upload Icon',
              'changeText'=>'Change Icon'
            );
            echo html_entity_decode(esc_html($this->w2a_image_uploadField($args))); ?>
                    </div>
                </div>
                <div class="addNewNavigationIcon">
                    <a href="javascript:void(0)" onclick="addTopNavNavigationIcon(this)">Add another navigation icon</a>
                </div>
            </div>
        </section>

        <section id='topNav_option_{{bottomBarpagecount}}_four' data-structure='4'
            class="topNav_optionParent navStructureRow flex-column jc-sb ai-fe">
            <div class='settingSelect'>
                <label><input type="radio" name="topNav_{{bottomBarpagecount}}_structure" value="4" /> Logo/Text middle
                    and navigation icons on both left and right </label>
            </div>
            <div class='settingParent hide'>
                <h3>Logo or text in top bar?</h3>
                <p>Would you like your logo or text displayed in the top bar?</p>
                <div class='settingOption'>
                    <div data-id="1" class="optionParent">
                        <div class="optionRadio"><label><input type="radio" class="conditional"
                                    name="topNav_{{bottomBarpagecount}}_structure_4_type" value="logo"> Logo </label>
                        </div>
                        <div class="conditionalSettings hide">
                        </div>
                    </div>
                    <div data-id="2" class="optionParent">
                        <div class="optionRadio"><label><input type="radio" class="conditional"
                                    name="topNav_{{bottomBarpagecount}}_structure_4_type" value="text"> Text</label>
                        </div>
                        <div class="conditionalSettings hide">
                        </div>
                    </div>
                </div>


                <div class="flex-column topNavPageIconItem">
                    <div class="flex-row bottomBarItemWrapTop">
                        <div class="bottomBarItemType">
                            <select onchange="handleTopNavLinkTypeChange(this)" _not_required class="bottomBarItemType"
                                name="topNav_{{bottomBarpagecount}}_structure_4_Source_1">
                                <!-- <option disabled selected>Select a Link Type</option> -->
                                <option value="page">Page</option>
                                <option value="external">External</option>

                            </select>
                        </div>
                        <div class="bottomBarItemUrl flex-column">
                            <?php $this->w2a_dropdown_pages(
                                          [
                                            'name'=>'topNav_{{bottomBarpagecount}}_structure_4_internalURL_1',
                                            'id'=>'topNav_{{bottomBarpagecount}}_structure_4_internalURL_1',
                                            'class'=>'topNavItemUrlInternal',
                                            'echo'=>'1',
                                            'value_field'=>'guid'
                                          ]
                                        );?>
                            <input type="text" class="topNavItemUrlExternal"
                                name="topNav_{{bottomBarpagecount}}_structure_4_externalURL_1"
                                placeholder="Enter External URL" style="display:none;" />
                        </div>
                    </div>
                    <div class="flex-row flex-start bottomBarItemWrapBottom">
                        <?php
          $args = array(
                  'inputName'=>'topNav_{{bottomBarpagecount}}_structure_4_iconImage',
                  'imageUrl'=>'',
                  'uploadText'=>'Upload Icon',
                  'changeText'=>'Change Icon'
                );
        echo html_entity_decode(esc_html($this->w2a_image_uploadField($args))); ?>
                    </div>

                </div>
                <div class="addNewNavigationIcon">
                    <a href="javascript:void(0)" onclick="addTopNavNavigationIcon(this)">Add another navigation icon</a>
                </div>
            </div>
        </section>
    </div>


</div>

<!-- ============================================================================================================================-->
<!-- ============================================================================================================================-->
<div class="hide flex-column  topNavPageIconItem" id="topNavNaviagionIconGeneric">
    <div class="flex-row bottomBarItemWrapTop">
        <div class="bottomBarItemType">
            <select onchange="handleTopNavLinkTypeChange(this)" _not_required class="bottomBarItemType"
                name="topNav_{{topNavTabCount}}_{{designType}}_Source[]">
                <option value="page">Page</option>
                <option value="external">External</option>
            </select>
        </div>
        <div class="bottomBarItemUrl flex-column">
            <?php
      $this->w2a_dropdown_pages(
                                    [
                                      'name'=>'topNav_{{topNavTabCount}}_{{designType}}_internalURL[]',
                                      'id'=>'topNav_{{topNavTabCount}}_{{designType}}_internalURL_{{iconCount}}',
                                      'class'=>'topNavItemUrlInternal',
                                      'echo'=>'1',
                                      'value_field'=>'guid',
                                      'selected'=>''
                                    ]
                                  );?>
            <input type="text" class="topNavItemUrlExternal hide"
                name="topNav_{{topNavTabCount}}_{{designType}}_externalURL[]" placeholder="Enter External URL"
                value="" />
        </div>
    </div>
    <div class="flex-row flex-start bottomBarItemWrapBottom">
        <?php
    $args = array(
            'inputName'=>'topNav_{{topNavTabCount}}_{{designType}}_iconImage_{{iconCount}}',
            'imageUrl'=>'',
            'uploadText'=>'Upload Icon',
            'changeText'=>'Change Icon'
          );
  echo html_entity_decode(esc_html($this->w2a_image_uploadField($args))); ?>
    </div>
</div>
<!-- ============================================================================================================================-->
<!-- ============================================================================================================================-->


<!-- ============================================================================================================================-->
<!-- ============================================================================================================================-->
<div class="hide flex-column  topNavPageIconItem" id="topNavNaviagionHamburgerItemGeneric">
    <div class="flex-row bottomBarItemWrapTop">
        <div class="bottomBarItemType">
            <select onchange="handleTopNavLinkTypeChange(this)" _not_required class="bottomBarItemType"
                name="topNav_{{topNavTabCount}}_logoLeftBurgerRight_hamburgerNavItemSource[]">
                <option value="page">Page</option>
                <option value="external">External</option>
            </select>
        </div>
        <div class="bottomBarItemUrl flex-column">
            <?php
      $this->w2a_dropdown_pages(
                                    [
                                      'name'=>'topNav_{{topNavTabCount}}_logoLeftBurgerRight_hamburgerNavItem_internalURL[]',
                                      'id'=>'topNav_{{topNavTabCount}}_logoLeftBurgerRight_hamburgerNavItem_internalURL_{{iconCount}}',
                                      'class'=>'topNavItemUrlInternal',
                                      'echo'=>'1',
                                      'value_field'=>'guid',
                                      'selected'=>''
                                    ]
                                  );?>
            <input type="text" class="topNavItemUrlExternal hide"
                name="topNav_{{topNavTabCount}}_logoLeftBurgerRight_hamburgerNavItem_externalURL[]"
                placeholder="Enter External URL" value="" />
        </div>
        <div class="flex-column">
            <input type="text" class="topNavItemLabel"
                name="topNav_{{topNavTabCount}}_logoLeftBurgerRight_hamburgerNavItem_title[]" placeholder="Title"
                value="" />
        </div>
    </div>
    <div class="flex-row flex-start bottomBarItemWrapBottom">
        <?php
    $args = array(
            'inputName'=>'topNav_{{topNavTabCount}}_logoLeftBurgerRight_hamburgerNavItemIcon_{{iconCount}}',
            'imageUrl'=>'',
            'uploadText'=>'Upload Icon',
            'changeText'=>'Change Icon'
          );
    echo html_entity_decode(esc_html($this->w2a_image_uploadField($args))); ?>
    </div>
    <div class="endOfJourneyPageSelectionWrap radioInputs">
        <fieldset class="flex-column mb10">
            <div class="flex-column mb10">
                <h4>Will this page have end of Journey Page?</h4>
                <div class="">
                    <input type="radio" class="hasEndJourneyPage"
                        name="topNav_{{topNavTabCount}}_logoLeftBurgerRight_hasEndJourneyPage_{{iconCount}}"
                        id="topNav_{{topNavTabCount}}_logoLeftBurgerRight_hasEndJourneyPageNo_{{iconCount}}" value="no"
                        checked><label
                        for="topNav_{{topNavTabCount}}_logoLeftBurgerRight_hasEndJourneyPage_{{iconCount}}No"
                        class="inputLabel">No</label>
                    <input type="radio" class="hasEndJourneyPage"
                        name="topNav_{{topNavTabCount}}_logoLeftBurgerRight_hasEndJourneyPage_{{iconCount}}"
                        id="topNav_{{topNavTabCount}}_logoLeftBurgerRight_hasEndJourneyPageYes_{{iconCount}}"
                        value="yes"><label
                        for="topNav_{{topNavTabCount}}_logoLeftBurgerRight_hasEndJourneyPageYes_{{iconCount}}"
                        class="inputLabel">Yes</label>
                </div>
            </div>
            <div class=" hide endFlowUrl">
                <h4>Select Page</h4>
                <?php 
        $pagesDropdownHtml = $this->w2a_dropdown_pages_multiple(
        [
        'name'=>'topNav_{{topNavTabCount}}_logoLeftBurgerRight_hamburgerNavItem_{{iconCount}}_endFlowUrl[]',
        'id'=>'topNav_{{topNavTabCount}}_logoLeftBurgerRight_hamburgerNavItem_{{iconCount}}_endFlowUrl',
        'class'=>'bottomBarEndFlowUrl',
        'echo'=>'0',
        'value_field'=>'guid',
        'multiselect'=>true
        ]
        );
        echo html_entity_decode(esc_html($pagesDropdownHtml));
      ?>


            </div>
        </fieldset>
    </div>
</div>
<!-- ============================================================================================================================-->
<!-- ============================================================================================================================-->
<div class="flex-column hide" id="navigationBottomBarItemGeneric">
    <div class="endOfJourneyPageSelectionWrap radioInputs">
        <fieldset class="flex-column mb10">
            <div class="flex-column mb10">
                <h4>Will this page have end of Journey Page?</h4>
                <div class="">
                    <input type="radio" class="hasEndJourneyPage" name="bottomBar_{{iconcount}}_hasEndJourneyPage"
                        id="bottomBar_{{iconcount}}_hasEndJourneyPageNo" value="no" checked><label
                        for="bottomBar_{{iconcount}}_hasEndJourneyPageNo" class="inputLabel">No</label>
                    <input type="radio" class="hasEndJourneyPage" name="bottomBar_{{iconcount}}_hasEndJourneyPage"
                        id="bottomBar_{{iconcount}}_hasEndJourneyPageYes" value="yes"><label
                        for="bottomBar_{{iconcount}}_hasEndJourneyPageYes" class="inputLabel">Yes</label>
                </div>
            </div>
            <div class=" hide endFlowUrl">
                <h4>Select Page</h4>

                <?php 
                                $pagesDropdownHtml = $this->w2a_dropdown_pages_multiple(
                                  [
                                  'name'=>'bottomBarEndFlowUrl_{{iconcount}}[]',
                                  'id'=>'bottomBarEndFlowUrl_{{iconcount}}',
                                  'class'=>'bottomBarEndFlowUrl',
                                  'echo'=>'0',
                                  'value_field'=>'guid',
                                  'multiselect'=>true
                                  ]
                                  );
                                  echo html_entity_decode(esc_html($pagesDropdownHtml));
                                  ?>





            </div>

        </fieldset>
    </div>
    <div class="flex-row bottomBarItemWrapTop">

        <div class="bottomBarItemType">
            <select onchange="handleBottomBarLinkTypeChange(this)" _not_required class="bottomBarItemType"
                name="bottomBarItemType_{{iconcount}}">
                <!-- <option disabled selected>Select a Link Type</option> -->
                <option value="page">Page</option>
                <option value="external">External</option>
            </select>
        </div>
        <div class="bottomBarItemUrl flex-column">
            <?php $this->w2a_dropdown_pages(
                                    [
                                      'name'=>'bottomBarItemUrlInternal_{{iconcount}}',
                                      'id'=>'bottomBarItemUrlInternal_{{iconcount}}',
                                      'class'=>'bottomBarItemUrlInternal',
                                      'echo'=>'1',
                                      'value_field'=>'guid'
                                    ]
                                  );?>
            <input type="text" class="bottomBarItemUrlExternal hide" name="bottomBarItemUrlExternal_{{iconcount}}"
                placeholder="Enter External URL" />
        </div>
        <div class="bottomBarItemText">
            <input type="text" class="bottomBarItemText" name="bottomBarItemText[]" value=""
                placeholder="Enter Label" />
        </div>
    </div>
    <div class="flex-row flex-start bottomBarItemWrapBottom">
        <?php
    $args = array(
            'inputName'=>'bottomBarNavLogo_{{iconcount}}',
            'imageUrl'=>'',
            'uploadText'=>'Upload Icon',
            'changeText'=>'Change Icon'
          );
    echo html_entity_decode(esc_html($this->w2a_image_uploadField($args))); ?>
    </div>
</div>

<!-- ============================================================================================================================-->
<!-- ============================================================================================================================-->
<!-- ============================================================================================================================-->
<!-- ===============================Generic HTML Blocks used in Settings=========================================================-->
<!-- ============================================================================================================================-->
<!-- ============================================================================================================================-->


<div class="flex-row settings-page-parent" id="website2app-admin">
    <div class="flexitem w2a_settings_page_left">
        <div class="topPageSection">
            <h1 class="wp-heading-inline"><span class="w2a-icon"></span>
                <?php echo esc_html(get_admin_page_title()); ?></h1>
            <?php $this->admin_notices(); ?>
        </div>



        <div id="w2a_settings_tabs">
            <ul>
                <li class="settingsTab"><a href="#general">General</a></li>
                <li class="settingsTab"><a href="#bottomNav">Bottom Nav</a></li>
                <li class="settingsTab"><a href="#topNav">Top Nav</a></li>
                <li class="settingsTab"><a href="#authentication">Authentication</a></li>
            </ul>
            <?php $w2a_save_settings_nonce = wp_create_nonce( 'w2a_save_settings_form_nonce' ); ?>
            <form id="wpnaSettingsForm" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <input type="hidden" id="currentTabInput" name="currentTab"
                    value="<?php echo isset($_GET['section']) ? esc_attr($_GET['section']) : 0;?>" />
                <input type="hidden" name="action" value="handle_w2a_settings_submit">
                <input type="hidden" name="w2a_save_settings_nonce"
                    value="<?php echo esc_attr($w2a_save_settings_nonce); ?>" />
                <div id="general" class="tab-content generalSettings">
                    <?php include_once dirname(__FILE__) . '/general.php';?>
                </div>
                <div id="bottomNav" class="tab-content" style="display:none;">
                    <?php include_once dirname(__FILE__) . '/bottomnav.php';?>
                </div>
                <div id="topNav" class="tab-content" style="display:none;">
                    <?php include_once dirname(__FILE__) . '/topnav.php';?>
                </div>

                <div id="authentication" class="tab-content" style="display:none;">
                    <?php include_once dirname(__FILE__) . '/authentication.php';?>
                </div>
                <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary"
                        value="Save" onclick=""></p>

            </form>
        </div>
    </div>
    <div class="w2a_settings_page_right sticky">
        <h2 style='margin-bottom:0px;'>Preview your app</h2>
        <div id="appPreview">
            <div class='appPreviewPhoneContainer'>
                <div class="overlay loader">
                    <div class="lds-spinner">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
                <iframe src="/?hidetoolbar=true" class="appPreviewiFrame" onload="appPreviewerDidLoad();">

                </iframe>
                <div class="iFrameiPhoneFrame-Previewer"></div>
            </div>
        </div>
        <button class='preview-popup-trigger'>Ready to preview your app on your device?</button>
    </div>
</div>
<div class='popup-bg'>
    <div class='qr-code-popup'>
        <div id="qrcode" class='preview-qr-code'></div>
        <h2>Scan your QR code from inside the Website2App app to preview your App on your device</h2>
        <div class='download-app-inner'>
            <h4>Download Website2App on the App Store or Google Play Store</h4>
            <div class='download-app-icons'>
                <a href="https://androidpreviewerapp.website2app.com">
                    <img src='<?php echo esc_url(plugin_dir_url( __DIR__ ));?>/images/general/app-store.png' />
                </a>
                <a href="https://iospreviewerapp.website2app.com">
                    <img src='<?php echo esc_url(plugin_dir_url( __DIR__ ));?>/images/general/play-store.png' />
                </a>
            </div>
        </div>
    </div>
</div>
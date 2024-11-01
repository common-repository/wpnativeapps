<section class="flex=row mb10">
    <div class="flex-item flex-column topNavsection">
        <div class="section_heading">
            <h2>Select a top navigation for each of your bottom navigation Pages</h2>
        </div>
        <div id="topNavTabs">
            <?php
      $bottomNavPages = $config['bottomBarNav']['pages'];
      if (!empty($bottomNavPages)) {
        echo '<ul id="topNavTabsControl">';
        $liCount = 1;
        foreach ($bottomNavPages as $ulItem) {
          printf('<li class="topNavTabs"> <a href="#topNavPage_%1$d"> <img src="%2$s" class="topNavPageIcon">%3$s</a></li>', esc_attr($liCount), esc_url($ulItem["icon"]), esc_attr($ulItem["name"]));
          $liCount++;
        }
        printf('</ul>');
        $topNavTabCount = 1;
        foreach ($bottomNavPages as $bottomNavPage) {

          $navPage = $bottomNavPage['topNav'];
          $topNav_logo = '';
          $topNav_label = '';
          $designType = '';
          $logoAlignment = '';
          $useLogo = false;
          $logoAlignment = null;
          $hamburger = null;
          $hamburger_backgroundColor = null;
          $hamburger_menuIcon = null;
          $buttonsData = array(
            array(
              "isExternal" => true,
              "icon" => '',
              "url" => ''
            )
          );
          $hamburgerItems = array(
            array(
              "isExternal" => true,
              "icon" => '',
              "url" => ''
            )
          );
          $leftButtons = array(
            array(
              "isExternal" => true,
              "icon" => '',
              "url" => ''
            )
          );
          $rightButtons = array(
            array(
              "isExternal" => true,
              "icon" => '',
              "url" => ''
            )
          );

          if ($navPage !== null) {

            $designType = esc_attr($navPage['designType']);
            // var_dump($navPage);die;
            $topNav_logo = esc_url($navPage['logo']);
            $topNav_label = esc_html($navPage['label']);

            $useLogo = isset($navPage['useLogo']) ? $navPage['useLogo'] === true ? 'checked ' : '' : '';

            switch ($designType) {
              case 'logoOnly': {
                  $logoAlignment = esc_attr($navPage['alignment']);
                  break;
                }
              case 'logoLeftBurgerRight': {
                  $hamburger = $navPage['hamburger'];
                  $hamburger_backgroundColor = $hamburger['backgroundColor'];
                  $hamburger_fontColor = $hamburger['fontColor'];
                  $hamburger_menuIcon = esc_url($hamburger['menuIcon']);
                  $hamburgerItems = isset($hamburger['hamburgerMenuItems']) ? $hamburger['hamburgerMenuItems'] : '';
                  $hamburgerItemsData = array();
                  if (!empty($hamburgerItems)) {
                    foreach ($hamburgerItems as $buttonItem) {
                      $endFlowPageIds = array();
                      $endFlowurls = isset($buttonItem['endFlowUrl']) ? $buttonItem['endFlowUrl'] : null;
                      if (!empty($endFlowurls)) {
                        foreach ($endFlowurls as $url) {
                          $endFlowPageIds[] = sanitize_url($url);
                        }
                      }

                      $hamburgerItemsData[] = array(
                        "isExternal" => isset($buttonItem['isExternal']) ? esc_attr($buttonItem['isExternal']) : 'external',
                        "icon" => isset($buttonItem['icon']) ? esc_url($buttonItem['icon']) : '',
                        "title" => isset($buttonItem['title']) ? esc_html($buttonItem['title']) : '',
                        "url" => isset($buttonItem['url']) ? esc_url($buttonItem['url']) : '',
                        "endFlowPageIds" => $endFlowPageIds,
                      );
                    }
                  } else {
                    $hamburgerItemsData = array(
                      array(
                        "isExternal" => true,
                        "title" => '',
                        "icon" => '',
                        "url" => '',
                        'endFlowPageIds' => null,
                      )
                    );
                  }
                  break;
                }
              case 'logoLeftNavRight': {
                  $buttonsSettings = $navPage['buttons'];
                  if (!empty($buttonsSettings)) {
                    $buttonsData = array();
                    foreach ($buttonsSettings as $buttonItem) {
                      $buttonsData[] = array(
                        "isExternal" => isset($buttonItem['isExternal']) ?  $buttonItem['isExternal'] : 'external',
                        "icon" => isset($buttonItem['icon']) ?  esc_url($buttonItem['icon']) : '',
                        "url" => isset($buttonItem['url']) ?  esc_url($buttonItem['url']) : ''
                      );
                    }
                  }

                  break;
                }
              case 'logoMidNavBoth': {
                  // $leftButtons = $navPage['leftButtons'];
                  $leftButtonsSettings = $navPage['leftButtons'];
                  if (!empty($leftButtonsSettings)) {
                    $leftButtons = array();
                    foreach ($leftButtonsSettings as $buttonItem) {
                      $leftButtons[] = array(
                        "isExternal" => isset($buttonItem['isExternal']) ?  $buttonItem['isExternal'] : 'external',
                        "icon" => isset($buttonItem['icon']) ?  esc_url($buttonItem['icon']) : '',
                        "url" => isset($buttonItem['url']) ?  esc_url($buttonItem['url']) : ''
                      );
                    }
                  }

                  // $rightButtons = $navPage['rightButtons'];
                  $rightButtonsSettings = $navPage['rightButtons'];
                  if (!empty($rightButtonsSettings)) {
                    $rightButtons = array();
                    foreach ($rightButtonsSettings as $buttonItem) {
                      $rightButtons[] = array(
                        "isExternal" => isset($buttonItem['isExternal']) ?  $buttonItem['isExternal'] : 'external',
                        "icon" => isset($buttonItem['icon']) ?  esc_url($buttonItem['icon']) : '',
                        "url" => isset($buttonItem['url']) ?  esc_url($buttonItem['url']) : ''
                      );
                    }
                  }

                  break;
                }
            }
          }

      ?>

            <div id="topNavPage_<?php esc_attr_e($topNavTabCount); ?>"
                data-pagecount="<?php esc_attr_e($topNavTabCount); ?>" class="topNavPageSettings flex-column">
                <input type="hidden" id="topNavTabsCurrent" name="topNavTabsCurrent"
                    value="<?php echo isset($_GET['topnav']) ? esc_attr($_GET['topnav']) : 0; ?>" />
                <h3>Upload a logo for the nav bar or enter text</h3>
                <p>The logo and text uploaded in this section will be used in the nav configuration you choose below.
                </p>
                <div class="topNavLogoAndText">
                    <h4>Select Logo</h4>
                    <?php
              $args = array(
                'inputName' => 'topNav_' . $topNavTabCount . '_logo',
                'imageUrl' => $topNav_logo,
                'uploadText' => 'Upload Icon',
                'changeText' => 'Change Icon'
              );
              echo html_entity_decode(esc_html($this->w2a_image_uploadField($args)));

              ?>
                    <h4>Top bar text</h4>
                    <p>By default we'll load in the page title. You can edit the text to be anything you would like
                        within 10 characters.</p>
                    <input class='topNavInput' type="text" name="topNav_<?php esc_attr_e($topNavTabCount); ?>_text"
                        value="<?php esc_attr_e($topNav_label); ?>" />
                </div>
                <h2 class='structureLabel'>How would you like your top bar navigation to be structured?</h2>
                <div class="topNavOptionsParent">

                    <section data-structure='1' class="topNav_optionParent navStructureRow flex-column jc-sb ai-fe">
                        <div class='settingSelect'>
                            <label><input type="radio" name="topNav_<?php esc_attr_e($topNavTabCount); ?>_structure"
                                    <?php echo ($designType == 'logoOnly') ? 'checked ' : ''; ?> value="logoOnly" />
                                Logo/Text aligned left,middle or right</label>
                        </div>
                        <div class="settingParent <?php echo $designType == 'logoOnly' ? '' : 'hide' ?>">
                            <h4 class='question'>Logo or Text?</h4>
                            <div class='settingOption'>
                                <div data-id="1" class="optionParent">
                                    <div class="optionRadio">
                                        <label>
                                            <input type="radio" class="conditional"
                                                <?php echo ($useLogo) ? 'checked  ' : ''; ?>
                                                name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoOnly_type"
                                                value="logo"> Logo
                                        </label>
                                    </div>
                                    <div class="conditionalSettings hide">
                                    </div>
                                </div>

                                <div data-id="2" class="optionParent">
                                    <div class="optionRadio">
                                        <label>
                                            <input type="radio" class="conditional"
                                                <?php echo ($useLogo) ? ' ' : 'checked  '; ?>
                                                name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoOnly_type"
                                                value="text"> Text
                                        </label>
                                    </div>
                                    <div class="conditionalSettings hide">
                                    </div>
                                </div>
                            </div>
                            <h4>Select the Logo Alignment</h4>
                            <div class="alignmentOptions flex-row">
                                <label><input type="radio" class=""
                                        <?php echo $logoAlignment == "left" ? "checked  " : ""; ?>
                                        name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoOnly_align"
                                        value="left" /> Left</label>
                                <label><input type="radio" class=""
                                        <?php echo $logoAlignment == "middle" ? "checked " : ""; ?>
                                        name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoOnly_align"
                                        value="middle" /> Middle</label>
                                <label><input type="radio" class=""
                                        <?php echo $logoAlignment == "right" ? "checked " : ""; ?>
                                        name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoOnly_align"
                                        value="right" /> Right</label>
                            </div>
                        </div>
                    </section>
                    <section data-structure='2' class="topNav_optionParent navStructureRow flex-column jc-sb ai-fe">
                        <div class='settingSelect'>
                            <label><input type="radio" name="topNav_<?php esc_attr_e($topNavTabCount); ?>_structure"
                                    <?php echo ($designType == 'logoLeftBurgerRight') ? 'checked ' : 'logoLeftBurgerRight'; ?>
                                    value="logoLeftBurgerRight" /> Logo/Text on the left and hamburger menu icon on the
                                right</label>
                        </div>
                        <div class="settingParent <?php echo $designType == 'logoLeftBurgerRight' ? '' : 'hide' ?>">
                            <div class='settingOption'>
                                <div data-id="1" class="optionParent">
                                    <div class="optionRadio"><label><input type="radio" class="conditional"
                                                <?php echo ($useLogo) ? 'checked ' : ''; ?>name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftBurgerRight_type"
                                                value="logo"> Logo </label></div>
                                    <div class="conditionalSettings hide">
                                    </div>
                                </div>
                                <div data-id="2" class="optionParent">
                                    <div class="optionRadio"><label> <input type="radio"
                                                <?php echo ($useLogo) ? '' : 'checked '; ?> class="conditional"
                                                name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftBurgerRight_type"
                                                value="text"> Text</label></div>
                                    <div class="conditionalSettings hide">
                                    </div>
                                </div>
                                <div data-id='3' class='optionParent flex-column'>
                                    <label>Hamburger Menu background color</label>
                                    <input type="text"
                                        value="<?php echo isset($hamburger_backgroundColor) ? esc_attr($hamburger_backgroundColor) : "rgba(0,0,0,0.85)"; ?>"
                                        data-alpha-enabled="true" data-default-color="rgba(0,0,0,0.85)"
                                        class="color-picker"
                                        name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftBurgerRight_HamburgerMenuBgColor"
                                        _not_required />
                                    <label>Hamburger Menu Font color</label>
                                    <input type="text"
                                        value="<?php echo isset($hamburger_fontColor) ? esc_attr($hamburger_fontColor) : "rgba(0,0,0,0.85)"; ?>"
                                        data-alpha-enabled="true" data-default-color="rgba(0,0,0,0.85)"
                                        class="color-picker"
                                        name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftBurgerRight_HamburgerMenuFontColor"
                                        _not_required />
                                    <label class="inputLabel">Hamburger Menu Icon</label>
                                    <?php
                      $args = array(
                        'inputName' => 'topNav_' . $topNavTabCount . '_logoLeftBurgerRight_HamburgerMenuIcon',
                        'imageUrl' => $hamburger_menuIcon,
                        'uploadText' => 'Select Icon',
                        'changeText' => 'Change Icon'
                      );
                      echo html_entity_decode(esc_html($this->w2a_image_uploadField($args)));
                      ?>
                                    <label class="inputLabel">Hamburger Menu Items</label>
                                    <?php
                      $buttonItemCount = 1;

                      /*
                          $hamburgerMenuItems = isset($config['hamburgerMenuItems']) ? $config['hamburgerMenuItems'] : array("hamburgerMenuItems"=>array(
                                                                                                                                                          "isExternal"=>true,
                                                                                                                                                          'url'=>'',
                                                                                                                                                          'icon'=>'',
                                                                                                                                                          ));
  echo '<pre>';var_dump($config);
  */
                      if (!empty($hamburgerItemsData)) {
                        foreach ($hamburgerItemsData as $hamburgerMenuItem) {
                          $endFlowPageIds = !empty($hamburgerMenuItem['endFlowPageIds']) ? $hamburgerMenuItem['endFlowPageIds'] : null;
                      ?>
                                    <div class="flex-column topNavPageIconItem">
                                        <div class="flex-row bottomBarItemWrapTop">
                                            <div class="bottomBarItemType">
                                                <select onchange="handleHamburgerMenuLinkTypeChange(this)" _not_required
                                                    class="bottomBarItemType"
                                                    name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftBurgerRight_hamburgerNavItemSource[]">
                                                    <option value="page"
                                                        <?php echo $hamburgerMenuItem['isExternal'] ? '' : 'selected'; ?>>
                                                        Page</option>
                                                    <option value="external"
                                                        <?php echo $hamburgerMenuItem['isExternal'] ? 'selected' : ''; ?>>
                                                        External</option>
                                                </select>
                                            </div>
                                            <div class="bottomBarItemUrl flex-column">
                                                <?php
                                $ddClass = $hamburgerMenuItem['isExternal'] ? 'hide' : '';
                                $this->w2a_dropdown_pages(
                                  [
                                    'name' => 'topNav_' . esc_attr($topNavTabCount) . '_logoLeftBurgerRight_hamburgerNavItem_internalURL[]',
                                    'id' => 'topNav_' . esc_attr($topNavTabCount) . '_logoLeftBurgerRight_hamburgerNavItem_internalURL_' . $buttonItemCount,
                                    'class' => $ddClass . ' topNavItemUrlInternal',
                                    'echo' => '1',
                                    'value_field' => 'guid',
                                    'selected' => esc_url($hamburgerMenuItem['url'])
                                  ]
                                ); ?>
                                                <input type="text"
                                                    class="topNavItemUrlExternal <?php echo $hamburgerMenuItem['isExternal'] ? '' : 'hide' ?>"
                                                    name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftBurgerRight_hamburgerNavItem_externalURL[]"
                                                    placeholder="Enter External URL"
                                                    value="<?php echo esc_url($hamburgerMenuItem['url']); ?>" />

                                            </div>
                                            <div class="flex-column">
                                                <input type="text" class="topNavItemLabel"
                                                    name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftBurgerRight_hamburgerNavItem_title[]"
                                                    placeholder="Title"
                                                    value="<?php echo esc_html($hamburgerMenuItem['title']); ?>" />
                                            </div>

                                            <div class="flex-column">
                                                <?php
                                $args = array(
                                  'inputName' => 'topNav_' . $topNavTabCount . '_logoLeftBurgerRight_hamburgerNavItemIcon_' . $buttonItemCount,
                                  'imageUrl' => esc_url($hamburgerMenuItem['icon']),
                                  'uploadText' => 'Upload Icon',
                                  'changeText' => 'Change Icon'
                                );
                                echo html_entity_decode(esc_html($this->w2a_image_uploadField($args)));
                                ?>
                                            </div>

                                        </div>

                                        <div class="endOfJourneyPageSelectionWrap radioInputs">
                                            <fieldset class="flex-column mb10">
                                                <div class="flex-column mb10">
                                                    <h4>Will this page have end of Journey Page?</h4>
                                                    <div class="">
                                                        <input type="radio" class="hasEndJourneyPage"
                                                            name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftBurgerRight_hasEndJourneyPage_<?php esc_attr_e($buttonItemCount); ?>"
                                                            id="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftBurgerRight_hasEndJourneyPageNo_<?php esc_attr_e($buttonItemCount); ?>"
                                                            value="no"
                                                            <?php echo empty($endFlowPageIds) ? 'checked' : '' ?>><label
                                                            for="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftBurgerRight_hasEndJourneyPageNo_<?php esc_attr_e($buttonItemCount); ?>"
                                                            class="inputLabel">No</label>
                                                        <input type="radio" class="hasEndJourneyPage"
                                                            name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftBurgerRight_hasEndJourneyPage_<?php esc_attr_e($buttonItemCount); ?>"
                                                            id="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftBurgerRight_hasEndJourneyPageYes_<?php esc_attr_e($buttonItemCount); ?>"
                                                            value="yes"
                                                            <?php echo empty($endFlowPageIds) ? '' : 'checked' ?>><label
                                                            for="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftBurgerRight_hasEndJourneyPageYes_<?php esc_attr_e($buttonItemCount); ?>"
                                                            class="inputLabel">Yes</label>
                                                    </div>
                                                </div>
                                                <div
                                                    class="endFlowUrl <?php echo empty($endFlowPageIds) ? 'hide' : ''; ?>">
                                                    <h4>Select Page</h4>
                                                    <?php
                                  $pagesDropdownHtml = $this->w2a_dropdown_pages_multiple(
                                    [
                                      'name' => 'topNav_' . esc_attr($topNavTabCount) . '_logoLeftBurgerRight_hamburgerNavItem_' . esc_attr($buttonItemCount) . '_endFlowUrl[]',
                                      'id' => 'topNav_' . esc_attr($topNavTabCount) . '_logoLeftBurgerRight_hamburgerNavItem_' . esc_attr($buttonItemCount) . '_endFlowUrl',
                                      'class' => 'bottomBarEndFlowUrl w2a_multiselect select2',
                                      'echo' => '0',
                                      'value_field' => 'guid',
                                      'selected' => $endFlowPageIds,
                                      'multiselect' => true
                                    ]
                                  );
                                  echo html_entity_decode(esc_html($pagesDropdownHtml));
                                  ?>
                                                </div>
                                            </fieldset>
                                        </div>

                                    </div>
                                    <?php
                          $buttonItemCount++;
                        }
                      } ?>
                                    <?php
                      if ($buttonItemCount > 1) {
                        echo '<span class="button removeNavigationIconRow" onclick="removeTopNavigationIconForHamburger(this);">Remove</span>';
                      }
                      ?>
                                    <div class="addNewNavigationIcon">
                                        <a href="javascript:void(0)" onclick="addTopNavHamburgerItem(this)">Add another
                                            navigation icon</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                    <section data-structure='3' class="topNav_optionParent navStructureRow flex-column jc-sb ai-fe">
                        <div class='settingSelect'>
                            <label><input type="radio" name="topNav_<?php esc_attr_e($topNavTabCount); ?>_structure"
                                    <?php echo ($designType == 'logoLeftNavRight') ? 'checked ' : 'logoLeftNavRight'; ?>
                                    value="logoLeftNavRight" /> Logo/Text on the left and navigation icons on the right
                            </label>
                        </div>
                        <div class="settingParent <?php echo $designType == 'logoLeftNavRight' ? '' : 'hide' ?>">
                            <h3>Logo or text in top bar</h3>
                            <p>Would you like your logo or text displayed in the top bar?</p>
                            <div class='settingOption'>
                                <div data-id="1" class="optionParent">
                                    <div class="optionRadio"><label><input type="radio" class="conditional"
                                                <?php echo $useLogo ? 'checked ' : ''; ?>name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftNavRight_type"
                                                value="logo"> Logo </label></div>
                                    <div class="conditionalSettings hide">
                                    </div>
                                </div>
                                <div data-id="2" class="optionParent">
                                    <div class="optionRadio"><label><input type="radio"
                                                <?php echo ($useLogo) ? '' : 'checked '; ?> class="conditional"
                                                name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftNavRight_type"
                                                value="text"> Text</label></div>
                                    <div class="conditionalSettings hide">
                                    </div>
                                </div>
                            </div>
                            <?php
                  $buttonItemCount = 1;
                  // echo '<pre>';
                  // var_dump($buttonsData);
                  foreach ($buttonsData as $buttonSettings) {
                    // var_dump($buttonSettings);
                    // echo '==================== \n \r\r';
                  ?>
                            <div class="flex-column topNavPageIconItem">
                                <div class="flex-row bottomBarItemWrapTop">
                                    <div class="bottomBarItemType">
                                        <select onchange="handleTopNavLinkTypeChange(this)" _not_required
                                            class="bottomBarItemType"
                                            name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftNavRight_Source[]">
                                            <option value="page"
                                                <?php echo $buttonSettings['isExternal'] ? '' : 'selected'; ?>>Page
                                            </option>
                                            <option value="external"
                                                <?php echo $buttonSettings['isExternal'] ? 'selected' : ''; ?>>External
                                            </option>
                                        </select>
                                    </div>
                                    <div class="bottomBarItemUrl flex-column">
                                        <?php
                          $ddClass = $buttonSettings['isExternal'] ? 'hide' : '';
                          $this->w2a_dropdown_pages(
                            [
                              'name' => 'topNav_' . $topNavTabCount . '_logoLeftNavRight_internalURL[]',
                              'id' => 'topNav_' . $topNavTabCount . '_logoLeftNavRight_internalURL_' . $buttonItemCount,
                              'class' => $ddClass . ' topNavItemUrlInternal',
                              'echo' => '1',
                              'value_field' => 'guid',
                              'selected' => $buttonSettings['url']
                            ]
                          ); ?>
                                        <input type="text"
                                            class="topNavItemUrlExternal <?php echo $buttonSettings['isExternal'] ? '' : 'hide' ?>"
                                            name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoLeftNavRight_externalURL[]"
                                            placeholder="Enter External URL"
                                            value="<?php echo esc_url($buttonSettings['url']); ?>" />
                                    </div>
                                </div>
                                <div class="flex-row flex-start bottomBarItemWrapBottom">
                                    <?php
                        $args = array(
                          'inputName' => 'topNav_' . $topNavTabCount . '_logoLeftNavRight_iconImage_' . $buttonItemCount,
                          'imageUrl' => esc_url($buttonSettings['icon']),
                          'uploadText' => 'Upload Icon',
                          'changeText' => 'Change Icon'
                        );
                        echo html_entity_decode(esc_html($this->w2a_image_uploadField($args))); ?>
                                </div>
                            </div>
                            <?php
                    $buttonItemCount++;
                  }
                  ?>
                            <?php
                  if ($buttonItemCount > 1) {
                    echo '<span class="button removeNavigationIconRow" onclick="removeTopNavigationIconForHamburger(this);">Remove</span>';
                  }
                  ?>

                            <div class="addNewNavigationIcon <?php echo ($buttonItemCount > 3) ? 'hide' : ''; ?>">
                                <a href="javascript:void(0)"
                                    onclick="addTopNavNavigationIcon(this, 'logoLeftNavRight')">Add another navigation
                                    icon</a>
                            </div>
                        </div>
                    </section>

                    <section data-structure='4' class="topNav_optionParent navStructureRow flex-column jc-sb ai-fe">
                        <div class='settingSelect'>
                            <label><input type="radio" name="topNav_<?php esc_attr_e($topNavTabCount); ?>_structure"
                                    <?php echo ($designType == 'logoMidNavBoth') ? 'checked ' : 'logoMidNavBoth'; ?>
                                    value="logoMidNavBoth" /> Logo/Text middle and navigation icons on both left and
                                right </label>
                        </div>
                        <div class="settingParent <?php echo $designType == 'logoMidNavBoth' ? '' : 'hide' ?>">
                            <h3>Logo or text in top bar?</h3>
                            <p>Would you like your logo or text displayed in the top bar?</p>
                            <div class='settingOption'>
                                <div data-id="1" class="optionParent">
                                    <div class="optionRadio"><label><input type="radio" class="conditional"
                                                <?php echo $useLogo ? 'checked ' : ''; ?>
                                                name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoMidNavBoth_type"
                                                value="logo"> Logo </label></div>
                                    <div class="conditionalSettings hide">
                                    </div>
                                </div>
                                <div data-id="2" class="optionParent">
                                    <div class="optionRadio"><label><input type="radio" class="conditional"
                                                <?php echo ($useLogo) ? '' : 'checked '; ?>
                                                name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoMidNavBoth_type"
                                                value="text"> Text</label></div>
                                    <div class="conditionalSettings hide">
                                    </div>
                                </div>
                            </div>


                            <?php
                  $navigationItems = array_merge($leftButtons, $rightButtons);
                  $buttonItemCount = 1;
                  foreach ($navigationItems as $buttonSettings) {

                  ?>

                            <div class="flex-column topNavPageIconItem">
                                <div class="flex-row bottomBarItemWrapTop">
                                    <div class="bottomBarItemType">
                                        <select onchange="handleTopNavLinkTypeChange(this)" _not_required
                                            class="bottomBarItemType"
                                            name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoMidNavBoth_Source[]">
                                            <option value="page"
                                                <?php echo $buttonSettings['isExternal'] ? '' : 'selected'; ?>>Page
                                            </option>
                                            <option value="external"
                                                <?php echo $buttonSettings['isExternal'] ? 'selected' : ''; ?>>External
                                            </option>
                                        </select>
                                    </div>
                                    <div class="bottomBarItemUrl flex-column">
                                        <?php
                          $ddClass = $buttonSettings['isExternal'] ? 'hide' : '';
                          $this->w2a_dropdown_pages(
                            [
                              'name' => 'topNav_' . $topNavTabCount . '_logoMidNavBoth_internalURL[]',
                              'id' => 'topNav_' . $topNavTabCount . '_logoMidNavBoth_internalURL_' . $buttonItemCount,
                              'class' => $ddClass . ' topNavItemUrlInternal',
                              'echo' => '1',
                              'value_field' => 'guid',
                              'selected' => esc_url($buttonSettings['url'])
                            ]
                          ); ?>
                                        <input type="text"
                                            class="topNavItemUrlExternal <?php echo $buttonSettings['isExternal'] ? '' : 'hide' ?>"
                                            name="topNav_<?php esc_attr_e($topNavTabCount); ?>_logoMidNavBoth_externalURL[]"
                                            placeholder="Enter External URL"
                                            value="<?php echo esc_url($buttonSettings['url']); ?>" />
                                    </div>
                                </div>
                                <div class="flex-row flex-start bottomBarItemWrapBottom">
                                    <?php
                        // print_r($buttonSettings);die;
                        $args = array(
                          'inputName' => 'topNav_' . esc_attr($topNavTabCount) . '_logoMidNavBoth_iconImage_' . esc_attr($buttonItemCount),
                          'imageUrl' => isset($buttonSettings['icon']) ? esc_url($buttonSettings['icon']) : '',
                          'uploadText' => 'Upload Icon',
                          'changeText' => 'Change Icon'
                        );
                        echo html_entity_decode(esc_html($this->w2a_image_uploadField($args))); ?>
                                </div>
                            </div>


                            <?php
                    $buttonItemCount++;
                  }


                  ?>


                            <?php
                  if ($buttonItemCount > 1) {
                    echo '<span class="button removeNavigationIconRow" onclick="removeTopNavigationIconForHamburger(this);">Remove</span>';
                  }
                  ?>
                            <div class="addNewNavigationIcon <?php echo ($buttonItemCount > 3) ? 'hide' : ''; ?>">
                                <a href="javascript:void(0)"
                                    onclick="addTopNavNavigationIcon(this, 'logoMidNavBoth')">Add another navigation
                                    icon</a>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
            <?php
          $topNavTabCount++;
        }
      }

      ?>



        </div>
    </div>
</section>
















<style>
.flex-column {}

.bottomBarItemWrapBottom .wpnaImageUploadPreview,
.hamburgerItemWrapBottom .wpnaImageUploadPreview {
    height: 36px;
    width: 36px;
    max-height: 36px;
    max-width: 36px;
    margin-right: 15px;
}

.bottomBarItemWrapBottom .wpnaImageUploadSection,
.hamburgerItemWrapBottom .wpnaImageUploadSection {
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 10px;
}

.bottomBarItemWrapBottom .wpnaImageUploadSection .button,
.hamburgerItemWrapBottom .wpnaImageUploadSection .button {
    padding: 3px 15px;
    color: #CB1818;
    border-color: #CB1818;
}

.hide {
    height: 0;
    width: 0;
    visibility: hidden;
}

.mb10 {
    margin-bottom: 10px;

}

.mt10 {
    margin-top: 10px;
}
</style>
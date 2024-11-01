<?php
$bottomBarNavs =  $config['bottomBarNav']['pages'];
?>
<div class="flex-column">
    <section class="flex=row mb10">
        <div class="flex-item flex-column navigation_bottomBar_section">
            <h1 class=" ">
                Bottom Nav
            </h1>
            <div class="flex-column navigationBottomBarItems">



                <?php
                $bottomNavHtml = '';
                $count = 1;
                // ob_start();
                if (!empty($bottomBarNavs)) {
                    foreach ($bottomBarNavs as $bottomNav) {
                        $isExternal = $bottomNav['isExternal'];
                        $url = esc_url($bottomNav['url']);
                        $icon = isset($bottomNav['icon']) ? esc_url($bottomNav['icon']) : '';
                        $name = esc_html($bottomNav['name']);
                        $selectedPage = ($isExternal) ? 0 : $url;

                        $endFlowPageIds = array();
                        // print_r($bottomNav);die;
                        $endFlowurls = $bottomNav['endFlowUrl'];
                        if (!empty($endFlowurls) && !$isExternal) {
                            foreach ($endFlowurls as $url) {
                                $endFlowPageIds[] = $url;
                            }
                        }
                        $args = array(
                            'inputName' => 'bottomBarNavLogo_' . $count,
                            'imageUrl' => $icon,
                            'uploadText' => 'Upload Background Image',
                            'changeText' => 'Change Background Image'
                        );

                        $pageDDHTML = $this->w2a_image_uploadField($args);
                ?>

                <div class="flex-column navigationBottomBarItem">
                    <div class="endOfJourneyPageSelectionWrap radioInputs">
                        <fieldset class="flex-column mb10">
                            <div class="flex-column mb10">
                                <h4>Will this page have end of Journey Page?</h4>
                                <div class="">
                                    <input type="radio" class="hasEndJourneyPage"
                                        name="bottomBar_<?php echo esc_attr($count); ?>_hasEndJourneyPage"
                                        id="bottomBar_<?php echo esc_attr($count); ?>_hasEndJourneyPageNo" value="no"
                                        <?php echo empty($endFlowPageIds) ? 'checked' : '' ?>><label
                                        for="bottomBar_<?php echo esc_attr($count); ?>_hasEndJourneyPageNo"
                                        class="inputLabel">No</label>
                                    <input type="radio" class="hasEndJourneyPage"
                                        name="bottomBar_<?php echo esc_attr($count); ?>_hasEndJourneyPage"
                                        id="bottomBar_<?php echo esc_attr($count); ?>_hasEndJourneyPageYes" value="yes"
                                        <?php echo empty($endFlowPageIds) ? '' : 'checked' ?>><label
                                        for="bottomBar_<?php echo esc_attr($count); ?>_hasEndJourneyPageYes"
                                        class="inputLabel">Yes</label>
                                </div>
                            </div>


                            <div class="endFlowUrl <?php echo empty($endFlowPageIds) ? 'hide' : '' ?> ">
                                <h4>Select Page</h4>
                                <div class="dropdownWrap">
                                    <?php $pagesDropdownHtml = $this->w2a_dropdown_pages_multiple(
                                                [
                                                    'name' => 'bottomBarEndFlowUrl_' . $count . '[]',
                                                    'id' => 'bottomBarEndFlowUrl_' . $count,
                                                    'class' => 'bottomBarEndFlowUrl w2a_multiselect select2',
                                                    'echo' => '1',
                                                    'value_field' => 'guid',
                                                    'selected' => $endFlowPageIds,
                                                    'multiselect' => true
                                                ]
                                            );
                                            echo html_entity_decode(esc_html($pagesDropdownHtml));

                                            ?>

                                </div>
                            </div>

                        </fieldset>
                    </div>

                    <div class="flex-row bottomBarItemWrapTop">
                        <div class="bottomBarItemType">
                            <select onchange="handleBottomBarLinkTypeChange(this)" required class="bottomBarItemType"
                                name="bottomBarItemType_<?php echo $count; ?>">
                                <option value="page" <?php echo ($isExternal) ? '' : 'selected'; ?>>Page</option>
                                <option value="external" <?php echo ($isExternal) ? 'selected' : ''; ?>>External
                                </option>
                            </select>
                        </div>
                        <div class="bottomBarItemUrl flex-column">
                            <?php
                                    $ddClass = ($isExternal) ? 'hide ' : '';

                                    $this->w2a_dropdown_pages(
                                        [
                                            'name' => 'bottomBarItemUrlInternal_' . $count,
                                            'id' => 'bottomBarItemUrlInternal_' . $count,
                                            'class' => $ddClass . 'bottomBarItemUrlInternal',
                                            'echo' => '1',
                                            'value_field' => 'guid',
                                            'selected' => $selectedPage
                                        ]
                                    ); ?>
                            <input type="text"
                                class="bottomBarItemUrlExternal <?php echo ($isExternal) ? '' : 'hide'; ?>"
                                value="<?php echo esc_url($url); ?>"
                                name="bottomBarItemUrlExternal_<?php echo esc_attr($count); ?>"
                                placeholder="Enter External URL" />
                        </div>
                        <div class="bottomBarItemText">
                            <input type="text" data-itemcount="<?php esc_attr_e($count); ?>"
                                class="bottomBarItemText item_<?php esc_attr_e($count); ?>" name="bottomBarItemText[]"
                                value="<?php echo esc_attr($name); ?>" placeholder="Enter Label"
                                onchange="updateTopNavTabName(this)" />
                        </div>
                    </div>
                    <div class="flex-row flex-start bottomBarItemWrapBottom">
                        <?php echo html_entity_decode(esc_html($pageDDHTML)); ?>
                    </div>
                    <?php
                            if ($count == count($bottomBarNavs) && $count > 3) {
                                echo '<span id="removeBottomBarNavigationIcon" class="button" onclick="removeBottomBarNavigationIcon(this);">Remove</span>';
                            }
                            ?>
                </div>
                <?php
                        $count++;
                    }
                } else {
                    $count = 1;
                    $isExternal = false;
                    $url = '';
                    $icon = '';
                    $name = '';
                    $selectedPage = 0;
                    $pageDDHTML = $this->w2a_image_uploadField("bottomBarItemIcon_" . $count);
                    ?>

                <div class="flex-column navigationBottomBarItem">
                    <div class="flex-row bottomBarItemWrapTop">
                        <div class="bottomBarItemType">
                            <select onchange="handleBottomBarLinkTypeChange(this)" required class="bottomBarItemType"
                                name="bottomBarItemType_<?php echo $count; ?>">
                                <option value="page">Page</option>
                                <option value="external">External</option>
                            </select>
                        </div>
                        <div class="bottomBarItemUrl flex-column">
                            <?php $this->w2a_dropdown_pages(
                                    [
                                        'name' => 'bottomBarItemUrlInternal_' . $count,
                                        'id' => 'bottomBarItemUrlInternal_' . $count,
                                        'class' => 'bottomBarItemUrlInternal',
                                        'echo' => '1',
                                        'value_field' => 'guid',
                                        'selected' => $selectedPage
                                    ]
                                ); ?>
                            <input type="text" class="bottomBarItemUrlExternal hide"
                                value="<?php echo esc_url($url); ?>"
                                name="bottomBarItemUrlExternal_<?php esc_attr_e($count); ?>"
                                placeholder="Enter External URL" />
                        </div>
                        <div class="bottomBarItemText">
                            <input type="text" class="bottomBarItemText" name="bottomBarItemText[]"
                                value="<?php echo esc_attr($name); ?>" placeholder="Enter Label" />
                        </div>
                    </div>
                    <div class="flex-row flex-start bottomBarItemWrapBottom">
                        <?php echo html_entity_decode(esc_html($pageDDHTML)); ?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="addNewNavigationIcon <?php echo ($count > 5) ? "hide" : ""; ?>">
            <a id="addBottomNavigationIcon" href="javascript:void(0)" onclick="addBottomBarNavigationIcon(this)">Add
                another navigation icon</a>
        </div>
    </section>



</div>



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
    display: none;
}

.mb10 {
    margin-bottom: 10px;

}

.mt10 {
    margin-top: 10px;
}
</style>
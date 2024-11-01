<?php 
// Hook to check if the siteURL in the config file matches the current domain
do_action('w2a_validateDomain');

printf('
<div class="notice notice-info is-dismissible">
    <div class="pluginIcon">
        <img class="wpnaNoticeIcon" src="%1$s" />
    </div>
    <div class="bannerContent">
      <h1>Introducing Prompts</h1>
      <p>
          When a new user opens your app for the first time we
          need to prompt them to enable mobile-only services. To
          increase the likelihood that they accept your prompt it’s
          important to tell them what we’re using the services for.
          That’s why we’ve designed these neat prompt cards that you
          can customise with your own text and icon.
      </p>
    </div>
</div>',$defaultLogoURL);

?>
<?php
$defaultLogo = get_theme_mod( 'custom_logo' );
$image = wp_get_attachment_image_src( $defaultLogo , 'thumbnail' );
$defaultLogoURL = $image[0];
$promptSettings = $config['prompts'];
$pushNotification = $promptSettings['promptItems']['pushNotification'];
$trackingService = $promptSettings['promptItems']['trackingService'];
?>
<div class="flex-column propmt-tab-section">
    <section class="prompt_pushNoti flex-row jc-fs">
        <div class="flex-column w60p">
            <div class="leftColumnContent">
                <h3 class="">Propmt for allowing push notification services</h3>
                <p class=" ">
                    Tell your customers what to expect from your push notifications.
                    Will you be providing special deals or timely information? Let them
                    know why you think enabling push notifications is a smart idea for them.
                </p>
                <h4>Prompt background colour</h4>
                <div class="flex-row colorPickerSection">
                    <input
                        type="text"
                        data-alpha-enabled="true"
                        data-default-color="#FFF"
                        class="color-picker"
                        name="promptPushNoti_backgroundColor"
                        id="promptPushNoti_backgroundColor"
                        value="<?php echo esc_attr($pushNotification['styles']['backgroundColor']);?>"
                        _not_required
                    />
                </div>
                <h4>Prompt text colour</h4>
                <div class="flex-row colorPickerSection">
                    <input
                        type="text"
                        data-alpha-enabled="true"
                        data-default-color="#FFF"
                        class="color-picker"
                        name="promptPushNoti_textColor"
                        id="promptPushNoti_textColor"
                        value="<?php echo esc_html($pushNotification['styles']['textColor']);?>"
                        _not_required
                    />
                </div>
                <h4>Prompt icon </h4>
                <div class="flex-row iconPickerSection">
                    <p>Choose an icon</p>
                    <?php
                        $args = array(
                              'inputName'=>'promptPushNoti_icon',
                              'imageUrl'=>esc_url($pushNotification['styles']['icon']),
                              'uploadText'=>'Upload Background Image',
                              'changeText'=>'Change Background Image'
                            );


                            echo html_entity_decode(esc_html($this->w2a_image_uploadField($args)));
                     ?>
                </div>
                <h4>Prompt title text </h4>
                <div class="flex-row propmtTextSections">
                    <input
                        type="text"
                        name="promptPushNoti_titleText"
                        id="promptPushNoti_titleText"
                        value="<?php echo esc_attr($pushNotification['styles']['title']);?>"
                        placeholder="Enable Push Notifications"
                        _not_required
                    />
                </div>
                <h4>Prompt description text </h4>
                <div class="flex-row propmtTextSections">
                    <textarea
                        name="promptPushNoti_descText"
                        id="promptPushNoti_descText"
                        placeholder="We use location services to do this that and the other thing. Please allow location services with the button below."
                        rows="3"
                        value="<?php echo esc_attr($pushNotification['styles']['description']);?>"
                    ><?php echo esc_html($pushNotification['styles']['description']);?></textarea>
                </div>
                <h4>Prompt accept button text </h4>
                <div class="flex-row propmtTextSections">
                    <input
                        type="text"
                        name="promptPushNoti_acceptButtonText"
                        id="promptPushNoti_acceptButtonText"
                        value="<?php echo esc_attr($pushNotification['styles']['acceptButtonText']);?>"
                        placeholder="Enable"
                        _not_required
                    />
                </div>
                <h4>Prompt accept button colour </h4>
                <div class="flex-row colorPickerSection">
                    <input
                        type="text"
                        data-alpha-enabled="true"
                        data-default-color="#FFF"
                        class="color-picker"
                        name="promptPushNoti_acceptButtonColor"
                        id="promptPushNoti_acceptButtonColor"
                        value="<?php echo esc_attr($pushNotification['styles']['acceptButtonColor']);?>"
                        _not_required
                    />
                </div>
            </div>
        </div>
        <div class="flex-column w40p">
            <img src="<?php echo esc_url(plugin_dir_url(__DIR__)).'images/prompts/prompt-1.png';?>" class="promptScreenPreview" />
            <span class="button previewSplash">Preview This Prompt</span>
        </div>
    </section>
    <section class="prompt_tracking flex-row jc-fs">
        <div class="flex-column w60p">
            <div class="leftColumnContent">
                <h3 class="">Propmt for allowing tracking services</h3>
                <p class=" ">
                    Tell your customers that your app will contain tracking services.
                </p>
                <h4>Prompt background colour</h4>
                <div class="flex-row colorPickerSection">
                    <input
                        type="text"
                        data-alpha-enabled="true"
                        data-default-color="#FFF"
                        class="color-picker"
                        name="promptTracking_backgroundColor"
                        id="promptTracking_backgroundColor"
                        value="<?php echo esc_attr($trackingService['styles']['backgroundColor']);?>"
                        _not_required
                    />
                </div>
                <h4>Prompt text colour</h4>
                <div class="flex-row colorPickerSection">
                    <input
                        type="text"
                        data-alpha-enabled="true"
                        data-default-color="#FFF"
                        class="color-picker"
                        name="promptTracking_textColor"
                        id="promptTracking_textColor"
                        value="<?php echo esc_attr($trackingService['styles']['textColor']);?>"
                        _not_required
                    />
                </div>
                <h4>Prompt icon </h4>
                <div class="flex-row iconPickerSection">
                    <p>Choose an icon</p>
                    <?php
                        $args = array(
                              'inputName'=>'promptTracking_icon',
                              'imageUrl'=>esc_url($trackingService['styles']['icon']),
                              'uploadText'=>'Upload Background Image',
                              'changeText'=>'Change Background Image'
                            );


                            echo html_entity_decode(esc_html($this->w2a_image_uploadField($args)));;
                     ?>
                </div>
                <h4>Prompt title text </h4>
                <div class="flex-row propmtTextSections">
                    <input
                        type="text"
                        name="promptTracking_titleText"
                        id="promptTracking_titleText"
                        value="<?php echo esc_attr($trackingService['styles']['title']);?>"
                        placeholder="Enable Push Notifications"
                        _not_required
                    />
                </div>
                <h4>Prompt description text </h4>
                <div class="flex-row propmtTextSections">
                    <textarea
                        name="promptTracking_descText"
                        id="promptTracking_descText"
                        placeholder="We use location services to do this that and the other thing. Please allow location services with the button below."
                        rows="3"
                        value="<?php echo esc_attr($trackingService['styles']['description']);?>"
                    ><?php echo esc_html($trackingService['styles']['description']);?></textarea>
                </div>
                <h4>Prompt accept button text </h4>
                <div class="flex-row propmtTextSections">
                    <input
                        type="text"
                        name="promptTracking_acceptButtonText"
                        id="promptTracking_acceptButtonText"
                        value="<?php echo esc_attr($trackingService['styles']['acceptButtonText']);?>"
                        placeholder="Enable"
                        _not_required
                    />
                </div>
                <h4>Prompt accept button colour </h4>
                <div class="flex-row colorPickerSection">
                    <input
                        type="text"
                        data-alpha-enabled="true"
                        data-default-color="#FFF"
                        class="color-picker"
                        name="promptTracking_acceptButtonColor"
                        id="promptTracking_acceptButtonColor"
                        value="<?php echo esc_attr($trackingService['styles']['acceptButtonColor']);?>"
                        _not_required
                    />
                </div>
                <h3 class="promptHeadingWithin">Prompt for allowing location services</h3>
                <p class=" ">
                    Tell your customers why you need location services.
                    Will giving their location help them use your product more
                    efficiently?  Let them know why you think enabling location
                    services is a smart idea for them.
                </p>
                <div class="flex-row radioInputs">
                    <fieldset>
                        <input type="radio" <?php echo $promptSettings['promptLocationService'] ? 'checked' :'';?> class="" name="promptLocationOn" id="promptLocationOn" value="true" /><label for="promptLocationOn" class="inputLabel">Enabled</label>
                        <input type="radio" <?php echo $promptSettings['promptLocationService'] ? '' :'checked';?> class="" name="promptLocationOn" id="promptLocationOff" value="false" /><label for="promptLocationOff" class="inputLabel">Disabled</label>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="flex-column w40p">
            <img src="<?php echo esc_url(plugin_dir_url(__DIR__)).'images/prompts/prompt-2.png';?>" class="promptScreenPreview" />
            <span class="button previewSplash">Preview This Prompt</span>
        </div>
    </section>
  </div>

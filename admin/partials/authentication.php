<?php
printf('
<div class="notice notice-info is-dismissible">
    <div class="pluginIcon">
        <img class="wpnaNoticeIcon" src="%1$s" />
    </div>
    <div class="bannerContent">
      <h1>How authentication will work in your app</h1>
      <p>Does your website require a user to sign in/sign up to use core functionality?
      If so, this screen will allow you to set your sign in page and choose whether you
      want to force sign in/sign up when they first open your app.
      Requesting sign in/sign up is common practice in app design.
      It may be a good chance to capture your user’s information.</p>
    </div>
</div>', $defaultLogoURL);

?>
<?php
$authentication = $config['authenticationSettings'];
$accountRequired = isset($authentication['accountRequired']) ? $authentication['accountRequired'] : false;
$authenticationPage = isset($authentication['authenticationPage']) ? sanitize_text_field($authentication['authenticationPage']) : '';
?>
<div class="flex-column">
    <section class="flex=row w60p">
        <div class="flex-item flex-column navigation_bottomBar_section">
            <h3 class=" ">
                Choose your sign in/sign up page
            </h3>
            <div class="signin-signup-page-choose">
                <?php $this->w2a_dropdown_pages(
                    [
                        'name' => 'authenticationPage',
                        'id' => 'authenticationPage',
                        'class' => '',
                        'echo' => '1',
                        'value_field' => 'guid',
                        'selected' => esc_url($authenticationPage)
                    ]
                ); ?>
            </div>
            <h3>Is Sign In/Sign Up required on app launch?</h3>
            <p>
                If you require users to sign in or sign up to use core functionality of your site tick the box below and
                all users will be navigated to sign in first before proceeding.
            </p>
            <div class="flex-row radioInputs">
                <fieldset>
                    <input type="radio" class="" name="accountRequired" id="accountRequiredYes" value="yes"
                        <?php echo ($accountRequired) ? 'checked' : ''; ?> required=""><label for="accountRequiredYes"
                        class="inputLabel">Yes</label>
                    <input type="radio" class="" name="accountRequired" id="accountRequiredNo" value="no"
                        <?php echo !($accountRequired)  ? 'checked' : ''; ?>><label for="accountRequiredNo"
                        class="inputLabel">No</label>
                </fieldset>
            </div>
        </div>

    </section>
</div>
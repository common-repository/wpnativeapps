<?php 
// Hook to check if the siteURL in the config file matches the current domain
do_action('w2a_validateDomain');

/* GET STATUS OF THE ACCOUNT */

//TODO: this varialbe should be set in website2app-settings to be passed here
$config = $this->website2AppSettings;

$appId = $config['appId'];
$appSecret = $config['appSecret'];
$url = 'https://api.website2.app/v1/subscription/initialcheck';
$header = array(
  'Website2AppRequestKey: sO4nl&W5sVTpBOQ#Wo07bJGMdJTZ&isi$HTe#j3x',
  "Website2AppId:$appId",
  "Website2AppSecret: $appSecret"
);
$response = wp_remote_get( $url, array('headers'=> $header) );
if(is_wp_error($response)){
  echo "Please contact Plulgin Author: \r\n Error Occurred: ".$response->get_error_message();
  return false;
}
$status = $response['status'];

if($status == false):
?>
<div id="website2AppPublish">
    <div id="publish">
      <div class="flex-column">
          <img class='w2a-logo' src="<?php echo esc_url(plugin_dir_url(__DIR__));?>/images/publish/Website2App-Logo-Landscape.png" />
          <img class='processing-graphic' src="<?php echo esc_url(plugin_dir_url(__DIR__));?>/images/publish/market-launch-bro.jpg" />
          <h2><?php _e('Ready to publish your app to the Google &amp; Apple App Store?', 'website2app');?></h2>
          <p>
            <?php _e('It costs $399USD to have us publish your app. The setup includes time with our design and development team to make sure that your app has a great user experience and is perfectly configured to meet the app store requirements.','website2app');?>
          </p>
          <div class='price-parent'>
              <h1 align=center>$399<span class='currency'>USD</span></h1>
              <a
                id="wpPayNow"
                href='#'
                class='publish-pay'
                data-website2appid="<?php esc_attr_e($appId); ?>"
                data-website2appsecret="<?php esc_attr_e($appSecret); ?>"
                data-returnurl="<?php echo esc_url($_SERVER['HTTP_HOST']) . esc_url($_SERVER['REQUEST_URI']); ?>"
              >
                Pay Now
              </a>
          </div>
      </div>
    </div>
</div>
<?php else: ?>
<div id="website2AppPublish">
  <div id="processing">
    <div class="flex-column">
      <img class='w2a-logo' src="<?php echo esc_url(plugin_dir_url(__DIR__));?>/images/publish/Website2App-Logo-Landscape.png" />
      <img class='processing-graphic' src="<?php echo esc_url(plugin_dir_url(__DIR__));?>/images/publish/Task-bro.jpg" />
      <h2><?php _e('We\'re working on getting your app onto the app stores', 'website2app');?></h2>
      <p>
        <?php _e('We’ll be in touch via email as we make progress. If you have any questions in the meantime please contact us at <a href="mailto:support@website2app.com">support@website2app.com</a>','website2app');?>
      </p>
    </div>
  </div>
</div>
<?php endif; ?>

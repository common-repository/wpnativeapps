<?php
// Hook to check if the siteURL in the config file matches the current domain
do_action('w2a_validateDomain');

$config = $this->website2AppSettings;

$pushNotification = $config['pushNotificationSettings'];
?>
<div class="main" id="pushNotifications">
    <img class='w2a-logo'
        src="<?php echo esc_url(plugin_dir_url(__DIR__)); ?>/images/publish/Website2App-Logo-Landscape.png" />
    <h1 class='page-header'>Push Notifications</h1>
    <div id="w2a_settings_tabs">
        <ul class="tabs">
            <li><a href="#send">Send</a></li>
            <li><a href="#history">History</a></li>
            <li><a href="#subscriptionGroup">Subscription Groups</a></li>
        </ul>

        <div id="send">
            <img src='<?php echo esc_url(plugin_dir_url(__DIR__)); ?>/images/push-note-example.jpg' id='example-push' />
            <div class='send-form-parent'>
                <div class="flex-row">
                    <div class="left flex-column">
                        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                            <?php $add_push_notification_nonce = wp_create_nonce('add_push_notification_submit_nonce'); ?>
                            <input type="hidden" name="action" value="send_push_notification">
                            <input type="hidden" name="add_push_notification_nonce"
                                value="<?php esc_attr_e($add_push_notification_nonce); ?>" />


                            <section>
                                <h1 class='inner-page-header'>Send or schedule a push notification</h1>
                                <h3>Push Notification Title *</h3>
                                <p><span
                                        class="icon-android"></span><?php _e('Android allows 65 characters before text is cut off.', 'website2app'); ?>
                                </p>
                                <p><span
                                        class="icon-ios"></span><?php _e('iOS allows 178 characters before text is cut off.', 'website2app'); ?>
                                </p>
                                <p><?php _e('We suggest using a maximum of 65 characters.', 'website2app'); ?></p>
                                <input type="text" name="pushNotificationTitle"
                                    placeholder="Enter push notification title" required
                                    value="<?php isset($pushNotification["title"]) ? $pushNotification["title"] : '' ?>" />
                            </section>
                            <section>
                                <h3>Push Notification Subtitle </h3>
                                <p><span
                                        class="icon-android"></span><?php _e('Android allows 65 characters before text is cut off.', 'website2app'); ?>
                                </p>
                                <p><span
                                        class="icon-ios"></span><?php _e('iOS allows 178 characters before text is cut off.'); ?>
                                </p>
                                <p><?php _e('We suggest using a maximum of 65 characters.', 'website2app'); ?></p>
                                <input type="text" name="pushNotificationSubtitle"
                                    placeholder="Enter push notification subtitle"
                                    value="<?php isset($pushNotification["subtitle"]) ? $pushNotification["subtitle"] : '' ?>" />
                            </section>
                            <section>
                                <h3>Push Notification Description </h3>
                                <p><span
                                        class="icon-android"></span><?php _e('Android allows 65 characters before text is cut off.', 'website2app'); ?>
                                </p>
                                <p><span
                                        class="icon-ios"></span><?php _e('iOS allows 178 characters before text is cut off.'); ?>
                                </p>
                                <p><?php _e('We suggest using a maximum of 65 characters.', 'website2app'); ?></p>
                                <input type="text" name="pushNotificationDescription"
                                    placeholder="Enter push notification subtitle"
                                    value="<?php isset($pushNotification["description"]) ? $pushNotification["description"] : '' ?>" />
                            </section>
                            <section>
                                <h3>Push Notification Link*</h3>
                                <p><span
                                        class="icon-android"></span><?php _e('What page do you want the push notification to open?', 'website2app'); ?>
                                </p>
                                <?php
                // $selectedPage = isset($pushNotification[''])
                $this->w2a_dropdown_pages(
                  [
                    'name' => 'pushNotification_link',
                    'id' => '',
                    'class' => '',
                    'echo' => '1',
                    'value_field' => 'guid',
                    'selected' => 0
                  ]
                );

                ?>
                            </section>
                            <section>
                                <h3>Push Notification Image</h3>
                                <p><span
                                        class="icon-android"></span><?php _e('Do you want to send an image with your push notification?', 'website2app'); ?>
                                </p>
                                <!-- choose image widget -->
                            </section>
                            <section>
                                <h3>Who would you like to send to?*</h3>
                                <!-- subscription group selector -->
                            </section>
                            <section>
                                <h3>When to send?*</h3>
                                <p><?php _e('When do you want your push notification to send?', 'website2app'); ?></p>
                                <div class='schedule-parent'>
                                    <p><?php _e('Please note that your timezone is set to '); ?><span
                                            id='timezone'>'AEST Sydney/Australia'</span></p>
                                    <!-- date selector -->
                                    <!-- time selector -->
                                </div>
                            </section>
                            <section>
                                <input type="submit" name="submit" id="send-push-button" class="button button-primary"
                                    value="Send Push Notification">
                                <!-- <button id='send-push-button'>Send Push Notification</button> -->
                            </section>
                    </div>
                    <div class="right">

                    </div>
                </div>
            </div>

        </div>
        <div id="history">
        </div>
        <div id="subscriptionGroup">
            <section>
                <div class="notice notice-info is-dismissible">
                    <div class="pluginIcon">
                        <img class="wpnaNoticeIcon"
                            src="<?php echo esc_url(plugin_dir_url(__DIR__)); ?>/images/Website2App-Icon.png" />
                    </div>
                    <div class="bannerContent">
                        <h1>Introducing Subscription Groups</h1>
                        <p>
                            Subscription groups allow you to be more targeted when sending push notifications. Your
                            customers will turn off push notifications if you aren’t reaching out with messages targeted
                            toward them! That’s why we recommend using subscription groups that are relevant to segments
                            of your customer base. Don’t send push notifications to ALL frequently or risk your
                            customers turning off their notifications.
                        </p>
                    </div>
                </div>
            </section>
            <section>
                <div class='flex-row sg-row'>
                    <div class='flex-column sg-create'>
                        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                            <?php $addSubscriptionGroup_nonce = wp_create_nonce('w2a_addSubscriptionGroup_nonce'); ?>
                            <input type="hidden" name="action" value="add_notification_group">
                            <input type="hidden" name="addSubscriptionGroup_nonce"
                                value="<?php esc_attr_e($addSubscriptionGroup_nonce) ?>" />

                            <h2>Create a subscription group</h2>
                            <h3>Subscription Group Name</h3>
                            <input type="text" name="subscriptionGroupName" placeholder="Enter subscription group name"
                                value="" />
                            <h3>Subscription Trigger Page</h3>
                            <?php
              // $selectedPage = isset($pushNotification[''])
              $this->w2a_dropdown_pages(
                [
                  'name' => 'pushNotification_trigger',
                  'id' => '',
                  'class' => '',
                  'echo' => '1',
                  'value_field' => 'guid',
                  'selected' => 0
                ]
              );

              ?>
                            <input type="submit" name="submit" id="send-push-button" class="button button-primary"
                                value="Add new subscription group">
                            <!-- <button id='send-push-button'>Add new subscription group</button> -->
                        </form>
                    </div>
                    <div class='flex-column sg-table'>
                        <h2>Subscription Groups</h2>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script type='text/javascript'>
    var $ = jQuery;
    $(document).ready(function() {
        var key = 'wG3d_kk8VWQjrXogvKtp-J0NGT1im_g-4uT40WMs_v5SgPRXI4RXitlxQRtGi1B04YE';
        
        var auth_token ="";
        
        $.ajax({
            method: 'GET',
            url: 'https://www.universal-tutorial.com/api/getaccesstoken',
            data: {},
            beforeSend: function(request) {
                request.setRequestHeader("Content-Type", "application/json");
                request.setRequestHeader("api-token", key);
                request.setRequestHeader("user-email", "james@hustledigital.com.au");
            },
            dataType: 'json',
            success: function(response) {
                auth_token = response.auth_token;
                
                $.ajax({
                method: 'GET',
                url: 'https://www.universal-tutorial.com/api/countries',
                data: {},
                beforeSend: function(request) {
                    request.setRequestHeader("Content-Type", "application/json");
                    request.setRequestHeader("Authorization", "Bearer " + auth_token);
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    for (var i = 0; i < response.length; i ++) {
                        $("#accountAddressCountry").append($('<option>', {
                            value: response[i].country_name,
                            text: response[i].country_name
                        }));
                    }
                }
                });
                
            }
        });
        
        $("#accountAddressCountry").change(function() {
            var country = $(this).val();
            // console.log(country);
            $.ajax({
                method: 'GET',
                url: 'https://www.universal-tutorial.com/api/states/' + country,
                data: {},
                beforeSend: function(request) {
                    request.setRequestHeader("Content-Type", "application/json");
                    request.setRequestHeader("Authorization", "Bearer " + auth_token);
                },
                dataType: 'json',
                success: function(response) {
                    for (var i = 0; i < response.length; i ++) {
                        $("#addressState").append($('<option>', {
                            value: response[i].state_name,
                            text: response[i].state_name
                        }));
                    }
                }
            });
        });
        
        $("#addressState").change(function() {
            var state = $(this).val();
            // console.log(state);
            $.ajax({
                method: 'GET',
                url: 'https://www.universal-tutorial.com/api/cities/' + state,
                data: {},
                beforeSend: function(request) {
                    request.setRequestHeader("Content-Type", "application/json");
                    request.setRequestHeader("Authorization", "Bearer " + auth_token);
                },
                dataType: 'json',
                success: function(response) {
                    for (var i = 0; i < response.length; i ++) {
                        $("#addressCity").append($('<option>', {
                            value: response[i].city_name,
                            text: response[i].city_name
                        }));
                    }
                }
            });
        });
        
    });
</script>
<div id="website2AppAccount">
  <h1><?php printf('Account');?></h1>
  <ul class="tabs">
    <li>
      <a href="#subscription">Subscription</a>
    </li>
    <li>
      <a href="#billing">Billing</a>
    </li>
    <li>
      <a href="#payments">Payments</a>
    </li>
  </ul>

  <div class="tabContentWrap">
    <div id="subscription">
        <p align='center'>Your subscription</p>
        <h2 align='center' id='price'>$99<span class='currency'>USD</span></h2>
        <p align='center'>per month</p>
        <p align='center'><span class='bill-label'>Next bill date</span>22 Aug 2022</p>
        <p align='center'><span class='bill-label'>Last bill date</span>22 July 2022</p>
        <a align='center' href='mailto:support@website2app.com' class='support-link'>Email us to change your subscription frequency</a>
        <a align='center' href='#' class='cancel-link'>Cancel Subscription</a>
    </div>
    <div id="billing">
      <form method="post" action="">
      <input type="hidden" name="action" value="w2a_save_billing" />
      <input type="hidden" name="w2a_save_billing_nonce" value="<?php wp_create_nonce('w2a_save_billing_nonce');?>">
      <fieldset class="flex-column">
        <label>Account Name</label>
        <input type="text" name="accountName" id="accountName" placeholder="Enter your account name" required  />
      </fieldset>
      <fieldset class="flex-column">
        <label>Account Email</label>
        <input type="text" name="accountEmail" id="accountEmail" placeholder="Enter your Email" required  />
      </fieldset>
      <fieldset class="flex-column">
        <label>Country</label>
        <select id="accountAddressCountry" name="accountAddressCountry" class="form-control">
            <option> -- Select Country -- </option>
          
              </select>
      </fieldset>
      <fieldset class="flex-column">
        <label>Address Line 1</label>
        <input type="text" name="accountAddressLine1" id="accountAddressLine1" placeholder="Enter your Address" required  />
      </fieldset>
      <fieldset class="flex-column">
        <label>Address Line 2</label>
        <input type="text" name="accountAddressLine2" id="accountAddressLine2" placeholder="Unit/Apartment" required  />
      </fieldset>
      <fieldset class="flex-column">
        <label>State</label>
        <select name="addressState" id="addressState" required>
          <option> -- Select State -- </option>
        </select>
      </fieldset>
      <fieldset class="flex-column">
        <label>City</label>
        <select name="addressCity" id="addressCity" required>
          <option> -- Select City -- </option>
        </select>
      </fieldset>

    </form>
    </div>
    <div id="payments">

    </div>
  </div>
</div>

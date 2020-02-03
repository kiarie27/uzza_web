<?php
$appId  = get_settings('content_settings','fb_app_id','none');
$secret = get_settings('content_settings','fb_secret_key','none');
?>
<script type="text/javascript">
function statusChangeCallback(response) {
    if (response.status === 'connected') {
//      console.log("access token: "+response.authResponse.accessToken);
      testAPI(response.authResponse.accessToken);
    } else {

      <?php if(is_loggedin()){ ?>
    //  window.location.replace('<?php echo site_url("account/logout");?>'); 
      <?php }?>
    }
  }

  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?php echo $appId;?>',
      cookie     : true,  // enable cookies to allow the server to access 
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.12' // use graph api version v2.12
    });

    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  function testAPI(accessToken) {

    FB.api('/me?fields=first_name,last_name,email,gender,picture', function(response) {
      response.accessToken = accessToken;
      var loadUrl = '<?php echo site_url("account/fblogin");?>';
      jQuery.post(
          loadUrl,
          response,
          function(responseText){
              if(responseText.error==0)
              {
                <?php if(!is_loggedin()){?>
                window.location.replace(responseText.url);
                <?php }?>
              }
              else
              {
                alert(responseText.msg);
              }

          },
          'JSON'
      );

    });

  }

  function login()
  {
    FB.login(function(response) {
      statusChangeCallback(response);
    }, {scope: 'public_profile,email'});
  }

  function logout()
  {
        FB.logout(function(){
          window.location.replace('<?php echo site_url("account/logout");?>');          
        });
  }
  </script>
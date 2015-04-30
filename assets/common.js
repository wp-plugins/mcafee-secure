//-----------------------------------------------------------------------------------------------------------------
jQuery(document).ready(function() {
   load_page();
});
//-----------------------------------------------------------------------------------------------------------------
function load_page() {
   var host = jQuery('#mcafeesecure').attr('data-host');
   console.log('mfes lookup ' + host);
   jQuery.getJSON('https://www.mcafeesecure.com/rpc/ajax?do=lookup-site-status&jsoncallback=?&rand='+new Date().getTime()+'&host=' + encodeURIComponent(host),function(data) {
      console.log('mfes lookup ' + host + ' is ' + data.status);
      jQuery('#mfes-loading').hide();
      if(data.status == 'secure') {
         jQuery('#mfes-signup').hide();
         jQuery('#mfes-secure').show();
         jQuery('#mfes-notsecure').hide();
         jQuery('#mfes-overlimit').hide();
         jQuery('#mfes-login').show();
         save_active();
      } else if(data.status == 'notsecure') {
         jQuery('#mfes-signup').hide();
         jQuery('#mfes-secure').hide();
         jQuery('#mfes-notsecure').show();
         jQuery('#mfes-overlimit').hide();
         jQuery('#mfes-login').show();
         save_active();
      } else if(data.status == 'overlimit') {
         jQuery('#mfes-signup').hide();
         jQuery('#mfes-secure').hide();
         jQuery('#mfes-notsecure').hide();
         jQuery('#mfes-overlimit').show();
         jQuery('#mfes-login').show();
         save_active();
      } else {
         jQuery('#mfes-signup').show();
         jQuery('#mfes-secure').hide();
         jQuery('#mfes-notsecure').hide();
         jQuery('#mfes-overlimit').hide();
         jQuery('#mfes-login').hide();
         window.setTimeout(function() { load_page() },30000);
      }
   });
}
//-----------------------------------------------------------------------------------------------------------------
function save_active() {
   var url = document.location + '&active=1';
   jQuery.get(url);
}
//-----------------------------------------------------------------------------------------------------------------

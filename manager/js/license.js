$(document).ready(function(){

  $('#license-config').submit(function(){
    if($('#lsid').val()==''){
      alert('Please enter register key!');
      return false;
      close();
    }

    $.post("../php/license_config.php", {
			lsid: $('#lsid').val(),
			regkey: $('#regkey').val()
			},
			function(result){
				if(result=='Y'){
          alert('Create registerkey success success!');
					window.location = 'license.php?id=1';
				}else{
					alert(result);
				}
			}
		);
    return false;
  });

});

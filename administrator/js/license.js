$(document).ready(function(){
  $('#searchBtn').click(function(){
    window.location = 'license.php?key=' + $('#appendedInputButton').val();
  });

  $('#license-profile').submit(function(){
    $.post("../php/add_license.php", {
			license: $('#key1').val() + '-' + $('#key2').val() + '-' + $('#key3').val() + '-' + $('#key4').val(),
			username: $('#username').val(),
      password: $('#password1').val(),
      email: $('#email').val(),
      password2: $('#password2').val()
			},
			function(result){
				if(result=='Y'){
          alert('Create license success!');
					window.location = 'license.php';
				}else{
					alert(result);
				}
			}
		);
    return false;
  });

});

var change_license_status = function(ls_id,todo,page){
  $.post("../php/change_license_status.php", {
    todo: todo,
    page: page,
    ls_id: ls_id
    },
    function(result){
      if(result=='Y'){
        window.location = page + '.php?id=1';
      }else{
        alert(result);
      }
    }
  );
}

var change_license_status_p2 = function(ls_id,todo,page){
  $.post("../php/change_license_status.php", {
    todo: todo,
    page: page,
    ls_id: ls_id
    },
    function(result){
      if(result=='Y'){
        window.location = page + '.php?id=1&ls_id=' + ls_id;
      }else{
        alert(result);
      }
    }
  );
}

var change_user_status = function(username,todo,page){
  $.post("../php/change_user_status.php", {
    todo: todo,
    page: page,
    username: username
    },
    function(result){
      if(result=='Y'){
        window.location = page;
      }else{
        alert(result);
      }
    }
  );
}

var change_user_active_status = function(username,todo,page){
  $.post("../php/change_user_active_status.php", {
    todo: todo,
    page: page,
    username: username
    },
    function(result){
      if(result=='Y'){
        window.location = page;
      }else{
        alert(result);
      }
    }
  );
}

var delete_license = function(ls_id,todo,page){
  if(confirm('Confirm to delete this license?')){
    $.post("../php/delete_license.php", {
      todo: todo,
      page: page,
      ls_id: ls_id
      },
      function(result){
        if(result=='Y'){
          window.location = page;
        }else{
          alert(result);
        }
      }
    );
    // End post
  }
}

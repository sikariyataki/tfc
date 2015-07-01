$(document).ready(function(){
  $('#searchBtn').click(function(){
    window.location = 'user.php?id=2&key=' + $('#appendedInputButton').val();
    return false;
  });

  $('#search-profile').submit(function(){
    window.location = 'user.php?id=2&key=' + $('#appendedInputButton').val();
    return false;
  });

  $('#user-profile').submit(function(){
    $.post("../php/add_user_madmin.php", {
			username: $('#username').val(),
      password: $('#password1').val(),
      email: $('#email').val(),
      accountType: $('#acctype').val(),
      password2: $('#password2').val()
			},
			function(result){
				if(result=='Y'){
          alert('Create user account success!');
					window.location = 'user.php?id=2';
          return false;
				}else{
					alert(result);
				}
			}
		);
    return false;
  });

  $('#update-user-profile').submit(function(){
    $.post("../php/update_user_madmin.php", {
      username: $('#username').val(),
      email: $('#email').val(),
      accountType: $('#acctype').val(),
      firstname: $('#firstname').val(),
      surname: $('#surname').val(),
      phone: $('#phone').val(),
      address: $('#address').val(),
      password2: $('#password2').val()
      },
      function(result){
        if(result=='Y'){
          alert('Update success!');
          window.location = 'user.php?id=2';
          return false;
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
  $.post("../php/change_user_status_m.php", {
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
  $.post("../php/change_user_active_status_m.php", {
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

var update_account = function(username){
  // alert(username);
  window.location = 'edit_account_detail.php?id=2&username=' + username;
}

var delete_account = function(username,returnpage){
  if(confirm('Confirm to delete this useraccount?')){
    $.post("../php/delete_username_m.php", {
      username: username
      },
      function(result){
        if(result=='Y'){
          window.location = returnpage;
        }else{
          alert(result);
        }
      }
    );
  }
}

$(document).ready(function(){
  $('#login').submit(function(){
    if($('#txtUsername').val()=="" || $('#txtPassword').val()==""){
      return false;
    }else{

      $.post("php/checkuser.php", {
        username: $('#txtUsername').val(),
        password: $('#txtPassword').val()
        },
        function(result){
          if(result=='Y'){
            window.location = 'php/authen.php?aut_t=1';
          }else{
            alert(result);
          }
        }
      );
      return false;
    }
  });
});

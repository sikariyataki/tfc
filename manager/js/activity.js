var ddData = [
    {
        text: "รถสามล้อเครื่อง",
        value: "bike3w1.png",
        selected: false,
        description: "เหมาะสำหรับรถสามล้อเครื่อง",
        imageSrc: "../img/bike3w1.png"
    },
    {
        text: "รถบัส",
        value: "bus1.png",
        selected: false,
        description: "เหมาะสำหรับรถบัสขนาดกลาง และขนาดใหญ่",
        imageSrc: "../img/bus1.png"
    },
    {
        text: "รถยนต์นั่ง 4 ล้อ",
        value: "car4w.png",
        selected: false,
        description: "เหมาะสำหรับรถยนต์นั่ง 4 ล้อ, รถสองแถว 6 ล้อ หรือรถโฟว์วิล",
        imageSrc: "../img/car4w.png"
    },
    {
        text: "รถจักรยานยนต์",
        value: "motercycle.png",
        selected: false,
        description: "เหมาะสำหรับรถจักรยานยนต์, จักรยาน",
        imageSrc: "../img/motercycle.png"
    },
    {
        text: "รถปิคอัพ",
        value: "pickup1.png",
        selected: false,
        description: "เหมาะสำหรับรถปิคอัพ หรือรถบรรทุก 4 ล้อ",
        imageSrc: "../img/pickup1.png"
    },
    {
        text: "รถเทรเลอร์ 1",
        value: "trawior2.png",
        selected: false,
        description: "เหมาะสำหรับรถเทรเลอร์หรือรถพ่วง",
        imageSrc: "../img/trawior2.png"
    },
    {
        text: "รถเทรเลอร์ 2",
        value: "trawior3.png",
        selected: false,
        description: "เหมาะสำหรับรถเทรเลอร์หรือรถพ่วง",
        imageSrc: "../img/trawior3.png"
    },
    {
        text: "รถเทรเลอร์ 3",
        value: "trawior.png",
        selected: false,
        description: "เหมาะสำหรับรถเทรเลอร์หรือรถพ่วง",
        imageSrc: "../img/trawior.png"
    },
    {
        text: "รถบรรทุก 6 ล้อ",
        value: "truck6w1.png",
        selected: false,
        description: "เหมาะสำหรับรถบรรทุก 6 ล้อ",
        imageSrc: "../img/truck6w1.png"
    },
    {
        text: "รถตู้ ",
        value: "van1.png",
        selected: false,
        description: "เหมาะสำหรับรถสองแถว 4 ล้อ  ซูบารุ และรถตู้",
        imageSrc: "../img/van1.png"
    }
];

var ddSlikeData = '';

$(document).ready(function(){
  $('#my-select').multiSelect({});
  // $('#my-select2').multiSelect({});
  $('#my-select3').multiSelect({});

  $('#searchBtn').click(function(){
    window.location = 'user.php?id=2&key=' + $('#appendedInputButton').val();
    return false;
  });

  $('#searchBtnAct').click(function(){
    window.location = 'activity.php?id=3&key=' + $('#appendedInputButton').val();
    return false;
  });

  $('#search-profile').submit(function(){
    window.location = 'user.php?id=2&key=' + $('#appendedInputButton').val();
    return false;
  });


  $('#myDropdown').ddslick({
    data: ddData,
    width: 400,
    imagePosition: "left",
    selectText: "Select vehicle group icon",
    onSelected: function (data) {
      ddSlikeData = data.selectedData.value;
    }
  });

  $("#myDropdown").ddslick({width: 100,
        imagePosition: "left",
        selectText: "Select"
  });

  $('#group-vehicle').submit(function(){

    if($('#grouptitle').val()==''){
        alert('Please enter group title!');
        return false;
    }

    var value = [];
    $('#my-select :selected').each(function(i, selected){
        value[i] = $(selected).val();
    });

    if(value.length==0){
      alert('Please choose vehicle!');
      return false;
    }

    if(ddSlikeData == ''){
      alert('Please choose group icon!');
      return false;
    }

    $.post("../php/add_vehicle_group.php", {
        mac_id: $('#act_id2').val(),
        grouptitle: $('#grouptitle').val(),
        icon: ddSlikeData,
        vehicleList: value
  			},
  			function(result){
  				if(result=='Y'){
            alert('Create vehicle group success!');
  					window.location = 'config_activity.php?id=3&mac_id=' + $('#act_id2').val() + '&menu_id=2';
            return false;
  				}else{
  					alert(result);
  				}
  			}
  	);

    return false;
  });

  // Sub activity form submission
  $('#usub-activity').submit(function(){
    if($('#subtitle').val()==''){
      alert('Please enter sub-activity title!');
      close();
      return false;
    }

    if($('#direction').val()==''){
      alert('Please select direction!');
      close();
      return false;
    }

    var value1 =  $('#my-select2').val();

    if(value1==''){
      alert('Please assign counter staff!');
      return false;
    }

    var value2 = [];
    $('#my-select3 :selected').each(function(i, selected){
        value2[i] = $(selected).val();
    });

    if(value2.length==0){
      alert('Please choose vehicle group!');
      return false;
    }

    $.post("../php/add_sub_activity.php", {
      mac_id: $('#act_id').val(),
      subtitle: $('#subtitle').val(),
      position: $('#position').val(),
      other_desc: $('#other_desc').val(),
      direction: $('#direction').val(),
      auditor: $('#auditor').val(),
      counter: value1,
      vehiclegroup: value2

			},
			function(result){
				if(result=='Y'){
          alert('Create sub-activity/work success!');
					window.location = 'config_activity.php?id=3&mac_id=' + $('#act_id').val() + '&menu_id=3';
          return false;
				}else{
					alert(result);
				}
			}
		);
    return false;
  });

  $('#main_activity_add').submit(function(){
    if($('#act_title').val()==''){
      alert("Please enter main activity's title!");
      close();
      return false;
    }

    if($('#coldate').val()=='' || $('#coldate').val()=='0000-00-00'){
      alert('Please enter date of activity.');
      close();
      return false;
    }

    if($('#password2').val()==''){
      alert('Please enter manager password.');
      close();
      return false;
    }

    var startTime = $('#s_h').val() + ":" + $('#s_m').val() + ":00";
    var endTime = $('#e_h').val() + ":" + $('#e_m').val() + ":00";

    var startDate = new Date("1/1/1900 " + startTime);
    var endDate = new Date("1/1/1900 " + endTime);

    if (startDate > endDate){
      alert('Invalid time!');
      close();
      return false;
    }

    $.post("../php/add_main_activity.php", {
      act_title: $('#act_title').val(),
      coldate: $('#coldate').val(),
      startTime: startTime,
      endTime: endTime,
      interval_val: $('#interval_val').val(),
      acType: $('#acType').val(),
      pname: $('#pname').val(),
      descs: $('#desc').val(),
      password2: $('#password2').val()
			},
			function(result){
				if(result=='Y'){
          alert('Save main activity success!');
					window.location = 'activity.php?id=3';
          return false;
				}else{
					alert(result);
				}
			}
		);
    return false;

  });

  $('#main_activity_update').submit(function(){
    if($('#act_title').val()==''){
      alert("Please enter main activity's title!");
      close();
      return false;
    }

    if($('#coldate').val()=='' || $('#coldate').val()=='0000-00-00'){
      alert('Please enter date of activity.');
      close();
      return false;
    }

    if($('#password2').val()==''){
      alert('Please enter manager password.');
      close();
      return false;
    }

    var startTime = $('#s_h').val() + ":" + $('#s_m').val() + ":00";
    var endTime = $('#e_h').val() + ":" + $('#e_m').val() + ":00";

    var startDate = new Date("1/1/1900 " + startTime);
    var endDate = new Date("1/1/1900 " + endTime);

    if (startDate > endDate){
      alert('Invalid time!');
      close();
      return false;
    }

    $.post("../php/update_main_activity.php", {
      mac_id: $('#mac_id').val(),
      act_title: $('#act_title').val(),
      coldate: $('#coldate').val(),
      startTime: startTime,
      endTime: endTime,
      interval_val: $('#interval_val').val(),
      acType: $('#acType').val(),
      pname: $('#pname').val(),
      descs: $('#desc').val(),
      password2: $('#password2').val()
      },
      function(result){
        if(result=='Y'){
          alert('Update main activity success!');
          window.location = 'activity.php?id=3';
          return false;
        }else{
          alert(result);
        }
      }
    );
    return false;

  });

  $('#group-vehicle-update').submit(function(){

    if($('#grouptitle').val()==''){
      alert('Please enter group title!');
      close();
      return false;
    }

    if($('#password3').val()==''){
      alert('Please enter manager password!');
      close();
      return false;
    }

    $.post("../php/update_vehicle_group.php", {
      mac_id: $('#mac_id').val(),
      vg_id: $('#vg_id').val(),
      grouptitle: $('#grouptitle').val(),
      icon: $('input[name="rdio_icon"]:checked').val(),
      password3: $('#password3').val()
			},
			function(result){
				if(result=='Y'){
          alert('Update vehicle group success!');
					window.location = 'config_activity.php?id=3&mac_id=' + $('#act_id2').val();
          return false;
				}else{
					alert(result);
				}
			}
		);
    return false;
  });

  // group-vehicle-config
  $('#group-vehicle-config').submit(function(){
    var checked = [];

    $("input[name='vhc_checkbox[]']:checked").each(function ()
    {
        checked.push(parseInt($(this).val()));
    });

    if(checked.length==0){
      alert('Please select vehicle!');
      return false;
      close();
    }

    $.post("../php/config_vehicle_group.php", {
      vg_id: $('#vg_id').val(),
      vehicle: checked,
      password3: $('#password3').val()
			},
			function(result){
				if(result=='Y'){
          alert('Config vehicle group success!');
					window.location = 'config_activity.php?id=3&mac_id=' + $('#mac_id').val();
          return false;
				}else{
					alert(result);
				}
			}
		);
    return false;
  });

  $('#assignStaff-form').submit(function(){
    var checked = [];

    $("input[name='vhc_checkbox[]']:checked").each(function ()
    {
        checked.push(($(this).val()));
    });

    // alert(checked[0]);
    // return false;
    if(checked.length==0){
      alert('Please select staff!');
      return false;
      close();
    }

    if($('#password3').val()==''){
      alert('Please enter manager password!');
      close();
      return false;
    }

    $.post("../php/assign_staff.php", {
      mac_id: $('#mac_id').val(),
      act_id: $('#act_id').val(),
      staff: checked,
      password3: $('#password3').val()
      },
      function(result){
        if(result=='Y'){
          alert('Assign activity success!');
          window.location = 'config_activity.php?id=3&mac_id=' + $('#mac_id').val();
          return false;
        }else{
          alert(result);
        }
      }
    );
    return false;
  });

  $('#assignVehicle-form').submit(function(){
    var checked = [];

    $("input[name='vhc_checkbox[]']:checked").each(function ()
    {
        checked.push(($(this).val()));
    });

    if(checked.length==0){
      alert('Please select vehicle!');
      return false;
      close();
    }

    if($('#password4').val()==''){
      alert('Please enter manager password!');
      close();
      return false;
    }

    $.post("../php/assign_vehicle.php", {
      username: $('#username').val(),
      act_id: $('#act_id').val(),
      vg_id: checked,
      password4: $('#password4').val()
      },
      function(result){
        if(result=='Y'){
          alert('Assign vehicle success!');
          window.history.back();
          return false;
        }else{
          alert(result);
        }
      }
    );
    return false;
  });



  $('#group-vehicle-shortcut').submit(function(){
    if($('#group_sc').val()==''){
      alert('Please enter group pattern name!');
      close();
      return false;
    }

    $.post("../php/add_group_shortcut.php", {
      mac_id: $('#mac_idc').val(),
      group_sc: $('#group_sc').val()
      },
      function(result){
        if(result=='Y'){
          alert('Config vehicle group success!');
          window.location = 'config_activity.php?id=3&mac_id=' + $('#mac_idc').val();
          return false;
        }else{
          alert(result);
        }
      }
    );
    return false;
  });

  // Sub activity form submission
  $('#usub-activity-update').submit(function(){

    if($('#subtitle').val()==''){
      alert('Please enter sub-activity title!');
      close();
      return false;
    }

    if($('#direction').val()==''){
      alert('Please select direction!');
      close();
      return false;
    }

    if($('#password2').val()==''){
      alert('Please enter manager password!');
      close();
      return false;
    }

    $.post("../php/update_sub_activity.php", {
      mac_id: $('#mac_id').val(),
      act_id: $('#act_id').val(),
      subtitle: $('#subtitle').val(),
      position: $('#position').val(),
      other_desc: $('#other_desc').val(),
      direction: $('#direction').val(),
      password2: $('#password2').val()
			},
			function(result){
				if(result=='Y'){
          alert('Update sub-activity/work success!');
					window.location = 'config_activity.php?id=3&mac_id=' + $('#mac_id').val();
          return false;
				}else{
					alert(result);
				}
			}
		);
    return false;
  });



});

var update_vehicle_group = function(mac_id,vg_id){
  window.location = 'update_vehicle_group.php?id=3&mac_id=' + mac_id +'&vg_id=' + vg_id;
}

var config_main_activity = function(act_id){
  window.location = 'config_activity.php?id=3&mac_id=' + act_id;
}

var update_subactivity = function(mac_id,act_id){
  window.location = 'update_sub_activity.php?id=3&mac_id=' + mac_id +'&act_id=' + act_id;
}

var config_vehicle_group = function(mac_id,vg_id){
  window.location = 'config_vehicle_group.php?id=3&mac_id=' + mac_id +'&vg_id=' + vg_id;
}

var delete_vehicle_group = function(mac_id,vg_id){
  if(confirm('Confirm to delete this vehicle group?')){
    window.location = '../php/delete_vehicle_group.php?mac_id=' + mac_id + '&vg_id=' + vg_id;
  }
}

var delete_main_activity = function(mac_id){
  if(confirm('Confirm to delete this vehicle group?')){
    window.location = '../php/delete_main_activity.php?mac_id=' + mac_id;
  }
}

var view_main_activity = function(mac_id){
  window.location = 'view_activity_counting.php?id=3&mac_id=' + mac_id;
}

var delete_sub_activity = function(mac_id,act_id){
  if(confirm('Confirm to delete this sub-activity/work?')){
    window.location = '../php/delete_sub_activity.php?mac_id=' + mac_id + '&act_id=' + act_id;
  }
}

var update_main_activity = function(mac_id){
  window.location = 'update_activity.php?id=3&mac_id=' + mac_id;
}

var choosePattern_value = function(mac_id){
  window.location = 'choose_pattern.php?id=3&mac_id=' + mac_id;
}

var view_pattern = function(cur_mac_id,pat_mac_id){
  window.location = 'view_pattern.php?id=3&mac_id=' + cur_mac_id + '&pattern_id=' + pat_mac_id;
}

var copy_Pattern = function(cur_mac_id,pat_mac_id){
  window.location = '../php/copy_pattern.php?mac_id=' + cur_mac_id + '&pattern_id=' + pat_mac_id;
}

var config_sub_activity = function(mac_id,sub_id){
  window.location = 'config_sub_activity.php?id=3&mac_id=' + mac_id + '&act_id=' + sub_id;
}

var config_vahicle_activity = function(mac_id,act_id,username){
  window.location = 'config_vahicle_activity.php?id=3&mac_id=' + mac_id + '&act_id=' + act_id + '&username=' + username;
}

var delete_assign_staffs = function(usernames,mac_id,act_id){
  if(confirm('Confirm to delete this assigned staff?')){
    window.location = '../php/delete_assign_staff.php?mac_id=' + mac_id + '&act_id=' + act_id + '&username=' + usernames;
  }
}

var delete_assign_vehicle = function(usernames,vg_id,mac_id,act_id){
  if(confirm("Confirm to delete this assigned vehicle's group?")){
    window.location = '../php/delete_assign_vehicle.php?mac_id=' + mac_id + '&act_id=' + act_id + '&username=' + usernames + '&vg_id=' + vg_id;
  }
}

var filter_view = function(mac_id){
  var interval = $('#interval_val').val();
  var invest = $('#investigator_val').val();
  if(invest!=''){
    window.location = 'view_activity_counting.php?id=3&mac_id=' + mac_id + '&interval=' + interval + '&invest=' + invest;
  }else{
    window.location = 'view_activity_counting.php?id=3&mac_id=' + mac_id + '&interval=' + interval;
  }

}

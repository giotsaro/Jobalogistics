  <!-- END wrapper -->

        <!-- Vendor js
        <script src="assets/js/vendor.min.js"></script> -->

        <!-- Daterangepicker js -->
        <script src="assets/vendor/daterangepicker/moment.min.js"></script>
        <script src="assets/vendor/daterangepicker/daterangepicker.js"></script>
        
        <!-- Apex Charts jsx-->
        <script src="assets/vendor/apexcharts/apexcharts.min.js"></script> 

        <!-- Vector Map js -->
        <script src="assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="assets/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

        <!-- Dashboard App js
        <script src="assets/js/pages/demo.dashboard.js"></script>-->
 
        <!-- App js 
        <script src="assets/js/app.js"></script>-->
<script>

function copyemer(elmt) {

  if (elmt.value!='') {
    navigator.clipboard.writeText(elmt.value);
    $.toast({
    heading: 'Number is copied',
    text: elmt.value,
    position: 'bottom-right',
    stack: false,
    icon:'info'
})
    
  }
  else{
  $.toast({
    heading: 'Number is empty',
    position: 'bottom-right',
    stack: false,
    icon:'error'
})
  }
}
function copyemail(elmt) {

  if (elmt.value!='') {
    navigator.clipboard.writeText(elmt.value);
    $.toast({
    heading: 'Email is copied',
    text: elmt.value,
    position: 'bottom-right',
    stack: false,
    icon:'info'
})
    
  }
  else{
  $.toast({
    heading: 'Email is empty',
    position: 'bottom-right',
    stack: false,
    icon:'error'
})
  }
}

 
$(function () {
             // Add the code in your script section to render the DateTimePicker with cssClass property
             $('#Date').ejDateTimePicker({

            //  dateTimeFormat: "MM/dd/yyyy hh:mm tt",

                 width: 200,
                 cssClass: "gradient-azure-dark"
             });
         });

         
$(function () {
             // Add the code in your script section to render the DateTimePicker with cssClass property
             $('#Dateee').ejDateTimePicker({

             // dateTimeFormat: "MM/dd/yyyy hh:mm tt",
                 width: 200,
                 cssClass: "gradient-azure-dark"
             });
         });
 




$("#setzip1").on("keydown",function (e) {
    if(e.keyCode ==13){      
     if( $(this).val().length==4 ||$(this).val().length==5 ){
              
      setbtn1();
     }
    }
});

$("#radius1").on("keydown",function (e) {
    if(e.keyCode ==13){
        if($("#setzip1").val().length==4||$("#setzip1").val().length ==5)
            {
              setbtn1();
            }
            else{
              
                $.toast({
    heading: 'Zip Code Error',
    text: 'Zip Code length should be 4  or 5 digit number.',
    position: 'mid-center',
    stack: false,
    icon:'error'
})
            }
    }
});



$("#setzip").on("keydown",function (e) {
    if(e.keyCode ==13){      
     if( $(this).val().length==4 ||$(this).val().length==5 ){      
        setbtn();
     }
    }
});

$("#radius").on("keydown",function (e) {
  

    if(e.keyCode ==13){
        if($("#setzip").val().length==4||$("#setzip").val().length ==5)
            {
              setbtn();
            }
            else{
                $.toast({
    heading: 'Zip Code Error',
    text: 'Zip Code length should be 4  or 5 digit number.',
    position: 'mid-center',
    stack: false,
    icon:'error'
})
            }   
    }
});




var a,crad;



function setbtn() {
  a=$("#setzip").val();
  $("#setzip1").val(a);

  if($('#radius').val()!=''){
    crad = $('#radius').val();
     $('#radius1').val(crad);
    } else{
      $('#radius1').val('');
      crad= 50000;
     
    }


  calculate(a,crad);
}
function setbtn1() {
  a=$("#setzip1").val();
  $("#setzip").val(a);

  if($('#radius1').val()!=''){
    crad = $('#radius1').val();
     $('#radius').val(crad);
    } else{
      $('#radius').val('');
      crad= 50000;
    }
  calculate(a,crad);

}




function calculate(a,crad){
 
    
      $('#listbody').empty();
     
    var currentdate = new Date(); 
    var nowTime = 
                 (currentdate.getMonth()+1)  + "/" 
                + currentdate.getDate() + "/"
                + currentdate.getFullYear() + "  "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes();
    $.ajax({
    url: './lib/user.php',
    type: 'post',
    data: {a:a},
    dataType: 'json',
    success: function(response){
         
    if(response=='notfound'){
      
      let text = "Zip Code Not Found  in database! \n Do you want to add this zip code?";



      if (confirm(text) == true) {
          var unexistingzip =  $('#setzip').val();

          if(unexistingzip.length==4||unexistingzip.length==5)
          {
            $('#addzipbtn').prop('disabled',false);
            $('#tosetzip').val(unexistingzip);
          }else{     
          } 
        $('#addzipmodal').modal('show');
      } 
    
    }else{
       
        for (var i=0; i<response.drivers.length; i++) {


          var startTime = response.drivers[i].Date;
           if(startTime>nowTime){
            var b= 'badge-danger-lighten';
          }else{
            var b= 'badge-success-lighten';
          } 


            var row = $('<tr><td>' + response.drivers[i].Units+ '</td><td>'+ response.drivers[i].Name + 
            '</td><td>'+response.drivers[i].Dims +'</td><td>+'+response.drivers[i].Phone + '</td><td>'+response.drivers[i].Location +'</td><td>'+
            response.drivers[i].Zip +'</td><td><h4 class="my-0"><span class="badge  '+b+' "> '+startTime+' </span></h4></td><td >'+response.drivers[i].Comments +'</td><td>'
            +response.drivers[i].Email +'</td><td>'+response.drivers[i].Emergency +'</td><td >'+response.drivers[i].distance+ '</td></tr>');
           if(crad>=response.drivers[i].distance ){
            $('#distancelist').append(row);  
           
        }
        var zip_code =response.searchbyzip[0].zip_code;
          var city =response.searchbyzip[0].city;
          var county =response.searchbyzip[0].county;
          var state_id =response.searchbyzip[0].state_id;
           $('#distancemodaltitle').text('From ' +zip_code+' '  +city+' , '+county+' , '+state_id+' to Drivers');
          // var newzipcode = $('#setzip1').val(zip_code);
           $( "#calculate1" ).prop( "disabled", false );
          // $('#setzip').val(newzipcode.val());
           $('#distancemodal').modal('show');  
        


        }
    }
}
});

      /*   $('#setzip').val('');
        $('#radius').val(''); */
}
 
$(document).on('submit', '#newzip', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("add_zip", true);

            $.ajax({
                type: "POST",
                url: "./lib/user.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                    var res = jQuery.parseJSON(response);
                    if(res.status == 422) {
                      $.toast({
                         position: 'bottom-right',
                        heading: 'Error',
                        text: res.message,
                        showHideTransition: 'slide',
                        icon: 'error'
})

                    }else if(res.status == 200){

                        $('#errorMessage').addClass('d-none');
                        $('#addzipmodal').modal('hide');
                        $('#newzip')[0].reset(); 

                        $.toast({
                         position: 'bottom-right',
                        heading: 'Success',
                        text: res.message,
                        showHideTransition: 'slide',
                        icon: 'success'})



                    }else if(res.status == 500) {

                      $.toast({
                         position: 'bottom-right',
                        heading: 'Error',
                        text: res.message,
                        showHideTransition: 'slide',
                        icon: 'error'
})
    
                    }
                }
            });

        }); 




      




$(document).on('submit', '#newdriver', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_driver", true);

            $.ajax({
                type: "POST",
                url: "./lib/user.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                    var res = jQuery.parseJSON(response);
                    if(res.status == 422) {
                      $.toast({
                         position: 'bottom-right',
                        heading: 'Error',
                        text: res.message,
                        showHideTransition: 'slide',
                        icon: 'error'
})

                    }else if(res.status == 200){

                        $('#errorMessage').addClass('d-none');
                        $('#newdrivermodal').modal('hide');
                        $('#newdriver')[0].reset();

                        $.toast({
                         position: 'bottom-right',
                        heading: 'Success',
                        text: res.message,
                        showHideTransition: 'slide',
                        icon: 'success'})

                        $('#mytable').load(location.href + " #mytable");

                    }else if(res.status == 500) {
                      $.toast({
                         position: 'bottom-right',
                        heading: 'Error',
                        text: res.message,
                        showHideTransition: 'slide',
                        icon: 'error'
})
                    }
                }
            });

        }); 




$(document).on('submit', '#save_upuser', function (ee) {
             ee.preventDefault();
      
            var formData1 = new FormData(this);
            formData1.append("update_user", true);
        
            $.ajax({
                type: "POST",
                url: "./lib/user.php",
                data: formData1,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                    var res = jQuery.parseJSON(response);
                    if(res.status == 422) {
                      $.toast({
                         position: 'bottom-right',
                        heading: 'Error',
                        text: res.message,
                        showHideTransition: 'slide',
                        icon: 'error'
})

                    }else if(res.status == 200){

                        $('#secondmodal').modal('hide');
                        $('#save_upuser')[0].reset();
                        $('#updateusersmodal').modal('show');
                       

                        $('#userlistbody').load(location.href + " #userlistbody");

                        $.toast({
                         position: 'bottom-right',
                        heading: 'Success',
                        text: res.message,
                        showHideTransition: 'slide',
                        icon: 'success'})

                    }else if(res.status == 500) {
                      $.toast({
                         position: 'bottom-right',
                        heading: 'Error',
                        text: res.message,
                        showHideTransition: 'slide',
                        icon: 'error'
})
                    }
                }
            });

        }); /* end user update table */





function openuserlist(){
  $('#updateusersmodal').modal('show');
}

 
 $(document).on('submit', '#up_Driver', function (e) {
            e.preventDefault();

           
            var formData = new FormData(this);
            formData.append("update_driver", true);
            
              
            $.ajax({
                type: "POST",
                url: "./lib/user.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                    var res = jQuery.parseJSON(response);
                    if(res.status == 422) {
                      $.toast({
                         position: 'bottom-right',
                        heading: 'Error',
                        text: res.message,
                        showHideTransition: 'slide',
                        icon: 'error'
})

                    }else if(res.status == 200){

                        $('#errorMessageUpdate').addClass('d-none');

                        alertify.set('notifier','position', 'top-right');
                        alertify.success(res.message);
                        
                        $('#updatedrivermodal').modal('hide');
                        $('#up_Driver')[0].reset();

                        $('#mytable').load(location.href + " #mytable");


                        $.toast({
                         position: 'bottom-right',
                        heading: 'Success',
                        text: res.message,
                        showHideTransition: 'slide',
                        icon: 'success'
})


                    }else if(res.status == 500) {
                      $.toast({
                         position: 'bottom-right',
                        heading: 'Error',
                        text: res.message,
                        showHideTransition: 'slide',
                        icon: 'error'
})
                    }
                }
            });

        });

       



 $(document).on('click', '.updateUserBtn', function () {

var user_id = $(this).val();


   
$.ajax({
    type: "GET",
    url: "./lib/user.php?user_id=" + user_id,
    success: function (response) {

        var res = jQuery.parseJSON(response);
        if(res.status == 404) {

          $.toast({
                         position: 'bottom-right',
                        heading: 'Error',
                        text: res.message,
                        showHideTransition: 'slide',
                        icon: 'error'
})
        }else if(res.status == 200){

            $('#user_id').val(res.data.user_id);
            $('#firstname').val(res.data.firstname);
            $('#lastname').val(res.data.lastname);
            $('#user_phone').val(res.data.user_phone);
            $('#user_email').val(res.data.user_email);
            $('#user_password').val(res.data.user_password);
            $('#user_type').val(res.data.user_type);
            $('#secondmodal').modal('show');
        }

    }
});

});






 $(document).on('click', '.updateDriverBtn', function () {

var driverid = $(this).val();
   
$.ajax({
    type: "GET",
    url: "./lib/user.php?driverid=" + driverid,
    success: function (response) {

        var res = jQuery.parseJSON(response);
        if(res.status == 404) {

          $.toast({
                         position: 'bottom-right',
                        heading: 'Error',
                        text: res.message,
                        showHideTransition: 'slide',
                        icon: 'error'
})
        }else if(res.status == 200){

            $('#driverid').val(res.data.id);
            $('#Units').val(res.data.Units);
            $('#Name').val(res.data.Name);
            $('#Dims').val(res.data.Dims);
            $('#Phone').val(res.data.Phone);
            $('#Location').val(res.data.Location);
            $('#Zip').val(res.data.Zip);
            $('#Date').val(res.data.Date);
            $('#Comments').val(res.data.Comments);
            $('#Email').val(res.data.Email);
            $('#Emergency').val(res.data.Emergency);

            $('#updatedrivermodal').modal('show');
        }

    }
});

});




$(document).on('click', '.deleteDriverBtn', function (e) {
            e.preventDefault();

            if(confirm('Are you sure you want to delete this data?'))
            {
                var driverid = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "./lib/user.php",
                    data: {
                        'delete_driver': true,
                        'driverid': driverid
                    },
                    success: function (response) {

                        var res = jQuery.parseJSON(response);
                        if(res.status == 500) {

                          $.toast({
                         position: 'bottom-right',
                        heading: 'Error',
                        text: res.message,
                        showHideTransition: 'slide',
                        icon: 'error'
})
                        }else{
                          $.toast({
                         position: 'bottom-right',
                        heading: 'Success',
                        text: res.message,
                        showHideTransition: 'slide',
                        icon: 'success'
})

                            $('#mytable').load(location.href + " #mytable");
                        }
                    }
                });
            }
        });



function copy(that){
var inp =document.createElement('input');
document.body.appendChild(inp)
inp.value =that.textContent
inp.select();
document.execCommand('copy',false);
inp.remove();
}

      function byUnit() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("byUnit");
  filter = input.value.toUpperCase();
  table = document.getElementById("mytable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function byName() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("byname");
  filter = input.value.toUpperCase();
  table = document.getElementById("mytable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function byDims() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("byDims");
  filter = input.value.toUpperCase();
  table = document.getElementById("mytable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function byPhone() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("byPhone");
  filter = input.value.toUpperCase();
  table = document.getElementById("mytable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function byLocation() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("byLocation");
  filter = input.value.toUpperCase();
  table = document.getElementById("mytable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[4];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function byZip() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("byZip");
  filter = input.value.toUpperCase();
  table = document.getElementById("mytable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[5];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function byDate() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("byDate");
  filter = input.value.toUpperCase();
  table = document.getElementById("mytable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[6];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function byComment() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("byComment");
  filter = input.value.toUpperCase();
  table = document.getElementById("mytable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[7];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function byEmail() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("byEmail");
  filter = input.value.toUpperCase();
  table = document.getElementById("mytable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[8];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
</div>
    </body>
</html> 
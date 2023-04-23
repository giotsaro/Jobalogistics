<?php
//user file is included here
//include 'backend.php';
include './inc/header.php';
include './lib/user.php';


$user = new user;

session::userSession();

 $i= $_SESSION['user_type'];

/*  if($i==3){
    header("location: index.php");
} elseif ($i==2) {
    header("location: index.php");
} elseif ($i==1) {
    header("location: index.php");
}; */
?>

    <body>

 <!--  second modal -->
 <div class="modal  task-modal-content" id="secondmodal" tabindex="-1" role="dialog" aria-labelledby="secondmodal" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered modal-fullscreen-xxl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="NewTaskModalLabel">Edit Driver Details</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="p-2" id="save_upuser" >

                                 <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>
                                 
                                     <input type="hidden"  class="form-control form-control-light"  name="user_id" id="user_id" >
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                    <label for="firstname" class="form-label">Name</label>
                                        <input type="text" class="form-control form-control-light"  name="firstname" id="firstname"  >
                                
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                    <label for="lastname" class="form-label">Lastname</label>
                                        <input type="text" class="form-control form-control-light"  name="lastname"    id="lastname" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="user_phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control form-control-light" name="user_phone"  id="user_phone" > 
                                            
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="user_email" class="form-label">Email</label>
                                        <input type="text" class="form-control form-control-light" name="user_email" id="user_email" > 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">

                                        <label for="user_password" class="form-label">Password</label>
                                        <input type="text"  class="form-control form-control-light" name='user_password' id="user_password">
                                            
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="user_type" class="form-label">Role</label>
                                        <input type="text" class="form-control form-control-light" name='user_type' id="user_type" >
                                    </div>
                                </div>
                            </div>
                           
                      

                            <div class="text-end">
                            
                                <button type="button" class="btn btn-light"    onclick="openuserlist()"   data-bs-dismiss="modal"     >back</button>
                                <button type="submit"   class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->    
   
    <?php  if($i==2||$i==1){ ?>

        <div class="toast align-items-center text-white bg-primary border-0" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      Hello, world! This is a toast message.
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>

<!--  update Users modal -->
<div class="modal  task-modal-content   " id="updateusersmodal" tabindex="-1" role="dialog" aria-labelledby="updateusersmodal" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable ">
               <div class="modal-content">
                   <div class="modal-header">
                       <h4 class="modal-title" >User List</h4>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                   </div>
                   <div class="modal-body">

                   <div class="col-md-12">
                                           <table id="userlistbody" class="table table-striped table-bordered  table-hover dt-responsive nowrap w-100 dataTable no-footer dtr-inline collapsed" aria-describedby="selection-datatable_info" > 
                                           <thead>
                               <tr>
                                   <th scope="col">Name</th>
                                   <th scope="col">Lastname</th>
                                   <th scope="col">Phone</th>
                                   <th scope="col">Email</th>
                                   <th scope="col">Password</th>
                                   <th scope="col">Role</th>
                                   <th scope="col">Action</th>
                                   
                               </tr>

                               </thead>
                           
                           
                               <tbody >

                               
                               <?php
$userlist = new user;
$result = $userlist->userList();

if($result){
foreach($result as $data){ ?>
<tr>
<td>
   <?=$data['firstname']; ?>
</td>
<td><h4 class="my-0"><span class="badge badge-success-lighten">
   <?=$data['lastname']; ?></span></h4>
</td>
<td>
   <?=$data['user_phone']; ?>
</td>
<td >
       <?=$data['user_email'];?>
</td>

<td >
        <?=$data['user_password']; ?>
</td>
<td >
       <?=$data['user_type']; ?>
</td>
<td >

       <button value="<?=$data['user_id'];?>" class="updateUserBtn btn-sm btn-primary btn ri-edit-box-line" data-bs-dismiss="modal" ></button>
    
      <!-- here must be delete user button -->
</td>
</tr>


<?php }
} ?>                                   
                              </tbody>
                           </table>

                       </div>
                    
                   </div>
               </div>
           </div>
       </div>                          
           <?php } ?>
             <!--  calculated modal -->
             <div class="modal  task-modal-content   " id="distancemodal" tabindex="-1" role="dialog" aria-labelledby="distancemodal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen modal-dialog-scrollable ">
                <div class="modal-content">
                    <div class="modal-header">
                    <div class="row">
                    <span class="badge badge-info-lighten">   <h4 class="modal-title" id="distancemodaltitle">From zip to driver</h4></span>

                       



                        </div>

                        <div class="row justify-content-center" style="margin-left: 10px;">
                                        <div class="col-md-4">
                                        <input id="setzip1" type="text" class="form-control form-control-sm"  minlength="4"   placeholder="Zip Code" 
                                    onkeyup="if(this.value.length ==4||this.value.length ==5) document.getElementById('calculate1').disabled = false;
                                    else document.getElementById('calculate1').disabled = true;" 
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" >
                                        </div>
                                        <div class="col-md-4">
                                            <input  type="text" id="radius1" class="form-control form-control-sm" placeholder="Radius" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" >
                                        </div>
                                        <div class="col-md-4">
                                        <button class="btn btn-primary btn-sm" id="calculate1" type="submit"  disabled   onclick="setbtn1()" >Calculate</button>
                                        </div>
                                    </div>
                       
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                  
                    <div class="modal-body">




                
   

                    <div class="col-md-12">
                                            <table id="distancelist" class="table table-striped table-bordered  table-hover dt-responsive nowrap w-100 dataTable no-footer dtr-inline collapsed" aria-describedby="selection-datatable_info" > 
                                            <thead>
                                <tr>
                                    <th scope="col">Units</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Dims</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Zip</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Comments</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Emergency </th>
                                    <th scope="col">Distance</th>
                                </tr>

                                </thead>
                            
                            
                                <tbody id="listbody">

                                                                          
                                  
                               </tbody>
                            </table>
                        </div>
                     
                    </div>
                </div>
            </div>
        </div> 

                        <!--  add zip  modal -->
            <div class="modal  task-modal-content" id="addzipmodal" tabindex="-1" role="dialog" aria-labelledby="addzipmodal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="NewTaskModalLabel">Add Zip Code</h4>
                        
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="p-2" id="newzip" >
                                 <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>
                                 
                                 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                        <input type="text" class="form-control form-control-light" name='city' placeholder="Buena Park" required >
                                        
                                            
                                       
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                    <label for="county" class="form-label">County</label>
                                        <input type="text" class="form-control form-control-light" name='county' placeholder="Orange" required  >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="state_name" class="form-label">State Name</label>
                                        <input type="text" class="form-control form-control-light" name='state_name' placeholder="California" required >
                                            
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Phone" class="form-label">State ID</label>
                                        <input type="text" class="form-control form-control-light" name='state_id'  placeholder="CA" required >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">                        
                                    <label for="LAT" class="form-label">Latitude</label>                                                        
                                        <input type="text" class="form-control form-control-light" name='LAT'    placeholder="33.84632800" required>
                                        
                                            
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                    <label for="LNG" class="form-label">Longitude</label>
                                        <input type="text" class="form-control form-control-light" name='LNG'   placeholder="-118.01148300" required >
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        
                                    <label for="zip_code" class="form-label">Zip Code</label>
                                        <input type="text"  class="form-control form-control-light" name='zip_code' id="tosetzip" placeholder="90620"   oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0')"   onkeyup="if(this.value.length ==4||this.value.length ==5) document.getElementById('addzipbtn').disabled = false; else document.getElementById('addzipbtn').disabled = true;"  required >
                                       
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        
                                        <a href="https://www.zipdatamaps.com/index.php" target="_blank" > <h4>Lookup Zip Details from  here </h4></a>
                                    </div>
                                </div>
                            </div>
                           

                            <div class="text-end">
                            
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" id="addzipbtn" disabled class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
                        <!--  add new  modal -->
            <div class="modal  task-modal-content" id="newdrivermodal" tabindex="-1" role="dialog" aria-labelledby="NewTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="NewTaskModalLabel">Add Driver</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="p-2" id="newdriver" >
                                 <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>
                                
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                    <label for="Units" class="form-label">Units</label>
                                        <input type="text" class="form-control form-control-light" name='Units'  >
                                        
                                            
                                       
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                    <label for="Name" class="form-label">Name</label>
                                        <input type="text" class="form-control form-control-light" name='Name'required  >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Dims" class="form-label">Dims</label>
                                        <input type="text" class="form-control form-control-light" name='Dims'  >
                                            
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control form-control-light" name='Phone'  required >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Location" class="form-label">Location</label>
                                        <input type="text"  class="form-control form-control-light" name='Location' >
                                            
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Zip" class="form-label">Zip</label>
                                        <input type="text" class="form-control form-control-light" name='Zip'  required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Date" class="form-label">Date</label>
                                        <input type="text" class="form-control form-control-light" name='Date' id="Dateee" >
                                            
                                       
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Comments" class="form-label">Comments</label>
                                        <input type="text" class="form-control form-control-light" name='Comments' >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Email" class="form-label">Email</label>
                                        <input type="text" class="form-control form-control-light" name='Email'  >
                                                     
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Emergency" class="form-label">Emergency Number</label>
                                        <input type="text" class="form-control form-control-light" name='Emergency'  >
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                            
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit"   class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 

                        <!--  update modal -->
        <div class="modal  task-modal-content" id="updatedrivermodal" tabindex="-1" role="dialog" aria-labelledby="NewTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="NewTaskModalLabel">Edit Driver Details</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="p-2" id="up_Driver" >
                                 <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>
                                     <input type="hidden"  class="form-control form-control-light"  name="driverid" id="driverid" >
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                    <label for="Units" class="form-label">Units</label>
                                        <input type="text" class="form-control form-control-light" name='Units' id="Units"  >
                                        
                                            
                                       
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                    <label for="Name" class="form-label">Name</label>
                                        <input type="text" class="form-control form-control-light" name='Name' id="Name" required  >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Dims" class="form-label">Dims</label>
                                        <input type="text" class="form-control form-control-light" name='Dims' id="Dims" >
                                            
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control form-control-light" name='Phone' id="Phone" required >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Location" class="form-label">Location</label>
                                        <input type="text"  class="form-control form-control-light" name='Location' id="Location">
                                            
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Zip" class="form-label">Zip</label>
                                        <input type="text" class="form-control form-control-light" name='Zip' id="Zip" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Date" class="form-label">Date</label>
                                        <input type="text" class="form-control form-control-light" name='Date' id="Date" >
                                            
                                       
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Comments" class="form-label">Comments</label>
                                        <input type="text" class="form-control form-control-light" name='Comments' id="Comments" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Email" class="form-label">Email</label>
                                        <input type="text" class="form-control form-control-light" name='Email' id="Email" >
                                                     
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="Emergency" class="form-label">Emergency Number</label>
                                        <input type="text" class="form-control form-control-light" name='Emergency' id="Emergency" >
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                            
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit"   class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->    
     
        <!-- nav bar -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
   <div class="container-fluid">
   <a class="navbar-brand" href="http://localhost/jobalogistics/index.php">Joba Logistics</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
   <div class="container">
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li><input id="setzip" type="text" class="form-control form-control-sm"  minlength="4"   placeholder="Zip Code" 
           onkeyup="if(this.value.length ==4||this.value.length ==5) document.getElementById('calculate').disabled = false;
            else document.getElementById('calculate').disabled = true;" 
            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" ></li>
          <li><input id="radius" type="text" class="form-control form-control-sm" placeholder="Radius"  oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" ></li>

        <li class="nav-item">
          <button class="btn btn-primary btn-sm" id="calculate" name="calculate" type="submit"  disabled   onclick="setbtn()" >Calculate</button>
        </li>
      </ul>
    <ul>
      <div class="dropdown text-end">
          <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
       <!--   <img src="https://icons8.com/icon/u05i13Fgasru/user" alt="mdo" width="32" height="32" class="rounded-circle"> -->
               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-person-square" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z"/></svg>
          </a>
          <ul class="dropdown-menu  dropdown-menu-end text-small " style="">
     <?php     if($i==2||$i==1){ ?>
        <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#newdrivermodal" >Add Driver</button></li>
   
      
        <?php   } ?>

     <?php  if($i==2||$i==1){ ?>
            <li><button class="dropdown-item"  data-bs-toggle="modal"  data-bs-target="#updateusersmodal" >Users</button></li>

            <?php } ?>

            <?php   if($i==2||$i==1){ ?>
            <li><a class="dropdown-item" data-bs-toggle="modal"  data-bs-target="#addzipmodal">Add Zip Code</a></li>
            <?php } ?>

            <li><hr class="dropdown-divider"></li>


            <?php
$userlogin = session::get("login");
if($userlogin == true){ ?>

            <li><a class="dropdown-item" href="?action=logout">Sign out</a></li><?php

} ?>
          </ul>
        </div>
        </ul>
      </div>
     </div>
   </div>
  </div>
</nav><!-- end nav -->




<main class="content" style="padding-top:50px">

<!-- Start Content-->
<div class="container-fluid">

    <div class="row" >
        <div class="col-12">
            <div class="page-title-box">                                    
                <div class="page-title-right">
                   
                </div>
               
            </div>
                            
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    
                   
                    <div class="tab-content">
                        <div class="tab-pane show active" id="multi-item-preview" role="tabpanel" s>
                            <div id="selection-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                <div class="row" >
                                <div class="col-sm-12">
                                        <label><input type="text" class="form-control form-control-sm" placeholder="Unit" id="byUnit" onkeyup="byUnit()" aria-controls="selection-datatable" size="5"></label>
                                        <label><input type="text" class="form-control form-control-sm" placeholder="Name" id="byname" onkeyup="byName()"aria-controls="selection-datatable" size="9"></label>
                                        <label><input type="text" class="form-control form-control-sm" placeholder="Dims" id="byDims" onkeyup="byDims()"aria-controls="selection-datatable" size="10"></label>
                                        <label><input type="text" class="form-control form-control-sm" placeholder="Phone" id="byPhone" onkeyup="byPhone()"aria-controls="selection-datatable" size="17"></label>
                                        <label><input type="text" class="form-control form-control-sm" placeholder="Location" id="byLocation" onkeyup="byLocation()" aria-controls="selection-datatable" size="17"></label>
                                        <label><input type="text" class="form-control form-control-sm" placeholder="Zip" id="byZip" onkeyup="byZip()"aria-controls="selection-datatable" size="6"></label>
                                        <label><input type="text" class="form-control form-control-sm" placeholder="Date" id="byDate" onkeyup="byDate()" aria-controls="selection-datatable" size="8"></label>
                                        <label><input type="text" class="form-control form-control-sm" placeholder="Comments" id="byComment" onkeyup="byComment()" aria-controls="selection-datatable" size="10"></label>
                                        <label><input type="text" class="form-control form-control-sm" placeholder="Email" id="byEmail" onkeyup="byEmail()" aria-controls="selection-datatable" size="33"></label>
                                     </div>
                                </div>
                                    </div>
                                   
                                    <hr class="">
                                    <div class="d-flex">
                                        <div class="col-md-12">
                                            <table id="mytable" class="table table-striped table-bordered  table-hover dt-responsive nowrap w-100 dataTable no-footer dtr-inline collapsed" aria-describedby="selection-datatable_info" > 
                                            <thead>
                                <tr>
                                    <th scope="col">Units</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Dims</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Zip</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Comments</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Emergency </th>
                                    <th scope="col">Action</th>
                                </tr>

                                </thead>
                            
                            
                                <tbody>
                                <?php
$driversList = new drivers;
$result = $driversList->driversList();

if($result){
foreach($result as $data){ ?>
<tr>
<td>
    <?=$data['Units']; ?>
</td>
<td><h4 class="my-0"><span class="badge badge-success-lighten">
    <?=$data['Name']; ?></span></h4>
</td>
<td>
    <?=$data['Dims']; ?>
</td>
<td >
        <?=$data['Phone'];?>
</td>
<td>
    <?=$data['Location']; ?>
</td>
<td ondblclick="copy(this)">
    <?=$data['Zip']; ?>
</td>
<td><h4 class="my-0"><span class="badge         <?php   


$c = strtotime($data['Date']);  
    //converts seconds into a specific format  
    $newc = date ("mdYhi", $c);             $now = date("mdYhi");
                                        if ($newc > $now) {
                                            echo (" badge-danger-lighten");}else {echo (" badge-success-lighten");}  ?>">
    <?php
     
    $sec = strtotime($data['Date']);  
    //converts seconds into a specific format  
    $newdate = date ("m/d/Y H:i ", $sec);  
    //Appends seconds with the time  
   // $newdatee = $newdate . ":00";
         echo $newdate;
     // echo  $date_now = new DateTime();  success danger
    ?>
</span></h4>
    
</td>
<td>
    <?=$data['Comments']; ?>
</td>

<td>

<button  onClick='copyemail(this)' value="<?=$data['Email'];?>" class="btn-sm btn-primary btn   ri-mail-fill" ></button>
</td>
<td >
<button  onClick='copyemer(this)' value="<?=$data['Emergency'];?>" class="btn-sm btn-primary btn  ri-phone-fill" ></button>
     
</td> 
<td>
         
            <button value="<?=$data['id'];?>" class="updateDriverBtn  btn-sm btn-primary btn ri-edit-box-line" ></button>
            <button value="<?=$data['id'];?>" class="deleteDriverBtn  btn-sm btn-primary btn mdi mdi-delete" ></button>
            
                                                    
</td>
</tr>                                                                           
<?php }
} ?>                                   
                               </tbody>
                            </table>
                        </div>
                    </div>
                   </div>                                          
                        </div> <!-- end preview-->
                    
                    </div> <!-- end tab-content-->
                
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

</div>

<!-- content -->
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>

</main>
       <?php  include './inc/footer.php'; ?>
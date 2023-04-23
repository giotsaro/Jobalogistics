<?php

//sessoin is included for once 
//if it exist it will not work it not then it will load
include_once 'session.php';

//database is included here
include 'db.php';


//all mechanism started from here

class user{
    private $db;

    public function __construct(){
        $this->db = new database;
    }

        
    //user registration mechanism is created here
    public function userRegistration($data){
        $firstname  = $data['firstname'];
        $lastname   = $data['lastname'];
        $phone      = $data['phone'];
        $email      = $data['email'];
        $password   = $data['password'];
        $cpassword  = $data['cpassword'];
        $emailcheck = $this->checkEmail($email);


        
  

        //empty validation of fields
        if($firstname ==  "" OR $lastname ==  "" OR $phone ==  "" OR $email ==  "" OR $password ==  "" OR $cpassword ==  ""){
            $msg = "<div class='alert alert-danger'>* ველები სავალდებულოა!</div>";
            return $msg;

        }
        
        //length validatoin

        //name length validation
        if(strlen($firstname) < 2){
            $msg = "<div class='alert alert-danger'>* სახელი უნდა აღემატებოდეს 1 სიმბოლოს!</div>";
            return $msg;
        }elseif(strlen($firstname) > 50){
            $len = strlen($firstname);
            $msg = "<div class='alert alert-danger'>* აღემატება სიმბოლოს დასაშვებ რაოდენობას </div>";
            return $msg;
          
        }

        //lastname validation
        if(strlen($lastname) < 3){
            $msg = "<div class='alert alert-danger'>* გვარი არ აღემატება  დასაშვებ სიმბოლოს რაოდენობას</div>";
            return $msg;
        }elseif(strlen($lastname) > 50){
            $msg = "<div class='alert alert-danger'>* გვარი აღემატება სიმბოლოს დასაშვებ რაოდენობას</div>";
            return $msg;
        }

        //password and confirm password length validation
        if(strlen($password) < 8 && strlen($cpassword) < 8){
            $msg = "<div class='alert alert-danger'>* პაროლი უნდა აღემატებოდეს 8 სიმბოლოს</div>";
            return $msg;
        }elseif(strlen($password) > 30 && strlen($cpassword) > 30){
            $msg = "<div class='alert alert-danger'>*  პაროლი არ უნდა აღემატებოდეს 15 სიმბოლოს</div>";
            return $msg;
        }

        //passwords equality validation
        if($password != $cpassword){
            $msg = "<div class='alert alert-danger'>* პაროლები არ ემთხვევა</div>";
            return $msg;
        }

        // //email vaidation
        // if(filter_var($phone, FILTER_VALIDATE_PHONE) == false){
        //    $msg = "<div class='alert alert-danger'>* Phone is not valid!</div>";
        //    return $msg;
        //}

        //email vaidation
        if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
            $msg = "<div class='alert alert-danger'>* Email is not valid!</div>";
            return $msg;
        }


        //email existence validation
        if($emailcheck == true){
            $msg = "<div class='alert alert-danger'>* ელ.ფოსტა უკვე რეგისტრირებულია!</div>";
            return $msg;
        }




      
        try {
  
        //insert data if there is no error            
        $query = "INSERT INTO `users`(`firstname`, `lastname`,`user_phone`, `user_email`, `user_password`,`user_type`,`creation_date`) VALUES (:firstname,:lastname, :phone, :email,:password,DEFAULT,DEFAULT)";
        $sql = $this->db->pdo->prepare($query);
        $sql->bindValue(':firstname', $firstname);
        $sql->bindValue(':lastname', $lastname);
        $sql->bindValue(':phone', $phone);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':password', $password);
        $result = $sql->execute();

        if($result){
            $msg = "<div class='alert alert-success'>* ანგარიში წარმატებით შეიქმნა</div>";
            
            header("location: login.php");
            return $msg;
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
     
}




    //email existence check before account registering
    public function checkEmail($email){

        $query = "SELECT * FROM users WHERE `user_email` = :email";
        $sql = $this->db->pdo->prepare($query);
        $sql->bindValue(':email', $email);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }
   
    //phone existence check before account registering
  // public function checkPhone($phone){

  //     $query = "SELECT * FROM users WHERE `user_phone` = :phone";
  //     $sql = $this->db->pdo->prepare($query);
  //     $sql->bindValue(':phone', $phone);
  //     $sql->execute();

  //     if($sql->rowCount() > 0){
  //         return true;
  //     }else{
  //         return false;
  //     }
  // }



    //user login mechanism is created here
    public function userLogin($data){

        $email = $data['email'];
        $password = $data['password'];


    
/* 
        //empty value validation
        if($email == "" OR $password == ""){
            $msg = "<div class='alert alert-danger'>* ველები სავალდებულოა</div>";
            return $msg;
        }
 */

        //length validation

         //email vaidation
       // if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
       //    $msg = "<div class='alert alert-danger'>* Email is not valid!</div>";
       //    return $msg;
       //}

        //password validation
        if(strlen($password) <8 && strlen($password) > 15){
            $msg = "<div class='alert alert-danger'>* Password should be between 8-15 characters</div>";
            return $msg;
        }


        //user will be login if there is no error

        $result = $this->getLoginUserData($email, $password);
        
        if($result){
            session::init();
            session::set("login", true);
            session::set("user_id", $result->user_id);
            session::set("firstname", $result->firstname);
            session::set("lastname", $result->lastname);
            session::set("phone", $result->phone);
            session::set("email", $result->email);
            session::set("user_type", $result->user_type);
            session::set("loginmsg", "<div class='container'><div class='alert alert-success'>შესული ხართ სისტემაში</div></div>");
            header("location: index.php");
        }else{

            $msg = "<div class='alert alert-danger'>*ელ.ფოსტა ან პაროლი არასწორია</div>";
            return $msg;
        }
    }


    
    //user data fetch form database
    public function getLoginUserData($email, $password){

        $query = "SELECT * FROM users WHERE `user_email` = :email AND `user_password` = :password";
        $sql = $this->db->pdo->prepare($query);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':password', $password);



        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }


    //get all data from the database
    public function userList(){
        
        $query = "SELECT * FROM users Where user_type !=1";
        $sql = $this->db->pdo->prepare($query);
        $sql->execute();
        $result = $sql->fetchAll();
        return $result;
    }


    public function customerList(){
        
        $query = "SELECT * FROM users Where user_type='4'";
        $sql = $this->db->pdo->prepare($query);
        $sql->execute();
        $result = $sql->fetchAll();
        return $result;
    }
    public function driverList(){
        
        $query = "SELECT * FROM users Where user_type='3'";
        $sql = $this->db->pdo->prepare($query);
        $sql->execute();
        $result = $sql->fetchAll();
        return $result;
    }

    //get all data from database based on id
    public function userById($user_id){

        $query = "SELECT * FROM users WHERE `user_id` = :id LIMIT 1";
        $sql = $this->db->pdo->prepare($query);
        $sql->bindValue(':id', $user_id);
        $sql->execute();
        $result = $sql->fetchAll();
        return $result;
    }


    //user update mechanism is created here
    public function userUpdate($user_id, $data){

        $firstname  = $data['firstname'];
        $lastname   = $data['lastname'];
        $email      = $data['email'];
        $phone      = $data['phone'];
        $password   = $data['password'];
        $cpassword  = $data['cpassword'];
        $emailcheck = $this->checkupdateEmail($email);


        //empty validation of fields
        if($firstname ==  "" OR $lastname ==  "" OR $email ==  "" OR $password ==  "" OR $cpassword ==  ""){
            $msg = "<div class='alert alert-danger'>* ველები სავალდებულოა!</div>";
            return $msg;
        }

        
        //length validatoin

        //name length validation
        if(strlen($firstname) < 2){
            $msg = "<div class='alert alert-danger'>* სახელი უნდა აღემატებოდეს 1 სიმბოლოს!</div>";
            return $msg;
        }elseif(strlen($firstname) > 50){
            $len = strlen($firstname);
            $msg = "<div class='alert alert-danger'>* აღემატება სიმბოლოს დასაშვებ რაოდენობას $len </div>";
            return $msg;
        }

        //username validation
        if(strlen($lastname) < 3){
            $msg = "<div class='alert alert-danger'>* გვარი არ აღემატება  დასაშვებ სიმბოლოს რაოდენობას</div>";
            return $msg;
        }elseif(strlen($lastname) > 50){
            $msg = "<div class='alert alert-danger'>* გვარი აღემატება სიმბოლოს დასაშვებ რაოდენობას</div>";
            return $msg;
        }

        //password and confirm password length validation
        if(strlen($password) < 8 && strlen($cpassword) < 8){
            $msg = "<div class='alert alert-danger'>* პაროლი უნდა შეიცავდეს მინიმუმ 8 სიმბოლოს</div>";
            return $msg;
        }elseif(strlen($password) > 30 && strlen($cpassword) > 30){
            $msg = "<div class='alert alert-danger'>* პაროლი აღემატება დასაშვებ სიმბოლოს რაოდენობას</div>";
            return $msg;
        }

        //passwords equality validation
        if($password != $cpassword){
            $msg = "<div class='alert alert-danger'>* პაროლები არ ემთხვევა</div>";
            return $msg;
        }


        //phone vaidation
      //  if(strlen($phone) <9){
       //     $msg = "<div class='alert alert-danger'>* phone can not be more than 9 characters</div>";
       //     return $msg;
      //  }elseif(strlen($phone) >12){
        //    $msg = "<div class='alert alert-danger'>* phone can not be more than 12 characters</div>";
        //    return $msg;
       // }


        //email vaidation
        if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
            $msg = "<div class='alert alert-danger'>* Email is not valid!</div>";
            return $msg;
        }


        //email existence validation
        if($emailcheck == true){
            $msg = "<div class='alert alert-danger'>* Email already exist!</div>";
            return $msg;
        }


        
        //insert data if there is no error            
        $query = "UPDATE `users` SET `firstname`=:firstname,`lastname`=:lastname,`user_phone`=:phone,`user_email`=:email,`user_password`=:password WHERE `user_id` = :id";
        $sql = $this->db->pdo->prepare($query);
        $sql->bindValue(':firstname', $firstname);
        $sql->bindValue(':lastname', $lastname);
        $sql->bindValue(':phone', $phone);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':password', $password);
        $sql->bindValue(':id', $user_id);
        $result = $sql->execute();

        if($result){
            $msg = "<div class='alert alert-success'>* მომხმარებელი წარმატებით განახლდა!</div>";
            return $msg;
        }
    }

 //email existence check before account update
 public function checkupdateEmail($email){

    $query = "SELECT * FROM users WHERE `user_email` = :email and ";
    $sql = $this->db->pdo->prepare($query);
    $sql->bindValue(':email', $email);
    $sql->execute();

    if($sql->rowCount() > 0){
        return true;
    }else{
        return false;
    }
}





   //delete user 
   /* public function deleteUser ($user_id){

        $query = "UPDATE * FROM users WHERE `user_id` = :id LIMIT 1 SET ";
        $sql = $this->db->pdo->prepare($query);
        $sql->bindValue(':id', $userid);
        $sql->execute();
        $result = $sql->fetchAll();
        return $result;



    }*/

}

class drivers
{
  private $db;

  public function __construct()
  {
    $this->db = new database;
  }

  public function driversList()
  {
    $query = "SELECT * FROM drivers";
    $sql = $this->db->pdo->prepare($query);
    $sql->execute();
    $result = $sql->fetchAll();
    return $result;
  }



}

if(isset($_POST['a'])){

  //  a= zip code
  $a = mysqli_real_escape_string($con, $_POST['a']);
  $query = "SELECT `id`, `city`, `county`, `state_name`, `state_id`, `zip_code`, `LAT`, `LNG` FROM us_zips_t where `zip_code` ='$a'";
  $query_run = mysqli_query($con, $query);
  $thingsarr=array();
  while ($fetch = mysqli_fetch_assoc($query_run)) {
    $aaaa=$fetch['id'];
    $bbbb=$fetch['city'];
    $cccc= $fetch['county'];
    $dddd= $fetch['state_name'];
    $eeee=$fetch['state_id'];
    $ffff=$fetch['zip_code'];
    $gggg= $fetch['LAT'];
    $hhhh= $fetch['LNG'];
 
    $thingsarr[] = array("id" => $aaaa,"city"=>$bbbb, "county" => $cccc, "state_name" => $dddd,"state_id" => $eeee,"zip_code"=>$ffff, "lt" => $gggg, "lg" => $hhhh);
    }
     $i = count($thingsarr);
    // if zip code do not exists in db
    if($i==0){

        $thingsarr[] = array('notfound');
        echo json_encode ($thingsarr);

    }else{

      $latitudeFrom = $thingsarr[0]['lt'];
      $longitudeFrom=$thingsarr[0]['lg'];
      $earthRadius = 3960;
        $sql = "SELECT drivers.id,drivers.Units,drivers.Name,drivers.Phone,drivers.Dims,drivers.Location,drivers.Zip,drivers.Date,drivers.Comments,drivers.Email,drivers.Emergency,us_zips_t.LAT,us_zips_t.LNG FROM drivers , us_zips_t where LENGTH(Zip)>3 && drivers.Zip = us_zips_t.zip_code ORDER BY `drivers`.`id` ASC";
        $result = mysqli_query($con,$sql);
        $needtocalc= array();
        //add values to array 
    while($fetch = mysqli_fetch_assoc($result)){
      $id = $fetch['id'];
      $Units = $fetch['Units']; 
      $Name = $fetch['Name']; 
      $Phone = $fetch['Phone'];
      $Dims = $fetch['Dims']; 
      $Location = $fetch['Location']; 
      $Zip = $fetch['Zip'];
      $olddate=$fetch['Date'];
      $sec = strtotime($olddate);  
      $Date = date ("m/d/Y H:i", $sec);  
      $Comments = $fetch['Comments'];
      $Email = $fetch['Email']; 
      $Emergency = $fetch['Emergency']; 
      $LAT = $fetch['LAT'];
      $LNG = $fetch['LNG'];
      $needtocalc[] = array( "id"=>$id, "Units"=>$Units, "Name"=>$Name,"Phone"=>$Phone,"Dims"=>$Dims,  "Zip"=>$Zip  ,"Location"=>$Location, "Date"=>$Date,"Comments"=>$Comments,"Email"=>$Email,"Emergency"=>$Emergency,"LAT"=>$LAT,"LNG"=>$LNG);
    }
  
    $j=count($needtocalc);
    $j--;
  
  
    while($j>=0){
      $latitudeTo= $needtocalc[$j]['LAT'];
      $longitudeTo=$needtocalc[$j]['LNG'];
      $latFrom = deg2rad($latitudeFrom);
      $lonFrom = deg2rad($longitudeFrom);
      $latTo = deg2rad($latitudeTo);
      $lonTo = deg2rad($longitudeTo);
      $latDelta = $latTo - $latFrom;
      $lonDelta = $lonTo - $lonFrom;
      $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
      $distance=$angle * $earthRadius;
      $rdistance =round($distance);
      $needtocalc[$j]['distance'] =($rdistance);
      $j--;
    }
    usort($needtocalc, function ($item1, $item2) {
      return $item1['distance'] <=> $item2['distance'];
  });


          $calculated['drivers'] = $needtocalc;
        $calculated['searchbyzip'] = $thingsarr;  


  echo json_encode ($calculated);
  
    }
}

/* $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
$txt = "$Date\n";
fwrite($myfile, $txt);
fclose($myfile);  */


if(isset($_POST['add_zip']))
{
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $county = mysqli_real_escape_string($con, $_POST['county']);
    $state_name = mysqli_real_escape_string($con, $_POST['state_name']);
    $state_id = mysqli_real_escape_string($con, $_POST['state_id']);
    $LAT = mysqli_real_escape_string($con, $_POST['LAT']);
    $LNG = mysqli_real_escape_string($con, $_POST['LNG']);
    $zip_code = mysqli_real_escape_string($con, $_POST['zip_code']);
  

    $query = "INSERT INTO us_zips_t (`id`,`city`,`county`,`state_name`,`state_id`,`zip_code`,`LAT`,`LNG`) VALUES ('','$city','$county','$state_name','$state_id','$zip_code','$LAT','$LNG')";
    
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Zip Code Created Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Zip Not Created'
        ];
        echo json_encode($res);
        
        return;
    }
}



if(isset($_POST['save_driver']))
{
    $Units = mysqli_real_escape_string($con, $_POST['Units']);
    $Name = mysqli_real_escape_string($con, $_POST['Name']);
    $Dims = mysqli_real_escape_string($con, $_POST['Dims']);
    $Phone = mysqli_real_escape_string($con, $_POST['Phone']);
    $Location = mysqli_real_escape_string($con, $_POST['Location']);
    $Zip = mysqli_real_escape_string($con, $_POST['Zip']);
    $Date = mysqli_real_escape_string($con, $_POST['Date']);
    $Comments = mysqli_real_escape_string($con, $_POST['Comments']);
    $Email = mysqli_real_escape_string($con, $_POST['Email']);
    $Emergency = mysqli_real_escape_string($con, $_POST['Emergency']);
    $sec = strtotime($Date);  
    //converts seconds into a specific format  
    $newdate = date ("Y/m/d H:i", $sec);  
    //Appends seconds with the time  
    $newdatee = $newdate . ":00";  

   

    $query = "INSERT INTO drivers (`id`,`Units`,`Name`,`Dims`,`Phone`,`Location`,`Zip`,`Date`,`Comments`,`Email`,`Emergency`) VALUES ('','$Units','$Name','$Dims','$Phone','$Location','$Zip','$newdatee','$Comments','$Email','$Emergency')";
    
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Driver Created Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Driver Not Created'
        ];
        echo json_encode($res);
        
        return;
    }
}


if(isset($_POST['update_driver']))
{
    $driverid = mysqli_real_escape_string($con, $_POST['driverid']);
    $Units = mysqli_real_escape_string($con, $_POST['Units']);
    $Name = mysqli_real_escape_string($con, $_POST['Name']);
    $Dims = mysqli_real_escape_string($con, $_POST['Dims']);
    $Phone = mysqli_real_escape_string($con, $_POST['Phone']);
    $Location = mysqli_real_escape_string($con, $_POST['Location']);
    $Zip = mysqli_real_escape_string($con, $_POST['Zip']);
    $Date = mysqli_real_escape_string($con, $_POST['Date']);
    $Comments = mysqli_real_escape_string($con, $_POST['Comments']);
    $Email = mysqli_real_escape_string($con, $_POST['Email']);
    $Emergency = mysqli_real_escape_string($con, $_POST['Emergency']);

   // $Date = "06/13/2019 5:35 PM";  
    //converts date and time to seconds  
    $sec = strtotime($Date);  
    //converts seconds into a specific format  
    $newdate = date ("Y/m/d H:i", $sec);  
    //Appends seconds with the time  
    $newdatee = $newdate . ":00";  
    // display converted date and time  
    //echo "New date time format is: ".$newDate;  
     


   /*    $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
    $txt = "$newdatee\n";
    fwrite($myfile, $txt);
    fclose($myfile); 
  */


    $query = "UPDATE drivers SET `Units`='$Units',`Name`='$Name', `Dims`='$Dims', `Phone`='$Phone', `Location`='$Location', `Zip`='$Zip', `Date`='$newdate', `Comments`='$Comments' , `Email`='$Email', `Emergency`='$Emergency' 
       WHERE `id`='$driverid'";
    $query_run = mysqli_query($con, $query);
    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'driver Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {

         
        $res = [
            'status' => 500,
            'message' => 'driver Not Updated'
        ];
        echo json_encode($res);
      
        return;
       
    }
}
if(isset($_POST['update_user']))
{
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $user_phone = mysqli_real_escape_string($con, $_POST['user_phone']);
    $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
    $user_password = mysqli_real_escape_string($con, $_POST['user_password']);
    $user_type = mysqli_real_escape_string($con, $_POST['user_type']);
    $query = "UPDATE users SET `firstname`='$firstname',`lastname`='$lastname', `user_phone`='$user_phone', `user_email`='$user_email', `user_password`='$user_password', `user_type`='$user_type' WHERE `user_id`='$user_id'";
    $query_run = mysqli_query($con, $query);
    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'User Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {

         
        $res = [
            'status' => 500,
            'message' => 'User Not Updated'
        ];
        echo json_encode($res);
      
        return;
       
    }
}

if(isset($_GET['driverid']))
{
    $driverid = mysqli_real_escape_string($con, $_GET['driverid']);

    $query = "SELECT * FROM drivers WHERE id='$driverid'";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $driver = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Driver Fetch Successfully by id',
            'data' => $driver
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Driver Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_GET['user_id']))
{
    $user_id = mysqli_real_escape_string($con, $_GET['user_id']);

    $query = "SELECT `user_id`,`firstname`,`lastname`,`user_phone`,`user_email`,`user_password`,`user_type` FROM users WHERE user_id='$user_id'";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $users = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'User Fetch Successfully by id',
            'data' => $users
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'User Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_POST['delete_driver']))
{
    $driverid = mysqli_real_escape_string($con, $_POST['driverid']);

    $query = "DELETE FROM drivers WHERE id='$driverid'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Driver Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Driver Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

?>
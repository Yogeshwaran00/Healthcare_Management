<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Patients</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
        #reportPopup {
        display: none;
    }
    .popup-header {
    text-align: center;
    font-size: 18px;
    margin-bottom: 20px;
}

/* Popup input fields */
.popup-input {
    margin-bottom: 15px;
}

.popup-input input[type="text"],
.popup-input textarea,
.popup-input select,
.popup-input input[type="date"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box;
}

.popup-input textarea {
    resize: vertical;
}

/* Popup submit button */
.popup-input {
    margin-bottom: 15px;
}

.popup-input input[type="text"],
.popup-input textarea,
.popup-input select,
.popup-input input[type="date"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box;
}

.popup-input textarea {
    resize: vertical;
}

/* Popup submit button */
.popup-button {
    text-align: center;
    margin-top: 20px;
}

/* .login-btn {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.login-btn:hover {
    background-color: #0056b3;
} */

.popup .content {
    max-height: 80vh; /* You can adjust this value as needed */
    overflow-y: auto;
}

/* Adjust the width of the scrollbar if necessary */
.popup .content::-webkit-scrollbar {
    width: 8px;
}

.popup .content::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius: 4px;
}

.popup .content::-webkit-scrollbar-track {
    background-color: transparent;
}

/* Remove margin-bottom from the last popup input to prevent unnecessary scrolling */
.popup-input:last-child {
    margin-bottom: 0;
}      
.popup-input input[type="text"] {
        margin-top: 5px; /* Adjust the value as needed */
    }
    .popup-input textarea[type="text"] {
        margin-top: 5px; /* Adjust the value as needed */
    }
    .popup-input .hint {
        font-size: 12px;
        color: red;
       
    }

/* Style for the checkbox group */
.checkbox-group {
    display: flex;
    align-items: center;
    margin-top: 5px;
}

.checkbox-group label {
    margin-right: 10px; /* Adjust this value as needed for your desired spacing */
}

/* Style for the food checkbox row */
.food-checkbox-row {
    display: flex;
    align-items: center;
    margin-top: 5px;
}

.food-checkbox-row label{
    margin-right: 10px;
}


.tablet-row {
    display: flex;
    align-items: center;
    margin-top: 5px;
}


</style>
<head>
    <!-- ... your existing <head> content ... -->

    <script>
        function showReportPopup(patientId) {
            document.getElementById('reportForm').action = 'process_report.php?id=' + patientId;
            document.getElementById('reportPopup').style.display = 'block';
        }
    </script>
</head>

</head>
<body>
    <?php

    //learn from w3schools.com

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    

    //import database
    include("../connection.php");
    $userrow = $database->query("select * from doctor where docemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["docid"];
    $username=$userfetch["docname"];


    //echo $userid;
    //echo $username;
    ?>
    <div class="container">
    <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord" >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Appointments</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">My Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient menu-active menu-icon-patient-active">
                        <a href="patient.php" class="non-style-link-menu  non-style-link-menu-active"><div><p class="menu-text">My Patients</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings   ">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
        <?php       

                    $selecttype="My";
                    $current="My patients Only";
                    if($_POST){

                        if(isset($_POST["search"])){
                            $keyword=$_POST["search12"];
                            
                            $sqlmain= "select * from patient where pemail='$keyword' or pname='$keyword' or pname like '$keyword%' or pname like '%$keyword' or pname like '%$keyword%' ";
                            $selecttype="my";
                        }
                        
                        if(isset($_POST["filter"])){
                            if($_POST["showonly"]=='all'){
                                $sqlmain= "select * from patient";
                                $selecttype="All";
                                $current="All patients";
                            }else{
                                $sqlmain= "select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.docid=$userid;";
                                $selecttype="My";
                                $current="My patients Only";
                            }
                        }
                    }else{
                        $sqlmain= "select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.docid=$userid;";
                        $selecttype="My";
                    }



                ?>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%">

                    <a href="patient.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                        
                    </td>
                    <td>
                        
                        <form action="" method="post" class="header-search">

                        <input type="hidden" name="patientEmail" value="<?php echo $email; ?>">
                            <input type="search" name="search12" class="input-text header-searchbar" placeholder="Search Patient name or Email" list="patient">&nbsp;&nbsp;
                            
                            <?php
                                echo '<datalist id="patient">';
                                $list11 = $database->query($sqlmain);
                               //$list12= $database->query("select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.docid=1;");

                                for ($y=0;$y<$list11->num_rows;$y++){
                                    $row00=$list11->fetch_assoc();
                                    $d=$row00["pname"];
                                    $c=$row00["pemail"];
                                    echo "<option value='$d'><br/>";
                                    echo "<option value='$c'><br/>";
                                };
                                for ($x = 0; $x < $result->num_rows; $x++) {
                                    $row = $result->fetch_assoc();
                                    $pid = $row["pid"];
                                    // ... other patient data ...
                                
                                    echo '<tr>
                                        <!-- ... your existing table row content ... -->
                                        <td>
                                            <div style="display:flex;justify-content: center;">
                                                <button class="btn-primary-soft btn button-icon btn-report report-button"
                                                        style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"
                                                        data-index="' . $x . '">
                                                    <font class="tn-in-text">Report</font>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>';
                                }

                            echo ' </datalist>';
?>
                            
                       
                            <input type="Submit" value="Search" name="search" class="login-btn btn-primary-soft btn " style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                        
                        </form>
                        
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                        date_default_timezone_set('Asia/Kolkata');

                        $date = date('Y-m-d');
                        echo $date;
                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>


                </tr>
               
                
                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)"><?php echo $selecttype." Patients (".$list11->num_rows.")"; ?></p>
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;" >
                        <center>
                        <table class="filter-container" border="0" >
 
                        <form action="" method="post">
                        
                        <td  style="text-align: right;">
                        Show Details About : &nbsp;
                        </td>
                        <td width="30%">
                        <select name="showonly" id="" class="box filter-container-items" style="width:90% ;height: 37px;margin: 0;" >
                                    <option value="" disabled selected hidden><?php echo $current   ?></option><br/>
                                    <option value="my">My Patients Only</option><br/>
                                    <option value="all">All Patients</option><br/>
                                    

                        </select>
                    </td>
                    <td width="12%">
                        <input type="submit"  name="filter" value=" Filter" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
                        </form>
                    </td>

                    </tr>
                            </table>

                        </center>
                    </td>
                    
                </tr>
                  
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown"  style="border-spacing:0;">
                        <thead>
                        <tr>
                                <th class="table-headin">
                                    
                                
                                Name
                                
                                </th>
                                <th class="table-headin">
                                    
                                
                                    gender
                                    
                                </th>
                                <th class="table-headin">
                                
                            
                                Telephone
                                
                                </th>
                                <th class="table-headin">
                                    Email
                                </th>
                                <th class="table-headin">
                                    
                                    Date of Birth
                                    
                                </th>
                                <th class="table-headin">
                                    
                                    Events
                                    
                                </th>
                                <th class="table-headin">
                                    
                                    Report                                    
                                </tr>
                        </thead>
                        <tbody>
                        
                            <?php

                                
                                $result= $database->query($sqlmain);
                                //echo $sqlmain;
                                if($result->num_rows==0){
                                    echo '<tr>
                                    <td colspan="4">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                    <a class="non-style-link" href="patient.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Patients &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                    
                                }
                                else{
                                for ( $x=0; $x<$result->num_rows;$x++){
                                    $row=$result->fetch_assoc();
                                    $pid=$row["pid"];
                                    $name=$row["pname"];
                                    $email=$row["pemail"];
                                    $gender=$row["pgender"];
                                    $dob=$row["pdob"];
                                    $tel=$row["ptel"];
                                    
                                    echo '<tr>
                                        <td> &nbsp;'.
                                        substr($name,0,35)
                                        .'</td>
                                        <td>
                                        '.substr($gender,0,12).'
                                        </td>
                                        <td>
                                            '.substr($tel,0,10).'
                                        </td>
                                        <td>
                                        '.substr($email,0,20).'
                                         </td>
                                        <td>
                                        '.substr($dob,0,10).'
                                        </td>
                                        <td >
                                        <div style="display:flex;justify-content: center;">
                                        
                                        <a href="?action=view&id='.$pid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                                        </div>
                                        </td>
                                        <td>
                                        <input type="hidden" name="patientEmail" value="' . $email . '">
            <div style="display:flex;justify-content: center;">
                <button class="btn-primary-soft btn button-icon btn-report report-button"
                        style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                    <font class="tn-in-text">Report</font>
                </button>
            </div>
                                    </td>
                                    
                                    
                                    </tr>';
                                    
                                }
                            }
                                 
                            ?>
 
                            </tbody>

                        </table>
                        </div>
                        </center>
                   </td> 
                </tr>
                       
                        
                        
            </table>
        </div>
    </div>
    <?php 
    if($_GET){
        
        $id=$_GET["id"];
        $action=$_GET["action"];
            $sqlmain= "select * from patient where pid='$id'";
            $result= $database->query($sqlmain);
            $row=$result->fetch_assoc();
            $name=$row["pname"];
            $email=$row["pemail"];
            $gender=$row["pgender"];
            $dob=$row["pdob"];
            $tele=$row["ptel"];
            $address=$row["paddress"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <a class="close" href="patient.php">&times;</a>
                        <div class="content">

                        </div>
                        <div style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                                </td>
                            </tr>
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Patient ID: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    P-'.$id.'<br><br>
                                </td>
                                
                            </tr>
                            
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$name.'<br><br>
                                </td>
                                
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Email: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$email.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="gender" class="form-label">gender: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$gender.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Telephone: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$tele.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Address: </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                            '.$address.'<br><br>
                            </td>
                            </tr>
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Date of Birth: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$dob.'<br><br>
                                </td>
                                
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="patient.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                
                                    
                                </td>
                
                            </tr>
                           

                        </table>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';
        
    };

?>
</div>
<!-- ... your existing HTML code ... -->

<div id="reportPopup" class="overlay">
    <div class="popup">
        <a class="close" href="patient.php">&times;</a>
        <div class="content">
        <form id="reportForm" action="process_report.php" method="post">
                <div class="popup-header">
                    <p>Enter report details:</p>
                </div>
                <div class="popup-input">
                    <label for="patientName">Patient name:</label>
                    <br><br>
                    <input type="text" name="patientName" placeholder="Patient Name" required>
                    <p class="hint">*Enter correct patient name</p>
                   
                </div>
                <div class="popup-input">
                    <label for="prescription">Prescription:</label>
                    <br>
                    <br>
                    <textarea name="prescription" rows="4" cols="50" placeholder="Prescription" required></textarea>
                </div>
                <div class="popup-input">
                    <div class="checkbox-container">
                        <label for="tabletQuantity">Number of Tablets:</label>
                        <br><br>
                        <select id="tabletQuantity" name="tabletQuantity" onchange="addTabletInputs()">
                            <option value="" disabled selected>Select no of Tablets</option>
                            <!-- Adding options from 1 to 30 -->
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                        <div id="medicationInputs" class="medication-inputs">
                            <!-- Medication input fields will be added here dynamically -->
                        </div>
                    </div>
                </div>
                <div class="popup-input">
                    <label for="revisit">Revisit:</label>
                    <br>
                    <br>
                    <input type="text" name="revisit" placeholder="Revisit" required>
                </div>
                <div class="popup-button">
                <input type="submit" value="Submit" name="search" class="login-btn btn-primary-soft btn">
                <input type="hidden" name="patientEmail" value="<?php echo $email; ?>">
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var reportButtons = document.querySelectorAll('.report-button');

        reportButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var row = button.closest('tr'); // Get the closest parent <tr> element
                var patientId = row.getAttribute('data-pid'); // Get the patient ID from the data-pid attribute
                showReportPopup(patientId);
            });
        });
    });

    function addTabletInputs() {
    const tabletQuantity = document.getElementById("tabletQuantity").value;
    const medicationInputs = document.getElementById("medicationInputs");
    // Clear previous inputs
    medicationInputs.innerHTML = "";

    for (let i = 1; i <= tabletQuantity; i++) {
        const medicationDiv = document.createElement("div");
        medicationDiv.classList.add("medication-row");

        const tabletRow = document.createElement("div");
        tabletRow.classList.add("tablet-row");

        const tabletInput = document.createElement("input");
        tabletInput.type = "text";
        tabletInput.name = `tablet${i}_name`;
        tabletInput.placeholder = `Tablet ${i} Name`;
        tabletInput.required = true;

        const checkboxGroup = document.createElement("div");
        checkboxGroup.classList.add("checkbox-group");

        const morningCheckbox = createCheckbox(`tablet${i}_morning`, `Morning`);
        const afternoonCheckbox = createCheckbox(`tablet${i}_afternoon`, `Afternoon`);
        const nightCheckbox = createCheckbox(`tablet${i}_night`, `Night`);

        checkboxGroup.appendChild(morningCheckbox);
        checkboxGroup.appendChild(afternoonCheckbox);
        checkboxGroup.appendChild(nightCheckbox);

        tabletRow.appendChild(tabletInput);
        tabletRow.appendChild(checkboxGroup);

        medicationDiv.appendChild(tabletRow);

        // Create a new line for "Before Food" and "After Food" checkboxes
        
        const foodCheckboxDiv = document.createElement("div");
        foodCheckboxDiv.classList.add("food-checkbox-row");

        const beforeFoodCheckbox = createCheckbox(`tablet${i}_beforeFood`, `Before Food`);
        const afterFoodCheckbox = createCheckbox(`tablet${i}_afterFood`, `After Food`);

        foodCheckboxDiv.appendChild(beforeFoodCheckbox);
        foodCheckboxDiv.appendChild(afterFoodCheckbox);

        medicationDiv.appendChild(foodCheckboxDiv);

        medicationInputs.appendChild(medicationDiv);
    }
}




        function createCheckbox(name, label) {
            const checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.name = name;
            checkbox.id = name;

            const checkboxLabel = document.createElement("label");
            checkboxLabel.htmlFor = name;
            checkboxLabel.appendChild(document.createTextNode(label));
            checkboxLabel.appendChild(checkbox);

            return checkboxLabel;
        }

</script>


</body>
</html>
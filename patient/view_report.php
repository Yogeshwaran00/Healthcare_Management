<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Sessions</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
    <?php

    //learn from w3schools.com

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    

    //import database
    include("../connection.php");

    $sqlmain= "select * from patient where pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $result = $stmt->get_result();
    $userfetch = $result->fetch_assoc();
    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];


    //echo $userid;
    //echo $username;
    


    date_default_timezone_set('Asia/Kolkata');

    $today = date('Y-m-d');


 //echo $userid;
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
                    <td class="menu-btn menu-icon-home " >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Home</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">All Doctors</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                        <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></a></div>
                    </td>
                </tr>
                <td class="menu-btn menu-icon-report">
        <a href="my_reports.php" class="non-style-link-menu">
            <div><p class="menu-text">My Report</p></div>
        </a>
    </td>
</tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
        
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%" >
                    <a href="schedule.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td >
                            <form action="schedule.php" method="post" class="header-search">

                                        <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Doctor name or Email or Date (YYYY-MM-DD)" list="doctors" >&nbsp;&nbsp;
                                        
                                        <?php
                                            echo '<datalist id="doctors">';
                                            $list11 = $database->query("select DISTINCT * from  doctor;");
                                            $list12 = $database->query("select DISTINCT * from  schedule GROUP BY title;");
                                            

                                            


                                            for ($y=0;$y<$list11->num_rows;$y++){
                                                $row00=$list11->fetch_assoc();
                                                $d=$row00["docname"];
                                               
                                                echo "<option value='$d'><br/>";
                                               
                                            };


                                            for ($y=0;$y<$list12->num_rows;$y++){
                                                $row00=$list12->fetch_assoc();
                                                $d=$row00["title"];
                                               
                                                echo "<option value='$d'><br/>";
                                                                                         };

                                        echo ' </datalist>';
            ?>
                                        
                                
                                        <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                                        </form>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                                
                                echo $today;

                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>


                </tr>

<tr>
    <td colspan="4" style="padding-top:10px;width: 100%;" >
        <!-- <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49);font-weight:400;">Scheduled Sessions / Booking / <b>Review Booking</b></p> -->
    </td>
</tr>

<tr>
    <td colspan="4">
        <center>
            <div class="abc scroll">
                <table width="100%" class="sub-table scrolldown" border="0" style="padding: 50px;border:none">
                    <tbody>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "edoc";

                    $mysqli = new mysqli($servername, $username, $password, $dbname);

                    if ($mysqli->connect_error) {
                        die("Connection failed: " . $mysqli->connect_error);
                    }
                    $patientEmail = $_SESSION["user"];  // Replace with the patient's email

                    $getLastReportIdQuery = "SELECT MAX(report_id) AS last_report_id FROM merged_reports WHERE pemail = ?";
                    $getLastReportIdStmt = $mysqli->prepare($getLastReportIdQuery);
                    $getLastReportIdStmt->bind_param("s", $patientEmail);
                    $getLastReportIdStmt->execute();
                    $getLastReportIdResult = $getLastReportIdStmt->get_result();
                    $lastReportIdRow = $getLastReportIdResult->fetch_assoc();
                    $lastReportId = $lastReportIdRow["last_report_id"];

                    
if (!empty($lastReportId)) {
    $doctorEmailQuery = "SELECT demail FROM merged_reports WHERE report_id = ?";
    $doctorEmailStmt = $mysqli->prepare($doctorEmailQuery);
    $doctorEmailStmt->bind_param("i", $lastReportId);
    $doctorEmailStmt->execute();
    $doctorEmailResult = $doctorEmailStmt->get_result();
    $doctorEmailRow = $doctorEmailResult->fetch_assoc();
    $demail = $doctorEmailRow["demail"];


    $patientDetailsQuery = "SELECT patient_name, prescription_text, revisit FROM merged_reports WHERE report_id = ?";
    $patientStmt = $mysqli->prepare($patientDetailsQuery);
    $patientStmt->bind_param("i", $lastReportId);
    $patientStmt->execute();
    $patientResult = $patientStmt->get_result();
    $patientRow = $patientResult->fetch_assoc();

    $patientName = $patientRow["patient_name"];
    $prescriptionText = $patientRow["prescription_text"];
    $revisitDate = $patientRow["revisit"];

    // Retrieve tablet data from tablets and tablet_details tables
    $tabletsData = [];
    $tabletsQuery = "SELECT t.tablet_name, td.morning, td.afternoon, td.night, td.before_food, td.after_food
                     FROM tablets t
                     INNER JOIN tablet_details td ON t.tablet_id = td.tablet_id
                     WHERE t.report_id = ?";
    $tabletsStmt = $mysqli->prepare($tabletsQuery);
    $tabletsStmt->bind_param("i", $lastReportId);
    $tabletsStmt->execute();
    $tabletsResult = $tabletsStmt->get_result();

    while ($tabletRow = $tabletsResult->fetch_assoc()) {
        $tabletsData[] = $tabletRow;
    }

    // Display the retrieved details
    echo '<tr>
        <td colspan="4">
            <center>
                <div class="abc scroll">
                    <table width="100%" class="sub-table scrolldown" border="0" style="padding: 50px;border:none">
                        <tbody>
                            <td style="width: 50%;" rowspan="2">
                                <div class="dashboard-items search-items">
                                    <div style="width:100%">
                                        <div class="h1-search" style="font-size:25px;">
                                         Your report
                                        </div><br><br>
                                        <div class="h3-search" style="font-size:18px;line-height:30px">
                                            Doctor name:  &nbsp;&nbsp;<b>' . ucfirst(explode("@", $demail)[0]) . '</b><br>
                                            Doctor Email:  &nbsp;&nbsp;<b>' . $demail . '</b> 
                                        </div>
                                        <div class="h3-search" style="font-size:18px;">
                                        </div><br>
                                        <div class="h3-search" style="font-size:18px;">
                                            <!-- Display patient information here -->
                                            <p>Patient Name: ' . htmlspecialchars($patientName) . '</p>
                                            <p>Prescription: ' . htmlspecialchars($prescriptionText) . '</p>
                                            
                                            <!-- Display tablet information here -->
                                            <p>Tablets:</p>
                                            <ul>';
    foreach ($tabletsData as $tabletRow) {
        echo '<li>' . htmlspecialchars($tabletRow["tablet_name"]) . '</li>
                <ul>
                    <li>Morning: ' . ($tabletRow["morning"] ? "Yes" : "No") . '</li>
                    <li>Afternoon: ' . ($tabletRow["afternoon"] ? "Yes" : "No") . '</li>
                    <li>Night: ' . ($tabletRow["night"] ? "Yes" : "No") . '</li>
                    <li>Before Food: ' . ($tabletRow["before_food"] ? "Yes" : "No") . '</li>
                    <li>After Food: ' . ($tabletRow["after_food"] ? "Yes" : "No") . '</li>
                </ul>';
    }
    echo '</ul>
            <p>Revisit Date: ' . htmlspecialchars($revisitDate) . '</p>
            </div>
            <br>
        </div>
    </div>
    <button class="login-btn btn-primary btn" onclick="downloadPDF()">Download PDF</button>
</td>
</tbody>
</table>
</div>
</center>
</td>
</tr>';
} else {
    echo "No report available for this patient.";
}

$mysqli->close();
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
       
    </div>
<script>
    function downloadPDF() {
    // You can pass necessary parameters to the generate_pdf.php file using URL parameters
    var reportId = <?php echo $lastReportId; ?>; // Replace with your logic to get the report ID

    // Redirect to the generate_pdf.php file with the report ID as a parameter
    window.location.href = 'generate_pdf.php?report_id=' + reportId;
}
</script>
</body>
</html>
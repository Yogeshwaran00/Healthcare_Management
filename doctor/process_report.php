<?php
// Replace with your database credentials
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edoc";

$mysli = new mysqli($servername, $username, $password, $dbname);

if ($mysli->connect_error) {
    die("Connection failed: " . $mysli->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $patientName = $_POST["patientName"];
    $prescriptionText = $_POST["prescription"];
    $revisitDate = $_POST["revisit"];
    $doctorEmail = $_SESSION["user"]; // Assuming you have this input in your form
    $patientEmail = $_POST["patientEmail"];

    // Insert into Merged Patients and Prescriptions Table
    $insertReportQuery = "INSERT INTO merged_reports (patient_name, prescription_text, revisit, demail, pemail)
                          VALUES ('$patientName', '$prescriptionText', '$revisitDate', '$doctorEmail', '$patientEmail')";

    if ($mysli->query($insertReportQuery)) {
        $reportId = $mysli->insert_id; // Get the auto-generated report_id

        $tabletQuantity = $_POST["tabletQuantity"];

        for ($i = 1; $i <= $tabletQuantity; $i++) {
            $tabletName = $_POST["tablet{$i}_name"];
            $insertTabletQuery = "INSERT INTO tablets (report_id, tablet_name)
                                  VALUES ($reportId, '$tabletName')";
            $mysli->query($insertTabletQuery);

            $tabletId = $mysli->insert_id; // Get the auto-generated tablet_id

            $morning = isset($_POST["tablet{$i}_morning"]) ? 1 : 0;
            $afternoon = isset($_POST["tablet{$i}_afternoon"]) ? 1 : 0;
            $night = isset($_POST["tablet{$i}_night"]) ? 1 : 0;
            $beforeFood = isset($_POST["tablet{$i}_beforeFood"]) ? 1 : 0;
            $afterFood = isset($_POST["tablet{$i}_afterFood"]) ? 1 : 0;

            $insertTabletDetailsQuery = "INSERT INTO tablet_details (tablet_id, morning, afternoon, night, before_food, after_food)
                                        VALUES ($tabletId, $morning, $afternoon, $night, $beforeFood, $afterFood)";
            $mysli->query($insertTabletDetailsQuery);
        }

        echo "Data inserted successfully!";
    } else {
        echo "Error inserting data: " . $mysli->error;
    }
}

$mysli->close();
?>

<?php
require_once('../tcpdf/tcpdf.php'); // Adjust the path based on your project structure

// Retrieve the report ID from the URL parameter
$reportId = isset($_GET['report_id']) ? intval($_GET['report_id']) : 0;

// Ensure the report ID is valid
if ($reportId > 0) {
    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "edoc";

    $mysqli = new mysqli($servername, $username, $password, $dbname);

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Fetch report data from the database based on the report ID
    $query = "SELECT * FROM merged_reports WHERE report_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $reportId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $demail = $row['demail'];
        $patientName = $row['patient_name'];
        $prescriptionText = $row['prescription_text'];

        // Fetch tablet data
        $tabletsData = [];
        $tabletsQuery = "SELECT tablet_name, morning, afternoon, night, before_food, after_food 
                         FROM tablets 
                         INNER JOIN tablet_details ON tablets.tablet_id = tablet_details.tablet_id
                         WHERE report_id = ?";
        $tabletsStmt = $mysqli->prepare($tabletsQuery);
        $tabletsStmt->bind_param("i", $reportId);
        $tabletsStmt->execute();
        $tabletsResult = $tabletsStmt->get_result();

        while ($tabletRow = $tabletsResult->fetch_assoc()) {
            $tabletsData[] = $tabletRow;
        }

        // Create a new PDF instance
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Report PDF');
        $pdf->SetSubject('Patient Report');

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('times', '', 12);

        // Set margins
        $pdf->SetMargins(15, 15, 15);

        // Add Logo
        //$logoPath = 'C:\xampp\htdocs\doctor\doctor\Screenshots\Screenshot (11).png'; // Provide the path to your logo image
        //$pdf->Image($logoPath, 15, 15, 40, 0, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Header
        $pdf->SetFont('times', 'B', 16);
        $pdf->Cell(0, 10, 'Patient Report', 0, 1, 'C');

        // Spacer
        $pdf->Ln(10);

        // Doctor Info
        $pdf->SetFont('times', 'B', 14);
        $pdf->Cell(0, 10, 'DOCTOR INFORMATION', 0, 1);
        $pdf->SetFont('times', '', 12);
        $pdf->Cell(0, 10, 'Doctor: ' . ucfirst(explode("@", $demail)[0]), 0, 1);
        $pdf->Cell(0, 10, 'Doctor Email: ' . $demail, 0, 1);

        // Spacer
        $pdf->Ln(10);

        // Patient Info
        $pdf->SetFont('times', 'B', 14);
        $pdf->Cell(0, 10, 'PaATIENT INFORMATION', 0, 1);
        $pdf->SetFont('times', '', 12);
        $pdf->Cell(0, 10, 'Patient Name: ' . $patientName, 0, 1);
        $pdf->Cell(0, 10, 'Prescription: ' . $prescriptionText, 0, 1);

        // Spacer
        $pdf->Ln(10);

        // Tablet Info
        $pdf->SetFont('times', 'B', 14);
        $pdf->Cell(0, 10, 'TABLETS IINFORMATION', 0, 1);

        foreach ($tabletsData as $tabletRow) {
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Tablet: ' . $tabletRow['tablet_name'], 0, 1);
            $pdf->SetFont('times', '', 12);
            $pdf->Cell(0, 10, 'Morning: ' . ($tabletRow['morning'] ? 'Yes' : 'No'), 0, 1);
            $pdf->Cell(0, 10, 'Afternoon: ' . ($tabletRow['afternoon'] ? 'Yes' : 'No'), 0, 1);
            $pdf->Cell(0, 10, 'Night: ' . ($tabletRow['night'] ? 'Yes' : 'No'), 0, 1);
            $pdf->Cell(0, 10, 'Before Food: ' . ($tabletRow['before_food'] ? 'Yes' : 'No'), 0, 1);
            $pdf->Cell(0, 10, 'After Food: ' . ($tabletRow['after_food'] ? 'Yes' : 'No'), 0, 1);
            
            // Spacer
            $pdf->Ln(5);
        }

        //$pdf->SetFont('times', 'B', 14);
        //$pdf->Cell(0, 10, 'REVISIT', 0, 1);
        //$pdf->SetFont('times', '', 12);
        //$pdf->Cell(0, 10, 'Revisit: ' . $revisitDate, 0, 1);

        
        // Output the PDF as a download
        $pdf->Output('report.pdf', 'D');
    } else {
        echo "Report not found.";
    }

    // Close database connection
    $mysqli->close();
} else {
    echo "Invalid report ID.";
}
?>

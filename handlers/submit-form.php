<?php
require_once '../vendor/autoload.php';
require_once '../config/config.php';
require_once '../includes/functions.php';

session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Validate CSRF token
if (!validateCSRFToken($_POST['csrf_token'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Invalid token']);
    exit;
}

try {
    // Sanitize inputs
    $firstName = sanitizeInput($_POST['firstName']);
    $lastName = sanitizeInput($_POST['lastName']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $city = sanitizeInput($_POST['city']);
    $experience = sanitizeInput($_POST['experience']);

    // Initialize Google Sheets API
    $client = new Google_Client();
    $client->setAuthConfig(GOOGLE_SHEETS_CREDENTIALS_PATH);
    $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
    
    $service = new Google_Service_Sheets($client);
    
    // Prepare data for Google Sheets
    $values = [
        [
            date('Y-m-d H:i:s'),
            $firstName,
            $lastName,
            $email,
            $phone,
            $city,
            $experience
        ]
    ];
    
    $body = new Google_Service_Sheets_ValueRange([
        'values' => $values
    ]);
    
    // Append data to Google Sheet
    $result = $service->spreadsheets_values->append(
        SPREADSHEET_ID,
        'Sheet1!A:G',
        $body,
        ['valueInputOption' => 'RAW']
    );

    echo json_encode([
        'success' => true,
        'message' => 'اطلاعات شما با موفقیت ثبت شد. به زودی با شما تماس خواهیم گرفت.'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'متاسفانه خطایی رخ داده است. لطفا دوباره تلاش کنید.'
    ]);
} 
<?php
// Start session if needed
session_start();

// Include configuration and helper functions
require_once 'config/config.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<!-- Previous head content remains the same -->
<head>
    <!-- ... existing head content ... -->
    <!-- Add Toastify for notifications -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body>
    <!-- ... Previous sections remain unchanged until the form section ... -->

    <!-- Update the form section with AJAX handling -->
    <section class="section-alternate-1 section-padding" id="apply-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg" data-aos="fade-up">
                        <div class="card-body p-5">
                            <h3 class="text-center mb-4">فرم درخواست همکاری</h3>
                            <p class="text-center text-muted mb-4">اطلاعات خود را وارد کنید تا در اسرع وقت با شما تماس بگیریم</p>
                            
                            <form id="agentForm" class="needs-validation" novalidate>
                                <!-- Previous form fields remain the same -->
                                <!-- Add CSRF token -->
                                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                                
                                <!-- Add loading spinner -->
                                <div class="submit-spinner d-none">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">در حال ارسال...</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ... Rest of the content remains the same ... -->

    <!-- Add required scripts -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="assets/js/form-handler.js"></script>
</body>
</html> 
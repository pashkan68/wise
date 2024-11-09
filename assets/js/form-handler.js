document.getElementById('agentForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    if (!this.checkValidity()) {
        this.classList.add('was-validated');
        return;
    }

    // Show loading spinner
    const submitBtn = this.querySelector('button[type="submit"]');
    const spinner = this.querySelector('.submit-spinner');
    submitBtn.disabled = true;
    spinner.classList.remove('d-none');

    try {
        const formData = new FormData(this);
        const response = await fetch('/handlers/submit-form.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            // Show success message
            Toastify({
                text: result.message,
                duration: 5000,
                gravity: "top",
                position: "center",
                className: "success-toast",
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                }
            }).showToast();

            // Reset form
            this.reset();
            this.classList.remove('was-validated');
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        // Show error message
        Toastify({
            text: error.message || 'خطایی رخ داده است. لطفا دوباره تلاش کنید.',
            duration: 5000,
            gravity: "top",
            position: "center",
            className: "error-toast",
            style: {
                background: "linear-gradient(to right, #ff5f6d, #ffc371)",
            }
        }).showToast();
    } finally {
        // Hide loading spinner
        submitBtn.disabled = false;
        spinner.classList.add('d-none');
    }
}); 
<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $accountNumber = $_POST['account_number'];
    $paymentAmount = $_POST['payment_amount'];
    $paymentMethod = $_POST['payment_method'];
    
    // Perform validation or additional processing as needed

    // Process the payment based on the selected payment method
    switch ($paymentMethod) {
        case 'online':
            // Code to handle online payment processing
            // Replace this with your actual online payment processing logic
            echo "Online payment processed successfully.";
            break;
        case 'in_person':
            // Code to handle in-person payment processing
            // Replace this with your actual in-person payment processing logic
            echo "In-person payment processed successfully.";
            break;
        case 'bank_transfer':
            // Code to handle bank transfer payment processing
            // Replace this with your actual bank transfer payment processing logic
            echo "Bank transfer payment processed successfully.";
            break;
        default:
            echo "Invalid payment method selected.";
    }
} else {
    echo "Invalid request.";
}
?>

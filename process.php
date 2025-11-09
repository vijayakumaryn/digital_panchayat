 <?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $name = $_POST["name"];
  $email = $_POST["email"];

  // Save the data to a file
  $file = fopen("signatures.txt", "a");
  fwrite($file, "$name,$email\n");
  fclose($file);

  // Redirect to a thank you page
  header("Location: thanks.html");
  exit();
}
?>

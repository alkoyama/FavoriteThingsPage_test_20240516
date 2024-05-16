<?php

// Check if form is submitted and data exists
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['comment'])) {

  // Collect data from form
  $username_post = $_POST['username'];
  $subject = $_POST['subject'];
  $email = $_POST['email'];
  $comment = $_POST['comment'];

  // **Connect to your Database Here**
  // Replace with your connection details
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "git_test";
  // Check connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  // Insert data into database (replace with your INSERT statement)
  $sql = "INSERT INTO comments (username, subject , email, comment, CreatedAt) VALUES ('$username_post', '$subject' , '$email', '$comment',NOW())";

  if (mysqli_query($conn, $sql)) {
    echo "投稿ありがとうございます！";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

  // **New: Retrieve messages from database**
  $sql = "SELECT username, email, comment FROM comments";
  $result = mysqli_query($conn, $sql);
  
  $comments_html = ''; // Initialize an empty string to hold HTML for comments
  while ($row = $result->fetch_assoc()) { // Loop through each comment row
      $username = $row['username'];
      $email = $row['email']; // If you're storing email
      $comment = $row['comment'];
  
      $comments_html .= '<div class="message">'; // Create a container for each comment
      $comments_html .= '<h3>' . $username . '</h3>'; // Display username
      if ($email) { // Add email if available
          $comments_html .= '<p>' . $email . '</p>';
      }
      $comments_html .= '<p>' . $comment . '</p>'; // Display comment
      $comments_html .= '</div>';
  }

  $comments_data = json_encode(array('comments' => $comments_html));

  // Close connection
  mysqli_close($conn);
} else {
  echo "投稿が失敗しました";
}

?>

<script>
  document.querySelector('.messages').innerHTML = `<?php echo $messages; ?>`;
</script>

<a href="index.html">戻る</a>
<?php
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

// Pagination variables
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page from URL or default to 1
$messagesPerPage = 5; // Number of messages to display per page

// Calculate offset for messages based on current page
$offset = ($currentPage - 1) * $messagesPerPage;

// Retrieve comments from database with pagination
$sql = "SELECT * FROM comments WHERE DATE(CreatedAt) = CURDATE() ORDER BY CreatedAt DESC LIMIT $offset, $messagesPerPage";
$result = mysqli_query($conn, $sql);

$commentsHtml = ''; // Initialize empty string for comments HTML

while ($row = $result->fetch_assoc()) {
  $username = htmlspecialchars($row['username']); // Escape special characters
  $subject = htmlspecialchars($row['subject']); // Escape special characters
  $email = htmlspecialchars($row['email']); // Escape special characters
  $comment = htmlspecialchars($row['comment']); // Escape special characters
  $CreatedAt = htmlspecialchars($row['CreatedAt']); // Escape special characters

  $commentsHtml .= '<div class="message-container">';
  $commentsHtml .= '<div class="message">';
  $commentsHtml .= '<h3>' . $username . '</h3>'; // Display username
  if ($subject) {
    $commentsHtml .= '<p>' . $subject . 'へ</p>';
  }
  if ($email) { // Add email if available
    $commentsHtml .= '<p>Email: ' . $email . '</p>';
  }
  $commentsHtml .= '<p>' . $comment . '</p>'; // Display comment
  $commentsHtml .= '<p>' . $CreatedAt . '</p>'; // Display comment date
  $commentsHtml .= '</div>'; // Close message container
  $commentsHtml .= '</div>'; // Close message-container
}

// Calculate total comments and total pages
$totalCommentsSql = "SELECT COUNT(*) AS total_comments FROM comments WHERE DATE(CreatedAt) = CURDATE()";
$totalCommentsResult = mysqli_query($conn, $totalCommentsSql);
$totalCommentsRow = mysqli_fetch_assoc($totalCommentsResult);
$totalComments = (int)$totalCommentsRow['total_comments'];
$totalPages = ceil($totalComments / $messagesPerPage);

// Generate pagination links
$paginationLinks = '';

// Previous button
if ($currentPage > 1) {
  $paginationLinks .= '<a href="?page=' . ($currentPage - 1) . '">Previous</a>';
}

// Next button
if ($currentPage < $totalPages) {
  $paginationLinks .= '<a href="?page=' . ($currentPage + 1) . '">Next</a>';
}


// Close connection
mysqli_close($conn);

// Prepare output data
$output = array(
  'comments' => $commentsHtml,
  'pagination' => $paginationLinks,
);

// Output JSON data
echo json_encode($output);
?>

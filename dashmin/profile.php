<?php
include "components/header.php";

// Check if session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    echo "Please log in to view your profile.";
    exit();
}

// Get the logged-in user's ID from the session
$userId = $_SESSION['userid'];

// Query to select the logged-in user's data
$profileQuery = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
$profileQuery->execute(['user_id' => $userId]);
$userData = $profileQuery->fetch(PDO::FETCH_ASSOC);

// Check if user data is found
if ($userData) {
?>
    <div class="container mt-4">
        <div class="profile-container">
            <div class="profile-header">
                <h1><?php echo htmlspecialchars($userData['user_name']); ?></h1>
            </div>
            <div class="profile-details">
                <ul class="list-group">
                    <li class="p-3 list-group-item">Email: <?php echo htmlspecialchars($userData['user_email']); ?></li>
                
                    <li class="p-3 list-group-item">Phone: <?php echo htmlspecialchars($userData['user_phone']); ?></li>
                    <li class="p-3 list-group-item">User Role Type: <?php echo htmlspecialchars($userData['user_role_type']); ?></li>
                </ul>
            </div>
            <!-- Button to open the Bootstrap modal -->
            <a href="#" class="edit-button" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</a>
        </div>  
    </div>

    <!-- Bootstrap Modal for changing the password -->
    <div class="modal fade" style="margin-top: 100px;" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm" action="php/query.php" method="POST">
                        <!-- Hidden input field to pass the user ID -->
                        <input type="hidden" name="empid" value="<?php echo htmlspecialchars($userId); ?>">
                        
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle form submission via AJAX (optional)
        document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Perform AJAX request to submit the form data
            fetch('php/query.php', {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Show response message
                if (data.includes("successfully")) {
                    window.location.reload(); // Reload the page on success
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
    </script>
<?php
} else {
    echo "User data not found.";
}
include "components/footer.php";
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    // Check if user ID is passed from the form (hidden input)
    if (!isset($_POST['empid']) || empty($_POST['empid'])) {
        echo "User ID is missing.";
        exit();
    }

    $userId = $_POST['empid'];

    // Ensure new password and confirmation match
    if ($newPassword !== $confirmNewPassword) {
        echo "New passwords do not match.";
        exit();
    }

    // Fetch the user's current password hash from the database
    $stmt = $pdo->prepare("SELECT user_password FROM users WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found.";
        exit();
    }

    // Verify the current password
    if (!password_verify($currentPassword, $user['user_password'])) {
        echo "Current password is incorrect.";
        exit();
    }

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the user's password in the database
    $updateStmt = $pdo->prepare("UPDATE users SET user_password = :user_password WHERE user_id = :user_id");
    $updateStmt->execute([
        'user_password' => $hashedPassword,
        'user_id' => $userId
    ]);

    if ($updateStmt->rowCount() > 0) {
        echo "Password changed successfully.";
    } else {
        echo "Failed to change the password.";
    }
}
?>

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
    <div class="profile-container">
        <div class="profile-header">
            <h1><?php echo htmlspecialchars($userData['user_name']); ?></h1>
        </div>
        <div class="profile-details">
            <ul>
                <li>Email: <?php echo htmlspecialchars($userData['user_email']); ?></li>
                <li>Password: <?php echo htmlspecialchars($userData['user_password']); ?></li>
                <li>Phone: <?php echo htmlspecialchars($userData['user_phone']); ?></li>
                <li>User Role Type: <?php echo htmlspecialchars($userData['user_role_type']); ?></li>
            </ul>
        </div>
        <!-- Edit Profile Button -->
        <a href="#" class="edit-button" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</a>
    </div>

    <!-- Bootstrap Modal for Password Change -->
    <div class="modal fade" style="margin-top: 100px;" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm" action="auth/auth.php" method="POST">
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

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle form submission via AJAX (optional)
        document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Perform AJAX request to submit the form data
            fetch('auth/auth.php', {
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

$currentPage = basename($_SERVER['PHP_SELF']); // Get the current page name

// Allow logged-out users to access specific public pages
$publicPages = ['index.php', 'login.php', 'register.php','product.php','product-detail.php','contact.php','feedback.php','blog.php','shoping-cart.php','about.php'];

if (!isset($_SESSION['userid']) && !in_array($currentPage, $publicPages)) {
    header("Location: index.php");
    exit();
}

// If the user is logged in, proceed
if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmNewPassword = $_POST['confirmNewPassword'];

        // Validate new password confirmation
        if ($newPassword !== $confirmNewPassword) {
            echo "New passwords do not match.";
            exit();
        }

        // Fetch current password hash from the database
        $stmt = $pdo->prepare("SELECT user_password FROM users WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            session_destroy(); // Destroy session if user doesn't exist
            header("Location: index.php");
            exit();
        }

        $storedHashedPassword = $user['user_password'];

        if (password_verify($currentPassword, $storedHashedPassword)) {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password in the database
            $updateStmt = $pdo->prepare("UPDATE users SET user_password = :user_password WHERE user_id = :user_id");
            $updateStmt->execute([
                'user_password' => $hashedPassword,
                'user_id' => $userId
            ]);

            echo "Password updated successfully.";
        } else {
            echo "Current password is incorrect.";
        }
    }
}
?>
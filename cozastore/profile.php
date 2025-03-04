<?php
include "components/header.php";

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please log in to view your profile.'); window.location.href='index.php';</script>";
    exit();
}
$userId = $_SESSION['userid'];
$message = ""; // Message for password change feedback

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['changePassword'])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    if ($newPassword !== $confirmNewPassword) {
        echo "<script>alert('New passwords do not match.');</script>";
    } else {
        // Fetch current password hash from the database
        $stmt = $pdo->prepare("SELECT user_password FROM users WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            session_destroy();
            echo "<script>alert('User not found.'); window.location.href='index.php';</script>";
            exit();
        }

        if (password_verify($currentPassword, $user['user_password'])) {
            // Hash new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update password in database
            $updateStmt = $pdo->prepare("UPDATE users SET user_password = :user_password WHERE user_id = :user_id");
            $updateStmt->execute([
                'user_password' => $hashedPassword,
                'user_id' => $userId
            ]);

            echo "<script>alert('Password updated successfully.'); </script>";
        } else {
            echo "<script>alert('Current password is incorrect.');</script>";
        }
    }
}

// Fetch user data for profile display
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
                <li>Phone: <?php echo htmlspecialchars($userData['user_phone']); ?></li>
                <li>User Role Type: <?php echo htmlspecialchars($userData['user_role_type']); ?></li>
            </ul>
        </div>

        <!-- Change Password Button -->
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
                    <form id="changePasswordForm" method="POST">
                        <input type="hidden" name="changePassword" value="1">
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

<?php
} else {
    echo "<script>alert('User data not found.');</script>";
}

include "components/footer.php";
?>

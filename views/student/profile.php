<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-header">
    <div class="container">
        <h1>My Profile</h1>
        <p>Manage your account information</p>
    </div>
</div>

<div class="container" style="padding: 2rem 0;">
    <div style="max-width: 800px; margin: 0 auto;">
        <div class="card">
            <h2>Personal Information</h2>
            <form method="POST" action="<?php echo BASE_URL; ?>student/profile">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control"
                        value="<?php echo htmlspecialchars($student['name']); ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($student['email']); ?>"
                        disabled style="background: var(--light-gray);">
                    <small style="color: var(--gray);">Email cannot be changed</small>
                </div>

                <div class="form-group">
                    <label class="form-label">University</label>
                    <input type="text" name="university" class="form-control"
                        value="<?php echo htmlspecialchars($student['university'] ?? ''); ?>"
                        placeholder="Enter your university name">
                </div>

                <div class="form-group">
                    <label class="form-label">Department</label>
                    <input type="text" name="department" class="form-control"
                        value="<?php echo htmlspecialchars($student['department'] ?? ''); ?>"
                        placeholder="e.g., Computer Science">
                </div>

                <div class="form-group">
                    <label class="form-label">Skills</label>
                    <textarea name="skills" class="form-control" rows="4"
                        placeholder="List your skills (e.g., Python, Java, Web Development)"><?php echo htmlspecialchars($student['skills'] ?? ''); ?></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                    <a href="<?php echo BASE_URL; ?>student/dashboard" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>

        <div class="card">
            <h2>Account Settings</h2>
            <p><strong>Account Status:</strong> <span class="badge badge-approved">Active</span></p>
            <p><strong>Member Since:</strong> <?php echo date('F Y', strtotime($student['created_at'])); ?></p>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
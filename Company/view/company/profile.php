<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-header">
    <div class="container">
        <h1>Company Profile</h1>
        <p>Manage your company information</p>
    </div>
</div>

<div class="container" style="padding: 2rem 0;">
    <div style="max-width: 800px; margin: 0 auto;">
        <div class="card">
            <h2>Company Information</h2>
            <form method="POST" action="<?php echo BASE_URL; ?>company/profile">
                <div class="form-group">
                    <label class="form-label">Contact Person Name</label>
                    <input type="text" name="name" class="form-control"
                        value="<?php echo htmlspecialchars($company['name']); ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($company['email']); ?>"
                        disabled style="background: var(--light-gray);">
                    <small style="color: var(--gray);">Email cannot be changed</small>
                </div>

                <div class="form-group">
                    <label class="form-label">Company Name</label>
                    <input type="text" name="company_name" class="form-control"
                        value="<?php echo htmlspecialchars($company['company_name']); ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Company Description</label>
                    <textarea name="description" class="form-control" rows="4"
                        placeholder="Describe your company and what you do..."><?php echo htmlspecialchars($company['description'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Website</label>
                    <input type="url" name="website" class="form-control"
                        value="<?php echo htmlspecialchars($company['website'] ?? ''); ?>"
                        placeholder="https://example.com">
                </div>

                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control"
                        value="<?php echo htmlspecialchars($company['location'] ?? ''); ?>" placeholder="City, Country">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                    <a href="<?php echo BASE_URL; ?>company/dashboard" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>

        <div class="card">
            <h2>Account Settings</h2>
            <p><strong>Account Status:</strong>
                <span class="badge badge-<?php echo $company['status']; ?>">
                    <?php echo ucfirst($company['status']); ?>
                </span>
            </p>
            <p><strong>Member Since:</strong> <?php echo date('F Y', strtotime($company['created_at'])); ?></p>
            <?php if ($company['is_verified']): ?>
                <p><strong>Verified:</strong> <span class="badge badge-approved">✓ Verified Company</span></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
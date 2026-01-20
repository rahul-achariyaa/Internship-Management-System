<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-header">
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>System Overview and Management</p>
    </div>
</div>

<div class="dashboard container">
    <!-- Statistics Grid -->
    <div class="dashboard-grid">
        <div class="stats-card">
            <h3><?php echo $totalUsers; ?></h3>
            <p>Total Users</p>
        </div>
        <div class="stats-card">
            <h3><?php echo $totalStudents; ?></h3>
            <p>Students</p>
        </div>
        <div class="stats-card">
            <h3><?php echo $totalCompanies; ?></h3>
            <p>Companies</p>
        </div>
        <div class="stats-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <h3><?php echo $totalInternships; ?></h3>
            <p>Internships</p>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="stats-card" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
            <h3><?php echo $totalApplications; ?></h3>
            <p>Total Applications</p>
        </div>
        <div class="stats-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <h3><?php echo $pendingCompanies; ?></h3>
            <p>Pending Companies</p>
        </div>
        <div class="stats-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <h3><?php echo $pendingInternships; ?></h3>
            <p>Pending Internships</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
        <h2 class="card-title">Quick Actions</h2>
        <div class="d-flex gap-2" style="margin-top: 1rem; flex-wrap: wrap;">
            <a href="<?php echo BASE_URL; ?>admin/users" class="btn btn-primary">Manage Users</a>
            <a href="<?php echo BASE_URL; ?>admin/companies" class="btn btn-primary">Manage Companies</a>
            <a href="<?php echo BASE_URL; ?>admin/internships" class="btn btn-primary">Manage Internships</a>
        </div>
    </div>

    <!-- Pending Approvals -->
    <?php if ($pendingCompanies > 0 || $pendingInternships > 0): ?>
        <div class="card" style="border-left: 4px solid var(--warning);">
            <h2 class="card-title">⚠️ Pending Approvals</h2>
            <div style="margin-top: 1rem;">
                <?php if ($pendingCompanies > 0): ?>
                    <p>✓ <strong><?php echo $pendingCompanies; ?></strong> company account(s) awaiting approval.
                        <a href="<?php echo BASE_URL; ?>admin/companies">Review now</a>
                    </p>
                <?php endif; ?>
                <?php if ($pendingInternships > 0): ?>
                    <p>✓ <strong><?php echo $pendingInternships; ?></strong> internship posting(s) awaiting approval.
                        <a href="<?php echo BASE_URL; ?>admin/internships">Review now</a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- System Info -->
    <div class="card">
        <h2 class="card-title">System Information</h2>
        <div style="margin-top: 1rem;">
            <p><strong>Application:</strong> <?php echo APP_NAME; ?> v<?php echo APP_VERSION; ?></p>
            <p><strong>Administrator:</strong> <?php echo htmlspecialchars($_SESSION['name']); ?></p>
            <p><strong>Today's Date:</strong> <?php echo date('F d, Y'); ?></p>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
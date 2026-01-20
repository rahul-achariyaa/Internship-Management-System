<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-header">
    <div class="container">
        <h1>Company Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($company['company_name']); ?>!</p>
        <?php if ($company['status'] === 'pending'): ?>
            <div class="alert alert-warning" style="margin-top: 1rem;">
                ⏳ Your account is pending admin approval. You can post internships, but they will need approval before being
                visible to students.
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="dashboard container">
    <div class="dashboard-grid">
        <div class="stats-card">
            <h3><?php echo $totalInternships; ?></h3>
            <p>Total Internships</p>
        </div>
        <div class="stats-card">
            <h3><?php echo $pendingInternships; ?></h3>
            <p>Pending Approval</p>
        </div>
        <div class="stats-card">
            <h3><?php echo $approvedInternships; ?></h3>
            <p>Active Internships</p>
        </div>
        <div class="stats-card" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
            <h3><?php echo $totalApplications; ?></h3>
            <p>Total Applications</p>
        </div>
    </div>

    <div class="card">
        <h2 class="card-title">Quick Actions</h2>
        <div class="d-flex gap-2" style="margin-top: 1rem;">
            <a href="<?php echo BASE_URL; ?>company/create" class="btn btn-primary">+ Post New Internship</a>
            <a href="<?php echo BASE_URL; ?>company/internships" class="btn btn-secondary">View My Internships</a>
            <a href="<?php echo BASE_URL; ?>company/applications" class="btn btn-secondary">View Applications</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-between align-center">
            <h2 class="card-title">Recent Internships</h2>
            <a href="<?php echo BASE_URL; ?>company/internships" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <div class="card-body">
            <?php if (!empty($recentInternships)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentInternships as $internship): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($internship['title']); ?></td>
                                <td><?php echo htmlspecialchars($internship['location']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($internship['deadline'])); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $internship['status']; ?>">
                                        <?php echo ucfirst($internship['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>company/applications/<?php echo $internship['internship_id']; ?>"
                                        class="btn btn-primary btn-sm">
                                        View Applications
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No internships posted yet. <a href="<?php echo BASE_URL; ?>company/create">Post your first
                        internship</a>!</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-between align-center">
            <h2 class="card-title">Recent Applications</h2>
            <a href="<?php echo BASE_URL; ?>company/applications" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <div class="card-body">
            <?php if (!empty($recentApplications)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Internship</th>
                            <th>University</th>
                            <th>Applied Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentApplications as $app): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($app['name']); ?></td>
                                <td><?php echo htmlspecialchars($app['internship_title']); ?></td>
                                <td><?php echo htmlspecialchars($app['university'] ?? 'N/A'); ?></td>
                                <td><?php echo date('M d, Y', strtotime($app['applied_at'])); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $app['status']; ?>">
                                        <?php echo ucfirst($app['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No applications received yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
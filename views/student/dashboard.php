<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-header">
    <div class="container">
        <h1>Student Dashboard</h1>
        <p>Welcome back, <?php echo htmlspecialchars($student['name']); ?>!</p>
    </div>
</div>

<div class="dashboard container">
    <div class="dashboard-grid">
        <div class="stats-card">
            <h3><?php echo $totalApplications; ?></h3>
            <p>Total Applications</p>
        </div>
        <div class="stats-card">
            <h3><?php echo $pendingCount; ?></h3>
            <p>Pending</p>
        </div>
        <div class="stats-card">
            <h3><?php echo $approvedCount; ?></h3>
            <p>Approved</p>
        </div>
        <div class="stats-card" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
            <h3><?php echo $rejectedCount; ?></h3>
            <p>Rejected</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-between align-center">
            <h2 class="card-title">Recent Applications</h2>
            <a href="<?php echo BASE_URL; ?>student/applications" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <div class="card-body">
            <?php if (!empty($recentApplications)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Internship Title</th>
                            <th>Company</th>
                            <th>Applied Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentApplications as $app): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($app['title']); ?></td>
                                <td><?php echo htmlspecialchars($app['company_name']); ?></td>
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
                <p>No applications yet. <a href="<?php echo BASE_URL; ?>student/internships">Browse internships</a> to get
                    started!</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-between align-center">
            <h2 class="card-title">Latest Internship Opportunities</h2>
            <a href="<?php echo BASE_URL; ?>student/internships" class="btn btn-secondary btn-sm">Browse All</a>
        </div>
        <div class="card-body">
            <?php if (!empty($latestInternships)): ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem;">
                    <?php foreach ($latestInternships as $internship): ?>
                        <div class="card">
                            <h3><?php echo htmlspecialchars($internship['title']); ?></h3>
                            <p style="color: var(--primary-maroon); font-weight: 600;">
                                <?php echo htmlspecialchars($internship['company_name']); ?>
                            </p>
                            <p><?php echo substr(htmlspecialchars($internship['description']), 0, 100); ?>...</p>
                            <p><strong>Location:</strong> <?php echo htmlspecialchars($internship['location']); ?></p>
                            <p><strong>Deadline:</strong> <?php echo date('M d, Y', strtotime($internship['deadline'])); ?></p>
                            <a href="<?php echo BASE_URL; ?>student/viewInternship/<?php echo $internship['internship_id']; ?>"
                                class="btn btn-primary btn-sm">View Details</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No internships available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
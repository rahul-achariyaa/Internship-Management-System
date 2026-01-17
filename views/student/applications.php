<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-header">
    <div class="container">
        <h1>My Applications</h1>
        <p>Track your internship applications</p>
    </div>
</div>

<div class="container" style="padding: 2rem 0;">
    <div class="card">
        <?php if (!empty($applications)): ?>
            <div class="table" style="overflow-x: auto;">
                <table class="table" id="applicationsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Internship Title</th>
                            <th>Company</th>
                            <th>Location</th>
                            <th>Applied Date</th>
                            <th>Deadline</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $index => $app): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($app['title']); ?></td>
                                <td><?php echo htmlspecialchars($app['company_name']); ?></td>
                                <td><?php echo htmlspecialchars($app['location']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($app['applied_at'])); ?></td>
                                <td><?php echo date('M d, Y', strtotime($app['deadline'])); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $app['status']; ?>">
                                        <?php echo ucfirst($app['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center" style="padding: 3rem;">
                <h3>No Applications Yet</h3>
                <p style="margin: 1rem 0;">You haven't applied for any internships yet.</p>
                <a href="<?php echo BASE_URL; ?>student/internships" class="btn btn-primary">
                    Browse Internships
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Legend -->
    <div class="card" style="margin-top: 2rem;">
        <h3>Status Legend</h3>
        <div class="d-flex gap-3" style="margin-top: 1rem;">
            <span class="badge badge-pending">Pending - Under Review</span>
            <span class="badge badge-approved">Approved - Congratulations!</span>
            <span class="badge badge-rejected">Rejected - Better luck next time</span>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
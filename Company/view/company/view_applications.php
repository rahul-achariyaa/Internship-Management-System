<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-header">
    <div class="container">
        <h1>Applications</h1>
        <p><?php echo isset($internship) ? htmlspecialchars($internship['title']) : 'All Applications'; ?></p>
    </div>
</div>

<div class="container" style="padding: 2rem 0;">
    <div class="card">
        <?php if (!empty($applications)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>University</th>
                        <th>Department</th>
                        <th>Applied Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $app): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($app['name']); ?></td>
                            <td><?php echo htmlspecialchars($app['email']); ?></td>
                            <td><?php echo htmlspecialchars($app['university'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($app['department'] ?? 'N/A'); ?></td>
                            <td><?php echo date('M d, Y', strtotime($app['applied_at'])); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $app['status']; ?>">
                                    <?php echo ucfirst($app['status']); ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="<?php echo BASE_URL; ?>company/updateApplication"
                                    style="display: inline;">
                                    <input type="hidden" name="application_id" value="<?php echo $app['application_id']; ?>">
                                    <input type="hidden" name="redirect"
                                        value="company/applications/<?php echo $app['internship_id'] ?? ''; ?>">

                                    <?php if ($app['status'] === 'pending'): ?>
                                        <button type="submit" name="status" value="approved" class="btn btn-success btn-sm"
                                            onclick="return confirm('Approve this application?')">
                                            Approve
                                        </button>
                                        <button type="submit" name="status" value="rejected" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Reject this application?')">
                                            Reject
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" name="status" value="pending" class="btn btn-secondary btn-sm"
                                            onclick="return confirm('Reset to pending?')">
                                            Reset
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="text-center" style="padding: 3rem;">
                <h3>No Applications Yet</h3>
                <p>No students have applied for this internship.</p>
            </div>
        <?php endif; ?>
    </div>

    <?php if (isset($internship)): ?>
        <a href="<?php echo BASE_URL; ?>company/internships" class="btn btn-secondary">← Back to My Internships</a>
    <?php endif; ?>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
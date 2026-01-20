<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-header">
    <div class="container">
        <h1>My Internships</h1>
        <p>Manage your posted internships</p>
    </div>
</div>

<div class="container" style="padding: 2rem 0;">
    <div class="card">
        <div class="card-header d-flex justify-between align-center">
            <h2 class="card-title">All Internships</h2>
            <a href="<?php echo BASE_URL; ?>company/create" class="btn btn-primary">+ Post New Internship</a>
        </div>
        <div class="card-body">
            <?php if (!empty($internships)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Applications</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($internships as $internship): ?>
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
                                    <a
                                        href="<?php echo BASE_URL; ?>company/applications/<?php echo $internship['internship_id']; ?>">
                                        View
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="<?php echo BASE_URL; ?>company/edit/<?php echo $internship['internship_id']; ?>"
                                            class="btn btn-secondary btn-sm">
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="text-center" style="padding: 3rem;">
                    <h3>No Internships Posted</h3>
                    <p style="margin: 1rem 0;">Start attracting talent by posting your first internship!</p>
                    <a href="<?php echo BASE_URL; ?>company/create" class="btn btn-primary">
                        Post Your First Internship
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-header">
    <div class="container">
        <h1>Manage Internships</h1>
        <p>Approve and manage internship postings</p>
    </div>
</div>

<div class="container" style="padding: 2rem 0;">
    <div class="card">
        <?php if (!empty($internships)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Deadline</th>
                        <th>Posted</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($internships as $internship): ?>
                        <tr>
                            <td><?php echo $internship['internship_id']; ?></td>
                            <td><?php echo htmlspecialchars($internship['title']); ?></td>
                            <td><?php echo htmlspecialchars($internship['company_name']); ?></td>
                            <td><?php echo htmlspecialchars($internship['location']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($internship['deadline'])); ?></td>
                            <td><?php echo date('M d, Y', strtotime($internship['created_at'])); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $internship['status']; ?>">
                                    <?php echo ucfirst($internship['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($internship['status'] === 'pending'): ?>
                                    <a href="<?php echo BASE_URL; ?>admin/approveInternship/<?php echo $internship['internship_id']; ?>"
                                        class="btn btn-success btn-sm" onclick="return confirm('Approve this internship?')">
                                        Approve
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>admin/rejectInternship/<?php echo $internship['internship_id']; ?>"
                                        class="btn btn-danger btn-sm" onclick="return confirm('Reject this internship?')">
                                        Reject
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="text-center" style="padding: 3rem;">
                <h3>No Internships</h3>
                <p>No internship postings available.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
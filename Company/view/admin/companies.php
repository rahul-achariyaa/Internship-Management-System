<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-header">
    <div class="container">
        <h1>Manage Companies</h1>
        <p>Approve and manage company accounts</p>
    </div>
</div>

<div class="container" style="padding: 2rem 0;">
    <div class="card">
        <?php if (!empty($companies)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company Name</th>
                        <th>Contact Person</th>
                        <th>Email</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($companies as $company): ?>
                        <tr>
                            <td><?php echo $company['company_id']; ?></td>
                            <td><?php echo htmlspecialchars($company['company_name']); ?></td>
                            <td><?php echo htmlspecialchars($company['name']); ?></td>
                            <td><?php echo htmlspecialchars($company['email']); ?></td>
                            <td><?php echo htmlspecialchars($company['location'] ?? 'N/A'); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $company['status']; ?>">
                                    <?php echo ucfirst($company['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($company['created_at'])); ?></td>
                            <td>
                                <?php if ($company['status'] === 'pending'): ?>
                                    <a href="<?php echo BASE_URL; ?>admin/approveCompany/<?php echo $company['user_id']; ?>"
                                        class="btn btn-success btn-sm" onclick="return confirm('Approve this company?')">
                                        Approve
                                    </a>
                                <?php elseif ($company['status'] === 'approved'): ?>
                                    <a href="<?php echo BASE_URL; ?>admin/blockUser/<?php echo $company['user_id']; ?>"
                                        class="btn btn-danger btn-sm" onclick="return confirm('Block this company?')">
                                        Block
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="text-center" style="padding: 3rem;">
                <h3>No Companies</h3>
                <p>No company accounts registered yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
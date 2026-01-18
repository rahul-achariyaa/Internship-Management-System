<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-header">
    <div class="container">
        <h1>Browse Internships</h1>
        <p>Find your perfect internship opportunity</p>
    </div>
</div>

<div class="container" style="padding: 2rem 0;">
    <div class="card">
        <form method="GET" action="<?php echo BASE_URL; ?>student/internships">
            <div class="d-flex gap-2">
                <input type="text" name="search" class="form-control"
                    placeholder="Search by title, company, or location..."
                    value="<?php echo htmlspecialchars($keyword); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
                <?php if (!empty($keyword)): ?>
                    <a href="<?php echo BASE_URL; ?>student/internships" class="btn btn-secondary">Clear</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div style="margin-top: 2rem;">
        <h3>
            <?php if (!empty($keyword)): ?>
                Search Results for "<?php echo htmlspecialchars($keyword); ?>" (<?php echo count($internships); ?> found)
            <?php else: ?>
                All Available Internships (<?php echo count($internships); ?>)
            <?php endif; ?>
        </h3>

        <?php if (!empty($internships)): ?>
            <div style="display: grid; gap: 1.5rem; margin-top: 1.5rem;">
                <?php foreach ($internships as $internship): ?>
                    <div class="card">
                        <div class="d-flex justify-between align-center mb-2">
                            <h3 style="margin: 0;"><?php echo htmlspecialchars($internship['title']); ?></h3>
                            <span class="badge badge-approved">Open</span>
                        </div>
                        <p style="color: var(--primary-maroon); font-weight: 600; margin-bottom: 1rem;">
                            <?php echo htmlspecialchars($internship['company_name']); ?>
                        </p>
                        <p><?php echo substr(htmlspecialchars($internship['description']), 0, 200); ?>...</p>
                        <div class="d-flex gap-3 mt-2" style="color: var(--gray); font-size: 0.9rem;">
                            <span>📍 <?php echo htmlspecialchars($internship['location']); ?></span>
                            <span>📅 Deadline: <?php echo date('M d, Y', strtotime($internship['deadline'])); ?></span>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <a href="<?php echo BASE_URL; ?>student/viewInternship/<?php echo $internship['internship_id']; ?>"
                                class="btn btn-primary btn-sm">
                                View Details
                            </a>
                            <?php if (isset($internship['has_applied']) && $internship['has_applied']): ?>
                                <span class="badge badge-pending" style="padding: 0.5rem 1rem;">Already Applied</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="card text-center" style="margin-top: 2rem; padding: 3rem;">
                <h3>No internships found</h3>
                <p>Try adjusting your search criteria</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
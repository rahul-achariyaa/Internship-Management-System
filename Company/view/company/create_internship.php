<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-header">
    <div class="container">
        <h1>Post New Internship</h1>
        <p>Create a new internship opportunity</p>
    </div>
</div>

<div class="container" style="padding: 2rem 0;">
    <div style="max-width: 800px; margin: 0 auto;">
        <div class="card">
            <form method="POST" action="<?php echo BASE_URL; ?>company/create">
                <div class="form-group">
                    <label class="form-label">Internship Title *</label>
                    <input type="text" name="title" class="form-control"
                        value="<?php echo htmlspecialchars($title ?? ''); ?>" required
                        placeholder="e.g., Software Development Intern">
                </div>

                <div class="form-group">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-control" rows="6" required
                        placeholder="Describe the internship role, responsibilities, and what the intern will learn..."><?php echo htmlspecialchars($description ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Requirements</label>
                    <textarea name="requirements" class="form-control" rows="5"
                        placeholder="List required skills, qualifications, and prerequisites..."><?php echo htmlspecialchars($requirements ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Location *</label>
                    <input type="text" name="location" class="form-control"
                        value="<?php echo htmlspecialchars($location ?? ''); ?>" required
                        placeholder="City, Country or Remote">
                </div>

                <div class="form-group">
                    <label class="form-label">Application Deadline *</label>
                    <input type="date" name="deadline" class="form-control" value="<?php echo $deadline ?? ''; ?>"
                        min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                </div>

                <div class="alert alert-info">
                    <strong>Note:</strong> Your internship posting will be reviewed by an admin before it becomes
                    visible to students.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Post Internship</button>
                    <a href="<?php echo BASE_URL; ?>company/dashboard" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
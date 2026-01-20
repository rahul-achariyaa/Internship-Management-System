<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-header">
    <div class="container">
        <h1>Edit Internship</h1>
        <p>Update internship details</p>
    </div>
</div>

<div class="container" style="padding: 2rem 0;">
    <div style="max-width: 800px; margin: 0 auto;">
        <div class="card">
            <form method="POST"
                action="<?php echo BASE_URL; ?>company/edit/<?php echo $internship['internship_id']; ?>">
                <div class="form-group">
                    <label class="form-label">Internship Title *</label>
                    <input type="text" name="title" class="form-control"
                        value="<?php echo htmlspecialchars($internship['title']); ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-control" rows="6"
                        required><?php echo htmlspecialchars($internship['description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Requirements</label>
                    <textarea name="requirements" class="form-control"
                        rows="5"><?php echo htmlspecialchars($internship['requirements'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Location *</label>
                    <input type="text" name="location" class="form-control"
                        value="<?php echo htmlspecialchars($internship['location']); ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Application Deadline *</label>
                    <input type="date" name="deadline" class="form-control"
                        value="<?php echo $internship['deadline']; ?>" min="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Internship</button>
                    <a href="<?php echo BASE_URL; ?>company/internships" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
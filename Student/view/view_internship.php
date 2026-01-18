<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="page-header">
    <div class="container">
        <h1><?php echo htmlspecialchars($internship['title']); ?></h1>
        <p><?php echo htmlspecialchars($internship['company_name']); ?></p>
    </div>
</div>

<div class="container" style="padding: 2rem 0;">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <div>
            <div class="card">
                <h2>About the Internship</h2>
                <p style="white-space: pre-wrap; margin-top: 1rem;">
                    <?php echo htmlspecialchars($internship['description']); ?>
                </p>
            </div>

            <?php if (!empty($internship['requirements'])): ?>
                <div class="card">
                    <h2>Requirements</h2>
                    <p style="white-space: pre-wrap; margin-top: 1rem;">
                        <?php echo htmlspecialchars($internship['requirements']); ?>
                    </p>
                </div>
            <?php endif; ?>

            <?php if (!$hasApplied): ?>
                <div class="card" style="background: var(--light-gray);">
                    <h2>Apply for this Internship</h2>
                    <form method="POST"
                        action="<?php echo BASE_URL; ?>student/apply/<?php echo $internship['internship_id']; ?>"
                        enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="form-label">Upload Resume (Optional)</label>
                            <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx"
                                onchange="handleFileUpload(this)">
                            <small style="color: var(--gray);">Accepted formats: PDF, DOC, DOCX (Max 5MB)</small>
                        </div>
                        <button type="submit" class="btn btn-primary"
                            onclick="return confirm('Are you sure you want to apply?')">
                            Submit Application
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <div class="card" style="background: #d1fae5; border-left: 4px solid var(--success);">
                    <h3>✓ Application Submitted</h3>
                    <p>You have already applied for this internship. Check your <a
                            href="<?php echo BASE_URL; ?>student/applications">applications page</a> for status updates.</p>
                </div>
            <?php endif; ?>
        </div>

        <div>
            <div class="card">
                <h3>Internship Details</h3>
                <div style="margin-top: 1rem;">
                    <p><strong>Company:</strong><br><?php echo htmlspecialchars($internship['company_name']); ?></p>
                    <p><strong>Location:</strong><br>📍 <?php echo htmlspecialchars($internship['location']); ?></p>
                    <p><strong>Application Deadline:</strong><br>📅
                        <?php echo date('F d, Y', strtotime($internship['deadline'])); ?>
                    </p>
                    <?php if (!empty($internship['website'])): ?>
                        <p><strong>Website:</strong><br>
                            <a href="<?php echo htmlspecialchars($internship['website']); ?>" target="_blank">
                                <?php echo htmlspecialchars($internship['website']); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                    <p><strong>Posted
                            On:</strong><br><?php echo date('M d, Y', strtotime($internship['created_at'])); ?></p>
                </div>
            </div>

            <div class="card" style="background: var(--light-gray);">
                <h4>Tips for Applying</h4>
                <ul style="margin-left: 1.5rem; margin-top: 1rem;">
                    <li>Read the requirements carefully</li>
                    <li>Update your resume before applying</li>
                    <li>Highlight relevant skills and experience</li>
                    <li>Apply before the deadline</li>
                </ul>
            </div>

            <a href="<?php echo BASE_URL; ?>student/internships" class="btn btn-secondary" style="width: 100%;">
                ← Back to All Internships
            </a>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
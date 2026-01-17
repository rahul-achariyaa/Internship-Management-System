<?php
class StudentController extends Controller
{
    private $studentModel;
    private $internshipModel;
    private $applicationModel;

    public function __construct()
    {
        $this->requireRole('student');
        $this->studentModel = $this->model('StudentProfile');
        $this->internshipModel = $this->model('Internship');
        $this->applicationModel = $this->model('Application');
    }
    public function dashboard()
    {
        $userId = $this->getCurrentUserId();
        $student = $this->studentModel->getByUserId($userId);

        if (!$student) {
            $this->setFlash('danger', 'Student profile not found');
            $this->redirect('auth/logout');
            return;
        }

        if (!$student) {
            $this->setFlash('danger', 'Student profile not found');
            $this->redirect('auth/logout');
            return;
        }

        $totalApplications = count($this->applicationModel->getByStudent($student['student_id']));
        $pendingCount = $this->applicationModel->countByStatus($student['student_id'], 'pending');
        $approvedCount = $this->applicationModel->countByStatus($student['student_id'], 'approved');
        $rejectedCount = $this->applicationModel->countByStatus($student['student_id'], 'rejected');
        $recentApplications = array_slice($this->applicationModel->getByStudent($student['student_id']), 0, 5);

        $latestInternships = $this->internshipModel->getLatest(6);

        $data = [
            'title' => 'Student Dashboard',
            'student' => $student,
            'totalApplications' => $totalApplications,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'recentApplications' => $recentApplications,
            'latestInternships' => $latestInternships
        ];

        parent::view('student/dashboard', $data);
    }
    public function internships()
    {
        $keyword = $_GET['search'] ?? '';

        if (!empty($keyword)) {
            $internships = $this->internshipModel->search($keyword);
        } else {
            $internships = $this->internshipModel->getAllApproved();
        }

        $userId = $this->getCurrentUserId();
        $student = $this->studentModel->getByUserId($userId);

        $appliedInternships = [];
        foreach ($internships as &$internship) {
            $hasApplied = $this->applicationModel->hasApplied($internship['internship_id'], $student['student_id']);
            $internship['has_applied'] = $hasApplied;
        }

        $data = [
            'title' => 'Browse Internships',
            'internships' => $internships,
            'keyword' => $keyword,
            'student' => $student
        ];

        parent::view('student/internships', $data);
    }
    public function viewInternship($internshipId)
    {
        $internship = $this->internshipModel->getById($internshipId);

        if (!$internship) {
            $this->setFlash('danger', 'Internship not found');
            $this->redirect('student/internships');
            return;
        }

        $userId = $this->getCurrentUserId();
        $student = $this->studentModel->getByUserId($userId);

        if (!$student) {
            $this->setFlash('danger', 'Student profile not found');
            $this->redirect('auth/logout');
            return;
        }
        $hasApplied = $this->applicationModel->hasApplied($internshipId, $student['student_id']);

        $data = [
            'title' => $internship['title'],
            'internship' => $internship,
            'hasApplied' => $hasApplied,
            'student' => $student
        ];

        parent::view('student/view_internship', $data);
    }
    public function apply($internshipId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('student/viewInternship/' . $internshipId);
            return;
        }

        $userId = $this->getCurrentUserId();
        $student = $this->studentModel->getByUserId($userId);

        if (!$student) {
            $this->setFlash('danger', 'Student profile not found');
            $this->redirect('auth/logout');
            return;
        }
        $resumeFile = null;
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
            $resumeFile = $this->uploadResume($_FILES['resume']);

            if (!$resumeFile) {
                $this->setFlash('danger', 'Resume upload failed');
                $this->redirect('student/viewInternship/' . $internshipId);
                return;
            }
        }
        $applicationId = $this->applicationModel->create($internshipId, $student['student_id'], $resumeFile);

        if ($applicationId) {
            $this->setFlash('success', 'Application submitted successfully!');
            $this->redirect('student/applications');
        } else {
            $this->setFlash('danger', 'You have already applied for this internship');
            $this->redirect('student/viewInternship/' . $internshipId);
        }
    }
    public function applications()
    {
        $userId = $this->getCurrentUserId();
        $student = $this->studentModel->getByUserId($userId);

        if (!$student) {
            $this->setFlash('danger', 'Student profile not found');
            $this->redirect('auth/logout');
            return;
        }

        $applications = $this->applicationModel->getByStudent($student['student_id']);

        $data = [
            'title' => 'My Applications',
            'applications' => $applications
        ];

        parent::view('student/applications', $data);
    }
    public function profile()
    {
        $userId = $this->getCurrentUserId();
        $student = $this->studentModel->getByUserId($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updateData = [
                'university' => trim($_POST['university']),
                'department' => trim($_POST['department']),
                'skills' => trim($_POST['skills'])
            ];

            if ($this->studentModel->update($student['student_id'], $updateData)) {
                $userModel = $this->model('User');
                $userModel->updateProfile($userId, ['name' => trim($_POST['name'])]);

                $_SESSION['name'] = trim($_POST['name']);

                $this->setFlash('success', 'Profile updated successfully!');
                $this->redirect('student/profile');
            } else {
                $this->setFlash('danger', 'Profile update failed');
            }
        }

        $data = [
            'title' => 'My Profile',
            'student' => $student
        ];

        parent::view('student/profile', $data);
    }
    private function uploadResume($file)
    {
        $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $maxSize = MAX_FILE_SIZE;

        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'resume_' . uniqid() . '_' . time() . '.' . $extension;
        $destination = RESUME_PATH . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $filename;
        }

        return false;
    }
}

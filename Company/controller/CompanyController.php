<?php
class CompanyController extends Controller
{
    private $companyModel;
    private $internshipModel;
    private $applicationModel;

    public function __construct()
    {
        $this->requireRole('company');
        $this->companyModel = $this->model('CompanyProfile');
        $this->internshipModel = $this->model('Internship');
        $this->applicationModel = $this->model('Application');
    }
    public function dashboard()
    {
        $userId = $this->getCurrentUserId();
        $company = $this->companyModel->getByUserId($userId);

        if (!$company) {
            $this->setFlash('danger', 'Company profile not found');
            $this->redirect('auth/logout');
            return;
        }

        $internships = $this->internshipModel->getByCompany($company['company_id']);
        $totalInternships = count($internships);
        $pendingInternships = count(array_filter($internships, fn($i) => $i['status'] === 'pending'));
        $approvedInternships = count(array_filter($internships, fn($i) => $i['status'] === 'approved'));

        $totalApplications = count($this->applicationModel->getByCompany($company['company_id']));

        $recentInternships = array_slice($internships, 0, 5);

        $recentApplications = array_slice($this->applicationModel->getByCompany($company['company_id']), 0, 5);

        $data = [
            'title' => 'Company Dashboard',
            'company' => $company,
            'totalInternships' => $totalInternships,
            'pendingInternships' => $pendingInternships,
            'approvedInternships' => $approvedInternships,
            'totalApplications' => $totalApplications,
            'recentInternships' => $recentInternships,
            'recentApplications' => $recentApplications
        ];

        $this->view('company/dashboard', $data);
    }

    public function internships()
    {
        $userId = $this->getCurrentUserId();
        $company = $this->companyModel->getByUserId($userId);

        $internships = $this->internshipModel->getByCompany($company['company_id']);

        $data = [
            'title' => 'My Internships',
            'internships' => $internships,
            'company' => $company
        ];

        $this->view('company/internships', $data);
    }

    public function create()
    {
        $userId = $this->getCurrentUserId();
        $company = $this->companyModel->getByUserId($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'requirements' => trim($_POST['requirements']),
                'location' => trim($_POST['location']),
                'deadline' => $_POST['deadline']
            ];

            if (empty($data['title']) || empty($data['description']) || empty($data['location']) || empty($data['deadline'])) {
                $this->setFlash('danger', 'Please fill in all required fields');
                $this->view('company/create_internship', $data);
                return;
            }

            $internshipId = $this->internshipModel->create($company['company_id'], $data);

            if ($internshipId) {
                $this->setFlash('success', 'Internship posted successfully! Waiting for admin approval.');
                $this->redirect('company/internships');
            } else {
                $this->setFlash('danger', 'Failed to create internship');
                $this->view('company/create_internship', $data);
            }
        } else {
            $this->view('company/create_internship');
        }
    }
    public function edit($internshipId)
    {
        $userId = $this->getCurrentUserId();
        $company = $this->companyModel->getByUserId($userId);

        $internship = $this->internshipModel->getById($internshipId);

        if (!$internship || $internship['company_id'] != $company['company_id']) {
            $this->setFlash('danger', 'Internship not found or access denied');
            $this->redirect('company/internships');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'requirements' => trim($_POST['requirements']),
                'location' => trim($_POST['location']),
                'deadline' => $_POST['deadline']
            ];

            if ($this->internshipModel->update($internshipId, $data)) {
                $this->setFlash('success', 'Internship updated successfully!');
                $this->redirect('company/internships');
            } else {
                $this->setFlash('danger', 'Failed to update internship');
            }
        }

        $this->view('company/edit_internship', ['internship' => $internship]);
    }
    public function applications($internshipId = null)
    {
        $userId = $this->getCurrentUserId();
        $company = $this->companyModel->getByUserId($userId);

        if ($internshipId) {
            $internship = $this->internshipModel->getById($internshipId);
            if (!$internship || $internship['company_id'] != $company['company_id']) {
                $this->setFlash('danger', 'Access denied');
                $this->redirect('company/applications');
                return;
            }

            $applications = $this->applicationModel->getByInternship($internshipId);
            $data = [
                'title' => 'Applications - ' . $internship['title'],
                'applications' => $applications,
                'internship' => $internship
            ];

            $this->view('company/view_applications', $data);
        } else {
            $applications = $this->applicationModel->getByCompany($company['company_id']);
            $data = [
                'title' => 'All Applications',
                'applications' => $applications
            ];

            $this->view('company/applications', $data);
        }
    }
    public function updateApplication()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('company/applications');
            return;
        }

        $applicationId = $_POST['application_id'];
        $status = $_POST['status'];

        if ($this->applicationModel->updateStatus($applicationId, $status)) {
            $this->setFlash('success', 'Application status updated successfully!');
        } else {
            $this->setFlash('danger', 'Failed to update application status');
        }
        if (isset($_POST['redirect'])) {
            $this->redirect($_POST['redirect']);
        } else {
            $this->redirect('company/applications');
        }
    }
    public function profile()
    {
        $userId = $this->getCurrentUserId();
        $company = $this->companyModel->getByUserId($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updateData = [
                'company_name' => trim($_POST['company_name']),
                'description' => trim($_POST['description']),
                'website' => trim($_POST['website']),
                'location' => trim($_POST['location'])
            ];

            if ($this->companyModel->update($company['company_id'], $updateData)) {
                $userModel = $this->model('User');
                $userModel->updateProfile($userId, ['name' => trim($_POST['name'])]);

                $_SESSION['name'] = trim($_POST['name']);

                $this->setFlash('success', 'Profile updated successfully!');
                $this->redirect('company/profile');
            } else {
                $this->setFlash('danger', 'Profile update failed');
            }
        }

        $data = [
            'title' => 'Company Profile',
            'company' => $company
        ];

        $this->view('company/profile', $data);
    }
}
<?php
class AdminController extends Controller
{
    private $userModel;
    private $companyModel;
    private $studentModel;
    private $internshipModel;
    private $applicationModel;

    public function __construct()
    {
        $this->requireRole('admin');
        $this->userModel = $this->model('User');
        $this->companyModel = $this->model('CompanyProfile');
        $this->studentModel = $this->model('StudentProfile');
        $this->internshipModel = $this->model('Internship');
        $this->applicationModel = $this->model('Application');
    }
    public function dashboard()
    {
        $totalUsers = count($this->userModel->getAll());
        $totalStudents = count($this->studentModel->getAll());
        $totalCompanies = count($this->companyModel->getAll());
        $totalInternships = count($this->internshipModel->getAll());
        $totalApplications = count($this->applicationModel->getAll());

        $pendingCompanies = count($this->companyModel->getPending());
        $pendingInternships = count($this->internshipModel->getPending());

        $data = [
            'title' => 'Admin Dashboard',
            'totalUsers' => $totalUsers,
            'totalStudents' => $totalStudents,
            'totalCompanies' => $totalCompanies,
            'totalInternships' => $totalInternships,
            'totalApplications' => $totalApplications,
            'pendingCompanies' => $pendingCompanies,
            'pendingInternships' => $pendingInternships
        ];

        $this->view('admin/dashboard', $data);
    }
    public function users()
    {
        $users = $this->userModel->getAll();

        $data = [
            'title' => 'Manage Users',
            'users' => $users
        ];

        $this->view('admin/users', $data);
    }

    public function companies()
    {
        $companies = $this->companyModel->getAll();

        $data = [
            'title' => 'Manage Companies',
            'companies' => $companies
        ];

        $this->view('admin/companies', $data);
    }

    public function approveCompany($userId)
    {
        if ($this->userModel->updateStatus($userId, 'approved')) {
            $this->setFlash('success', 'Company approved successfully!');
        } else {
            $this->setFlash('danger', 'Failed to approve company');
        }

        $this->redirect('admin/companies');
    }

    public function blockUser($userId)
    {
        if ($this->userModel->updateStatus($userId, 'blocked')) {
            $this->setFlash('success', 'User blocked successfully!');
        } else {
            $this->setFlash('danger', 'Failed to block user');
        }

        $this->redirect('admin/users');
    }

    public function internships()
    {
        $internships = $this->internshipModel->getAll();

        $data = [
            'title' => 'Manage Internships',
            'internships' => $internships
        ];

        $this->view('admin/internships', $data);
    }

    public function approveInternship($internshipId)
    {
        if ($this->internshipModel->updateStatus($internshipId, 'approved')) {
            $this->setFlash('success', 'Internship approved successfully!');
        } else {
            $this->setFlash('danger', 'Failed to approve internship');
        }

        $this->redirect('admin/internships');
    }

    public function rejectInternship($internshipId)
    {
        if ($this->internshipModel->updateStatus($internshipId, 'rejected')) {
            $this->setFlash('success', 'Internship rejected');
        } else {
            $this->setFlash('danger', 'Failed to reject internship');
        }

        $this->redirect('admin/internships');
    }
}

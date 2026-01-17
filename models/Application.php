<?php
class Application extends Model
{
    public function create($internshipId, $studentId, $resumeFile = null)
    {
        if ($this->hasApplied($internshipId, $studentId)) {
            return false;
        }

        $sql = "INSERT INTO applications (internship_id, student_id, resume_file, status) 
                VALUES (:internship_id, :student_id, :resume_file, 'pending')";

        $params = [
            ':internship_id' => $internshipId,
            ':student_id' => $studentId,
            ':resume_file' => $resumeFile
        ];

        if ($this->query($sql, $params)) {
            return $this->lastInsertId();
        }

        return false;
    }
    public function hasApplied($internshipId, $studentId)
    {
        $sql = "SELECT COUNT(*) as count FROM applications 
                WHERE internship_id = :internship_id AND student_id = :student_id";

        $result = $this->fetchOne($sql, [
            ':internship_id' => $internshipId,
            ':student_id' => $studentId
        ]);

        return $result['count'] > 0;
    }
    public function getByStudent($studentId)
    {
        $sql = "SELECT a.*, i.title, i.location, i.deadline, cp.company_name
                FROM applications a
                JOIN internships i ON a.internship_id = i.internship_id
                JOIN company_profiles cp ON i.company_id = cp.company_id
                WHERE a.student_id = :student_id
                ORDER BY a.applied_at DESC";

        return $this->fetchAll($sql, [':student_id' => $studentId]);
    }
    public function getByInternship($internshipId)
    {
        $sql = "SELECT a.*, sp.university, sp.department, sp.skills, u.name, u.email
                FROM applications a
                JOIN student_profiles sp ON a.student_id = sp.student_id
                JOIN users u ON sp.user_id = u.user_id
                WHERE a.internship_id = :internship_id
                ORDER BY a.applied_at DESC";

        return $this->fetchAll($sql, [':internship_id' => $internshipId]);
    }
    public function getByCompany($companyId)
    {
        $sql = "SELECT a.*, i.title as internship_title, sp.university, sp.department, u.name, u.email
                FROM applications a
                JOIN internships i ON a.internship_id = i.internship_id
                JOIN student_profiles sp ON a.student_id = sp.student_id
                JOIN users u ON sp.user_id = u.user_id
                WHERE i.company_id = :company_id
                ORDER BY a.applied_at DESC";

        return $this->fetchAll($sql, [':company_id' => $companyId]);
    }
    public function updateStatus($applicationId, $status)
    {
        $sql = "UPDATE applications SET status = :status 
                WHERE application_id = :application_id";

        return $this->query($sql, [
            ':status' => $status,
            ':application_id' => $applicationId
        ]);
    }
    public function getById($applicationId)
    {
        $sql = "SELECT a.*, i.title, i.location, cp.company_name, sp.university, sp.department, u.name, u.email
                FROM applications a
                JOIN internships i ON a.internship_id = i.internship_id
                JOIN company_profiles cp ON i.company_id = cp.company_id
                JOIN student_profiles sp ON a.student_id = sp.student_id
                JOIN users u ON sp.user_id = u.user_id
                WHERE a.application_id = :application_id";

        return $this->fetchOne($sql, [':application_id' => $applicationId]);
    }
    public function getAll()
    {
        $sql = "SELECT a.*, i.title, cp.company_name, u.name as student_name
                FROM applications a
                JOIN internships i ON a.internship_id = i.internship_id
                JOIN company_profiles cp ON i.company_id = cp.company_id
                JOIN student_profiles sp ON a.student_id = sp.student_id
                JOIN users u ON sp.user_id = u.user_id
                ORDER BY a.applied_at DESC";

        return $this->fetchAll($sql);
    }
    public function delete($applicationId)
    {
        $sql = "DELETE FROM applications WHERE application_id = :application_id";
        return $this->query($sql, [':application_id' => $applicationId]);
    }
    public function countByStatus($studentId, $status)
    {
        $sql = "SELECT COUNT(*) as count FROM applications 
                WHERE student_id = :student_id AND status = :status";

        $result = $this->fetchOne($sql, [
            ':student_id' => $studentId,
            ':status' => $status
        ]);

        return $result['count'];
    }
}

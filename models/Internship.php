<?php
class Internship extends Model
{
    public function create($companyId, $data)
    {
        $sql = "INSERT INTO internships (company_id, title, description, requirements, location, deadline, status) 
                VALUES (:company_id, :title, :description, :requirements, :location, :deadline, :status)";

        $params = [
            ':company_id' => $companyId,
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':requirements' => $data['requirements'] ?? null,
            ':location' => $data['location'],
            ':deadline' => $data['deadline'],
            ':status' => 'pending'
        ];

        if ($this->query($sql, $params)) {
            return $this->lastInsertId();
        }

        return false;
    }
    public function getById($internshipId)
    {
        $sql = "SELECT i.*, cp.company_name, cp.location as company_location, cp.website
                FROM internships i
                JOIN company_profiles cp ON i.company_id = cp.company_id
                WHERE i.internship_id = :internship_id";

        return $this->fetchOne($sql, [':internship_id' => $internshipId]);
    }
    public function getAllApproved()
    {
        $sql = "SELECT i.*, cp.company_name
                FROM internships i
                JOIN company_profiles cp ON i.company_id = cp.company_id
                WHERE i.status = 'approved' AND i.deadline >= CURDATE()
                ORDER BY i.created_at DESC";

        return $this->fetchAll($sql);
    }
    public function getLatest($limit = 6)
    {
        $sql = "SELECT i.*, cp.company_name
                FROM internships i
                JOIN company_profiles cp ON i.company_id = cp.company_id
                WHERE i.status = 'approved' AND i.deadline >= CURDATE()
                ORDER BY i.created_at DESC
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    public function getByCompany($companyId)
    {
        $sql = "SELECT * FROM internships 
                WHERE company_id = :company_id 
                ORDER BY created_at DESC";

        return $this->fetchAll($sql, [':company_id' => $companyId]);
    }
    public function getPending()
    {
        $sql = "SELECT i.*, cp.company_name
                FROM internships i
                JOIN company_profiles cp ON i.company_id = cp.company_id
                WHERE i.status = 'pending'
                ORDER BY i.created_at DESC";

        return $this->fetchAll($sql);
    }
    public function updateStatus($internshipId, $status)
    {
        $sql = "UPDATE internships SET status = :status 
                WHERE internship_id = :internship_id";

        return $this->query($sql, [
            ':status' => $status,
            ':internship_id' => $internshipId
        ]);
    }
    public function update($internshipId, $data)
    {
        $sql = "UPDATE internships 
                SET title = :title,
                    description = :description,
                    requirements = :requirements,
                    location = :location,
                    deadline = :deadline
                WHERE internship_id = :internship_id";

        $params = [
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':requirements' => $data['requirements'],
            ':location' => $data['location'],
            ':deadline' => $data['deadline'],
            ':internship_id' => $internshipId
        ];

        return $this->query($sql, $params);
    }
    public function delete($internshipId)
    {
        $sql = "DELETE FROM internships WHERE internship_id = :internship_id";
        return $this->query($sql, [':internship_id' => $internshipId]);
    }
    public function getAll()
    {
        $sql = "SELECT i.*, cp.company_name
                FROM internships i
                JOIN company_profiles cp ON i.company_id = cp.company_id
                ORDER BY i.created_at DESC";

        return $this->fetchAll($sql);
    }
    public function search($keyword)
    {
        $sql = "SELECT i.*, cp.company_name
                FROM internships i
                JOIN company_profiles cp ON i.company_id = cp.company_id
                WHERE i.status = 'approved' 
                AND i.deadline >= CURDATE()
                AND (i.title LIKE :keyword 
                     OR i.description LIKE :keyword 
                     OR i.location LIKE :keyword
                     OR cp.company_name LIKE :keyword)
                ORDER BY i.created_at DESC";

        return $this->fetchAll($sql, [':keyword' => '%' . $keyword . '%']);
    }
}

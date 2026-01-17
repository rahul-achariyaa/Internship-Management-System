<?php
class CompanyProfile extends Model
{
    public function create($userId, $data)
    {
        $sql = "INSERT INTO company_profiles (user_id, company_name, description, website, location) 
                VALUES (:user_id, :company_name, :description, :website, :location)";

        $params = [
            ':user_id' => $userId,
            ':company_name' => $data['company_name'] ?? '',
            ':description' => $data['description'] ?? null,
            ':website' => $data['website'] ?? null,
            ':location' => $data['location'] ?? null
        ];

        if ($this->query($sql, $params)) {
            return $this->lastInsertId();
        }

        return false;
    }
    public function getByUserId($userId)
    {
        $sql = "SELECT cp.*, u.name, u.email, u.status
                FROM company_profiles cp
                JOIN users u ON cp.user_id = u.user_id
                WHERE cp.user_id = :user_id";

        return $this->fetchOne($sql, [':user_id' => $userId]);
    }
    public function getById($companyId)
    {
        $sql = "SELECT cp.*, u.name, u.email, u.status
                FROM company_profiles cp
                JOIN users u ON cp.user_id = u.user_id
                WHERE cp.company_id = :company_id";

        return $this->fetchOne($sql, [':company_id' => $companyId]);
    }
    public function update($companyId, $data)
    {
        $sql = "UPDATE company_profiles 
                SET company_name = :company_name,
                    description = :description,
                    website = :website,
                    location = :location
                WHERE company_id = :company_id";

        $params = [
            ':company_name' => $data['company_name'],
            ':description' => $data['description'],
            ':website' => $data['website'],
            ':location' => $data['location'],
            ':company_id' => $companyId
        ];

        return $this->query($sql, $params);
    }
    public function verify($companyId)
    {
        $sql = "UPDATE company_profiles SET is_verified = TRUE 
                WHERE company_id = :company_id";

        return $this->query($sql, [':company_id' => $companyId]);
    }
    public function getAll()
    {
        $sql = "SELECT cp.*, u.name, u.email, u.status
                FROM company_profiles cp
                JOIN users u ON cp.user_id = u.user_id
                ORDER BY cp.created_at DESC";

        return $this->fetchAll($sql);
    }
    public function getPending()
    {
        $sql = "SELECT cp.*, u.name, u.email
                FROM company_profiles cp
                JOIN users u ON cp.user_id = u.user_id
                WHERE u.status = 'pending'
                ORDER BY cp.created_at DESC";

        return $this->fetchAll($sql);
    }
}

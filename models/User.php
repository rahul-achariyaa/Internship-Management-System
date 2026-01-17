<?php
class User extends Model
{
    public function create($data)
    {
        $sql = "INSERT INTO users (name, email, password_hash, role, status) 
                VALUES (:name, :email, :password_hash, :role, :status)";

        $params = [
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':role' => $data['role'],
            ':status' => $data['status'] ?? 'pending'
        ];

        if ($this->query($sql, $params)) {
            return $this->lastInsertId();
        }

        return false;
    }
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        return $this->fetchOne($sql, [':email' => $email]);
    }
    public function findById($id)
    {
        $sql = "SELECT * FROM users WHERE user_id = :id";
        return $this->fetchOne($sql, [':id' => $id]);
    }
    public function verify($email, $password)
    {
        $user = $this->findByEmail($email);

        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }

        return false;
    }
    public function updatePassword($userId, $newPassword)
    {
        $sql = "UPDATE users SET password_hash = :password_hash, updated_at = NOW() 
                WHERE user_id = :user_id";

        $params = [
            ':password_hash' => password_hash($newPassword, PASSWORD_DEFAULT),
            ':user_id' => $userId
        ];

        return $this->query($sql, $params);
    }
    public function updateStatus($userId, $status)
    {
        $sql = "UPDATE users SET status = :status, updated_at = NOW() 
                WHERE user_id = :user_id";

        return $this->query($sql, [
            ':status' => $status,
            ':user_id' => $userId
        ]);
    }
    public function updateProfile($userId, $data)
    {
        $sql = "UPDATE users SET name = :name, updated_at = NOW() 
                WHERE user_id = :user_id";

        return $this->query($sql, [
            ':name' => $data['name'],
            ':user_id' => $userId
        ]);
    }
    public function getAllByRole($role)
    {
        $sql = "SELECT * FROM users WHERE role = :role ORDER BY created_at DESC";
        return $this->fetchAll($sql, [':role' => $role]);
    }
    public function getAll()
    {
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        return $this->fetchAll($sql);
    }
    public function delete($userId)
    {
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        return $this->query($sql, [':user_id' => $userId]);
    }
    public function emailExists($email)
    {
        $user = $this->findByEmail($email);
        return $user !== null && $user !== false;
    }
}

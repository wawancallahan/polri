<?php

namespace Model;

use Model\DatabaseModel;
use Exception;

class User extends DatabaseModel {

    public function create ($data) {
        try {
            $nama = $data['nama'] ?? "";
            $username = $data['username'] ?? "";
            $password = $data['password'] ?? "";
            $role = $data['role'] ?? "";
    
            if ($nama !== "" && $username !== "" && $password !== "" && $role !== "") {
    
                $query = "INSERT INTO users VALUES(null, ?, ?, ?, ?)";
                
                $statement = $this->pdo->prepare($query);
                
                $execute = $statement->execute([
                    $nama,
                    $username,
                    $password,
                    $role
                ]);

                return $execute ? $this->pdo->lastInsertId() : 0;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            return 0;
        }    
    }

    public function update ($data, $id) {
        try {
            $nama = $data['nama'] ?? "";
            $username = $data['username'] ?? "";
            $password = $data['password'] ?? "";
    
            if ($nama !== "" && $username !== "") {

                if ($password !== "") {
                    $query = "UPDATE users SET nama = ?, username = ?, password = ? WHERE id = ?";
                
                    $statement = $this->pdo->prepare($query);
                    
                    $execute = $statement->execute([
                        $nama,
                        $username,
                        $password,
                        $id
                    ]);
    
                    return $execute ? 'success' : 'fail';
                } else {
                    $query = "UPDATE users SET nama = ?, username = ? WHERE id = ?";
                
                    $statement = $this->pdo->prepare($query);
                    
                    $execute = $statement->execute([
                        $nama,
                        $username,
                        $id
                    ]);
    
                    return $execute ? 'success' : 'fail';
                }
            } else {
                return 'fail';
            }
        } catch (Exception $e) {
            return 'fail';
        }    
    }

    public function find($username, $password)
    {
        try {
            if ($username !== "" && $password !== "") {

                $password = md5($password);
    
                $query = "SELECT * FROM users WHERE username = ? AND password = ?";
                
                $statement = $this->pdo->prepare($query);
                
                $statement->execute([
                    $username,
                    $password
                ]);

                if ($statement->rowCount() <= 0) {
                    return null;
                }

                return $statement->fetch(\PDO::FETCH_ASSOC);
            } else {
                
                return null;
               
            }
        } catch (Exception $e) {
            return null;
        } 
    }

    public function findById($id)
    {
        try {
            $query = "SELECT * FROM users WHERE id = ?";
            
            $statement = $this->pdo->prepare($query);
            
            $statement->execute([
                $id
            ]);

            if ($statement->rowCount() <= 0) {
                return null;
            }

            return $statement->fetch(\PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return null;
        } 
    }

    public function findCountUsername($username, $id = null)
    {
        try {
            if ($username !== "") {
    
                $query = "SELECT * FROM users WHERE username = ?";

                if ($id !== null) {
                    $query .= " AND id NOT IN ('$id')";
                }
                
                $statement = $this->pdo->prepare($query);
                
                $statement->execute([
                    $username
                ]);

                return $statement->rowCount();
            } else {
                return null;
               
            }
        } catch (Exception $e) {
            return null;
        } 
    }

    public function delete($id)
    {
        try {
            if ($id !== "") {
    
                $query = "DELETE FROM users WHERE id = ?";
                
                $statement = $this->pdo->prepare($query);
                
                $execute = $statement->execute([
                    $id,
                ]);

                return $execute;
            } else {
                return false;
               
            }
        } catch (\Exception $e) {
            return false;
        } 
    }
}
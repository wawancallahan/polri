<?php

namespace Model;

use Model\DatabaseModel;

class Anggota extends DatabaseModel {
    public function index ()
    {
        $query = "SELECT * FROM anggota";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function create ($data)
    {
        try {
            $nama = $data['nama'] ?? "";
            $pangkat = $data['pangkat'] ?? "";
            $kode = $data['kode'] ?? "";
            $user_id = $data['user_id'] ?? "";
    
            if ($nama !== "" && $pangkat !== "" && $kode !== "" && $user_id !== "") {
    
                $query = "INSERT INTO anggota VALUES(null, ?, ?, ?, ?)";
                
                $statement = $this->pdo->prepare($query);
                
                $execute = $statement->execute([
                    $pangkat,
                    $nama,
                    $kode,
                    $user_id
                ]);

                return $execute ? 'success' : 'fail';
            } else {
                return 'validation';
               
            }
        } catch (Exception $e) {
            return 'fail';
        }    
    }

    public function find($id)
    {
        try {
            if ($id !== "") {
    
                $query = "SELECT * FROM anggota WHERE id = ?";
                
                $statement = $this->pdo->prepare($query);
                
                $statement->execute([
                    $id,
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

    public function findByUserId($id)
    {
        try {
            if ($id !== "") {
    
                $query = "SELECT * FROM anggota WHERE user_id = ?";
                
                $statement = $this->pdo->prepare($query);
                
                $statement->execute([
                    $id,
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

    public function update ($data, $id)
    {
        try {
            $nama = $data['nama'] ?? "";
            $pangkat = $data['pangkat'] ?? "";
            $kode = $data['kode'] ?? "";

            if ($nama !== "" && $pangkat !== "" && $kode !== "") {
                $query = "UPDATE anggota SET nama = ?, pangkat = ?, kode = ? WHERE user_id = ?";
                
                $statement = $this->pdo->prepare($query);
                
                $execute = $statement->execute([
                    $nama,
                    $pangkat,
                    $kode,
                    $id
                ]);

                return $execute ? 'success' : 'fail';
            } else {
                return 'validation';
               
            }
        } catch (\Exception $e) {
            return 'fail';
        }    
    }

    public function delete($id)
    {
        try {
            if ($id !== "") {
    
                $query = "DELETE FROM anggota WHERE id = ?";
                
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

    public function deleteByUserId($id)
    {
        try {
            if ($id !== "") {
    
                $query = "DELETE FROM anggota WHERE user_id = ?";
                
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
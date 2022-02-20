<?php

namespace Model;

use Model\DatabaseModel;

class Regu extends DatabaseModel {
    public function index ()
    {
        $query = "SELECT * FROM regu";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function indexByKetua ($anggota_id) {
        $query = "SELECT * FROM regu WHERE EXISTS (SELECT * FROM regu_anggota WHERE regu_anggota.anggota_id = ? AND regu_anggota.type = 1)";
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            $anggota_id
        ]);

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function create ($data)
    {
        try {
            $nama = $data['nama'] ?? "";
            $kode = $data['kode'] ?? "";
    
            if ($nama !== "" && $kode !== "") {
    
                $query = "INSERT INTO regu VALUES(null, ?, ?)";
                
                $statement = $this->pdo->prepare($query);
                
                $execute = $statement->execute([
                    $kode,
                    $nama
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
    
                $query = "SELECT * FROM regu WHERE id = ?";
                
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
            $nama = $data['nama'] ?? null;
            $kode = $data['kode'] ?? null;

            if ($nama !== "" && $kode !== "") {
    
                $query = "UPDATE regu SET kode = ?, nama = ? WHERE id = ?";
                
                $statement = $this->pdo->prepare($query);
                
                $execute = $statement->execute([
                    $kode,
                    $nama,
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
    
                $query = "DELETE FROM regu WHERE id = ?";
                
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
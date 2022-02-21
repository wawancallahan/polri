<?php

namespace Model;

use Model\DatabaseModel;

class ReguAnggota extends DatabaseModel {
    public function index ()
    {
        $query = "SELECT * FROM regu_anggota";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function indexByReguId ($id)
    {
        $query = "SELECT regu_anggota.id AS id, regu_anggota.type AS type, anggota.nama AS nama, anggota.kode AS kode, anggota.pangkat AS pangkat " . 
                 " FROM regu_anggota LEFT JOIN anggota ON anggota.id = regu_anggota.anggota_id WHERE regu_id = ? ORDER BY regu_anggota.type DESC";
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            $id
        ]);

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function findKetuaByReguId ($id) {
        try {
            if ($id !== "") {
    
                $query = "SELECT * FROM regu_anggota WHERE type = 1 AND regu_id = ?";
                
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

    public function findCountKetua ($id) {
        try {
            if ($id !== "") {
    
                $query = "SELECT * FROM regu_anggota WHERE type = 1 AND regu_id = ?";
                
                $statement = $this->pdo->prepare($query);
                
                $statement->execute([
                    $id,
                ]);

                return $statement->rowCount();
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        } 
    }

    public function create ($data)
    {
        try {
            $anggota_id = $data['anggota_id'] ?? "";
            $regu_id = $data['regu_id'] ?? "";
            $type = $data['type'] ?? "";
    
            if ($anggota_id !== "" && $regu_id !== "" && $type !== "") {
    
                $query = "INSERT INTO regu_anggota VALUES(null, ?, ?, ?)";
                
                $statement = $this->pdo->prepare($query);
                
                $execute = $statement->execute([
                    $regu_id,
                    $anggota_id,
                    $type
                ]);

                return $execute ? 'success' : 'fail';
            } else {
                return 'validation';
               
            }
        } catch (Exception $e) {
            return 'fail';
        }    
    }

    public function delete($id)
    {
        try {
            if ($id !== "") {
    
                $query = "DELETE FROM regu_anggota WHERE id = ?";
                
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

    public function deleteByAnggotaId($id) {
        try {
            if ($id !== "") {
    
                $query = "DELETE FROM regu_anggota WHERE anggota_id = ?";
                
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
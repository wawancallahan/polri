<?php

namespace Model;

use Model\DatabaseModel;

class TemaLaporan extends DatabaseModel {
    public function index ()
    {
        $query = "SELECT * FROM tema_laporan";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function indexBySuratPerintah ($id) {
        $query = "SELECT * FROM tema_laporan WHERE surat_perintah_id = ?";
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            $id
        ]);

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function create ($data)
    {
        try {
            $surat_perintah_id = $data['surat_perintah_id'] ?? "";
            $nama = $data['nama'] ?? "";
            $tanggal = $data['tanggal'] ?? "";
    
            if ($surat_perintah_id !== "" && $nama !== "" && $tanggal !== "") {
    
                $query = "INSERT INTO tema_laporan VALUES(null, ?, ?, ?)";
                
                $statement = $this->pdo->prepare($query);
                
                $execute = $statement->execute([
                    $surat_perintah_id,
                    $nama,
                    $tanggal
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
    
                $query = "SELECT * FROM tema_laporan WHERE id = ?";
                
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
            $tanggal = $data['tanggal'] ?? null;

            if ($nama !== "" && $tanggal !== "") {
    
                $query = "UPDATE tema_laporan SET nama = ?, tanggal = ? WHERE id = ?";
                
                $statement = $this->pdo->prepare($query);
                
                $execute = $statement->execute([
                    $nama,
                    $tanggal,
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
    
                $query = "DELETE FROM tema_laporan WHERE id = ?";
                
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
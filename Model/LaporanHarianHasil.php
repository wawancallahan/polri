<?php

namespace Model;

use Model\DatabaseModel;

class LaporanHarianHasil extends DatabaseModel {
    public function find($id)
    {
        try {
            if ($id !== "") {
    
                $query = "SELECT * FROM laporan_harian_hasil WHERE id = ?";
                
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

    public function findBySuratPerintah($id)
    {
        try {
            if ($id !== "") {
    
                $query = "SELECT * FROM laporan_harian_hasil WHERE surat_perintah_id = ?";
                
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

    public function initCreate ($data)
    {
        try {
            $surat_perintah_id = $data['surat_perintah_id'] ?? "";
    
            $query = "INSERT INTO laporan_harian_hasil (surat_perintah_id) VALUES(?)";
            
            $statement = $this->pdo->prepare($query);
            
            $execute = $statement->execute([
                $surat_perintah_id
            ]);

            return $execute ? 'success' : 'fail';
        } catch (Exception $e) {
            return 'fail';
        }    
    }

    public function update ($data, $id)
    {
        try {
            $nama = $data['nama'] ?? null;

            if ($nama !== "") {
    
                $query = "UPDATE regu SET nama = ? WHERE id = ?";
                
                $statement = $this->pdo->prepare($query);
                
                $execute = $statement->execute([
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

    public function patch ($data, $id)
    {
        try {
            $kolom = [];
            $values = [];

            foreach ($data as $key => $value) {
                $kolom[] = $key . ' = ? ';
                $values[] = $value;
            }

            $values[] = $id;
            
            $kolomUpdate = implode(', ', $kolom);

            $query = "UPDATE laporan_harian_hasil SET $kolomUpdate WHERE id = ?";
            
            $statement = $this->pdo->prepare($query);
            
            $execute = $statement->execute($values);

            return $execute ? 'success' : 'fail';
        } catch (\Exception $e) {
            return 'fail';
        }    
    }

    public function delete($id)
    {
        try {
            if ($id !== "") {
    
                $query = "DELETE FROM laporan_harian_hasil WHERE id = ?";
                
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

    public function deleteBySuratPerintahId($id)
    {
        try {
            if ($id !== "") {
    
                $query = "DELETE FROM laporan_harian_hasil WHERE surat_perintah_id = ?";
                
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
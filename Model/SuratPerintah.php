<?php

namespace Model;

use Model\DatabaseModel;

class SuratPerintah extends DatabaseModel {
    public function index ()
    {
        $query = "SELECT * FROM surat_perintah";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function indexByReguId ($id)
    {
        $query = "SELECT * FROM surat_perintah WHERE regu_id = ?";
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
            $regu_id = $data['regu_id'] ?? "";
            $nomor = $data['nomor'] ?? "";
            $tanggal = $data['tanggal'] ?? "";
            $dikeluarkan_di = $data['dikeluarkan_di'] ?? "";
    
            if ($regu_id !== "" && $nomor !== "" && $tanggal !== "" && $dikeluarkan_di !== "") {
    
                $query = "INSERT INTO surat_perintah (regu_id, nomor, tanggal, dikeluarkan_di) VALUES(?, ?, ?, ?)";
                
                $statement = $this->pdo->prepare($query);
                
                $execute = $statement->execute([
                    $regu_id,
                    $nomor,
                    $tanggal,
                    $dikeluarkan_di
                ]);

                if (!$execute) return 'fail';

                $id = $this->pdo->lastInsertId();

                $query = "INSERT INTO laporan_harian_hasil (surat_perintah_id) VALUES(?)";
            
                $statement = $this->pdo->prepare($query);
                
                $execute = $statement->execute([
                    $id
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
    
                $query = "SELECT * FROM surat_perintah WHERE id = ?";
                
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
            $nomor = $data['nomor'] ?? null;
            $tanggal = $data['tanggal'] ?? null;

            if ($nomor !== "" && $tanggal !== "") {
    
                $query = "UPDATE surat_perintah SET nomor = ?, tanggal = ? WHERE id = ?";
                
                $statement = $this->pdo->prepare($query);
                
                $execute = $statement->execute([
                    $nomor,
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

            $query = "UPDATE surat_perintah SET $kolomUpdate WHERE id = ?";
            
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
    
                $query = "DELETE FROM surat_perintah WHERE id = ?";
                
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

    public function deleteByReguId($id)
    {
        try {
            if ($id !== "") {
    
                $query = "DELETE FROM surat_perintah WHERE regu_id = ?";
                
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
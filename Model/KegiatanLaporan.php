<?php

namespace Model;

use Model\DatabaseModel;

class KegiatanLaporan extends DatabaseModel {
    public function index ()
    {
        $query = "SELECT * FROM kegiatan_laporan";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function indexByTemaLaporan ($id) {
        $query = "SELECT * FROM kegiatan_laporan WHERE tema_laporan_id = ?";
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            $id
        ]);

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function find($id)
    {
        try {
            if ($id !== "") {
    
                $query = "SELECT * FROM kegiatan_laporan WHERE id = ?";
                
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

    public function create ($data)
    {
        try {
            $tema_laporan_id = $data['tema_laporan_id'] ?? "";
            $nama = $data['nama'] ?? "";
            $person = $data['person'] ?? "";
            $sasaran = $data['sasaran'] ?? "";
            $hasil_kegiatan = $data['hasil_kegiatan'] ?? "";
            $dokumentasi = $data['dokumentasi'] ?? "";
    
            $query = "INSERT INTO kegiatan_laporan VALUES(null, ?, ?, ?, ?, ?, ?)";
            
            $statement = $this->pdo->prepare($query);
            
            $execute = $statement->execute([
                $tema_laporan_id,
                $nama,
                $person,
                $sasaran,
                $hasil_kegiatan,
                $dokumentasi
            ]);

            return $execute ? 'success' : 'fail';
        } catch (Exception $e) {
            return 'fail';
        }    
    }

    public function update ($data, $id)
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

            $query = "UPDATE kegiatan_laporan SET $kolomUpdate WHERE id = ?";
            
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
    
                $query = "DELETE FROM kegiatan_laporan WHERE id = ?";
                
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

    public function deleteByTemaLaporan($id)
    {
        try {
            if ($id !== "") {
    
                $query = "DELETE FROM kegiatan_laporan WHERE tema_laporan_id = ?";
                
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
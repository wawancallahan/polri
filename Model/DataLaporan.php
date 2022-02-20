<?php

namespace Model;

use Model\DatabaseModel;

class DataLaporan extends DatabaseModel {
    public function index ()
    {
        $query = "SELECT * FROM data_laporan";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function indexByLaporan ($laporan_id, $model, $jenis)
    {
        $query = "SELECT * FROM data_laporan WHERE laporan_id = ? AND model = ? AND jenis = ?";
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            $laporan_id,
            $model,
            $jenis
        ]);

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function create ($data)
    {
        try {
            $id = $data['id'] ?? "";
            $model = $data['model'] ?? "";
            $jenis = $data['jenis'] ?? "";
            $isi = $data['isi'] ?? "";
    
            if ($id !== "" && $model !== "" && $jenis !== "" && $isi !== "") {
    
                $query = "INSERT INTO data_laporan VALUES(null, ?, ?, ?, ?)";
                
                $statement = $this->pdo->prepare($query);
                
                $execute = $statement->execute([
                    $id,
                    $model,
                    $jenis,
                    $isi
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
    
                $query = "DELETE FROM data_laporan WHERE id = ?";
                
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
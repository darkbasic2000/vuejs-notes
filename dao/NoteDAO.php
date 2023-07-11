<?php

    require_once("ConnectionSingleton.php");
    require_once("../models/Note.php");

    class NoteDAO {

        public function list() {

            $list = array();
            try {
                $connection = ConnectionSingleton::getInstance();                
                $sql = "SELECT * FROM notes ORDER BY id DESC LIMIT 30";
                $rs = $connection->prepare($sql);
                $rs->execute();                
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $note = new Note();
                    $note->setId($row->id);                
                    $note->setAnnotations($row->annotations);
                    array_push($list, $note);
                }
                return $list;
            } 
            catch(PDOException $e) {            
                $e->getMessage();
            }

        }

        public function save(Note $note) {
        
            try {
                $connection = ConnectionSingleton::getInstance();
                $sql = "INSERT INTO notes (annotations) VALUES (:annotations)";
                $rs = $connection->prepare($sql);
                $rs->bindValue(":annotations", $note->getAnnotations());
                $rs->execute();
                if($rs->rowCount() > 0) {
                    return true;
                }
            } 
            catch (PDOException $e) {
                $e->getMessage();
            }
            return false;

        }

        public function delete($id) {

            try {
                $connection = ConnectionSingleton::getInstance();
                $sql = "DELETE FROM notes WHERE id = :id";
                $rs = $connection->prepare($sql);
                $rs->bindValue(":id", $id);
                $rs->execute();
                if($rs->rowCount() > 0) {
                    return true;
                }
            } 
            catch (PDOException $e) {
                $e->getMessage();
            }
            return false;
            
        }

    }
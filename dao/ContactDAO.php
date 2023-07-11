<?php

    require_once("ConnectionSingleton.php");
    require_once("../models/Contact.php");

    class ContactDAO {

        public function list($quantity, $search) {

            $list = array();            
            try {
                $connection = ConnectionSingleton::getInstance();
                if($search == "null") {
                    $sql = "SELECT * FROM contacts ORDER BY id DESC LIMIT :quantity";
                    $rs = $connection->prepare($sql);
                    $rs->bindValue(":quantity", (int)$quantity, PDO::PARAM_INT);
                }
                else {
                    $sql = "SELECT * FROM contacts WHERE username LIKE :username ORDER BY id DESC LIMIT :quantity";
                    $rs = $connection->prepare($sql);
                    $rs->bindValue(":username", "%".$search."%");
                    $rs->bindValue(":quantity", (int)$quantity, PDO::PARAM_INT);
                }
                $rs->execute();                
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $contact = new Contact();
                    $contact->setId($row->id);                
                    $contact->setUsername($row->username);
                    $contact->setPhone($row->phone);
                    $contact->setEmail($row->email);
                    $contact->setPicture($row->picture);
                    array_push($list, $contact);
                }
                return $list;
            } 
            catch(PDOException $e) {            
                $e->getMessage();
            }

        }

        public function save(Contact $contact) {
        
            try {
                $connection = ConnectionSingleton::getInstance();
                $sql = "INSERT INTO contacts (username, phone, email, picture) 
                       VALUES (:username, :phone, :email, :picture)";
                $rs = $connection->prepare($sql);
                $rs->bindValue(":username", $contact->getUsername());
                $rs->bindValue(":phone", $contact->getPhone());
                $rs->bindValue(":email", $contact->getEmail());
                $rs->bindValue(":picture", $contact->getPicture());
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

        public function edit(Contact $contact) {
        
            try {
                $connection = ConnectionSingleton::getInstance();
                if($contact->getPicture() === null) {
                    $sql = "UPDATE contacts SET username = :username, phone = :phone, email = :email WHERE id = :id";
                    $rs = $connection->prepare($sql);
                    $rs->bindValue(":username", $contact->getUsername());
                    $rs->bindValue(":phone", $contact->getPhone());
                    $rs->bindValue(":email", $contact->getEmail());                    
                    $rs->bindValue(":id", $contact->getId());
                    $rs->execute();
                    return true;
                }
                else {
                    $sql = "UPDATE contacts SET username = :username, phone = :phone, email = :email, 
                        picture = :picture WHERE id = :id";
                    $rs = $connection->prepare($sql);
                    $rs->bindValue(":username", $contact->getUsername());
                    $rs->bindValue(":phone", $contact->getPhone());
                    $rs->bindValue(":email", $contact->getEmail());
                    $rs->bindValue(":picture", $contact->getPicture());
                    $rs->bindValue(":id", $contact->getId());                
                    $rs->execute();
                    return true; 
                }                               
            } 
            catch (PDOException $e) {
                $e->getMessage();
                return false;
            }

        }

        public function delete($id) {

            try {
                $connection = ConnectionSingleton::getInstance();
                $sql = "DELETE FROM contacts WHERE id = :id";
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
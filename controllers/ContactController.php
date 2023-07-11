<?php

    header("Content-type: application/json");

    require_once("../models/Contact.php");
    require_once("../dao/ContactDAO.php");

    $query = filter_input(INPUT_POST, "query");

    if($query == "list") {
        getList();
    }
    else if($query == "save") {
        save();
    }
    else if($query == "edit") {
        edit();
    }
    else if($query == "delete") {
        delete();
    }

    function save() {

        $username = filter_input(INPUT_POST, trim("username"));
        $phone = filter_input(INPUT_POST, trim("phone"));
        $email = filter_input(INPUT_POST, trim("email"));                
        $contact = new Contact();
        if(!empty($_FILES['picture']['tmp_name']) && $_FILES['picture']['size'] < 1000000) {
            $allowed = array('image/jpeg', 'image/jpg', 'image/png');
            if(in_array($_FILES['picture']['type'], $allowed)) {
                $newname = md5(time().rand(0,9999));
                if($_FILES['picture']['type'] == 'image/png') {
                    $newname .= '.png';
                }
                else {
                    $newname .= '.jpg';
		        }
                $contact->setPicture($newname);
                move_uploaded_file($_FILES['picture']['tmp_name'], '../pictures/'.$newname);
            }
        }
        else {
            $contact->setPicture("");
        }
        $contactDAO = new ContactDAO();        
        $contact->setUsername(strtoupper($username));
        $contact->setPhone($phone);
        $contact->setEmail(strtolower($email));                
        $json = $contactDAO->save($contact);
        echo json_encode($json);
        
    }

    function getList($quantity = 1) {

        $quantity = filter_input(INPUT_POST, trim("quantity"));
        $search = filter_input(INPUT_POST, trim("search"));        
        $contactDAO = new ContactDAO();        
        echo json_encode($contactDAO->list($quantity, $search));
        
    }
    
    function edit() {

        $id = filter_input(INPUT_POST, trim("id"));
        $username = filter_input(INPUT_POST, trim("username"));
        $phone = filter_input(INPUT_POST, trim("phone"));
        $email = filter_input(INPUT_POST, trim("email"));                
        $contact = new Contact();
        if(!empty($_FILES['picture']['tmp_name']) && $_FILES['picture']['size'] < 1000000) {
            $allowed = array('image/jpeg', 'image/jpg', 'image/png');
            if(in_array($_FILES['picture']['type'], $allowed)) {
                $newname = md5(time().rand(0,9999));
                if($_FILES['picture']['type'] == 'image/png') {
                    $newname .= '.png';
                }
                else {
                    $newname .= '.jpg';
		        }
                $contact->setPicture($newname);
                move_uploaded_file($_FILES['picture']['tmp_name'], '../pictures/'.$newname);
            }
        }
        else {
            $contact->setPicture(null);
        }
        $contactDAO = new ContactDAO();
        $contact->setId($id);
        $contact->setUsername(strtoupper($username));
        $contact->setPhone($phone);
        $contact->setEmail(strtolower($email));                
        $json = $contactDAO->edit($contact);
        echo json_encode($json);
        
    }
    
    function delete() {        
        
        $id = filter_input(INPUT_POST, trim("id"));
        $picture = filter_input(INPUT_POST, trim("picture"));
        $contactDAO = new ContactDAO();        
        if($contactDAO->delete($id)) {
            if($picture != "") {
                unlink('../pictures/'.$picture);
            }            
            echo json_encode(true);
        }
        else {
            echo json_encode(false);
        }
        
    }
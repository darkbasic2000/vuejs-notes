<?php

    header("Content-type: application/json");

    require_once("../models/Note.php");
    require_once("../dao/NoteDAO.php");

    $query = filter_input(INPUT_POST, "query");

    if($query == "list") {
        getList();
    }
    else if($query == "save") {
        save();
    }
    else if($query == "delete") {
        delete();
    }    

    function save() {      
        
        $annotations = filter_input(INPUT_POST, trim("annotations"));
        $note = new Note();
        $note->setAnnotations($annotations);
        $noteDAO = new NoteDAO();        
        $json = $noteDAO->save($note);
        echo json_encode($json);
        
    }

    function getList() {

        $noteDAO = new NoteDAO();        
        echo json_encode($noteDAO->list());
        
    }
    
    function delete() {        
        
        $id = filter_input(INPUT_POST, trim("id"));        
        $noteDAO = new NoteDAO();
        if($noteDAO->delete($id)) {            
            echo json_encode(true);
        }
        else {
            echo json_encode(false);
        }
        
    }
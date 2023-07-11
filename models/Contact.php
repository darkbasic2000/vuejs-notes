
<?php

class Contact implements \JsonSerializable {
    
    private $id;
    private $username;    
    private $phone;
    private $email;    
    private $picture;
    
    public function jsonSerialize() : mixed {
        $vars = get_object_vars($this);
        return $vars;
    }
    
    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getPhone() {
        return $this->phone;
    }

    function getEmail() {
        return $this->email;
    }

    function getPicture() {
        return $this->picture;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setUsername($username): void {
        $this->username = $username;
    }

    function setPhone($phone): void {
        $this->phone = $phone;
    }

    function setEmail($email): void {
        $this->email = $email;
    }

    function setPicture($picture): void {
        $this->picture = $picture;
    }    
    
}

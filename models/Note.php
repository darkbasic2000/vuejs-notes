
<?php

class Note implements \JsonSerializable {
    
    private $id;
    private $annotations;
    
    public function jsonSerialize() : mixed {
        $vars = get_object_vars($this);
        return $vars;
    }
    
    function getId() {
        return $this->id;
    }

    function getAnnotations() {
        return $this->annotations;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setAnnotations($annotations): void {
        $this->annotations = $annotations;
    }

}

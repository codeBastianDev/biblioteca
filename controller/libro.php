<?php
include ('../class/helper.php');

class libro{
    private $id;
    private $libro;
    function __construct($id){
        $this->id = $id;
        $this->libro = new db('books');
    }

    public function save($value = []){
    
        $this->libro->insert([
            "titulo"=> $value['titulo'],
            "autor"=>$value['autor'],
            "editorial" => $value['editorial'],
            "anio_publicacion" => $value['anio'],
            "imagen" => $value['image'],
            "descripcion" => $value['descripcion'],
            "categoria_id" => $value['categoria'],
        ],$this->id);
    } 

    public function delete(){
        $this->libro->eliminar($this->id);
    }
}

?>
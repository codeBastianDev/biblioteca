<?php
include ('../class/helper.php');
class prestamo {

    private $libro_id;
    public $libro = [];
     // Constructor
     public function __construct($id = [],$fecha_inicio,$fecha_fin) {
        $this->libro_id = implode(',',$id); 
        $this->listado_libro();
     }

     public function listado_libro(){
        $this->libro = (new db())->dataTable("SELECT * FROM books where id in({$this->libro_id})");
     }

}

_log((new prestamo([1,2]))->libro);


?>
<?php
include ('../class/helper.php');
class prestamo {

    private $libro_id;
    public $libro = [];

    private $data;
     // Constructor
     public function __construct($id = [],$valores = []) {
        $this->data = $valores;
        $this->libro_id = implode(',',$id); 

        $this->listado_libro();
        $this->prestamo_libro(0);
        $this->add_prestamo();
     }

     public function listado_libro(){
        $this->libro = (new db())->dataTable("SELECT * FROM books where id in({$this->libro_id})");
     }

     public function prestamo_libro($estado){
         foreach ($this->libro as $libro) {
            $l = new db('books');
            $l->insert([
               "disponibilidad" => $estado
            ],$libro['id']);
         }
     }

     public function add_prestamo(){
         if(count($this->data) > 0){
            foreach ($this->libro as $libro) {
               $reservacion = new db('reservations');
               $reservacion->insert([
                "usuario_id"=>$this->data['usuario'],
                "libro_id" => $libro['id'],
                "fecha_reserva" => $this->data['reserva'],
                "fecha_expiracion" => $this->data['expiracion']
               ]);
             }
         }
       
     }

     static function fin_prestamo($id = [],$id_libro){
         foreach ($id as $value) {
            $reservacion = new db('reservations');
            $reservacion->insert([
               "estado" => 2
              ],$value);
         };
         (new prestamo($id_libro))->prestamo_libro(1);
     }

}

$valores = [
   "usuario" => 2,
   "reserva" => "2024-02-02",
   "expiracion" => "2024-04-02"
];

// ((new prestamo([1,2],$valores))->libro);
// prestamo::fin_prestamo([13,14],[1,2]);

?>
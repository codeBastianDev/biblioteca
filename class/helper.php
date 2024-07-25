<?php
class Conexion
{
    private $host = "localhost";
    private $user = "root";
    private $contrasena = "";
    private $db = "biblioteca";
    public $cnx;

    function conexion()
    {
        $this->cnx = new mysqli($this->host, $this->user, $this->contrasena, $this->db);
        if ($this->cnx->connect_error) {
            die("Error de conexion: " . $this->cnx->connect_error);
        }
    }
    function closeConexion()
    {
        $this->cnx->close();
    }
    function xd()
    {
        echo 'hola';
    }
};

class db extends conexion
{
    public $table;
    public $query;
    public $inser_id;
    public function __construct($table = '')
    {
        $this->table = $table;
    }

    function getColumn()
    {
        $this->conexion();
        $query = $this->cnx->query("SHOW COLUMNS FROM {$this->table}");
        foreach ($query->fetch_all() as $fl) {
            $columns[] =  ($fl[0]);
        }
        $this->closeConexion();
        return $columns;
    }


    function insert($data = [], $id = 0, $openNull = 0)
    {
        // if(empty($campos)){ $campos = implode(',',$this->getColumn()); }

        if ($id > 0) {
            $campos = '';
            // Para eliminar los valores que esten vacio
            foreach ($data as $indice => $valor) {
                if (empty($valor) && $openNull = 0) {
                    unset($data[$indice]);
                }
            }
            foreach ($data as $key => $value) {
                $campos .= "$key = '$value', ";
            }
            // Para eliminar la ultima coma 
            $campos = rtrim($campos, ', ');
            $this->query = "UPDATE {$this->table} SET {$campos} WHERE id = {$id}";
        } else {
            // Para eliminar los valores que esten vacio
            foreach ($data as $indice => $valor) {
                if (empty($valor)) {
                    unset($data[$indice]);
                }
            }

            $values = "'" . implode("', '", $data) . "'";
            $campos = implode(',', array_keys($data));
            $this->query = "INSERT INTO {$this->table} ({$campos}) VALUES ($values)";
        }
        $this->conexion();
        if ($this->cnx->query($this->query) === true) {
            $this->inser_id = $this->cnx->insert_id;
        } else {
            echo "Ocurrio errror " . $this->cnx->error;
        };
        $this->closeConexion();
    }

    function eliminar($id)
    {
        $this->conexion();
        $this->query = "DELETE FROM {$this->table} WHERE id = {$id}";
        if ($this->cnx->query($this->query) === TRUE) {
            echo "Datos eliminado";
        } else {
            echo "Error en la consulta " . $this->cnx->error;
        }
        $this->closeConexion();
    }

    // cargar consulta
    function cargar($id = 0, $where2 = [], $extra = '')
    {
        $campos = [];
        $wheres = '';
        $where = ($id != 0) ? "WHERE id = {$id}" : '';

        if (!empty($where2)) {
            if (!$where) {
                $wheres = 'WHERE ';
            } else {
                $wheres .= ' and ';
            }
            $wheres .= implode(' and ', $where2);
        } else {
            $wheres = '';
        }

        $this->query = $query = ("SELECT * FROM {$this->table} {$where} {$wheres} {$extra}");
    //    _log($query);
        $this->conexion();
        $result = $this->cnx->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $campos[] = $row;
            }
        }
        $this->closeConexion();
        
        return $campos;
        return (empty($campos)) ? '<h1>No hay registro</h1>' : $campos;
    }

    // Puedes crear tu consulta
    function dataTable($query)
    {
        $this->conexion();
        $result = $this->cnx->query($query);
        while ($row = $result->fetch_assoc()) {
            $campos[] = $row;
        };
        $this->closeConexion();
        return (empty($campos)) ? null : $campos;
    }


    function validar_inner($dato)
    {
        switch ($dato) {
            case 1:
                $union = "RIGHT JOIN";
                break;
            case 2:
                $union = "LEFT JOIN";
                break;

            default:
                $union = "INNER JOIN";
                break;
        }

        return $union;
    }

    function joinQuery($table = [], $inner = [], $onCondicion = [], $where = [], $campos = [], $extra = '')
    {

        $this->conexion();
        $joinQuery = '';
        if (!empty($where)) {
            $wheres = 'WHERE ';
            $wheres .= implode(' and ', $where);
        } else {
            $wheres = '';
        }

        for ($i = 0; $i <= count($table) - 1; $i++) {

            $union = $this->validar_inner($inner[$i]);

            $joinQuery .= "{$table[$i]} ON ({$onCondicion[$i]})  {$union} ";
        }
        // para eliminar las ultimas 2 palabras
        $joinQuery = preg_replace('/\b\w+\s+\w+\s*$/', '', $joinQuery);

        if (empty($campos)) {
            $campos = '*';
        } else {
            $campos = implode(', ', $campos);
        }
        $inner = $this->validar_inner($inner[0]);

        $query = "SELECT {$campos} FROM {$this->table}  {$inner}  {$joinQuery} {$wheres} {$extra}";
        // _log($query);
        $this->query = $query;
        $result = $this->cnx->query($query);
        $this->closeConexion();
        return $result;
    }
}

function _log($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function sexo($sexo)
{
    return $sexo = ($sexo == 1) ? 'Masculino' : 'Femenino';
}

// para los filtro
function getFiltro($data)
{
    $fil = [];
    foreach ($data as $key => $value) {
        if (!empty($key) && $value != 0) {
            $valor = str_replace('__', '.', $key);
            $fil[] = "{$valor} = {$value}";
        }
    }
    return $fil;
};

function subirImg($img, $ruta)
{


    $nombre_archivo = $img['name'];
    $archivo = $ruta . basename($img['name']);
    $tipo_archivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
    $rutaTemporal = $img['tmp_name'];



    if (true) {
        $size = $img['size'];
        if ($size < 5000000) {
            if ($tipo_archivo == 'jpg' || $tipo_archivo == 'png' || $tipo_archivo == 'jpeg' || $tipo_archivo == 'webp' || $tipo_archivo == 'pdf') {

                if (move_uploaded_file($rutaTemporal, $archivo)) {
                    return $nombre_archivo;
                } else {
                    return "Error en subir la imagen";
                }
            } else {
                return "No es una imagen";
            }
        } else {
            return "Archivo muy pesado";
        }
    } else {
        return 'La imagen es muy pesada mayor. Esto no es una imagen';
    }
}

class facturacion extends db
{

    private $id_perfil;
    private $id_factura;
    private $datos;


    function __construct($table, $datos = [])
    {
        parent::__construct($table);
        $this->datos = $datos;
    }

    function generar_perfil()
    {
        foreach ((new db('inscripcion i'))->joinQuery(array('anio a'), array(0), array('i.id_anio = a.id'), array("i.id_estudiante = {$this->datos['id_estudiante']}", "i.id_anio = {$this->datos['anio']}"), array('i.id')) as $fl) {
            $id_inscripcion = $fl['id'];
        }

        $id_precioInscripcion       = $this->datos['inscripcion'];
        $id_cuota                   = $this->datos['escolaridad'];
        $cantidad_cuota             = $this->datos['cuota'];
        $precioMatriculacion        = [];

        $precioMatriculacion['inscripcion']          =  $this->dataTable("SELECT * FROM producto where id = {$id_precioInscripcion} and categoria = 3");
        $precioMatriculacion['cuota']                =  $this->dataTable("SELECT * FROM producto where id = {$id_cuota} and categoria = 4");


        // Creamos el perfil de la facturas
        $perfil_factura = new db('perfil_factura');
        $perfil_factura->insert(
            array('idInscripcion' => $id_inscripcion)
        );

        // Conseguimos el id de la factuara 
        foreach ((new db('perfil_factura p'))->joinQuery(array('inscripcion i', 'anio a',), array(0, 0), array('p.idInscripcion = i.id', 'i.id_anio = a.id'), array("i.id_estudiante = {$this->datos['id_estudiante']}", "i.id_anio = {$this->datos['anio']}", "p.idInscripcion = {$id_inscripcion}"), array('p.id')) as $fl) {
            $id_factura = $fl['id'];
        }

        $this->id_perfil = $this->cargar(0, array("idInscripcion = '{$id_inscripcion}'"));

        //Creamos los insert de las cuotas en sql para ejecutarlo
        $values = $this->generarCuotas($cantidad_cuota, $this->datos, $precioMatriculacion);

        //Generamos los insert de las cuotas ejecutandolo
        foreach ($values as $data) {
            $cuota = new db('factura_detalle');
            $cuota->insert($data);
        }

        $matriculacion = new db('factura_detalle');
        $matriculacion->insert(array(
            "id_factura" => $this->id_perfil[0]['id'],
            'monto' => $precioMatriculacion['inscripcion'][0]['precio'],
            'id_producto' => $this->datos['inscripcion'],
            "balance" => $precioMatriculacion['inscripcion'][0]['precio']
        ));

        // Generamos la actualizacion del balance del perfil de facturas
        $cuotas = (new db('factura_detalle'))->dataTable("SELECT sum(balance) as total FROM factura_detalle where id_factura = {$id_factura}");
        $montoTotal =  $cuotas[0]['total'];
        (new db('perfil_factura'))->insert(array('monto' => $montoTotal, 'balance' => $montoTotal), $id_factura);
    }

    function generarCuotas($num, $datos, $precios)
    {
        $inser = [];
        $fecha = $datos['fecha'];
        for ($i = 1; $i <= $num; $i++) {
            $fecha = date('Y-m-d', strtotime($fecha . '+1 month'));

            $inser[] = array(
                'id_factura' => $this->id_perfil[0]['id'],
                'monto' => $precios['cuota'][0]['precio'],
                'id_producto' => $precios['cuota'][0]['id'],
                'balance' => $precios['cuota'][0]['precio'],
                'cuota' => $i,
                'fecha_pago' => $fecha
            );
        }
        return $inser;
    }

    function realizar_pago()
    {
        $factura = new db($this->table);
        $factura->insert(
            array(
                'id_factura' =>  $this->datos['id_factura'],
                'tipo_pago' =>       $this->datos['metodo_pago'],
                'id_usuario' =>     $this->datos['id_usuario']
            )
        );



        if (isset($this->datos['matriculacion']) && !empty($this->datos['matriculacion'])) {

            $producto = (new db('producto p'))->joinQuery(array('factura_detalle f'), array(0), array('p.id = f.id_producto'), array("f.id = {$this->datos['matriculacion']}"), array('p.id', 'p.precio', 'p.nombre'));

            foreach ($producto as $v) {
            };


            // Venta de una matriculacion
            $registrar_detalle = new db('facturas_pagas_detalle');
            $registrar_detalle->insert(
                array(
                    'id_producto' => $v['id'],
                    'precio' =>  $v['precio'],
                    'tipo' => 3,
                    'id_factura_paga' => $factura->inser_id,
                    'producto' => "{$v['nombre']}",
                    'cantidad' => 1,
                    'id_producto_venta' => $this->datos['matriculacion']
                )
            );
            $this->monitoreo($this->datos['id_factura'], $this->datos['id_usuario'], 1, $v['precio'], $this->datos['id_matriculacion'], 1,$v['nombre'],$v['id'],$this->datos['metodo_pago']);
            $data = (new db('factura_detalle'))->insert(
                array(
                    'balance' => 0,
                    'estado'  => 2,
                ),
                $this->datos['matriculacion']
            );
        }
        // Venta de productos
        if (isset($this->datos['id_productos'])) {
            foreach ($this->datos['id_productos'] as $v) {

                $producto = (new db('producto'))->cargar($v[0]);
                $registrar_detalle = new db('facturas_pagas_detalle');
                $precio = $producto[0]['precio'] * $v[1];

                $registrar_detalle->insert(
                    array(
                        'id_producto' => $producto[0]['id'],
                        'id_producto_venta' => 0,
                        'precio' =>  $precio,
                        'tipo' => 2,
                        'id_factura_paga' => $factura->inser_id,
                        'producto' => "{$producto[0]['nombre']}",
                        'cantidad' => $v[1]
                    )
                );
                $this->monitoreo($this->datos['id_factura'], $this->datos['id_usuario'], 1, $precio, $this->datos['id_matriculacion'], $v[1],$producto[0]['nombre'],$producto[0]['id'],$this->datos['metodo_pago']);
            }
        }

        foreach ($this->datos['cuotas'] as $values) {

            $data = (new db('factura_detalle'))->insert(
                array(
                    'balance' => 0,
                    'estado'  => 2,
                ),
                $values,
                1
            );

            $data = (new db('factura_detalle'))->cargar($values);
            $producto = (new db('producto'))->cargar($data[0]['id_producto']);

            $registrar_detalle = new db('facturas_pagas_detalle');
            $registrar_detalle->insert(
                array(
                    'id_producto' => $data[0]['id_producto'],
                    'id_producto_venta' => $data[0]['id'],
                    'precio' => $data[0]['monto'],
                    'tipo' => 1,
                    'id_factura_paga' => $factura->inser_id,
                    'producto' => "{$producto[0]['nombre']}",
                    'cantidad' => 1
                )
            );
            $this->monitoreo($this->datos['id_factura'], $this->datos['id_usuario'], 1, $data[0]['monto'], $this->datos['id_matriculacion'], 1,$producto[0]['nombre'],$producto[0]['id'],$this->datos['metodo_pago']);

        }
        $this->actualizarPerfil($this->datos['id_factura']);
    }

    function elimar_pago()
    {
        
        $cuota = new db("facturas_pagas_detalle");
        $cuota = $cuota->cargar(0, array("id_factura_paga = {$this->datos->id_factura_paga}"));
        $monto_total = 0;
        foreach ($cuota as $f) {
            $actualizar_valor = (new db('factura_detalle'))->cargar($f['id_producto_venta']);
            (new db('factura_detalle'))->insert(array(
                'estado' => 1,
                'balance' => $actualizar_valor[0]['monto']
            ), $actualizar_valor[0]['id']);
            $monto_total += $f['precio'];
        }
    
        $this->actualizarPerfil($actualizar_valor[0]['id_factura']);
        
        $pagos = new db("facturas_pagas_detalle");
        $this->monitoreo($this->datos->id_factura,$this->datos->user,2,$monto_total,$this->datos->id_matriculacion,null,null,null,null);
        $this->eliminar($this->datos->id_factura_paga);
    }

    function actualizarPerfil($id)
    {
        $producto_apagar = (new db('factura_detalle'))->dataTable("SELECT sum(balance) as total FROM factura_detalle where id_factura = {$id}");
        // _log($producto_apagar);
        $montoTotal = $producto_apagar[0]['total'];
        (new db('perfil_factura'))->insert(array('balance' => $montoTotal), $id);
    }

    function monitoreo($id_factua, $user, $accion, $monto, $inscripcion, $cantidad,$producto,$id_producto,$tipo_pago)
    {
        $usuario = new db("usuario");
        foreach ( $usuario->cargar($user)as $value) {};
        $monitero = new db('monitoreo');
        switch ($tipo_pago) {
            case 1:
                $metodo_pago = "Efectivo";
            break;
            case 2:
                $metodo_pago = "Tarjeta";
            break;
            case 3:
                $metodo_pago = "Transferencia";
            break;
            default:
            $metodo_pago = "Acaba de eliminar";
            break;
        }
        $monitero->insert(
            array(
                'id_factura' => $id_factua,
                'accion' => $accion,
                'usuario' => $value['nombre'].' '. $value['apellido'],
                'monto' => $monto,
                'id_inscripcion' => $inscripcion,
                'cantidad' => $cantidad,
                'nombre_producto'=>$producto,
                'id_producto'=> $id_producto,
                'metodo_pago'=>$metodo_pago
            )
        );
    }
}

function validarUser()
{
    session_start();

    if (!isset($_SESSION['usuario'])) {
        header('location:../');
    };
}
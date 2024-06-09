<?php

namespace App\Controllers\recepcion;

use App\Models\recepcion\Recepcion_det_model;
use CodeIgniter\RESTful\ResourceController;
use function App\Helpers\verPropiedad;
use App\Helpers\Hoy;

class Detalle extends ResourceController
{
    protected $format = 'json';
    protected $recepcion_det_model;

    public function __construct()
    {
        $this->recepcion_det_model = new Recepcion_det_model();
    }

    public function index()
    {
        return $this->failNotFound('Resource not found');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->recepcion_det_model->_buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = '')
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();

            if (verPropiedad($datos, 'recepcion_enc_id') &&
                verPropiedad($datos, 'no_linea') &&
                verPropiedad($datos, 'cantidad_recibida') &&
                verPropiedad($datos, 'producto_bodega_id') &&
                verPropiedad($datos, 'unidad_medida_id') &&
                verPropiedad($datos, 'estado_producto_id')) {

                $det = $this->recepcion_det_model;

                if (empty($id)) {
                    $det->setNoLinea(['recepcion' => $datos->recepcion_enc_id]);
                }

                if ($det->existe($datos)) {
                    $data['exito'] = 2;
                    $data['mensaje'] = "El producto ya se encuentra agregado a está recepción.";
                } else {
                    if ($det->guardar($datos)) {
                        $data['exito'] = 1;
                        $termino = empty($id) ? 'agregado' : 'actualizado';
                        $data['mensaje'] = "Producto {$termino} con éxito.";

                        $data['linea'] = $det->_buscar(['id' => $det->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = $det->getMensaje();
                    }
                }
            } else {
                $data['mensaje'] = "Complete todos los campos marcados con *.";
            }
        } else {
            $data['mensaje'] = "Error en el envío de datos";
        }

        return $this->respond($data);
    }

    public function guardar_detalle()
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();

            if (verPropiedad($datos, 'detalle') && verPropiedad($datos, 'id')) {
                if ($this->recepcion_det_model->existe_oc_rec(["oc" => $datos->oc, "rec" => $datos->id])) {
                    $data["mensaje"] = "La orden de compra #{$datos->oc} ya está relacionada a la recepción #{$datos->id}.";
                } else {
                    $realizados = 0;
                    foreach ($datos->detalle as $row) {
                        $detg = new Recepcion_det_model();

                        $row->recepcion_enc_id = $datos->id;
                        $row->estado_producto_id = 1;
                        $row->cantidad_recibida = $row->cantidad;
                        $row->no_linea = $detg->setNoLinea(['recepcion' => $datos->id]);
                        $detg->guardar($row);
                        $realizados++;
                    }

                    $droc = [
                        'orden_compra_enc_id' => $datos->oc,
                        'recepcion_enc_id' => $datos->id
                    ];

                    $this->recepcion_det_model->insert_rec_oc($droc);

                    if ($realizados > 0) {
                        $data['exito'] = 1;
                        $data['mensaje'] = "Productos agregados con éxito.";
                    } else {
                        $data['mensaje'] = $this->recepcion_det_model->getMensaje();
                    }
                }
            } else {
                $data['mensaje'] = "Complete todos los campos marcados con *.";
            }
        } else {
            $data['mensaje'] = "Error en el envío de datos";
        }

        return $this->respond($data);
    }

    public function eliminar_producto($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $det = new Recepcion_det_model($id);

        if ($det->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Producto removido con éxito.";
        } else {
            $data['mensaje'] = $det->getMensaje();
        }

        return $this->respond($data);
    }
}

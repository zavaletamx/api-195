<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model');
    }

    public function index()
    {
        die("<h1>Auth Service</h>");
    }

    /**
     * _POST
     * @return [type] [description]
     */
    public function registro()
    {
        /*Validacion de datos*/
        $this->form_validation->set_rules('tel', 'tel', 'trim|required|exact_length[10]|numeric|is_unique[usuario.tel]');
        //Siempre una cadena en MD5
        $this->form_validation->set_rules('pin', 'pin', 'trim|required|exact_length[32]|alpha_numeric');

        /*Si la validacion es correcta*/
        if($this->form_validation->run()) {
            /*Creamos un arreglo asociativo con todos los campos de la tabla 
            como indices*/
            $tel = $this->input->post('tel');
            $pin = $this->input->post('pin');
            $arr_insert = array(
                "tel"            => $tel,
                "pin"            => $pin,
                "estatus"        => 1,
                "fecha_registro" => date('Y-m-d')
            );

            /*Evaluamos si la inserción fué posible*/
            if ($this->auth_model->registro($arr_insert)) {
                echo "OK";
            }

            /*Si no es posible insertar*/
            else {
                echo "ERROR";
            }
        } // /validacion

        /*Si la validación es incorrecta*/
        else {
            /*Quitamos las etoquetas <p> de los errores*/
            $this->form_validation->set_error_delimiters('', '');
            echo validation_errors();
        }
    } // registro

    /**
    * [login description]
    * @return [type] [description]
    */
    public function login()
    {
        /*Indicamos que retornaremos texto en formato json*/
        header('Content-Type: application/json; charset=utf-8');

        /*Validamos los parámetros*/
        $this->form_validation->set_rules('tel', 'tel', 'trim|required|exact_length[10]|numeric');
        $this->form_validation->set_rules('pin', 'pin', 'trim|required|exact_length[32]|alpha_numeric');

        /*Creamos un arreglo asociativo para retirnar los datos*/
        $respuesta = array();

        /*Si la validación es correcta*/
        if ($this->form_validation->run()) {
            $tel = $this->input->post('tel');
            $pin = $this->input->post('pin');

            /*tomamos la info del usuario con ese teléfono*/
            $datos_usuario = $this->auth_model->login($tel);

            /*Si existen datos de un usuario con ese telefono*/
            if (!is_null($datos_usuario)) {
                /*Validamos si el pin es correcto*/
                if ($datos_usuario->pin === $pin) {
                    $respuesta['response_code'] = 200;
                    /*Retornamos la info del usuario*/
                    $respuesta['datos_usuario'] = array(
                        "id"       => $datos_usuario->usuario_id,
                        "tel"      => $datos_usuario->tel,
                        "estatus"  => $datos_usuario->estatus,
                        "userpic"  => $datos_usuario->userpic,
                        "registro" => $datos_usuario->fecha_registro
                    );
                }

                /*Si el pin es incorrecto*/
                else {
                    $respuesta['response_code'] = 404;
                }
            }

            /*si no existe un usuario con ese telefono*/
            else {
                $respuesta['response_code'] = 404;
            }
        }

        /*Si las variables post no pasasn la validación*/
        else {
            /*Quitamos las etoquetas <p> de los errores*/
            $this->form_validation->set_error_delimiters('', '');

            $respuesta['response_code'] = 400;
            $respuesta['errors'] = validation_errors();
        }

        /*Respondemos con el objeto JSON*/
        echo json_encode($respuesta);
    }

}

/* End of filºe Auth.php */
/* Location: ./application/controllers/Auth.php */

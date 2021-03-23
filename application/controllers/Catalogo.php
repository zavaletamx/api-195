<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogo extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        /**
        * Invocamos un modelo desde el constructor para tenerlo disponible en todos 
        * los métodos
        */
        $this->load->model('catalogo_model');
    }

    /**
     * Home
     * @method GET
     * @example https://zavaletazea.dev/api-195/catalogo/
     * @return HTML
     */
    public function index()
    {
        die("<h1>Producto Service </1>");
    }

    /**
     * Lista de productos activos
     * @method GET
     * @example https://zavaletazea.dev/api-195/catalogo/lista
     * @return JSON con un arreglo los productos 
     *         activos desde la base de datos 
     */
    public function lista()
    {
        /*Indicamos la respuesta en formato json*/
        header('Content-Type: application/json; charset=utf-8');

        /*
        Este método se atiende desde un método Get y retorna la lista de 
        productos marcados como activos
         */
        $lista_productos = $this->catalogo_model->lista(
            $ordenar = 'precio', 
            $tipo_ordenar = 'desc', 
            $activos = TRUE
        );

        /**
         * Crear un objeto para responder al servicio
         */
        $obj_respuesta = array(
            "response_code" => 200,
            "productos" => array()
        );

        /**
         * Si no hay productos retirnamos 404
         */
        if ($lista_productos === NULL) {
            $obj_respuesta['response_code'] = 404;
            $obj_respuesta['productos'] = NULL;
        }

        /* si tenemos productos */
        else {
            $obj_respuesta['productos'] = $lista_productos;
        }

        /*
        Respondemos con el obj de respuesta 
        EN FORMATO JSON
         */
        
        echo json_encode($obj_respuesta);
        
    }

    /**
     * Seleccionamos los datos de un producto a partir de su identificador
     * @method POST
     * @example https://zavaletazea.dev/api-195/catalogo/producto/$producto_id
     * @param  producto_id int identificador del registro en la base de datos 
     * @return Objeto de un producto
     */
    public function producto($producto_id = NULL)
    {
        /*Indicamos la respuesta en formato json*/
        header('Content-Type: application/json; charset=utf-8');

        /*
        Validamos que el servicio contenga el id del producto en tanto en la URL como por parámetro post
         */
        $this->form_validation->set_rules('producto_id', 'producto_id', "trim|required|min_length[1]|max_length[11]|numeric|in_list[$producto_id]");

        /*
        Preparamos la respuesta
         */
        $respuesta = array(
            'response_code' => 200
        );

        /*
        Si id se envía tanto en la url como medio post continuamos 
         */
        if ($this->form_validation->run()) {
            $producto_id = $this->input->post('producto_id');

            /*
            Invocamos un metodo en el modelo que consulta un solo producto
             */
            $producto = $this->catalogo_model->producto($producto_id);

            /*
            Si encontramos un producto con dicho identificador
             */
            if (!is_null($producto)) {
                $respuesta['producto'] = $producto;
            }
        }

        /*
        Si no encontramos productos con dicho identificador
         */
        else {
            /*Quitamos las etoquetas <p> de los errores*/
            $this->form_validation->set_error_delimiters('', '');

            $respuesta['response_code'] = 400;
            $respuesta['errors'] = validation_errors();
        }

        echo json_encode($respuesta);
    }

    /**
     * Método para agregar una referencia a la lista de deseos
     * @method POST
     * @example https://zavaletazea.dev/api-195/catalogo/agrega_lista_deseos/$usuario_id/$producto_id
     * @param  int $usuario_id  
     * @param  int $producto_id 
     * @return JSON             
     */
    public function agrega_lista_deseos($usuario_id = NULL, $producto_id = NULL)
    {
        /*Indicamos la respuesta en formato json*/
        header('Content-Type: application/json; charset=utf-8');

        /*
        Validamos que el servicio contenga el id del usuario en tanto en la URL como por parámetro post
         */
        $this->form_validation->set_rules('usuario_id', 'usuario_id', "trim|required|min_length[1]|max_length[11]|numeric|in_list[$usuario_id]");

        /*
        Validamos que el servicio contenga el id del producto en tanto en la URL como por parámetro post
         */
        $this->form_validation->set_rules('producto_id', 'producto_id', "trim|required|min_length[1]|max_length[11]|numeric|in_list[$producto_id]");

        /*
        Preparamos la respuesta
         */
        $respuesta = array(
            'response_code' => 200
        );

        /*
        Si id se envía tanto en la url como medio post continuamos 
        */
        if ($this->form_validation->run()) {
            $this->catalogo_model->agrega_lista_deseos(array(
                "usuario_id" => $usuario_id,
                "producto_id" => $producto_id
            ));
        }

        /*
        Si no logramos agregar la refrecnia a la lista de deseos
         */
        else {
            /*Quitamos las etoquetas <p> de los errores*/
            $this->form_validation->set_error_delimiters('', '');

            $respuesta['response_code'] = 400;
            $respuesta['errors'] = validation_errors();
        }

        echo json_encode($respuesta);

    }

    /**
     * Método que retorna los productos de la lista de deseos de un usuario
     * @method POST
     * @examplehttps://zavaletazea.dev/api-195/catalogo/lista_deseos/$usuario_id
     * @param  int $usuario_id [description]
     * @return JSONArray             
     */
    public function lista_deseos($usuario_id = NULL)
    {
        /*Indicamos la respuesta en formato json*/
        header('Content-Type: application/json; charset=utf-8');

        /*
        Validamos que el servicio contenga el id del usuario
         */
        $this->form_validation->set_rules('usuario_id', 'usuario_id', "trim|required|min_length[1]|max_length[11]|numeric|in_list[$usuario_id]");

        /*
        Preparamos la respuesta
         */
        $respuesta = array(
            'response_code' => 200
        );

        /*
        Si id se envía tanto en la url como medio post continuamos 
         */
        if ($this->form_validation->run()) {
            $usuario_id = $this->input->post('usuario_id');

            /*
            Invocamos un metodo en el modelo que consultalos productos asociados
            a la lista de deseos del usuario
             */
            $lista_deseos = $this->catalogo_model->lista_deseos($usuario_id);

            /*
            Si la consulta tiene registros 
             */
            if (!is_null($lista_deseos)) {
                $respuesta['lista_deseos'] = $lista_deseos;
            }

            else {
                $respuesta['response_code'] = 404;
                $respuesta['lista_deseos'] = NULL;
            }
        }

        /*
        Si el servicio no envía tanto el id usuario por url como post mostrsmo
        dicho error
         */
        else {
            /*Quitamos las etoquetas <p> de los errores*/
            $this->form_validation->set_error_delimiters('', '');

            $respuesta['response_code'] = 400;
            $respuesta['errors'] = validation_errors();
        }

        echo json_encode($respuesta);
    }

}

/* End of file Catalogo.php */
/* Location: ./application/controllers/Catalogo.php */

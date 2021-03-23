<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogo_model extends CI_Model {


    /**
     * Metodo que retorna una lista de productos desde la base de datos 
     * e indica el orden por un campo
     * @param  String  $order_field  
     * @param  String  $order_type   
     * @param  boolean $solo_activos 
     * @return dynamic               result/null
     */
    public function lista($order_field = null, $order_type = null, $solo_activos = false)
    {
        /**
         * Solo aplicamos el orden si el suuario 
         * agrega ambos valores
         */
        if (!is_null($order_field) && !is_null($order_type)) {
            $this->db->order_by($order_field, $order_type);
        }

        /**
         * Si mandamos el parámetro solo_activos como TRUE, agregamos un Where 
         * a la consulta
         */
        if ($solo_activos) {
            $this->db->where('activo', 1);
        }

        /*
        Ejecutamos la consulta
         */
        $query = $this->db->get('producto');

        /*
        Si la consulta contiene registros (uno  o mas) regresamos un arreglo 
        con la matríz de datos, peeeeeeeero si no ecisten registros, retornamos 
        nulo
         */
        
        //forma 1 (tradicional)
        // if ($query->num_rows() > 0) {
        //     return $query->result();
        // }

        // else {
        //     return NULL;
        // }
        
        //forma 2 (condicional ternario)
        //      (      CONDICION      ) Si [CODIGO_SI]    NO [CODIGO_NO]
        return ($query->num_rows() > 0) ? $query->result() : NULL; 
    }

    /**
     * Mostramos la info d eun solo producto
     * @param  int $producto_id  
     * @return dynamic           Objeto con los datos de un producto/null
     */
    public function producto($producto_id)
    {
        $this->db->where('producto_id', $producto_id);
        $query = $this->db->get('producto');

        return $query->num_rows() === 1 ? $query->row() : NULL;
    }

    /**
     * Método para insertar una referencia a la lista de deseos
     * @param  Object $data Objeto con los valores a isnertar en la tabla
     * @return boolean      Respuesta de la inserción a la tabla
     */
    public function agrega_lista_deseos($data)
    {
        $this->db->insert('lista_deseos', $data) ? TRUE : FALSE;
    }

    /**
     * Metodo que retorna la lista de deseos de un usuario específico
     * @param  int $usuario_id 
     * @return dynamic         result/null
     */
    public function lista_deseos($usuario_id)
    {
        $cmd = "SELECT * FROM lista_deseos LEFT JOIN producto USING(producto_id) WHERE usuario_id = '$usuario_id'";
        $query = $this->db->query($cmd);

        return ($query->num_rows() > 0) ? $query->result() : NULL; 
    }

}

/* End of file Catalogo_model.php */
/* Location: ./application/models/Catalogo_model.php */

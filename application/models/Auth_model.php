<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    /**
     * Metodo para insertar un usuario
     * @param  Array $data Arreglo asociativo que contiene todos los campos a
     *                     insertar de la tabla usuario
     *                     
     * @return boolean     El estado de la inserción
     */
    public function registro($data)
    {
        $this->db->insert('usuario', $data);

        return TRUE;
    }

    public function login($tel)
    {
        $this->db->where("tel LIKE BINARY '$tel'");
        $query = $this->db->get('usuario');

        /*Si existe un registro, retornamos el objeto del usuario
        de lo contrario retornamos nulo*/
        return $query->num_rows() == 1 ? $query->row() : NULL;
    }

}

/* End of file Auth_model 2.php */
/* Location: /application/modelsAuth_model.php */

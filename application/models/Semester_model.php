<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Semester_model extends MY_Model {

    public function __construct() {
        parent::__construct();

    }
    public function add($data) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well


        //=======================Code Start===========================
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('semesters', $data);
            $message = UPDATE_RECORD_CONSTANT . " On semesters id " . $data['id'];
            $action = "Update";
            $record_id = $data['id'];
            $this->log($message, $record_id, $action);

            $this->db->trans_complete(); # Completing transaction

            if ($this->db->trans_status() === false) {
                # Something went wrong.
                $this->db->trans_rollback();
                return false;
            } else {
                return true; // Indiquer que la mise à jour a réussi
            }
        } else {
            $this->db->insert('semesters', $data);
            $id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On semesters id " . $id;
            $action = "Insert";
            $record_id = $id;
            $this->log($message, $record_id, $action);

            $this->db->trans_complete(); # Completing transaction

            if ($this->db->trans_status() === false) {
                # Something went wrong.
                $this->db->trans_rollback();
                return false;
            } else {
                return $id; // Retourne l'ID du nouveau semestre ajouté
            }
        }
    }
    public function get($id = null) {
        $this->db->select('semesters.*') // Sélectionner uniquement les colonnes de la table 'semesters'
        ->from('semesters');

        if ($id != null) {
            $this->db->where('semesters.id', $id);
        } else {
            $this->db->order_by('semesters.id');
        }

        $query = $this->db->get();

        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }



    public function remove($id) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->where('id', $id);
        $this->db->delete('semesters');
        $message = DELETE_RECORD_CONSTANT . " On semesters id " . $id;
        $action = "Delete";
        $record_id = $id;
        $this->log($message, $record_id, $action);
        //======================Code End==============================
        $this->db->trans_complete(); # Completing transaction
        /* Optional */
        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            //return $return_value;
        }
    }





}

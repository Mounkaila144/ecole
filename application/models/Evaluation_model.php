<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Evaluation_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();

    }
    public function add($data, $section_group,$notes) {
        $this->db->trans_start();  // Démarrer la transaction
        $this->db->trans_strict(false);  // Paramétrer la transaction strictement

        // Ajouter la session actuelle aux données avant l'insertion ou la mise à jour
        $data['session_id'] = $this->current_session;

        //=======================Code Start===========================
        if (isset($data['id'])) {
            // Mise à jour de l'évaluation existante
            $this->db->where('id', $data['id']);
            $this->db->update('evaluations', $data);
            $evaluation_id = $data['id'];

            // Log de l'action
            $message = UPDATE_RECORD_CONSTANT . " On evaluations id " . $data['id'];
            $action = "Update";
            $record_id = $data['id'];
            $this->log($message, $record_id, $action);
        } else {
            // Insertion d'une nouvelle évaluation
            $this->db->insert('evaluations', $data);
            $evaluation_id = $this->db->insert_id();  // Récupérer l'ID de l'évaluation insérée

            // Log de l'action
            $message = INSERT_RECORD_CONSTANT . " On evaluations id " . $evaluation_id;
            $action = "Insert";
            $record_id = $evaluation_id;
            $this->log($message, $record_id, $action);
        }

        // Insérer les classes et sections associées à l'évaluation
        $section_group_array = array();
        foreach ($section_group as $section_group_value) {
            $sections_array = array(
                'evaluation_id' => $evaluation_id,  // ID de l'évaluation
                'class_section_id' => $section_group_value,  // ID de la classe_section
                'session_id' => $this->setting_model->getCurrentSession(),  // Session actuelle
            );

            $section_group_array[] = $sections_array;  // Ajouter à l'array pour l'insertion en batch
        }
        foreach ($notes as $student_id => $note) {
            // Traitement pour chaque étudiant (sauvegarder la note dans la base de données)
            $data = array(
                'student_id' => $student_id,
                'note' => $note,
                'evaluation_id' => $evaluation_id,  // Assurez-vous que vous avez l'ID de l'évaluation
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('student_evaluation_notes', $data);  // Insérer la note de l'étudiant
        }


        // Insérer toutes les classes/sections liées à l'évaluation en une seule requête
        $this->db->insert_batch('evaluation_class_sections', $section_group_array);

        // Compléter la transaction
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            // Si la transaction échoue
            $this->db->trans_rollback();
            return false;
        } else {
            // Transaction réussie, retourne l'ID de l'évaluation
            return $evaluation_id;
        }
    }

    public function get($id = null) {
        // Sélectionner les colonnes nécessaires pour l'évaluation
        $this->db->select('
        evaluations.*,
        sessions.session as session_name,
        subjects.name as subject_name, 
        classes.class as class_name, 
        semesters.name as semester_name
    ');

        // Effectuer la jointure des tables pour récupérer les informations principales
        $this->db->from('evaluations')
            ->join('sessions', 'evaluations.session_id = sessions.id')  // Jointure avec sessions
            ->join('subjects', 'evaluations.subject_id = subjects.id')  // Jointure avec subjects
            ->join('evaluation_class_sections', 'evaluations.id = evaluation_class_sections.evaluation_id')  // Jointure avec evaluation_class_sections (table pivot)
            ->join('class_sections', 'evaluation_class_sections.class_section_id = class_sections.id')  // Jointure avec class_sections
            ->join('classes', 'class_sections.class_id = classes.id')  // Jointure avec classes
            ->join('semesters', 'evaluations.semester_id = semesters.id');  // Jointure avec semesters

        // Filtrer par ID si un ID est fourni
        if ($id != null) {
            $this->db->where('evaluations.id', $id);
        }

        // Exécuter la première requête pour récupérer les évaluations
        $query = $this->db->get();
        $evaluations = $query->result_array();  // Récupérer les évaluations

        // Pour chaque évaluation, récupérer les sections associées
        foreach ($evaluations as &$evaluation) {
            $this->db->select('sections.section');
            $this->db->from('sections');
            $this->db->join('class_sections', 'sections.id = class_sections.section_id');
            $this->db->join('evaluation_class_sections', 'class_sections.id = evaluation_class_sections.class_section_id');
            $this->db->where('evaluation_class_sections.evaluation_id', $evaluation['id']);

            // Exécuter la requête pour récupérer les sections associées
            $sections_query = $this->db->get();
            $evaluation['sections'] = $sections_query->result_array();  // Associer les sections à chaque évaluation
        }

        // Retourner les résultats sous forme de tableau
        if ($id != null) {
            return $evaluations[0];  // Retourner une seule ligne si un ID est fourni
        } else {
            return $evaluations;  // Retourner toutes les évaluations si aucun ID n'est fourni
        }
    }

    public function remove($id) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->where('id', $id);
        $this->db->delete('evaluations');
        $message = DELETE_RECORD_CONSTANT . " On evaluations id " . $id;
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

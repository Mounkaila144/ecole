<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coeficient_model extends MY_Model {

    public function __construct() {
        parent::__construct();

    }
    public function add($data) {
        // Démarrer la transaction
        $this->db->trans_begin();

        if (isset($data['id'])) {
            // Mise à jour d'un enregistrement existant
            $this->db->where('id', $data['id']);
            $this->db->update('class_section_subjects', $data);
            $record_id = $data['id'];  // Utiliser l'ID existant pour les logs et autres opérations
            $action = "Update";
        } else {
            // Insertion de nouveaux enregistrements pour plusieurs sections
            if (!empty($data['sections'])) {
                $section_group_array = [];
                foreach ($data['sections'] as $section_id) {
                    $insert_data = [
                        'class_section_id' => $section_id,  // Assumant que chaque `section_id` est l'ID de la `class_section`
                        'subject_id' => $data['subject_id'],
                        'coeficient' => $data['coeficient']
                    ];

                    $section_group_array[] = $insert_data;  // Préparer l'array pour l'insertion en batch
                }

                // Insertion en batch des nouvelles associations
                if (!empty($section_group_array)) {
                    $this->db->insert_batch('class_section_subjects', $section_group_array);
                }
                // Récupérer l'ID de la première insertion, notez que `insert_batch` ne renvoie pas le dernier ID inséré
                $record_id = $this->db->insert_id();
            }
            $action = "Insert";
        }

        // Vérifier et conclure la transaction
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $record_id;
        }
    }


    public function get($id = null) {
        // Sélectionner les colonnes nécessaires
        $this->db->select('
        class_section_subjects.id,
        class_section_subjects.class_section_id,
        class_section_subjects.subject_id,
        class_section_subjects.coeficient,
        subjects.name as subject_name,
        classes.class as class_name,
        sections.section as section_name
    ');

        // Effectuer les jointures nécessaires
        $this->db->from('class_section_subjects');
        $this->db->join('subjects', 'class_section_subjects.subject_id = subjects.id', 'left');  // Jointure avec subjects
        $this->db->join('class_sections', 'class_section_subjects.class_section_id = class_sections.id', 'left');  // Jointure avec class_sections
        $this->db->join('classes', 'class_sections.class_id = classes.id', 'left');  // Jointure avec classes
        $this->db->join('sections', 'class_sections.section_id = sections.id', 'left');  // Jointure avec sections

        // Ajouter la clause WHERE pour filtrer par class_section_id si fourni
        if ($id !== null) {
            $this->db->where('class_section_subjects.id', $id);
        }

        // Exécuter la requête et retourner les résultats
        $query = $this->db->get();

        if ($id != null) {
            return $query->result_array()[0];  // Retourner une seule ligne si un ID est fourni
        } else {
            return $query->result_array();  // Retourner toutes les évaluations si aucun ID n'est fourni
        }
    }


    public function remove($id) {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->where('id', $id);
        $this->db->delete('class_section_subjects');
        $message = DELETE_RECORD_CONSTANT . " On coeficients id " . $id;
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





    public function getStudentNoteBySemester($student_id, $semester_id, $type) {
        // Sélectionner les colonnes nécessaires
        $this->db->select('
        student_evaluation_notes.note,
        subjects.name as subject,
        evaluations.type,
        evaluations.maxnote
    ');

        // Effectuer les jointures nécessaires
        $this->db->from('student_evaluation_notes');
        $this->db->join('evaluations', 'student_evaluation_notes.evaluation_id = evaluations.id', 'left');  // Jointure avec evaluations
        $this->db->join('subjects', 'evaluations.subject_id = subjects.id', 'left');  // Jointure avec subjects

        // Ajouter les clauses WHERE pour filtrer par étudiant, semestre et type d'évaluation
        $this->db->where('student_evaluation_notes.student_id', $student_id);
        $this->db->where('evaluations.semester_id', $semester_id);
        $this->db->where('evaluations.type', $type);  // Peut être "interrogation", "devoir" ou "composition"

        // Exécuter la requête et retourner les résultats
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getCoeficientByClassSection($class_id, $section_id) {
        // Sélectionner les colonnes nécessaires
        $this->db->select('
        class_section_subjects.subject_id,
        class_section_subjects.coeficient,
        subjects.name as subject
    ');

        // Effectuer les jointures nécessaires
        $this->db->from('class_section_subjects');
        $this->db->join('subjects', 'class_section_subjects.subject_id = subjects.id', 'left');  // Jointure avec subjects
        $this->db->join('class_sections', 'class_section_subjects.class_section_id = class_sections.id', 'left');  // Jointure avec class_sections

        // Ajouter la clause WHERE pour filtrer par class_id et section_id
        $this->db->where('class_sections.class_id', $class_id);
        $this->db->where('class_sections.section_id', $section_id);

        // Exécuter la requête et retourner les résultats
        $query = $this->db->get();

        return $query->result_array();
    }
    public function getStudentMoyenneByTypeEvaluationAndSubject($student_id, $class_id, $section_id, $semester_id, $type, $subject_id) {
        // Sélectionner la moyenne pondérée par matière
        $this->db->select('
        SUM(student_evaluation_notes.note / evaluations.maxnote) / COUNT(student_evaluation_notes.note)*20 as moyenne_ponderee
    ');

        // Effectuer les jointures nécessaires
        $this->db->from('student_evaluation_notes');
        $this->db->join('evaluations', 'student_evaluation_notes.evaluation_id = evaluations.id', 'left');  // Jointure avec evaluations

        // Ajouter les clauses WHERE pour filtrer par étudiant, classe, section, semestre, type d'évaluation et matière
        $this->db->where('student_evaluation_notes.student_id', $student_id);
        $this->db->where('evaluations.class_id', $class_id);
        $this->db->where('evaluations.semester_id', $semester_id);
        $this->db->where('evaluations.type', $type);  // Peut être "interrogation", "devoir"
        $this->db->where('evaluations.subject_id', $subject_id);  // Filtrer par matière

        // Exécuter la requête et retourner la moyenne pondérée
        $query = $this->db->get();

        return $query->result_array();
    }


    public function getStudentMoyenneByTypeEvaluation($student_id, $class_id, $section_id, $semester_id, $type) {
        // Sélectionner les colonnes nécessaires pour calculer la moyenne pondérée en fonction des max-notes
        $this->db->select('
        subjects.name as subject,
        evaluations.type,
        SUM(student_evaluation_notes.note / evaluations.maxnote) / COUNT(student_evaluation_notes.note)*20 as moyenne_ponderee
    ');

        // Effectuer les jointures nécessaires
        $this->db->from('student_evaluation_notes');
        $this->db->join('evaluations', 'student_evaluation_notes.evaluation_id = evaluations.id', 'left');  // Jointure avec evaluations
        $this->db->join('subjects', 'evaluations.subject_id = subjects.id', 'left');  // Jointure avec subjects
        $this->db->join('class_sections', 'class_sections.class_id = evaluations.class_id', 'left');  // Jointure avec class_sections

        // Ajouter les clauses WHERE pour filtrer par étudiant, classe, section, semestre et type d'évaluation
        $this->db->where('student_evaluation_notes.student_id', $student_id);
        $this->db->where('class_sections.class_id', $class_id);
        $this->db->where('class_sections.section_id', $section_id);
        $this->db->where('evaluations.semester_id', $semester_id);
        $this->db->where('evaluations.type', $type);  // Peut être "interrogation", "devoir", ou "composition"

        // Grouper par matière pour éviter les doublons
        $this->db->group_by('subjects.id');

        // Exécuter la requête et retourner la moyenne pondérée
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getMoyenneBySemesterAndType($class_id, $section_id, $semester_id, $type) {
        // Sélectionner la moyenne des notes pour un type d'évaluation
        $this->db->select('
        AVG(student_evaluation_notes.note) as moyenne,
        subjects.name as subject,
        evaluations.type
    ');

        // Effectuer les jointures nécessaires
        $this->db->from('student_evaluation_notes');
        $this->db->join('evaluations', 'student_evaluation_notes.evaluation_id = evaluations.id', 'left');  // Jointure avec evaluations
        $this->db->join('subjects', 'evaluations.subject_id = subjects.id', 'left');  // Jointure avec subjects
        $this->db->join('class_sections', 'class_sections.class_id = evaluations.class_id', 'left');  // Jointure avec class_sections

        // Ajouter les clauses WHERE pour filtrer par classe, section, semestre et type d'évaluation
        $this->db->where('class_sections.class_id', $class_id);
        $this->db->where('class_sections.section_id', $section_id);
        $this->db->where('evaluations.semester_id', $semester_id);
        $this->db->where('evaluations.type', $type);  // Peut être "interrogation", "devoir" ou "composition"

        // Grouper par matière pour éviter les doublons
        $this->db->group_by('subjects.id');

        // Exécuter la requête et retourner les résultats
        $query = $this->db->get();

        return $query->result_array();
    }


}

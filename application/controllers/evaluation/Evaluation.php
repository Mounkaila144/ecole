<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Evaluation extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();

    }

    public function index($id)
    {
        // Vérification des privilèges d'accès
        if (!$this->rbac->hasPrivilege('evaluation', 'can_view')) {
            access_denied();
        }

        // Gestion du menu
        $this->session->set_userdata('top_menu', 'Evaluation');
        $this->session->set_userdata('sub_menu', 'evaluation/evaluation/index');
        $data['title'] = 'Evaluation List';
        $data['semester_id'] = $id;

        // Récupération des données des évaluations et des semestres
        $data['classlist'] = $this->class_model->get();  // Liste des semestres pour le formulaire
        $data['subjectlist'] = $this->subject_model->get();  // Liste des semestres pour le formulaire
        $data['evaluationlist'] = $this->evaluation_model->get();
        $data['section_array'] =array();



        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|integer');
        $this->form_validation->set_rules('type', $this->lang->line('evaluation_type'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required|integer');
        $this->form_validation->set_rules('maxnote', $this->lang->line('max_note'), 'trim|required|numeric|greater_than[0]');

        // Vérification si la validation échoue
        if ($this->form_validation->run() == false) {
            // Chargement des vues avec les données
            $this->load->view('layout/header', $data);
            $this->load->view('evaluation/evaluationList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            // Préparation des données pour l'insertion
            $sections = $this->input->post('sections');
            $notes = $this->input->post('notes');
            $data = array(
                'type' => $this->input->post('type'),  // Récupère le type sélectionné
                'subject_id' => $this->input->post('subject_id'),
                'maxnote' => $this->input->post('maxnote'),
                'class_id' => $this->input->post('class_id'),
                'semester_id' => $id,

                'session_id' => $this->current_session,
            );

            // Ajout de l'évaluation dans la base de données
            $this->evaluation_model->add($data,$sections,$notes);

            // Message flash en cas de succès
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');

            // Redirection après succès
            redirect("evaluation/evaluation/index/".$id);
        }
    }
    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('evaluation', 'can_edit')) {
            access_denied();
        }
        $data['title']       = 'Evaluation List';
        $data['classlist'] = $this->class_model->get();  // Liste des semestres pour le formulaire
        $data['subjectlist'] = $this->subject_model->get();  // Liste des semestres pour le formulaire
        $data['evaluationlist'] = $this->evaluation_model->get();
        $data['evaluation'] = $this->evaluation_model->get($id);
        $data['section_array'] =array();



        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|integer');
        $this->form_validation->set_rules('type', $this->lang->line('evaluation_type'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required|integer');
        $this->form_validation->set_rules('maxnote', $this->lang->line('max_note'), 'trim|required|numeric|greater_than[0]');

        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('evaluation/evaluationEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $sections = $this->input->post('sections');
            $notes = $this->input->post('notes');
            $data = array(
                'type' => $this->input->post('type'),  // Récupère le type sélectionné
                'subject_id' => $this->input->post('subject_id'),
                'maxnote' => $this->input->post('maxnote'),
                'class_id' => $this->input->post('class_id'),
                'semester_id' => $id,

                'session_id' => $this->current_session,
            );

            // Ajout de l'évaluation dans la base de données
            $this->evaluation_model->add($data,$sections,$notes);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('evaluation/evaluation/index');
        }
    }

    public function getStudentsByClassAndSection() {
        $class_id = $this->input->post('class_id');
        $section_ids = $this->input->post('section_ids');

        // Requête pour récupérer les étudiants en fonction des sections et de la classe
        $this->db->select('students.id as student_id, students.firstname as firstname, students.lastname as lastname');
        $this->db->from('student_session');
        $this->db->join('students', 'students.id = student_session.student_id');
        $this->db->where('student_session.class_id', $class_id);
        $this->db->where_in('student_session.section_id', $section_ids);  // Vérifier les étudiants dans les sections sélectionnées

        $query = $this->db->get();
        echo json_encode($query->result_array());  // Retourner les résultats en JSON pour le script JavaScript
    }


    public function view($id)
    {
        if (!$this->rbac->hasPrivilege('evaluation', 'can_view')) {
            access_denied();
        }
        $data['title']   = 'Evaluation List';
        $evaluation         = $this->evaluation_model->get($id);
        $data['evaluation'] = $evaluation;
        $this->load->view('layout/header', $data);
        $this->load->view('evaluation/evaluationShow', $data);
        $this->load->view('layout/footer', $data);
    }

    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('evaluation', 'can_delete')) {
            access_denied();
        }
        $this->evaluation_model->remove($id);
        redirect('evaluation/evaluation/index');
    }

}
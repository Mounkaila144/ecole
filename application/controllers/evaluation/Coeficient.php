<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Coeficient extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        // Vérifier si l'utilisateur a les privilèges nécessaires pour voir les coeficients
        if (!$this->rbac->hasPrivilege('coeficient', 'can_view')) {
            access_denied();
        }

        // Gestion du menu
        $this->session->set_userdata('top_menu', 'Semesters');
        $this->session->set_userdata('sub_menu', 'evaluation/coeficient/index');
        $data['title'] = 'Coeficient List';

        // Récupération des listes pour le formulaire (classes et matières)
        $data['classlist'] = $this->class_model->get();  // Liste des classes
        $data['subjectlist'] = $this->subject_model->get();  // Liste des matières

        // Récupérer la liste des coeficients
        $data['coeficientlist'] = $this->coeficient_model->get();
        $data['section_array'] =array();

        // Validation du formulaire
        $this->form_validation->set_rules('coeficient', $this->lang->line('coeficient'), 'trim|required|numeric|greater_than[0]');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|integer');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required|integer');
        $this->form_validation->set_rules('sections[]', $this->lang->line('sections'), 'required');  // Validation des sections

        if ($this->form_validation->run() == false) {
            // Chargement de la vue en cas d'échec de validation
            $this->load->view('layout/header', $data);
            $this->load->view('coeficient/coeficientList', $data);
            $this->load->view('layout/footer');
        } else {
            // Préparation des données pour l'insertion ou mise à jour
            $sections = $this->input->post('sections');  // Récupérer les sections cochées
            $data = array(
                'coeficient' => $this->input->post('coeficient'),  // Coefficient sélectionné
                'subject_id' => $this->input->post('subject_id'),  // Matière sélectionnée
                'class_id' => $this->input->post('class_id'),  // Classe sélectionnée
                'sections' => $sections  // Sections sélectionnées
            );

            // Ajout ou mise à jour des coeficients via le modèle
            $this->coeficient_model->add($data);

            // Message flash en cas de succès
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');

            // Redirection après succès
            redirect('evaluation/coeficient/index');
        }
    }

    public function view($id)
    {
        if (!$this->rbac->hasPrivilege('coeficient', 'can_view')) {
            access_denied();
        }
        $data['title']   = 'Section List';
        $coeficient         = $this->coeficient_model->get($id);
        $data['coeficient'] = $coeficient;
        $this->load->view('layout/header', $data);
        $this->load->view('coeficient/coeficientShow', $data);
        $this->load->view('layout/footer', $data);
    }
    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('coeficient', 'can_edit')) {
            access_denied();
        }
        $data['title']       = 'Section List';
        $coeficient_result      = $this->coeficient_model->get();
        $data['coeficientlist'] = $coeficient_result;
        $data['title']       = 'Edit Section';
        $data['id']          = $id;
        $coeficient             = $this->coeficient_model->get($id);
        $data['coeficient']     = $coeficient;
        $data['sectionlist'] =$this->section_model->get();
        $data['classlist'] = $this->class_model->get();  // Liste des classes
        $data['subjectlist'] = $this->subject_model->get();  // Liste des matières

        $this->form_validation->set_rules('coeficient', $this->lang->line('coeficient'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('coeficient/coeficientEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $update_data = array(
                'id'=>$id,
                'coeficient' => $this->input->post('coeficient'),
                //'subject_id' => $this->input->post('subject_id'),
                //'class_id' => $this->input->post('class_id'),
                // 'semester_id' => $semester_id,  // Utiliser l'ID du semestre
                //'session_id' => $this->current_session,  // Session en cours
            );
            $this->coeficient_model->add($update_data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('evaluation/coeficient/index');
        }
    }

    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('coeficient', 'can_delete')) {
            access_denied();
        }
        $this->coeficient_model->remove($id);
        redirect('evaluation/coeficient/index');
    }

}
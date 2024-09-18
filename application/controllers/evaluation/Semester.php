<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Semester extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('semester', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Semesters');
        $this->session->set_userdata('sub_menu', 'evaluation/semester/index');
        $data['title'] = 'Section List';

        $semester_result      = $this->semester_model->get();
        $data['semesterlist'] = $semester_result;

        // Décommenter la validation du formulaire
        $this->form_validation->set_rules('name', $this->lang->line('semester_name'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            // Débogage en cas d'échec de validation
            var_dump('Validation failed');
            var_dump(validation_errors());

            $this->load->view('layout/header', $data);
            $this->load->view('semester/semesterList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            // Débogage en cas de validation réussie

            $data = array(
                'name' => $this->input->post('name'),
            );

            $this->semester_model->add($data);

            // Affichage de message flash en cas de succès
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');

            // Redirection après succès yes
            redirect('evaluation/semester/index');
        }
    }
    public function view($id)
    {
        if (!$this->rbac->hasPrivilege('semester', 'can_view')) {
            access_denied();
        }
        $data['title']   = 'Section List';
        $semester         = $this->semester_model->get($id);
        $data['semester'] = $semester;
        $this->load->view('layout/header', $data);
        $this->load->view('semester/semesterShow', $data);
        $this->load->view('layout/footer', $data);
    }
    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('semester', 'can_edit')) {
            access_denied();
        }
        $data['title']       = 'Section List';
        $semester_result      = $this->semester_model->get();
        $data['semesterlist'] = $semester_result;
        $data['title']       = 'Edit Section';
        $data['id']          = $id;
        $semester             = $this->semester_model->get($id);
        $data['semester']     = $semester;
        $this->form_validation->set_rules('name', $this->lang->line('semester_name'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            var_dump('yess');
            $this->load->view('layout/header', $data);
            $this->load->view('semester/semesterEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id'      => $id,
                'name' => $this->input->post('name'),
            );
            $this->semester_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('evaluation/semester/index');
        }
    }

    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('semester', 'can_delete')) {
            access_denied();
        }
        $this->semester_model->remove($id);
        redirect('evaluation/semester/index');
    }

}
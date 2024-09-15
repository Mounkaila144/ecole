<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Bulletin extends Admin_Controller
{

    public $exam_type = array();

    public function __construct()
    {
        parent::__construct();
        $this->sch_setting_detail = $this->setting_model->getSetting();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->load->library('mailsmsconf');
         $this->load->library('media_storage');
    }



    public function index()
    {

        if (!$this->rbac->hasPrivilege('print_marksheet', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Evaluation');
        $this->session->set_userdata('sub_menu', 'Evaluation/bulletin/marksheet');

        $evaluation_result      = $this->evaluation_model->get();
        $data['evaluationlist'] = $evaluation_result;
        $class                 = $this->class_model->get();
        $data['title']         = 'Add Batch';
        $data['title_list']    = 'Recent Batch';
        $data['classlist']     = $class;
        $data['semesterlist']     = $this->semester_model->get();
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('semester_id', $this->lang->line('semester'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {

        } else {
            $semester_id = $this->input->post('semester_id');
            $class_id      = $this->input->post('class_id');
            $section_id    = $this->input->post('section_id');
            $data['studentList']        = $this->getStudentsByClassAndSection($class_id, $section_id,$semester_id);
            $data['semester_id']      = $semester_id;
            $data['class_id']      = $class_id;
            $data['section_id']      = $section_id;
        }
        $data['sch_setting'] = $this->sch_setting_detail;
        $this->load->view('layout/header', $data);
        $this->load->view('bulletin/marksheet', $data);
        $this->load->view('layout/footer', $data);
    }



    public function pdftmarksheet()
    {
        // Récupérer les données d'entrée
        $student_id  = $this->input->post('student_id');
        $semester_id = $this->input->post('semester_id');
        $class_id    = $this->input->post('class_id');
        $section_id  = $this->input->post('section_id');
        $data['setting'] = $this->sch_setting_detail;
        // Récupérer les informations de l'étudiant, la session, et les coefficients
        $data['student'] = $this->student_model->get($student_id);
        $data['session'] = $this->session_model->get($this->current_session);
        $data['coeficientList'] = $this->coeficient_model->getCoeficientByClassSection($class_id, $section_id);
        // Récupérer les autres étudiants pour calculer le rang
        $students = $this->getStudentsByClassAndSection($class_id, $section_id, $semester_id);

        // Calculer le rang de l'étudiant
        $data['rank'] = $this->calculateStudentRank($students, $student_id, $class_id, $section_id, $semester_id);
        $data['total_students'] = $this->getStudentCountByClassSection($class_id, $section_id);
        // Ajouter la matière "Conduite" avec un coefficient fixe de 1
        $data['coeficientList'][] = [
            'subject' => 'Conduite',
            'coeficient' => 1
        ];

        // Récupérer la note de conduite pour cet étudiant, ce semestre et cette session
        $data['conduite_note'] = $this->getConduiteNoteByStudentSemesterSession($student_id, $semester_id);

        // Récupérer les moyennes pour chaque type d'évaluation
        $evaluations_types = ['interrogation', 'devoir', 'composition'];
        $moyenne_by_type = [];
        foreach ($evaluations_types as $type) {
            $moyenne_by_type[$type] = $this->coeficient_model->getStudentMoyenneByTypeEvaluation($student_id, $class_id, $section_id, $semester_id, $type);
        }

        // Traitement des moyennes par matière et composition
        $data['results'] = [];
        foreach ($data['coeficientList'] as $coeficient) {
            $subject = $coeficient['subject'];

            // Calcul de la moyenne finale pour chaque matière
            $moyenne_finale = $this->calculateMoyenneFinale($moyenne_by_type['interrogation'], $moyenne_by_type['devoir'], $subject);
            $composition_finale = $this->findMoyenneBySubject($moyenne_by_type['composition'], $subject);

            // Stocker les résultats dans un tableau
            $data['results'][] = [
                'subject'         => $subject,
                'coeficient'      => $coeficient['coeficient'],
                'moyenne_classe'  => ceil($moyenne_finale),
                'note_compo'      => ceil($composition_finale),
                'moyenne_ponderee'=> ceil(($moyenne_finale + $composition_finale) / 2)
            ];
        }

        // Paramètres pour le PDF
        $data['sch_setting'] = $this->sch_setting_detail;
        $html = $this->load->view('bulletin/_printpdfmarksheet', $data, true);

        // Génération du PDF
        $this->load->library('m_pdf');
        $mpdf = $this->m_pdf->load();
        $stylesheet = $this->curl_get_contents(base_url() . 'backend/pdf_style.css');
        $mpdf->WriteHTML($stylesheet, 1); // Ajouter le style
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        return $mpdf->Output(random_string() . '.pdf', 'I'); // Générer le PDF en sortie
    }

    /**
     * Fonction utilitaire pour calculer la moyenne finale
     */
    private function calculateMoyenneFinale($interrogation, $devoir, $subject)
    {
        $moyenne_interrogation = $this->findMoyenneBySubject($interrogation, $subject);
        $moyenne_devoir = $this->findMoyenneBySubject($devoir, $subject);
        return ($moyenne_interrogation + $moyenne_devoir) / 2;
    }

    /**
     * Fonction utilitaire pour trouver la moyenne par matière
     */
    private function findMoyenneBySubject($moyenne_array, $subject)
    {
        foreach ($moyenne_array as $moyenne) {
            if ($moyenne['subject'] == $subject) {
                return $moyenne['moyenne_ponderee'];
            }
        }
        return 0; // Si aucune moyenne n'est trouvée, retourner 0
    }

    public function curl_get_contents($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    public function getStudentCountByClassSection($class_id, $section_id)
    {
        // Requête pour compter les étudiants par classe et section
        $this->db->select('COUNT(*) as total_students');
        $this->db->from('student_session');
        $this->db->where('class_id', $class_id);
        $this->db->where('section_id', $section_id);

        // Exécuter la requête et obtenir le résultat
        $query = $this->db->get();
        $result = $query->row_array();

        // Retourner le nombre total d'étudiants
        return $result['total_students'];
    }
    public function getStudentsByClassAndSection($class_id, $section_id, $semester_id)
    {
        // Requête pour récupérer les étudiants en fonction des sections et de la classe
        $this->db->select('students.id, students.firstname, students.lastname');
        $this->db->from('student_session');
        $this->db->join('students', 'students.id = student_session.student_id')
            ->join('sessions', 'student_session.session_id = sessions.id');
        $this->db->where('student_session.class_id', $class_id);
        $this->db->where('sessions.id', $this->current_session);
        $this->db->where_in('student_session.section_id', $section_id);

        $query = $this->db->get();
        $students = $query->result_array();

        // Initialisation du tableau des étudiants avec leur rang
        $students_with_rank = [];

        // Calcul du rang pour chaque étudiant en passant les données à la fonction
        foreach ($students as $student) {
            $student_id = $student['id'];
            $rank = $this->calculateStudentRank($students, $student_id, $class_id, $section_id, $semester_id); // Calcul du rang
            $students_with_rank[] = array_merge($student, ['rank' => $rank]);
        }

        // Trier la liste des étudiants par rang (du premier au dernier)
        usort($students_with_rank, function ($a, $b) {
            return $a['rank'] <=> $b['rank']; // Tri par ordre croissant
        });

        return $students_with_rank;  // Retourner les résultats avec le rang trié
    }

    public function calculateStudentRank($students, $student_id, $class_id, $section_id, $semester_id)
    {
        $student_averages = [];
        foreach ($students as $student) {
            // Calculer la moyenne générale pour chaque étudiant
            $total_moyenne = 0;
            $total_coef = 0;

            $coeficients = $this->coeficient_model->getCoeficientByClassSection($class_id, $section_id);
            foreach ($coeficients as $coeficient) {
                $moyenne_interrogation = $this->coeficient_model->getStudentMoyenneByTypeEvaluation($student['id'], $class_id, $section_id, $semester_id, 'interrogation');
                $moyenne_devoir = $this->coeficient_model->getStudentMoyenneByTypeEvaluation($student['id'], $class_id, $section_id, $semester_id, 'devoir');

                // Calcul de la moyenne finale pour la matière
                $moyenne_finale = ($this->findMoyenneBySubject($moyenne_interrogation, $coeficient['subject']) +
                        $this->findMoyenneBySubject($moyenne_devoir, $coeficient['subject'])) / 2;

                $total_moyenne += $moyenne_finale * $coeficient['coeficient'];
                $total_coef += $coeficient['coeficient'];
            }

            // Calculer la moyenne pondérée pour cet étudiant
            $moyenne_generale = ($total_coef > 0) ? $total_moyenne / $total_coef : 0;
            $student_averages[] = [
                'student_id' => $student['id'],
                'moyenne' => $moyenne_generale
            ];
        }

        // Trier les étudiants par moyenne décroissante
        usort($student_averages, function ($a, $b) {
            return $b['moyenne'] <=> $a['moyenne']; // Tri en ordre décroissant
        });

        // Trouver le rang de l'étudiant
        foreach ($student_averages as $index => $student) {
            if ($student['student_id'] == $student_id) {
                return $index + 1; // Le rang est l'index + 1
            }
        }

        return null; // Si l'étudiant n'est pas trouvé
    }

    /**
     * Récupérer ou utiliser la note de conduite par défaut
     */
    public function getConduiteNoteByStudentSemesterSession($student_id, $semester_id)
    {
        // Vérifier si une note de conduite existe pour cet étudiant, ce semestre, et cette session
        $this->db->select('conduite');
        $this->db->from('student_conduite');
        $this->db->where('student_id', $student_id);
        $this->db->where('semester_id', $semester_id);
        $this->db->where('session_id', $this->current_session);
        $query = $this->db->get();

        // Si une note existe, la retourner, sinon retourner 18 par défaut
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result['conduite'];
        } else {
            return 18;  // Retourner 18 si aucun enregistrement n'existe
        }
    }



}

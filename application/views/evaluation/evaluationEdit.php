<div class="content-wrapper">   
    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> <?php echo $this->lang->line('academics'); ?> <small><?php echo $this->lang->line('student_fees1'); ?></small>        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            if ($this->rbac->hasPrivilege('evaluation', 'can_add') || $this->rbac->hasPrivilege('evaluation', 'can_edit')) {
                ?>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('edit_evaluation'); ?></h3>
                        </div>
                        <form  action="<?php echo site_url("evaluation/evaluation/edit/" . $evaluation['id'])."/".$semester_id ?>" id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php
                                    echo $this->session->flashdata('msg');
                                    $this->session->unset_userdata('msg');
                                    ?>
                                <?php } ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <!-- Champ pour le type d'évaluation -->
                                <div class="form-group">
                                    <label for="type"><?php echo $this->lang->line('type'); ?> </label><small class="req"> *</small>
                                    <select id="type" name="type" class="form-control">
                                        <option value="interrogation" <?php echo set_select('type', 'interrogation', ($evaluation['type'] == 'interrogation')); ?>>Interrogation</option>
                                        <option value="devoir" <?php echo set_select('type', 'devoir', ($evaluation['type'] == 'devoir')); ?>>Devoir</option>
                                        <option value="composition" <?php echo set_select('type', 'composition', ($evaluation['type'] == 'composition')); ?>>Composition</option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('type'); ?></span>
                                </div>

                                <!-- Champ pour la note maximale -->
                                <div class="form-group">
                                    <label for="maxnote"><?php echo $this->lang->line('max_note'); ?> </label><small class="req"> *</small>
                                    <input autofocus="" id="maxnote" name="maxnote" placeholder="Ex: 100" type="number" class="form-control" value="<?php echo set_value('maxnote', $evaluation['maxnote']); ?>" />
                                    <span class="text-danger"><?php echo form_error('maxnote'); ?></span>
                                </div>

                                <!-- Champ pour sélectionner la matière -->
                                <div class="form-group">
                                    <label for="subject_id"><?php echo $this->lang->line('subject'); ?> </label><small class="req"> *</small>
                                    <select id="subject_id" name="subject_id" class="form-control">
                                        <?php foreach ($subjectlist as $subject) { ?>
                                            <option value="<?php echo $subject['id']; ?>" <?php echo set_select('subject_id', $subject['id'], ($evaluation['subject_id'] == $subject['id'])); ?>>
                                                <?php echo $subject['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('subject_id'); ?></span>
                                </div>

                                <div class="form-group">
                                    <label for="class_id"><?php echo $this->lang->line('class'); ?> </label><small class="req"> *</small>
                                    <select disabled id="class_id" name="class_id" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php foreach ($classlist as $class) { ?>
                                            <option value="<?php echo $class['id']; ?>" <?php echo set_select('class_id', $class['id'], ($evaluation['class_id'] == $class['id'])); ?>>
                                                <?php echo $class['class']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                </div>

                                <!-- Affichage des sections sous forme de cases à cocher -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('sections'); ?></label><small class="req"> *</small>
                                    <?php
                                    // Créer un tableau contenant les noms des sections déjà sélectionnées
                                    $selected_sections = array_column($evaluation["sections"], 'section');

                                    // Boucle pour afficher toutes les sections disponibles

                                    foreach ($sectionlist as $section) {
                                        $isChecked = in_array($section['section'], $selected_sections); // Vérifier si la section est sélectionnée
                                        ?>
                                    <div class="section_checkbox">
                                                <input  disabled type="checkbox" name="sections[]" value="<?php echo $section['id']; ?>"
                                                    <?php echo set_checkbox('sections[]', $section['id'], $isChecked); ?>>
                                                <?php echo $section['section']; ?>
                                    </div>
                                    <?php } ?>
                                    <span class="text-danger"><?php echo form_error('sections[]'); ?></span>
                                </div>

                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('student_name'); ?></th>
                                        <th><?php echo $this->lang->line('note'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($students_with_notes as $student) { ?>
                                        <tr>
                                            <td><?php echo $student['firstname'] . " " . $student['lastname']; ?></td>
                                            <td>
                                                <input type="number" class="form-control" name="notes[<?php echo $student['student_id']; ?>]" value="<?php echo isset($student['note']) ? $student['note'] : '0'; ?>" placeholder="Enter note">
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>




                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>              
                </div>
            <?php } ?>
            <div class="col-md-<?php
            if ($this->rbac->hasPrivilege('evaluation', 'can_add') || $this->rbac->hasPrivilege('evaluation', 'can_edit')) {
                echo "8";
            } else {
                echo "12";
            }
            ?>">             
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('evaluation_list'); ?></h3>
                    </div>
                    <div class="box-body ">
                        <div class="table-responsive mailbox-messages overflow-visible">
                            <div class="download_label"><?php echo $this->lang->line('evaluation_list'); ?></div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('type'); ?></th>
                                    <th><?php echo $this->lang->line('subject'); ?></th>
                                    <th><?php echo $this->lang->line('class'); ?></th>
                                    <th><?php echo $this->lang->line('max_note'); ?></th>
                                    <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $count = 1;
                                foreach ($evaluationlist as $evaluation) {
                                    ?>
                                    <tr>
                                        <td><?php echo ucfirst($evaluation['type']); // Afficher le type d'évaluation ?></td>
                                        <td><?php echo $evaluation['subject_name']; // Afficher le nom de la matière ?></td>
                                        <td>
                                            <?php echo $evaluation['class_name']; // Afficher le nom de la classe ?>
                                            <span class="text-primary">
                            <?php foreach ($evaluation['sections'] as $section) { ?>
                                <span><?php echo $section['section']; // Afficher chaque section dans une liste ?> ;</span>
                            <?php } ?>
                    </span>
                                        </td>
                                        <td><?php echo $evaluation['maxnote']; // Afficher la note maximale ?></td>

                                        <td class="text-right">
                                            <?php
                                            // Afficher le bouton d'édition si l'utilisateur a le privilège 'can_edit'
                                            if ($this->rbac->hasPrivilege('evaluation', 'can_edit')) {
                                                ?>
                                                <a href="<?php echo base_url(); ?>evaluation/evaluation/edit/<?php echo $evaluation['id']; ?>/<?php echo $semester_id; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <?php
                                            }

                                            // Afficher le bouton de suppression si l'utilisateur a le privilège 'can_delete'
                                            if ($this->rbac->hasPrivilege('evaluation', 'can_delete')) {
                                                ?>
                                                <a href="<?php echo base_url(); ?>evaluation/evaluation/delete/<?php echo $evaluation['id']; ?>/<?php echo $semester_id; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line("evaluation_will_also_delete_all_evalutions_under_this_evaluation_so_be_careful_as_this_action_is_irreversible"); ?>');">
                                                    <i class="fa fa-remove"></i>
                                                </a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $count++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 

        </div> 
    </section>
</div>
<?php

function check_in_array($find, $array) {

    foreach ($array as $element) {
        if ($find == $element->id) {
            return TRUE;
        }
    }
    return FALSE;
}
?>
<!-- Script pour charger dynamiquement les sections et les étudiants -->

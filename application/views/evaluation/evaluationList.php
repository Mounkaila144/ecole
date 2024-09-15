<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> <?php echo $this->lang->line('evaluation'); ?> <small><?php echo $this->lang->line('student_fees1'); ?></small>        </h1>
    </section>
    <!-- Main content -->
    <style>
        @media print
        {
            .no-print, .no-print *
            {
                display: none !important;
            }
        }
    </style>
    <section class="content">
        <div class="row">
            <?php
            if ($this->rbac->hasPrivilege('evaluation', 'can_add')) {
                ?>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Ajouter un évaluation</h3>
                        </div>
                        <form action="<?php echo site_url('evaluation/evaluation/index/' . $semester_id) ?>" id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
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
                                    <label for="type">Type </label><small class="req"> *</small>
                                    <select id="type" name="type" class="form-control">
                                        <option value="interrogation" <?php echo set_select('type', 'interrogation'); ?>>Interrogation</option>
                                        <option value="devoir" <?php echo set_select('type', 'devoir'); ?>>Devoir</option>
                                        <option value="composition" <?php echo set_select('type', 'composition'); ?>>Composition</option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('type'); ?></span>
                                </div>
                                <!-- Champ pour la note maximale -->
                                <div class="form-group">
                                    <label for="maxnote">Note Maximum </label><small class="req"> *</small>
                                    <input autofocus="" id="maxnote" name="maxnote" placeholder="Ex: 100" type="number" class="form-control" value="<?php echo set_value('maxnote'); ?>" />
                                    <span class="text-danger"><?php echo form_error('maxnote'); ?></span>
                                </div>

                                <!-- Champ pour sélectionner la matière -->
                                <div class="form-group">
                                    <label for="subject_id"><?php echo $this->lang->line('subject'); ?> </label><small class="req"> *</small>
                                    <select id="subject_id" name="subject_id" class="form-control">
                                        <?php
                                        foreach ($subjectlist as $subject) {
                                            ?>
                                            <option value="<?php echo $subject['id']; ?>" <?php echo set_select('subject_id', $subject['id']); ?>>
                                                <?php echo $subject['name']; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('subject_id'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('class'); ?> </label><small class="req"> *</small>
                                    <select  id="class_id" name="class_id" class="form-control" >
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php
                                        foreach ($classlist as $class) {
                                            ?>
                                            <option value="<?php echo $class['id'] ?>" <?php
                                            if (set_value('class_id') == $class['id']) {
                                                echo "selected=selected";
                                            }
                                            ?>>
                                                <?php echo $class['class'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                </div>
                                <div class="form-group"> <!-- Radio group !-->
                                    <label class="control-label"><?php echo $this->lang->line('sections'); ?></label><small class="req"> *</small>
                                    <div class="section_checkbox">
                                        <?php echo $this->lang->line('no_section'); ?>
                                    </div>
                                    <span class="text-danger"><?php echo form_error('sections[]'); ?></span>
                                </div>
                                <style>
                                    #students_list::-webkit-scrollbar {
                                        width: 7px; /* Largeur de la barre de défilement */
                                    }

                                    #students_list::-webkit-scrollbar-thumb {
                                        background-color: rgba(0, 0, 0, 0.46); /* Couleur de la barre */
                                        border-radius: 10px;
                                    }

                                </style>
                                <!-- Section pour afficher les étudiants avec les champs de notes -->
                                <div id="students_list" class="table-responsive" style="height: 300px; overflow-y: scroll; overflow-x: hidden; scrollbar-width: auto; -webkit-overflow-scrolling: touch;">
                                    <!-- Contenu de la liste des étudiants ici -->
                                </div>


                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-<?php
            if ($this->rbac->hasPrivilege('evaluation', 'can_add')) {
                echo "8";
            } else {
                echo "12";
            }
            ?>">
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">List des évaluations</h3>
                    </div>
                    <div class="box-body ">
                        <div class="table-responsive mailbox-messages overflow-visible">
                            <div class="download_label">>List des évaluations</div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    <th><?php echo $this->lang->line('subject'); ?></th>
                                    <th><?php echo $this->lang->line('class'); ?></th>
                                    <th>Note Maximum</th>
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

<script>
    $(document).ready(function () {
        var post_class_id = '<?php echo set_value('class_id', 0) ?>';

        // Initialisation des sections basées sur la classe sélectionnée
        getSectionByClass(post_class_id, 0);

        // Lorsque la classe change
        $(document).on('change', '#class_id', function (e) {
            var class_id = $(this).val();
            getSectionByClass(class_id, 0);  // Récupère les sections par classe
        });
    });

    // Fonction pour récupérer les sections selon la classe sélectionnée
    function getSectionByClass(class_id, section_array) {
        $('.section_checkbox').html('');  // Réinitialiser la liste des sections
        if (class_id !== "" && class_id !== 0) {
            var div_data = "";
            $.ajax({
                type: "GET",
                url: "<?php echo base_url(); ?>sections/getByClass",  // Récupérer les sections de la classe
                data: {'class_id': class_id},
                dataType: "json",
                success: function (data) {
                    $.each(data, function (i, obj) {
                        var check = "";
                        div_data += "<div class='checkbox'>";
                        div_data += "<label>";
                        div_data += "<input type='checkbox' class='content_available' name='sections[]' value='" + obj.id + "' onchange='getStudentsBySection(" + class_id + ")'>" + obj.section;
                        div_data += "</label>";
                        div_data += "</div>";
                    });
                    $('.section_checkbox').html(div_data);  // Afficher la liste des sections
                },
                error: function (xhr) {
                    alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
                }
            });
        }
    }

    // Fonction pour récupérer les étudiants selon la section sélectionnée
    function getStudentsBySection(class_id) {
        var section_ids = [];
        $('input[name="sections[]"]:checked').each(function () {
            section_ids.push($(this).val());  // Ajouter les sections cochées
        });

        if (section_ids.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>evaluation/evaluation/getStudentsByClassAndSection",  // URL pour récupérer les étudiants
                data: {'class_id': class_id, 'section_ids': section_ids},
                dataType: "json",
                success: function (data) {
                    var student_data = "<table class='table'><thead><tr><th>Student</th><th>Note</th></tr></thead><tbody>";
                    $.each(data, function (i, obj) {
                        student_data += "<tr>";
                        student_data += "<td><a href='" + base_url + "student/view/" + obj.student_id + "'>" + obj.firstname + " " + obj.lastname + "</a></td>";
                        student_data += "<td><input type='number' class='form-control' value='0' name='notes[" + obj.student_id + "]' placeholder='Enter note'></td>";  // Champ input pour la note
                        student_data += "</tr>";
                    });
                    student_data += "</tbody></table>";
                    $('#students_list').html(student_data);  // Afficher la liste des étudiants avec un champ note
                },
                error: function (xhr) {
                    alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
                }
            });
        } else {
            $('#students_list').html('');  // Si aucune section sélectionnée, effacer la liste des étudiants
        }
    }


    $(".no_print").css("display", "block");
    document.getElementById("print").style.display = "block";
    document.getElementById("btnExport").style.display = "block";

    function printDiv() {
        $(".no_print").css("display", "none");
        document.getElementById("print").style.display = "none";
        document.getElementById("btnExport").style.display = "none";
        var divElements = document.getElementById('subject_list').innerHTML;
        var oldPage = document.body.innerHTML;
        document.body.innerHTML =
            "<html><head><title></title></head><body>" +
            divElements + "</body>";
        window.print();
        document.body.innerHTML = oldPage;
        location.reload(true);
    }










</script>
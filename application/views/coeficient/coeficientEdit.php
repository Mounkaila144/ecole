<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> <?php echo $this->lang->line('academics'); ?> <small><?php echo $this->lang->line('student_fees1'); ?></small>        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            if ($this->rbac->hasPrivilege('coeficient', 'can_add') || $this->rbac->hasPrivilege('coeficient', 'can_edit')) {
                ?>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Modifier le coefficient</h3>
                        </div>
                        <form  action="<?php echo site_url("evaluation/coeficient/edit/" . $coeficient['id'])?>" id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php
                                    echo $this->session->flashdata('msg');
                                    $this->session->unset_userdata('msg');
                                    ?>
                                <?php } ?>
                                <?php echo $this->customlib->getCSRF(); ?>


                                <!-- Champ pour la note maximale -->
                                <div class="form-group">
                                    <label for="coeficient">Coefficient </label><small class="req"> *</small>
                                    <input autofocus="" id="coeficient" name="coeficient" placeholder="Ex: 100" type="number" class="form-control" value="<?php echo set_value('coeficient', $coeficient['coeficient']); ?>" />
                                    <span class="text-danger"><?php echo form_error('coeficient'); ?></span>
                                </div>

                                <!-- Champ pour sélectionner la matière -->
                                <div class="form-group">
                                    <label for="subject_id"><?php echo $this->lang->line('subject'); ?> </label><small class="req"> *</small>
                                    <span><?php echo $coeficient['subject_name']; ?> </span>
                                </div>

                                <div class="form-group">
                                    <label for="class_id"><?php echo $this->lang->line('class'); ?> </label><small class="req"> *</small>
                                    <span><?php echo $coeficient['class_name']; ?> </span>
                                </div>

                                <!-- Affichage des sections sous forme de cases à cocher -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('sections'); ?></label><small class="req"> *</small>
                                    <span><?php echo $coeficient['section_name']; ?> </span>
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
            if ($this->rbac->hasPrivilege('coeficient', 'can_add') || $this->rbac->hasPrivilege('coeficient', 'can_edit')) {
                echo "8";
            } else {
                echo "12";
            }
            ?>">
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">List des Coefficients</h3>
                    </div>
                    <div class="box-body ">
                        <div class="table-responsive mailbox-messages overflow-visible">
                            <div class="download_label">List des Coefficients</div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('subject'); ?></th>
                                    <th><?php echo $this->lang->line('class'); ?></th>
                                    <th>Coefficient</th>
                                    <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $count = 1;
                                foreach ($coeficientlist as $coeficient) {
                                    ?>
                                    <tr>
                                        <td><?php echo $coeficient['subject_name']; // Afficher le nom de la matière ?></td>
                                        <td>
                                            <?php echo $coeficient['class_name']; // Afficher le nom de la classe ?>
                                            <span class="text-primary">  <?php echo $coeficient['section_name'];?>  </span>
                                        </td>
                                        <td><?php echo $coeficient['coeficient']; // Afficher la note maximale ?></td>

                                        <td class="text-right">
                                            <?php
                                            // Afficher le bouton d'édition si l'utilisateur a le privilège 'can_edit'
                                            if ($this->rbac->hasPrivilege('coeficient', 'can_edit')) {
                                                ?>
                                                <a href="<?php echo base_url(); ?>evaluation/coeficient/edit/<?php echo $coeficient['id']; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <?php
                                            }

                                            // Afficher le bouton de suppression si l'utilisateur a le privilège 'can_delete'
                                            if ($this->rbac->hasPrivilege('coeficient', 'can_delete')) {
                                                ?>
                                                <a href="<?php echo base_url(); ?>evaluation/coeficient/delete/<?php echo $coeficient['id']; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line("coeficient_will_also_delete_all_evalutions_under_this_coeficient_so_be_careful_as_this_action_is_irreversible"); ?>');">
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

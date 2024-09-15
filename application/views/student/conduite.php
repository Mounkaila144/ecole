<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> <?php echo $this->lang->line('academics'); ?> <small><?php echo $this->lang->line('student_fees1'); ?></small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php if ($this->rbac->hasPrivilege('evaluation', 'can_add') || $this->rbac->hasPrivilege('evaluation', 'can_edit')) { ?>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('edit_conduite'); ?></h3>
                        </div>
                        <form action="<?php echo site_url('student/conduite/' . $student_id); ?>" id="employeeform" method="post">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                    <?php $this->session->unset_userdata('msg'); ?>
                                <?php } ?>
                                <?php echo $this->customlib->getCSRF(); ?>

                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Semestre</th>
                                        <th>Note de conduite</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($semesters as $semester) { ?>
                                        <tr>
                                            <td><?php echo $semester['name']; ?></td>
                                            <td>
                                                <input type="number" class="form-control" name="notes[<?php echo $semester['id']; ?>]" value="<?php echo isset($conduites[$semester['id']]) ? $conduites[$semester['id']]['conduite'] : '18'; ?>" min="0" max="20" placeholder="Note sur 20">
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
        </div>
    </section>
</div>

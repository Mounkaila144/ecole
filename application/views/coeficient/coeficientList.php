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
            if ($this->rbac->hasPrivilege('coeficient', 'can_add')) {
                ?>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Ajouter un coefficient</h3>
                        </div>
                        <form method="post" action="<?php echo site_url('evaluation/coeficient/index'); ?>">

                            <div class="form-group">
                                <label for="subject_id"><?php echo $this->lang->line('subject'); ?></label>
                                <select id="subject_id" name="subject_id" class="form-control">
                                    <?php foreach ($subjectlist as $subject) { ?>
                                        <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('subject_id'); ?></span>
                            </div>

                            <div class="form-group">
                                <label for="coeficient">Coefficient</label>
                                <input type="number" name="coeficient" class="form-control" value="<?php echo set_value('coeficient'); ?>" min="0" step="0.1">
                                <span class="text-danger"><?php echo form_error('coeficient'); ?></span>
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

                            <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('save'); ?></button>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-<?php
            if ($this->rbac->hasPrivilege('coeficient', 'can_add')) {
                echo "8";
            } else {
                echo "12";
            }
            ?>">
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">List des coefficients</h3>
                    </div>
                    <div class="box-body ">
                        <div class="table-responsive mailbox-messages overflow-visible">
                            <div class="download_label">List des coefficients</div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('subject'); ?></th>
                                    <th><?php echo $this->lang->line('class'); ?></th>
                                    <th>coefficient</th>
                                    <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($coeficientlist as $coeficient) { ?>
                                    <tr>
                                        <td><?php echo $coeficient['subject_name']; ?></td>
                                        <td>
                                            <?php echo $coeficient['class_name']; // Afficher le nom de la classe ?>
                                            <span class="text-primary">  <?php echo $coeficient['section_name'];?>  </span>
                                        </td>
                                        <td><?php echo $coeficient['coeficient']; ?></td>
                                        <td class="text-right">
                                            <?php if ($this->rbac->hasPrivilege('coeficient', 'can_edit')) { ?>
                                                <a href="<?php echo base_url("evaluation/coeficient/edit/" . $coeficient['id']); ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            <?php } ?>
                                            <?php if ($this->rbac->hasPrivilege('coeficient', 'can_delete')) { ?>
                                                <a href="<?php echo base_url("evaluation/coeficient/delete/" . $coeficient['id']); ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line("coeficient_will_also_delete_all_evalutions_under_this_coeficient_so_be_careful_as_this_action_is_irreversible"); ?>');">
                                                    <i class="fa fa-remove"></i>
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
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
    var post_section_array = <?php echo json_encode($section_array); ?>;
    $(document).ready(function () {
        var post_class_id = '<?php echo set_value('class_id', 0) ?>';
        if (post_section_array !== null && post_section_array.length > 1) {

            $.each(post_section_array, function (i, elem) {

            });
        }

        getSectionByClass(post_class_id, 0);
        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });

        $(document).on('change', '#class_id', function (e) {
            var class_id = $(this).val();
            getSectionByClass(class_id, 0);
        });
    });

    function getSectionByClass(class_id, section_array) {
        $('.section_checkbox').html('');
        if (class_id !== "" && class_id !== 0) {
            var div_data = "";
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {'class_id': class_id},
                dataType: "json",
                beforeSend: function () {

                },
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        console.log(post_section_array);
                        console.log();
                        var check = "";
                        if (jQuery.inArray(obj.id, post_section_array) !== -1) {
                            check = "checked";
                        }

                        div_data += "<div class='checkbox'>";
                        div_data += "<label>";
                        div_data += "<input type='checkbox' class='content_available' name='sections[]' value='" + obj.id + "' " + check + ">" + obj.section;

                        div_data += "</label>";
                        div_data += "</div>";

                    });
                    $('.section_checkbox').html(div_data);
                },
                error: function (xhr) { // if error occured
                    alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");

                },
                complete: function () {

                }
            });
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
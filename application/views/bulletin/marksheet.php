<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-map-o"></i> <?php echo $this->lang->line('evaluations'); ?> <small><?php echo $this->lang->line('student_fee1'); ?></small>  </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <div class="box-body">
                        <form role="form" action="<?php echo site_url('evaluation/bulletin/index') ?>" method="post" class="row">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="col-sm-6 col-lg-4 col-md-4">
                                <div class="form-group">   
                                    <label><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
                                    <select id="class_id" name="class_id" class="form-control" >
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php
                                        foreach ($classlist as $class) {
                                            ?>
                                            <option value="<?php echo $class['id'] ?>" <?php
                                            if (set_value('class_id') == $class['id']) {
                                                echo "selected=selected";
                                            }
                                            ?>><?php echo $class['class'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                </div>  
                            </div>
                            <div class="col-sm-6 col-lg-4 col-md-4">
                                <div class="form-group"> 
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('section'); ?></label><small class="req"> *</small>
                                    <select  id="section_id" name="section_id" class="form-control" >
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('semester'); ?></label><small class="req"> *</small>
                                    <select id="semester_id" name="semester_id" class="form-control" >
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php
                                        foreach ($semesterlist as $semester) {
                                            ?>
                                            <option value="<?php echo $semester['id'] ?>" <?php
                                            if (set_value('semester_id') == $semester['id']) {
                                                echo "selected=selected";
                                            }
                                            ?>><?php echo $semester['name'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('semester_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="submit" name="search" value="search_filter" class="btn btn-primary pull-right btn-sm checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="aa"></div>
                    <?php
                    if (isset($studentList)) {
                        ?>
                        <form method="post" action="<?php echo base_url('bulletin/printmarksheet') ?>" id="printMarksheet">
                            <div class="box-header ptbnull"></div>
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix"><i class="fa fa-users"></i> <?php echo $this->lang->line('student_list'); ?></h3>
                                <button  class="btn btn-info btn-sm printSelected pull-right" type="submit" name="generate" title="generate multiple certificate"  data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> <?php echo $this->lang->line('please_wait') ; ?>" > <?php echo $this->lang->line('bulk_download'); ?></button>
                            </div>
                            <div class="box-body">
                                <div class="tab-pane active table-responsive no-padding" id="tab_1">
                                <?php if (!empty($studentList)) { ?>
                                    <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select_all" /></th>
                                                <th><?php echo $this->lang->line('student_name'); ?></th>
                                                <th><?php echo $this->lang->line('father_name'); ?></th>
                                                <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $count = 1;
                                                foreach ($studentList as $student_key => $student_value) {
                                                    ?>

                                                    <tr>
                                                        <td class="text-center"><input type="checkbox" class="checkbox center-block"  name="evaluation_class_batch_exam_student_id[]" data-student_id="<?php echo $student_value['id']; ?>" value="<?php echo $student_value['id']; ?>">
                                                        </td>
                                                        <td>
            <a href="<?php echo base_url(); ?>student/view/<?php echo $student_value['id']; ?>">
            <?php echo $student_value['firstname']; ?>
            
         </a>
        </td> 
                                                        <td><?php echo $student_value['lastname'];?></td>
                                                        <td><?php 
															if (!empty($student_value->dob) && $student_value->dob != '0000-00-00') {
															echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student_value->dob)); }?></td>
                                                        <td>

                        <button  type="button" class="btn btn-default btn-xs download_pdf" data-action="download" data-toggle="tooltip"  data-original-title="<?php echo $this->lang->line('download'); ?>"
                                 data-student_id="<?php echo $student_value['id']?>"
                                 data-semester_id="<?php echo $semester_id?>"
                                 data-section_id="<?php echo $section_id?>"
                                 data-class_id="<?php echo $class_id?>"
                                 data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" ><i class="fa fa-download"></i></button>
                       <button  type="button"  class="btn btn-default btn-xs email_pdf" data-action="email" data-evaluation_class_batch_exam_student_id="<?php echo $student_value['id']; ?>" id="load1" data-toggle="tooltip"  data-original-title="<?php echo $this->lang->line('sent_to_email'); ?>" data-student_id="<?php echo $student_value['id']?>" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" ><i class="fa fa-envelope"></i></button>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $count++;
                                                }
                                            ?>
                                        </tbody>
                                    <?php }else{ ?>
                                        <div class="alert alert-info"><?php echo $this->lang->line('no_record_found'); ?></div>
                                    <?php } ?>
                                    </table>
                                </div>                                                            
                            </div> 
                        </form>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
   $(document).on('click','.download_pdf',function(){

      var student_name = $(this).attr('data-student_name');
      let $button_ = $(this);
      var student_id=$button_.data('student_id');
      var class_id=$button_.data('class_id');
      var semester_id=$button_.data('semester_id');
      var section_id=$button_.data('section_id');
      var action=($button_.data('action'));

         $.ajax({
            type: 'POST',
            url: baseurl+'evaluation/bulletin/pdftmarksheet',
            data: {
                'type':action,
                'student_id':student_id,
                'class_id':class_id,
                'semester_id':semester_id,
                'section_id':section_id,
            },
         
            beforeSend: function() { 
               $button_.button('loading');    
            },
             xhr: function () {// Seems like the only way to get access to the xhr object
                var xhr = new XMLHttpRequest();
                xhr.responseType = 'blob'
                return xhr;
            },
           success: function (data, jqXHR, response) {           
                
                   var blob = new Blob([data], {type: 'application/pdf'});
                   var link = document.createElement('a');
                   link.href = window.URL.createObjectURL(blob);
                   link.download =  student_name;
                   document.body.appendChild(link);
                   link.click();
                   document.body.removeChild(link);
                   $button_.button('reset');
            },
            error: function(xhr) { // if error occured
              
                $button_.button('reset');
            },
            complete: function() {
             
                    $button_.button('reset');
              
            }
        });
    });

 $(document).on('click','.email_pdf',function(){
      let $button_ = $(this);
      let post_exam_id=$('#post_exam_id').val();
      let post_evaluation_id=$('#post_evaluation_id').val();
      var student_id=($button_.data('student_id'));
      var action=($button_.data('action'));
      var evaluation_class_batch_exam_student_id=($button_.data('evaluation_class_batch_exam_student_id'));
      let marksheet_template=$("input[name=marksheet_template]").val();
    $.ajax({
    type: 'POST',
    url: baseurl+'bulletin/pdftmarksheet',
    data: {
          'marksheet_template':marksheet_template,
        'type':action,
           'student_id':student_id,
           'evaluation_class_batch_exam_student_id':evaluation_class_batch_exam_student_id,
           'post_exam_id':post_exam_id,
           "post_evaluation_id":post_evaluation_id
          },
    dataType: 'JSON',
    beforeSend: function() {       
       $button_.button('loading');      
    },
   success: function (data, jqXHR, response) {
             if (data.status == 1) {
                  successMsg(data.message);
                } else {
                  errorMsg(data.message);
                }
            },
    error: function(xhr) { // if error occured      
        $button_.button('reset');
    },
    complete: function() {     
            $button_.button('reset');      
    }
});
    });

 $(document).ready(function () {
        $('.select2').select2();
    });
    var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy']) ?>';
    var class_id = '<?php echo set_value('class_id') ?>';
    var section_id = '<?php echo set_value('section_id') ?>';
    var session_id = '<?php echo set_value('session_id') ?>';
    var evaluation_id = '<?php echo set_value('evaluation_id') ?>';
    var exam_id = '<?php echo set_value('exam_id') ?>';
    getSectionByClass(class_id, section_id);
    getExamByExamgroup(evaluation_id, exam_id);
    $(document).on('change', '#evaluation_id', function (e) {
        $('#exam_id').html("");
        var evaluation_id = $(this).val();
        getExamByExamgroup(evaluation_id, 0);
    });

    $(document).on('change', '#class_id', function (e) {
        $('#section_id').html("");
        var class_id = $(this).val();
        getSectionByClass(class_id, 0);
    });

    function getSectionByClass(class_id, section_id) {
        if (class_id != "") {
            $('#section_id').html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';

            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {'class_id': class_id},
                dataType: "json",
                beforeSend: function () {
                    $('#section_id').addClass('dropdownloading');
                },
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        var sel = "";
                        if (section_id == obj.section_id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                },
                complete: function () {
                    $('#section_id').removeClass('dropdownloading');
                }
            });
        }
    }

    function getExamByExamgroup(evaluation_id, exam_id) {
        if (evaluation_id !== "") {
            $('#exam_id').html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';

            $.ajax({
                type: "POST",
                url: base_url + "evaluation/getExamByExamgroup",
                data: {'evaluation_id': evaluation_id},
                dataType: "json",
                beforeSend: function () {
                    $('#exam_id').addClass('dropdownloading');
                },
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        var sel = "";
                        if (exam_id === obj.id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.id + " " + sel + ">" + obj.exam + "</option>";
                    });

                    $('#exam_id').append(div_data);
                    $('#exam_id').trigger('change');
                },
                complete: function () {
                    $('#exam_id').removeClass('dropdownloading');
                }
            });
        }
    }
</script>
<script>

    $(document).on('submit', 'form#printMarksheet', function (e) {
        e.preventDefault();
        var form = $(this);
        var subsubmit_button = $(this).find(':submit');
        var formdata = form.serializeArray();
        var exam_name = $('#exam_id').find('option:selected').text();
        var session = $('#session_id').find('option:selected').text();
        var class_name = $('#class_id').find('option:selected').text();
        var section_name = $('#section_id').find('option:selected').text();
        var list_selected =  $('form#printMarksheet input[name="evaluation_class_batch_exam_student_id[]"]:checked').length;
      if(list_selected > 0){
        
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: formdata, // serializes the form's elements.
            beforeSend: function () {
                subsubmit_button.button('loading');
            },
             xhr: function () {// Seems like the only way to get access to the xhr object
                var xhr = new XMLHttpRequest();
                xhr.responseType = 'blob'
                return xhr;
            },
            success: function (data, jqXHR, response) {
       
                   var date_time = new Date().getTime();
                   var blob = new Blob([data], {type: 'application/pdf'});
                   var link = document.createElement('a');
                   link.href = window.URL.createObjectURL(blob);
                   link.download = exam_name +'_'+ session +'_'+ class_name +'_'+ section_name + ".pdf";
                   document.body.appendChild(link);
                   link.click();
                   document.body.removeChild(link);
                   subsubmit_button.button('reset');
            },
            error: function (xhr) { // if error occured

                alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
                subsubmit_button.button('reset');
            },
            complete: function () {
                subsubmit_button.button('reset');
            }
        });
      }else{
         confirm("<?php echo $this->lang->line('please_select_student'); ?>");
      }
    });

    $(document).on('click', '#select_all', function () {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
</script>

<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';
    function Popup(data)
    {
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
//Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
        return true;
    }
</script>
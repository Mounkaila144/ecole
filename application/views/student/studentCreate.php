<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<link href="<?php echo base_url(); ?>backend/multiselect/css/jquery.multiselect.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>backend/multiselect/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>backend/multiselect/js/jquery.multiselect.js"></script>

<style>
/* Enhanced Student Form Styling */
.student-form-container {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.student-form-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    text-align: center;
}

.form-title {
    margin: 0 0 10px 0;
    font-size: 28px;
    font-weight: 600;
}

.form-subtitle {
    margin: 0;
    opacity: 0.9;
    font-size: 16px;
}

.student-form-content {
    padding: 30px;
}

.form-section {
    margin-bottom: 40px;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
}

.section-title {
    background: #f8f9fa;
    margin: 0;
    padding: 20px 25px;
    font-size: 18px;
    font-weight: 600;
    color: #495057;
    border-bottom: 1px solid #e9ecef;
}

.section-content {
    padding: 25px;
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
}

.required {
    color: #dc3545;
}

.input-group-addon {
    background-color: #e9ecef;
    border-color: #ced4da;
    color: #495057;
}

.form-control {
    border-radius: 4px;
    border: 1px solid #ced4da;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.file-upload-area {
    position: relative;
}

.file-upload-area .form-text {
    margin-top: 5px;
    font-style: italic;
}

.sibling-section {
    padding: 15px 0;
}

.sibling-controls {
    display: flex;
    align-items: center;
    gap: 15px;
}

.btn-outline-primary {
    border: 2px solid #667eea;
    color: #667eea;
    background: transparent;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: #667eea;
    color: white;
    transform: translateY(-1px);
}

.sibling-display {
    flex: 1;
}

.sibling-tag {
    background: #28a745;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 14px;
    display: inline-block;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .student-form-header {
        padding: 20px;
    }

    .form-title {
        font-size: 24px;
    }

    .student-form-content {
        padding: 20px;
    }

    .section-content {
        padding: 20px;
    }

    .sibling-controls {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}

/* Form group spacing */
.form-group {
    margin-bottom: 20px;
}

/* Enhanced button styling */
.box-footer {
    background: #f8f9fa;
    padding: 25px 30px;
    border-top: 1px solid #e9ecef;
    text-align: center;
}

.box-footer .btn {
    padding: 12px 40px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 25px;
    transition: all 0.3s ease;
}

.box-footer .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Alert styling */
.alert {
    border-radius: 8px;
    border: none;
    padding: 15px 20px;
}

/* Custom field improvements */
.custom-fields-section {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    margin: 20px 0;
}

/* Enhanced modal styling */
.modal-content {
    border-radius: 10px;
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.modal-header {
    border-radius: 10px 10px 0 0;
    border-bottom: none;
    padding: 20px 25px;
}

.modal-title {
    font-weight: 600;
}

.modal-body {
    padding: 25px;
}

.modal-footer {
    border-radius: 0 0 10px 10px;
    border-top: 1px solid #e9ecef;
    padding: 20px 25px;
}

/* Input group button styling */
.input-group-btn .btn {
    border-left: none;
    border-radius: 0 4px 4px 0;
    padding: 10px 12px;
}

.input-group-btn .btn:hover {
    z-index: 0;
}

/* Enhanced button hover effects */
.btn-outline-success {
    border: 2px solid #28a745;
    color: #28a745;
    background: transparent;
    transition: all 0.3s ease;
}

.btn-outline-success:hover {
    background: #28a745;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
}

/* Form submission button styling */
#classSubmitBtn, #sectionSubmitBtn {
    min-width: 120px;
}

#classSubmitBtn:hover, #sectionSubmitBtn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
}

/* Alert positioning */
.alert-dismissible {
    padding-right: 35px;
}

.alert .close {
    right: 0;
}

/* Responsive modal improvements */
@media (max-width: 768px) {
    .modal-dialog {
        margin: 10px;
    }

    .input-group-btn {
        width: auto;
    }

    .input-group-btn .btn {
        padding: 8px 10px;
    }
}
</style>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="pull-right box-tools impbtntitle">
                        <?php if ($this->rbac->hasPrivilege('import_student', 'can_view')) {?>
                            <a href="<?php echo site_url('student/import') ?>">
                                <button class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> <?php echo $this->lang->line('import_student'); ?></button>
                            </a>
                        <?php }
?>
                    </div>
                    <form id="form1" action="<?php echo site_url('student/create') ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <div class="student-form-container">
                            <div class="student-form-header">
                                <h3 class="form-title">
                                    <i class="fa fa-user-plus"></i>
                                    <?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('admission'); ?>
                                </h3>
                                <p class="form-subtitle">Enter student information below</p>
                            </div>
                            <div class="student-form-content">
                                    <?php if ($this->session->flashdata('msg')) {
    ?>
                                        <?php
echo $this->session->flashdata('msg');
    $this->session->unset_userdata('msg');
    ?>
                                    <?php }?>

                                    <?php //if (isset($error_message)) {?>
                                        <!--<div class="alert alert-warning"><?php //echo $error_message; ?></div> -->
                                    <?php //}?>
                                    <?php echo $this->customlib->getCSRF(); ?>
                                    <input type="hidden" name="sibling_name" value="<?php echo set_value('sibling_name'); ?>" id="sibling_name_next">
                                    <input type="hidden" name="sibling_id" value="<?php echo set_value('sibling_id', 0); ?>" id="sibling_id">
                                <!-- Basic Information Section -->
                                <div class="form-section">
                                    <h4 class="section-title">
                                        <i class="fa fa-info-circle"></i>
                                        Basic Information
                                    </h4>
                                    <div class="section-content">
                                        <div class="row">
                                            <?php if (!$adm_auto_insert) {?>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="admission_no" class="form-label">
                                                            <?php echo $this->lang->line('admission_no'); ?>
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                                            <input autofocus="" id="admission_no" name="admission_no" placeholder="Enter admission number" type="text" class="form-control" value="<?php echo set_value('admission_no'); ?>" />
                                                        </div>
                                                        <span class="text-danger"><?php echo form_error('admission_no'); ?></span>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="class_id" class="form-label">
                                                        <?php echo $this->lang->line('class'); ?>
                                                        <span class="required">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>
                                                        <select id="class_id" name="class_id" class="form-control">
                                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                            <?php foreach ($classlist as $class) { ?>
                                                                <option value="<?php echo $class['id'] ?>"<?php if (set_value('class_id') == $class['id']) { echo "selected=selected"; } ?>>
                                                                    <?php echo $class['class'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-outline-success btn-sm" onclick="showClassModal()" title="Create New Class">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="section_id" class="form-label">
                                                        <?php echo $this->lang->line('section'); ?>
                                                        <span class="required">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                                                        <select id="section_id" name="section_id" class="form-control">
                                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                        </select>
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-outline-success btn-sm" onclick="showSectionModal()" title="Create New Section">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Personal Information Section -->
                                <div class="form-section">
                                    <h4 class="section-title">
                                        <i class="fa fa-user"></i>
                                        Personal Information
                                    </h4>
                                    <div class="section-content">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="firstname" class="form-label">
                                                        <?php echo $this->lang->line('first_name'); ?>
                                                        <span class="required">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <input id="firstname" name="firstname" placeholder="Enter first name" type="text" class="form-control" value="<?php echo set_value('firstname'); ?>" />
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('firstname'); ?></span>
                                                </div>
                                            </div>
                                            <?php if ($sch_setting->middlename) {?>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="middlename" class="form-label">
                                                            <?php echo $this->lang->line('middle_name'); ?>
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                            <input id="middlename" name="middlename" placeholder="Enter middle name" type="text" class="form-control" value="<?php echo set_value('middlename'); ?>" />
                                                        </div>
                                                        <span class="text-danger"><?php echo form_error('middlename'); ?></span>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <?php if ($sch_setting->lastname) {?>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="lastname" class="form-label">
                                                            <?php echo $this->lang->line('last_name'); ?>
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                            <input id="lastname" name="lastname" placeholder="Enter last name" type="text" class="form-control" value="<?php echo set_value('lastname'); ?>" />
                                                        </div>
                                                        <span class="text-danger"><?php echo form_error('lastname'); ?></span>
                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="gender" class="form-label">
                                                        <?php echo $this->lang->line('gender'); ?>
                                                        <span class="required">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-venus-mars"></i></span>
                                                        <select class="form-control" name="gender">
                                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                            <?php foreach ($genderList as $key => $value) { ?>
                                                                <option value="<?php echo $key; ?>" <?php if (set_value('gender') == $key) { echo "selected"; } ?>>
                                                                    <?php echo $value; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('gender'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="dob" class="form-label">
                                                        <?php echo $this->lang->line('date_of_birth'); ?>
                                                        <span class="required">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        <input id="dob" name="dob" placeholder="Select date of birth" type="text" class="form-control date" value="<?php echo set_value('dob'); ?>" />
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('dob'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                         <div class="row">
                                             <?php if ($sch_setting->mobile_no) {?>
                                                 <div class="col-md-4">
                                                     <div class="form-group">
                                                         <label for="mobileno" class="form-label">
                                                             <?php echo $this->lang->line('mobile_number'); ?>
                                                         </label>
                                                         <div class="input-group">
                                                             <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                             <input id="mobileno" name="mobileno" placeholder="Enter mobile number" type="text" class="form-control" value="<?php echo set_value('mobileno'); ?>" />
                                                         </div>
                                                         <span class="text-danger"><?php echo form_error('mobileno'); ?></span>
                                                     </div>
                                                 </div>
                                             <?php }?>
                                             <?php if ($sch_setting->student_email) {?>
                                                 <div class="col-md-4">
                                                     <div class="form-group">
                                                         <label for="email" class="form-label">
                                                             <?php echo $this->lang->line('email'); ?>
                                                         </label>
                                                         <div class="input-group">
                                                             <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                             <input id="email" name="email" placeholder="Enter email address" type="text" class="form-control" value="<?php echo set_value('email'); ?>" />
                                                         </div>
                                                         <span class="text-danger"><?php echo form_error('email'); ?></span>
                                                     </div>
                                                 </div>
                                             <?php }?>
                                             <?php if ($sch_setting->admission_date) {?>
                                                 <div class="col-md-4">
                                                     <div class="form-group">
                                                         <label for="admission_date" class="form-label">
                                                             <?php echo $this->lang->line('admission_date'); ?>
                                                         </label>
                                                         <div class="input-group">
                                                             <span class="input-group-addon"><i class="fa fa-calendar-check-o"></i></span>
                                                             <input id="admission_date" name="admission_date" placeholder="" type="text" class="form-control date" value="<?php echo set_value('admission_date', date($this->customlib->getSchoolDateFormat())); ?>" readonly="readonly" />
                                                         </div>
                                                         <span class="text-danger"><?php echo form_error('admission_date'); ?></span>
                                                     </div>
                                                 </div>
                                             <?php }?>
                                         </div>
                                         <div class="row">
                                             <?php if ($sch_setting->student_photo) {?>
                                                 <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="file" class="form-label">
                                                             <?php echo $this->lang->line('student_photo'); ?>
                                                         </label>
                                                         <div class="file-upload-area">
                                                             <input class="filestyle form-control" type='file' name='file' id="file" size='20' />
                                                             <small class="form-text text-muted">Upload a clear photo of the student (JPG, PNG, max 2MB)</small>
                                                         </div>
                                                         <span class="text-danger"><?php echo form_error('file'); ?></span>
                                                     </div>
                                                 </div>
                                             <?php }?>
                                             <div class="col-md-6">
                                                 <div class="sibling-section">
                                                     <label class="form-label">Siblings</label>
                                                     <div class="sibling-controls">
                                                         <button type="button" class="btn btn-outline-primary btn-sm" onclick="showSiblingModal()">
                                                             <i class="fa fa-plus"></i> <?php echo $this->lang->line('add_sibling'); ?>
                                                         </button>
                                                         <div id='sibling_id' class="sibling-display">
                                                             <span id="sibling_name" class="sibling-tag"><?php echo set_value('sibling_name'); ?></span>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                <!-- Custom Fields Section -->
                                <div class="form-section custom-fields-section">
                                    <h4 class="section-title">
                                        <i class="fa fa-cogs"></i>
                                        Additional Information
                                    </h4>
                                    <div class="section-content">
                                        <div class="row">
                                            <?php echo display_custom_fields('students'); ?>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </div>
                            </div>
                         <div class="mainstudent">
                             <div id="fade"></div>
                        <div id="modal">

                            <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span>
                            <img id="loader" src="<?php //echo base_url('backend/images/chatloading.gif'); ?>">
                        </div>

                        <h4 class="pagetitleh2">
            <?php echo $this->lang->line('fees_details'); ?>
            <span class="float-right bmedium total_fees_alloted">
             <?php

$view_total_fees = 0;
foreach ($feesessiongroup_model as $feesessiongroup_key => $feesessiongroup_value) {
    $total_fees = 0;

    foreach ($feesessiongroup_value->feetypes as $fee_type_key => $fee_type_value) {
        $total_fees += $fee_type_value->amount;
    }

    if (isset($_POST['fee_session_group_id'])) {
        if (in_array($feesessiongroup_value->id, $_POST['fee_session_group_id'])) {
            $view_total_fees += $total_fees;
        }
    }
}
if(!empty($view_total_fees)){
echo amountFormat($view_total_fees);
}
?>
<input type="hidden" name="total_post_fees" value="<?php echo $view_total_fees; ?>">
            </span>
                         </h4>
                                                    <div class="row around10">
                                                        <div class="col-md-12">
                                      <?php
if (!empty($feesessiongroup_model)) {
    ?>
<div class="table-responsive border0">
<table class="table mb0">
    <tbody>
        <?php
foreach ($feesessiongroup_model as $feesessiongroup_key => $feesessiongroup_value) {
        $total_fees = 0;

        foreach ($feesessiongroup_value->feetypes as $fee_type_key => $fee_type_value) {
            $total_fees += $fee_type_value->amount;
        }
        ?>
                                          <tr>
                                            <td colspan="3" class="mailbox-name white-space-nowrap border0">
                                                  <div class="panel-group1 mb0">
    <div class="panel panel-default1">
      <div class="panel-heading pt5 pb5">
        <h6 class="panel-title panel-title1 overflow-hidden">
          <input class="fee_group_chk vertical-middle" type="checkbox" name="fee_session_group_id[]" value="<?php echo $feesessiongroup_value->id; ?>" <?php echo set_checkbox('fee_session_group_id[]', $feesessiongroup_value->id); ?>>
          <a class="display-inline collapsed box-plus-panel" data-toggle="collapse" href="#collapse_fees_<?php echo $feesessiongroup_value->id ?>">
             <span class="font14"><?php echo $feesessiongroup_value->group_name; ?></span></a>
          <span class="float-right bmedium pt3 fee_group_total" data-amount="<?php echo ($total_fees); ?>"><?php echo amountFormat($total_fees); ?></span>
        </h6>
      </div>
      <div id="collapse_fees_<?php echo $feesessiongroup_value->id ?>" class="panel-collapse collapse">
            <ul class="list-group student_fee_list ui-sortable">
                <li class="list-group-item"><div class="displayinline stfirstdiv bmedium font14 pl-65"><?php echo $this->lang->line('fees_type'); ?></div>
                    <div class="due_date bmedium font14"><?php echo $this->lang->line('due_date'); ?></div>
                    <div class="tools bmedium font14"><?php echo $this->lang->line('amount'); ?> (<?php echo $currency_symbol; ?>)</div>
                </li>
            <?php
foreach ($feesessiongroup_value->feetypes as $fee_type_key => $fee_type_value) {
            ?>
                    <li class="list-group-item">
                        <div class="displayinline stfirstdiv pl-65"><?php echo $fee_type_value->type . " (" . $fee_type_value->code . ")" ?></div>
                    <small class="due_date"><i class="fa fa-calendar"></i> <?php
echo $this->customlib->dateformat($fee_type_value->due_date);
            ?></small>
                <div class="tools">
                       <?php echo amountFormat($fee_type_value->amount); ?>
                                  </div>
                    </li>
                  <?php
}
        ?>
         </ul>
      </div>
    </div>
  </div>
                                            </td>
                                          </tr>
                                        <?php
}
    ?>
    </tbody>
</table>
</div>
    <?php
}
?>
                                                        </div>
                                                    </div>
                                                </div>

                            <?php if (($sch_setting->father_name) || ($sch_setting->father_phone) || ($sch_setting->father_occupation) || ($sch_setting->father_pic) || ($sch_setting->mother_name) || ($sch_setting->mother_phone) || ($sch_setting->mother_occupation) || ($sch_setting->mother_pic) || ($sch_setting->guardian_name) || ($sch_setting->guardian_occupation) || ($sch_setting->guardian_relation) || ($sch_setting->guardian_phone) || ($sch_setting->guardian_email) || ($sch_setting->guardian_pic) || ($sch_setting->guardian_address)) {
    ?>
                            <div class="bozero">
                                <h4 class="pagetitleh2"><?php echo $this->lang->line('parent_guardian_detail'); ?></h4>
                                <div class="around10">
                                    <div class="row">
<?php if ($sch_setting->father_name) {?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('father_name'); ?></label>
                                                    <input id="father_name" name="father_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_name'); ?>" />
                                                    <span class="text-danger"><?php echo form_error('father_name'); ?></span>
                                                </div>
                                            </div>
<?php }if ($sch_setting->father_phone) {?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('father_phone'); ?></label>
                                                    <input id="father_phone" name="father_phone" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_phone'); ?>" />
                                                    <span class="text-danger"><?php echo form_error('father_phone'); ?></span>
                                                </div>
                                            </div>
<?php }if ($sch_setting->father_occupation) {?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('father_occupation'); ?></label>
                                                    <input id="father_occupation" name="father_occupation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_occupation'); ?>" />
                                                    <span class="text-danger"><?php echo form_error('father_occupation'); ?></span>
                                                </div>
                                            </div>
<?php }if ($sch_setting->father_pic) {?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputFile"><?php echo $this->lang->line('father_photo'); ?></label>
                                                    <div><input class="filestyle form-control" type='file' name='father_pic' id="file" size='20' />
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('file'); ?></span></div>
                                            </div>
<?php }?>
                                    </div>
                                    <div class="row">
<?php if ($sch_setting->mother_name) {?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('mother_name'); ?></label>
                                                    <input id="mother_name" name="mother_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_name'); ?>" />
                                                    <span class="text-danger"><?php echo form_error('mother_name'); ?></span>
                                                </div>
                                            </div>
<?php }if ($sch_setting->mother_phone) {?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('mother_phone'); ?></label>
                                                    <input id="mother_phone" name="mother_phone" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_phone'); ?>" />
                                                    <span class="text-danger"><?php echo form_error('mother_phone'); ?></span>
                                                </div>
                                            </div>
<?php }if ($sch_setting->mother_occupation) {?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('mother_occupation'); ?></label>
                                                    <input id="mother_occupation" name="mother_occupation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_occupation'); ?>" />
                                                    <span class="text-danger"><?php echo form_error('mother_occupation'); ?></span>
                                                </div>
                                            </div>
<?php }if ($sch_setting->mother_pic) {?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputFile"><?php echo $this->lang->line('mother_photo'); ?></label>
                                                    <div><input class="filestyle form-control" type='file' name='mother_pic' id="file" size='20' />
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('file'); ?></span></div>
                                            </div>
<?php }?>
                                    </div>
                                    <?php
if ($sch_setting->guardian_name) {
        ?>
                                        <div class="row">
                                        <div class="form-group col-md-12">
                                            <label><?php echo $this->lang->line('if_guardian_is'); ?><small class="req"> *</small>&nbsp;&nbsp;&nbsp;</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="guardian_is" <?php
echo set_value('guardian_is') == "father" ? "checked" : "";
        ?>   value="father"> <?php echo $this->lang->line('father'); ?>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="guardian_is" <?php
echo set_value('guardian_is') == "mother" ? "checked" : "";
        ?>   value="mother"> <?php echo $this->lang->line('mother'); ?>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="guardian_is" <?php
echo set_value('guardian_is') == "other" ? "checked" : "";
        ?>   value="other"> <?php echo $this->lang->line('other'); ?>
                                            </label>
                                            <span class="text-danger"><?php echo form_error('guardian_is'); ?></span>
                                        </div>
                                    </div>
                                        <?php
}
    ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                 <?php
if ($sch_setting->guardian_name) {
        ?>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_name'); ?></label><small class="req"> *</small>
                                                        <input id="guardian_name" name="guardian_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_name'); ?>" />
                                                        <span class="text-danger"><?php echo form_error('guardian_name'); ?></span>
                                                    </div>
                                                </div>
<?php }if ($sch_setting->guardian_relation) {?>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_relation'); ?></label>
                                                            <input id="guardian_relation" name="guardian_relation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_relation'); ?>" />
                                                            <span class="text-danger"><?php echo form_error('guardian_relation'); ?></span>
                                                        </div>
                                                    </div>
                                    <?php }?>
                                            </div>
                                            <div class="row">
                                                <?php
if ($sch_setting->guardian_phone) {
        ?>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_phone'); ?></label><small class="req"> *</small>
                                                        <input id="guardian_phone" name="guardian_phone" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_phone'); ?>" />
                                                        <span class="text-danger"><?php echo form_error('guardian_phone'); ?></span>
                                                    </div>
                                                </div>
                                            <?php }
    if ($sch_setting->guardian_occupation) {
        ?>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_occupation'); ?></label>
                                                        <input id="guardian_occupation" name="guardian_occupation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_occupation'); ?>" />
                                                        <span class="text-danger"><?php echo form_error('guardian_occupation'); ?></span>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            </div>
                                        </div>
                                    <?php if ($sch_setting->guardian_email) {?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_email'); ?></label>
                                                    <input id="guardian_email" name="guardian_email" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_email'); ?>" />
                                                    <span class="text-danger"><?php echo form_error('guardian_email'); ?></span>
                                                </div>
                                            </div>
<?php }if ($sch_setting->guardian_pic) {?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputFile"><?php echo $this->lang->line('guardian_photo'); ?></label>
                                                    <div><input class="filestyle form-control" type='file' name='guardian_pic' id="file" size='20' />
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('file'); ?></span></div>
                                            </div>
<?php }if ($sch_setting->guardian_address) {?>
                                            <div class="col-md-6">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_address'); ?></label>
                                                <textarea id="guardian_address" name="guardian_address" placeholder="" class="form-control" rows="2"><?php echo set_value('guardian_address'); ?></textarea>
                                                <span class="text-danger"><?php echo form_error('guardian_address'); ?></span>
                                            </div>
<?php }?>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                            <div class="box-group collapsed-box">
                                <div class="panel box collapsed-box border0 mb0">
                                    <div class="addmoredetail-title">
                                        <a data-widget="collapse" data-original-title="Collapse" class="collapsed btn boxplus">
                                            <i class="fa fa-fw fa-plus"></i><?php echo $this->lang->line('add_more_details'); ?>
                                        </a>
                                    </div>
                                    <div class="box-body">
                                        <div class="mb25 bozero">
                                            <h4 class="pagetitleh2"><?php echo $this->lang->line('student_address_details'); ?></h4>

                                            <div class="row around10">
<?php if ($sch_setting->current_address) {?>
                                                    <div class="col-md-6">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" id="autofill_current_address" onclick="return auto_fill_guardian_address();">
    <?php echo $this->lang->line('if_guardian_address_is_current_address'); ?>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('current_address'); ?></label>
                                                            <textarea id="current_address" name="current_address" placeholder=""  class="form-control" ><?php echo set_value('current_address'); ?></textarea>
                                                            <span class="text-danger"><?php echo form_error('current_address'); ?></span>
                                                        </div>
                                                    </div>
<?php }if ($sch_setting->permanent_address) {?>
                                                    <div class="col-md-6">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" id="autofill_address"onclick="return auto_fill_address();">
    <?php echo $this->lang->line('if_permanent_address_is_current_address'); ?>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('permanent_address'); ?></label>
                                                            <textarea id="permanent_address" name="permanent_address" placeholder="" class="form-control"><?php echo set_value('permanent_address'); ?></textarea>
                                                            <span class="text-danger"><?php echo form_error('permanent_address'); ?></span>
                                                        </div>
                                                    </div>
<?php }?>
                                            </div>
                                        </div>

                                        <div class="tshadow mb25 bozero">
                                            <h4 class="pagetitleh2"><?php echo $this->lang->line('miscellaneous_details'); ?>
                                            </h4>
                                                <div class="row around10">
                                                    <?php if ($sch_setting->bank_account_no) {?>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('bank_account_number'); ?></label>
                                                            <input id="bank_account_no" name="bank_account_no" placeholder="" type="text" class="form-control"  value="<?php echo set_value('bank_account_no'); ?>" />
                                                            <span class="text-danger"><?php echo form_error('bank_account_no'); ?></span>
                                                        </div>
                                                    </div><?php }if ($sch_setting->bank_name) {?>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('bank_name'); ?></label>
                                                            <input id="bank_name" name="bank_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('bank_name'); ?>" />
                                                            <span class="text-danger"><?php echo form_error('bank_name'); ?></span>
                                                        </div>
                                                    </div><?php }if ($sch_setting->ifsc_code) {?>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('ifsc_code'); ?></label>
                                                            <input id="ifsc_code" name="ifsc_code" placeholder="" type="text" class="form-control"  value="<?php echo set_value('ifsc_code'); ?>" />
                                                            <span class="text-danger"><?php echo form_error('ifsc_code'); ?></span>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                </div>
                                            <div class="row around10">
<?php if ($sch_setting->national_identification_no) {?>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">
    <?php echo $this->lang->line('national_identification_number'); ?>
                                                            </label>
                                                            <input id="adhar_no" name="adhar_no" placeholder="" type="text" class="form-control"  value="<?php echo set_value('adhar_no'); ?>" />
                                                            <span class="text-danger"><?php echo form_error('adhar_no'); ?></span>
                                                        </div>
                                                    </div>
<?php }if ($sch_setting->local_identification_no) {?>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">
    <?php echo $this->lang->line('local_identification_number'); ?>
                                                            </label>
                                                            <input id="samagra_id" name="samagra_id" placeholder="" type="text" class="form-control"  value="<?php echo set_value('samagra_id'); ?>" />
                                                            <span class="text-danger"><?php echo form_error('samagra_id'); ?></span>
                                                        </div>
                                                    </div>
<?php }if ($sch_setting->rte) {
    ?>
                                                    <div class="col-md-4">
                                                        <label><?php echo $this->lang->line('rte'); ?></label>
                                                        <div class="radio" style="margin-top: 2px;">
                                                            <label><input class="radio-inline" type="radio" name="rte" value="Yes"  <?php
echo set_value('rte') == "yes" ? "checked" : "";
    ?>  ><?php echo $this->lang->line('yes'); ?></label>
                                                            <label><input class="radio-inline" checked="checked" type="radio" name="rte" value="No" <?php
echo set_value('rte') == "no" ? "checked" : "";
    ?>  ><?php echo $this->lang->line('no'); ?></label>
                                                        </div>
                                                        <span class="text-danger"><?php echo form_error('rte'); ?></span>
                                                    </div>
<?php }if ($sch_setting->previous_school_details) {?>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('previous_school_details'); ?></label>
                                                            <textarea class="form-control" rows="3" placeholder="" name="previous_school"></textarea>
                                                            <span class="text-danger"><?php echo form_error('previous_school'); ?></span>
                                                        </div>
                                                    </div>
<?php }if ($sch_setting->student_note) {?>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('note'); ?></label>
                                                            <textarea class="form-control" rows="3" placeholder="" name="note"></textarea>
                                                            <span class="text-danger"><?php echo form_error('note'); ?></span>
                                                        </div>
                                                    </div>
<?php }?>
                                            </div>
                                        </div>
                                        <div id='upload_documents_hide_show'>
<?php if ($sch_setting->upload_documents) {?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="tshadow bozero">
                                                            <h4 class="pagetitleh2"><?php echo $this->lang->line('upload_documents'); ?></h4>
                                                            <div class="row around10">
                                                                <div class="col-md-6">
                                                                    <table class="table">
                                                                        <tbody><tr>
                                                                                <th style="width: 10px">#</th>
                                                                                <th><?php echo $this->lang->line('title'); ?></th>
                                                                                <th><?php echo $this->lang->line('documents'); ?></th>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>1.</td>
                                                                                <td><input type="text" name='first_title' class="form-control" placeholder=""></td>
                                                                                <td>
                                                                                    <input class="filestyle form-control" type='file' name='first_doc' id="doc1" >
                                                                                    <span class="text-danger"><?php echo form_error('first_doc'); ?></span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>2.</td>
                                                                                <td><input type="text" name='second_title' class="form-control" placeholder=""></td>
                                                                                <td>
                                                                                    <input class="filestyle form-control" type='file' name='second_doc' id="doc1" >
                                                                                    <span class="text-danger"><?php echo form_error('second_doc'); ?></span>
                                                                                </td>
                                                                            </tr>

                                                                        </tbody></table>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <table class="table">
                                                                        <tbody><tr>
                                                                                <th style="width: 10px">#</th>
                                                                                <th><?php echo $this->lang->line('title'); ?></th>
                                                                                <th><?php echo $this->lang->line('documents'); ?></th>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>3.</td>
                                                                                <td><input type="text" name='fourth_title' class="form-control" placeholder=""></td>
                                                                                <td>
                                                                                    <input class="filestyle form-control" type='file' name='fourth_doc' id="doc1" >
                                                                                    <span class="text-danger"><?php echo form_error('fourth_doc'); ?></span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>4.</td>
                                                                                <td><input type="text" name='fifth_title' class="form-control" placeholder=""></td>
                                                                                <td>
                                                                                    <input class="filestyle form-control" type='file' name='fifth_doc' id="doc1" >
                                                                                    <span class="text-danger"><?php echo form_error('fifth_doc'); ?></span>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
<?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right" id="addloader"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Class Creation Modal -->
<div class="modal fade" id="classModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-graduation-cap"></i>
                    <?php echo $this->lang->line('create_class'); ?>
                </h4>
            </div>
            <form id="classForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="class_name"><?php echo $this->lang->line('class_name'); ?><span class="required">*</span></label>
                                <input type="text" class="form-control" id="class_name" name="class" required placeholder="Ex: Informatique, Mathématiques">
                                <span class="text-danger" id="class_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('sections'); ?><span class="required">*</span></label>
                                <div id="sectionsContainer">
                                    <!-- Sections will be loaded here via AJAX -->
                                </div>
                                <span class="text-danger" id="sections_error"></span>
                                <small class="text-muted">Select existing sections to associate with this class</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                    <button type="submit" class="btn btn-success" id="classSubmitBtn">
                        <i class="fa fa-plus"></i> <?php echo $this->lang->line('create'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Section Creation Modal -->
<div class="modal fade" id="sectionModal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-sitemap"></i>
                    <?php echo $this->lang->line('create_section'); ?>
                </h4>
            </div>
            <form id="sectionForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="section_name"><?php echo $this->lang->line('section_name'); ?><span class="required">*</span></label>
                        <input type="text" class="form-control" id="section_name" name="section" required placeholder="Ex: Licence 1, Master 2, etc.">
                        <span class="text-danger" id="section_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                    <button type="submit" class="btn btn-success" id="sectionSubmitBtn">
                        <i class="fa fa-plus"></i> <?php echo $this->lang->line('create'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="mySiblingModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title title modal_title"></h4>
            </div>
            <div class="modal-body pb0">
                <div class="form-horizontal">
                    <div class="box-body pt0 pb0">
                        <input  type="hidden" class="form-control" id="transport_student_session_id"  value="0" readonly="readonly"/>
                        <div class="form-group">
                            <div class="sibling_msg">
                        </div>
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('class'); ?></label>
                            <div class="col-sm-10">
                                <select  id="sibiling_class_id" name="sibiling_class_id" class="form-control"  >
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    <?php
foreach ($classlist as $class) {
    ?>
                                        <option value="<?php echo $class['id'] ?>"<?php
if (set_value('sibiling_class_id') == $class['id']) {
        echo "selected=selected";
    }
    ?>><?php echo $class['class'] ?></option>
                                                <?php
$count++;
}
?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label"><?php echo $this->lang->line('section'); ?></label>
                            <div class="col-sm-10">
                                <select  id="sibiling_section_id" name="sibiling_section_id" class="form-control">
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                </select>
                                <span class="text-danger" id="transport_amount_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label"><?php echo $this->lang->line('student'); ?>
                            </label>
                            <div class="col-sm-10">
                                <select  id="sibiling_student_id" name="sibiling_student_id" class="form-control" >
                                    <option value=""   ><?php echo $this->lang->line('select'); ?></option>
                                </select>
                                <span class="text-danger" id="sibiling_student_id
"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary add_sibling" id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"><i class="fa fa-user"></i> <?php echo $this->lang->line('add'); ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
     
     
    $('#addloader').on('click',function(){
       $('#addloader').html('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><?php echo $this->lang->line('loading'); ?>');
    });
    
    
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy']) ?>';
        var class_id = $('#class_id').val();
        var section_id = '<?php echo set_value('section_id', 0) ?>';
        var hostel_id = $('#hostel_id').val();
        var hostel_room_id = '<?php echo set_value('hostel_room_id', 0) ?>';
        var vehroute_id = '<?php echo set_value('vehroute_id', 0) ?>';
        var route_pickup_point_id = '<?php echo set_value('route_pickup_point_id', 0) ?>';
        getHostel(hostel_id, hostel_room_id);
        getSectionByClass(class_id, section_id);
        get_pickup_point(vehroute_id,route_pickup_point_id);

        $(document).on('change', '#class_id', function (e) {
            $('#section_id').html("");
            var class_id = $(this).val();
            if (class_id) {
                getSectionByClass(class_id, 0);
            } else {
                $('#section_id').html('<option value=""><?php echo $this->lang->line('select'); ?></option>');
            }
        });

        $(".color").colorpicker();

        $("#btnreset").click(function () {
            $("#form1")[0].reset();
        });

        $(document).on('change', '#hostel_id', function (e) {
            var hostel_id = $(this).val();
            getHostel(hostel_id, 0);
        });

        function getSectionByClass(class_id, section_id) {

            if (class_id != "") {
                $('#section_id').html("");
                var base_url = '<?php echo base_url() ?>';
                var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                var url = "<?php
$userdata = $this->customlib->getUserData();
if (($userdata["role_id"] == 2)) {
    echo "getClassTeacherSection";
} else {
    echo "getByClass";
}
?>";

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
                        $('#section_id').html(div_data);

                        // Auto-select first section if no specific section was requested and we have sections
                        if (section_id == 0 && data.length > 0) {
                            $('#section_id').val(data[0].section_id);
                        }
                    },
                    complete: function () {
                        $('#section_id').removeClass('dropdownloading');
                    }
                });
            }
        }

    $(document).on('change','#vehroute_id',function(){

   var vehroute_id=$(this).val();
   get_pickup_point(vehroute_id,0);
    });

    function get_pickup_point(vehroute_id,pickuppoint_id){
         if (vehroute_id != "") {

           var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
        $.ajax({
                url: baseurl+'admin/pickuppoint/get_pickupdropdownlist',
                type: "POST",
                data:{vehroute_id:vehroute_id},
                dataType: 'json',
                 beforeSend: function() {
                    $('#pickup_point').html('');
                },
                success: function(res) {

                    $.each(res, function (index, value) {
                         var sel = "";
                            if (pickuppoint_id == value.route_pickup_point_id) {
                                sel = "selected";
                            }

                        div_data += "<option  value=" + value.route_pickup_point_id + " " + sel + ">" + value.name + "</option>";
                    });

                    $('#pickup_point').html(div_data);
                },
                   error: function(xhr) { // if error occured
                   alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            },
            complete: function() {

            }
            });
    }

    }

        function getHostel(hostel_id, hostel_room_id) {
            if (hostel_room_id == "") {
                hostel_room_id = 0;
            }

            if (hostel_id != "") {
                $('#hostel_room_id').html("");

                var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                $.ajax({
                    type: "GET",
                    url: baseurl + "admin/hostelroom/getRoom",
                    data: {'hostel_id': hostel_id},
                    dataType: "json",
                    beforeSend: function () {
                        $('#hostel_room_id').addClass('dropdownloading');
                    },
                    success: function (data) {
                        $.each(data, function (i, obj)
                        {
                            var sel = "";
                            if (hostel_room_id == obj.id) {
                                sel = "selected";
                            }

                            div_data += "<option value=" + obj.id + " " + sel + ">" + obj.room_no + " (" + obj.room_type + ")" + "</option>";

                        });
                        $('#hostel_room_id').append(div_data);
                    },
                    complete: function () {
                        $('#hostel_room_id').removeClass('dropdownloading');
                    }
                });
            }
        }
    });

    function auto_fill_guardian_address() {
        if ($("#autofill_current_address").is(':checked'))
        {
            $('#current_address').val($('#guardian_address').val());
        }
    }

    function auto_fill_address() {
        if ($("#autofill_address").is(':checked'))
        {
            $('#permanent_address').val($('#current_address').val());
        }
    }

    $('input:radio[name="guardian_is"]').change(
            function () {
                if ($(this).is(':checked')) {
                    var value = $(this).val();
                    if (value == "father") {
                        var father_relation = "<?php echo $this->lang->line('father'); ?>";
                        $('#guardian_name').val($('#father_name').val());
                        $('#guardian_phone').val($('#father_phone').val());
                        $('#guardian_occupation').val($('#father_occupation').val());
                        $('#guardian_relation').val(father_relation);
                    } else if (value == "mother") {
                        var mother_relation = "<?php echo $this->lang->line('mother'); ?>";
                        $('#guardian_name').val($('#mother_name').val());
                        $('#guardian_phone').val($('#mother_phone').val());
                        $('#guardian_occupation').val($('#mother_occupation').val());
                        $('#guardian_relation').val(mother_relation);
                    } else {
                        $('#guardian_name').val("");
                        $('#guardian_phone').val("");
                        $('#guardian_occupation').val("");
                        $('#guardian_relation').val("")
                    }
                }
            });
</script>

<script type="text/javascript">
     // Enhanced sibling modal functionality
     function showSiblingModal() {
         $('.sibling_msg').html("");
         $('.modal_title').html('<b>' + "<?php echo $this->lang->line('add_sibling'); ?>" + '</b>');
         $('#mySiblingModal').modal({
             backdrop: 'static',
             keyboard: false,
             show: true
         });
     }

     // Class modal functionality
     function showClassModal() {
         // Load existing sections first
         loadExistingSections();

         $('#classModal').modal({
             backdrop: 'static',
             keyboard: false,
             show: true
         });
         $('#class_name').focus();
     }

     // Load existing sections for class creation
     function loadExistingSections() {
         $.ajax({
             url: '<?php echo site_url("sections/get"); ?>',
             type: 'GET',
             dataType: 'json',
             success: function(data) {
                 var sectionsHtml = '';

                 if (data.length === 0) {
                     sectionsHtml = '<div class="alert alert-warning">' +
                                   '<i class="fa fa-exclamation-triangle"></i> ' +
                                   '<strong>No sections found:</strong> Please create sections first using the ' +
                                   '<button type="button" class="btn btn-sm btn-primary" onclick="$(\'#sectionModal\').modal(\'show\'); $(\'#classModal\').modal(\'hide\');">Create Section</button> ' +
                                   'button above, then come back to create classes.' +
                                   '</div>' +
                                   '<p class="text-muted"><em>Sections are required before creating classes.</em></p>';
                 } else {
                     sectionsHtml = '<div class="row">';
                     $.each(data, function(index, section) {
                         sectionsHtml += '<div class="col-md-6">';
                         sectionsHtml += '<div class="checkbox">';
                         sectionsHtml += '<label>';
                         sectionsHtml += '<input type="checkbox" name="sections[]" value="' + section.id + '" /> ' + section.section;
                         sectionsHtml += '</label>';
                         sectionsHtml += '</div>';
                         sectionsHtml += '</div>';
                     });
                     sectionsHtml += '</div>';
                 }

                 $('#sectionsContainer').html(sectionsHtml);
             },
             error: function(xhr, status, error) {
                 console.error('Error loading sections:', error);
                 var errorHtml = '<div class="alert alert-danger">' +
                                 '<i class="fa fa-exclamation-circle"></i> ' +
                                 'Error loading sections. Please try again.' +
                                 '</div>';
                 $('#sectionsContainer').html(errorHtml);
             }
         });
     }

     // Section modal functionality
     function showSectionModal() {
         $('#sectionModal').modal({
             backdrop: 'static',
             keyboard: false,
             show: true
         });
         $('#section_name').focus();
     }


     // Handle class form submission
     $('#classForm').on('submit', function(e) {
         e.preventDefault();

         var className = $('#class_name').val().trim();
         var selectedSections = $('input[name="sections[]"]:checked');

         if (!className) {
             $('#class_error').text('Class name is required');
             return;
         }

         if (selectedSections.length === 0) {
             $('#sections_error').text('Please select at least one section');
             return;
         }

         $('#classSubmitBtn').html('<i class="fa fa-spinner fa-spin"></i> Creating...').prop('disabled', true);
         $('#class_error').text('');
         $('#sections_error').text('');

         // Prepare form data
         var formData = new FormData(this);
         formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');

         $.ajax({
             url: '<?php echo site_url("classes"); ?>',
             type: 'POST',
             data: formData,
             processData: false,
             contentType: false,
             success: function(response) {
                 var newClassName = $('#class_name').val().trim();

                 // Refresh class dropdown and auto-select new class
                 refreshClassDropdown(function() {
                     autoSelectNewClassAndSection(newClassName);
                 });

                 // Close modal and reset form
                 $('#classModal').modal('hide');
                 $('#classForm')[0].reset();
                 loadExistingSections();

                 // Show success message
                 showSuccessAlert('Class created successfully!');
             },
             error: function(xhr, status, error) {
                 if (xhr.responseText) {
                     var errorMsg = 'Error creating class. Please try again.';
                     try {
                         var response = JSON.parse(xhr.responseText);
                         if (response.error) {
                             errorMsg = response.error;
                         }
                     } catch (e) {}
                     $('#class_error').text(errorMsg);
                 } else {
                     $('#class_error').text('Error creating class. Please try again.');
                 }
                 console.error('Class creation error:', error);
             },
             complete: function() {
                 $('#classSubmitBtn').html('<i class="fa fa-plus"></i> <?php echo $this->lang->line('create'); ?>').prop('disabled', false);
             }
         });
     });

     // Handle section form submission
     $('#sectionForm').on('submit', function(e) {
         e.preventDefault();

         var sectionName = $('#section_name').val().trim();
         if (!sectionName) {
             $('#section_error').text('Section name is required');
             return;
         }

         $('#sectionSubmitBtn').html('<i class="fa fa-spinner fa-spin"></i> Creating...').prop('disabled', true);
         $('#section_error').text('');

         // Prepare form data with CSRF token
         var formData = new FormData(this);
         formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');

         $.ajax({
             url: '<?php echo site_url("sections/index"); ?>',
             type: 'POST',
             data: formData,
             processData: false,
             contentType: false,
             success: function(response) {
                 var newSectionName = $('#section_name').val().trim();

                 // Refresh section dropdown and auto-select the new section
                 var currentClassId = $('#class_id').val();
                 if (currentClassId) {
                     // Reload sections for current class and auto-select the new one
                     $.ajax({
                         url: '<?php echo site_url("sections/getByClass"); ?>',
                         type: 'GET',
                         data: {class_id: currentClassId},
                         dataType: 'json',
                         success: function(data) {
                             var sectionHtml = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                             var newSectionSelected = false;

                             $.each(data, function(i, obj) {
                                 var selected = '';
                                 if (!newSectionSelected && obj.section.trim() === newSectionName.trim()) {
                                     selected = 'selected';
                                     newSectionSelected = true;
                                 }
                                 sectionHtml += '<option value="' + obj.section_id + '" ' + selected + '>' + obj.section + '</option>';
                             });

                             $('#section_id').html(sectionHtml);
                         },
                         error: function(xhr, status, error) {
                             console.error('Error refreshing section dropdown:', error);
                         }
                     });
                 }

                 // Close modal and reset form
                 $('#sectionModal').modal('hide');
                 $('#sectionForm')[0].reset();

                 // Show success message
                 showSuccessAlert('Section created successfully!');
             },
             error: function(xhr, status, error) {
                 if (xhr.responseText) {
                     var errorMsg = 'Error creating section. Please try again.';
                     try {
                         var response = JSON.parse(xhr.responseText);
                         if (response.error) {
                             errorMsg = response.error;
                         }
                     } catch (e) {}
                     $('#section_error').text(errorMsg);
                 } else {
                     $('#section_error').text('Error creating section. Please try again.');
                 }
                 console.error('Section creation error:', error);
             },
             complete: function() {
                 $('#sectionSubmitBtn').html('<i class="fa fa-plus"></i> <?php echo $this->lang->line('create'); ?>').prop('disabled', false);
             }
         });
     });

     // Refresh class dropdown
     function refreshClassDropdown(callback) {
         $.ajax({
             url: '<?php echo site_url("classes/get"); ?>',
             type: 'GET',
             dataType: 'json',
             success: function(data) {
                 var classDropdown = $('#class_id');
                 var currentSelected = classDropdown.val();

                 classDropdown.html('<option value=""><?php echo $this->lang->line('select'); ?></option>');

                 $.each(data, function(index, classItem) {
                     var selected = (currentSelected == classItem.id) ? 'selected' : '';
                     classDropdown.append('<option value="' + classItem.id + '" ' + selected + '>' + classItem.class + '</option>');
                 });

                 // Execute callback if provided
                 if (callback && typeof callback === 'function') {
                     callback();
                 }
             },
             error: function(xhr, status, error) {
                 console.error('Error refreshing class dropdown:', error);
                 // Fallback: reload the page
                 location.reload();
             }
         });
     }

     // Refresh section dropdown
     function refreshSectionDropdown(autoSelectFirst) {
         var classId = $('#class_id').val();
         if (classId) {
             // Get sections for the selected class
             $.ajax({
                 url: '<?php echo site_url("sections/getByClass"); ?>',
                 type: 'GET',
                 data: {class_id: classId},
                 dataType: 'json',
                 success: function(data) {
                     var sectionHtml = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                     $.each(data, function(i, obj) {
                         sectionHtml += '<option value="' + obj.section_id + '">' + obj.section + '</option>';
                     });
                     $('#section_id').html(sectionHtml);

                     // Auto-select first section if requested and available
                     if (autoSelectFirst && data.length > 0) {
                         $('#section_id').val(data[0].section_id);
                     }
                 },
                 error: function(xhr, status, error) {
                     console.error('Error refreshing section dropdown:', error);
                     $('#section_id').html('<option value=""><?php echo $this->lang->line('select'); ?></option>');
                 }
             });
         } else {
             $('#section_id').html('<option value=""><?php echo $this->lang->line('select'); ?></option>');
         }
     }

     // Auto-select class and section after creation
     function autoSelectNewClassAndSection(className) {
         setTimeout(function() {
             // Find and select the newly created class
             var classFound = false;
             $('#class_id option').each(function() {
                 if ($(this).text().trim() === className.trim()) {
                     $('#class_id').val($(this).val());
                     classFound = true;
                     $('#class_id').trigger('change');
                     return false; // Break the loop
                 }
             });

             if (classFound) {
                 // Auto-select first section after a short delay
                 setTimeout(function() {
                     var firstSection = $('#section_id option').eq(1); // Get first real option (skip placeholder)
                     if (firstSection.length > 0) {
                         $('#section_id').val(firstSection.val());
                     }
                 }, 500);
             }
         }, 200);
     }

     // Show success alert
     function showSuccessAlert(message) {
         var alertHtml = '<div class="alert alert-success alert-dismissible" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">' +
                         '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                         '<strong><i class="fa fa-check"></i> Success!</strong> ' + message +
                         '</div>';
         $('body').append(alertHtml);

         // Auto remove after 3 seconds
         setTimeout(function() {
             $('.alert-success').fadeOut('slow', function() {
                 $(this).remove();
             });
         }, 3000);
     }

     // Clear errors when user types
     $('#class_name').on('input', function() {
         $('#class_error').text('');
         $('#sections_error').text('');
     });

     $('#section_name').on('input', function() {
         $('#section_error').text('');
     });

     // Clear errors when sections are selected
     $(document).on('change', 'input[name="sections[]"]', function() {
         $('#sections_error').text('');
     });

     $(".mysiblings").click(function () {
         showSiblingModal();
     });

     // Form validation enhancement
     $(document).ready(function() {
         // Add smooth scrolling to form sections
         $('a[href^="#"]').on('click', function(event) {
             var target = $(this.getAttribute('href'));
             if(target.length) {
                 event.preventDefault();
                 $('html, body').stop().animate({
                     scrollTop: target.offset().top - 100
                 }, 1000);
             }
         });

         // Enhanced form validation feedback
         $('.form-control').on('blur', function() {
             var $field = $(this);
             if ($field.val() && !$field.hasClass('is-valid')) {
                 $field.addClass('is-valid');
             }
         });

         // Auto-hide alerts after 5 seconds
         setTimeout(function() {
             $('.alert').fadeOut('slow');
         }, 5000);
     });
</script>

<script type="text/javascript">

    $(document).on('change', '#sibiling_class_id', function (e) {
        $('#sibiling_section_id').html("");
        var class_id = $(this).val();
        var base_url = '<?php echo base_url() ?>';
        var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
        $.ajax({
            type: "GET",
            url: base_url + "sections/getByClass",
            data: {'class_id': class_id},
            dataType: "json",
            success: function (data) {
                $.each(data, function (i, obj)
                {
                    div_data += "<option value=" + obj.section_id + ">" + obj.section + "</option>";
                });
                $('#sibiling_section_id').append(div_data);
            }
        });
    });

    $(document).on('change', '#sibiling_section_id', function (e) {
        getStudentsByClassAndSection();
    });

    function getStudentsByClassAndSection() {

        $('#sibiling_student_id').html("");
        var class_id = $('#sibiling_class_id').val();
        var section_id = $('#sibiling_section_id').val();
        var student_id = '<?php echo set_value('student_id') ?>';
        var base_url = '<?php echo base_url() ?>';
        var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
        $.ajax({
            type: "GET",
            url: base_url + "student/getByClassAndSection",
            data: {'class_id': class_id, 'section_id': section_id},
            dataType: "json",
            success: function (data) {
                $.each(data, function (i, obj)
                {
                    var sel = "";
                    if (section_id == obj.section_id) {
                        sel = "selected=selected";
                    }

                    if (obj.admission_no == null) {
                        div_data += "<option value=" + obj.id + ">" + obj.full_name +  "</option>";
                    } else {
                        div_data += "<option value=" + obj.id + ">" + obj.full_name +  " (" + obj.admission_no + ") " + "</option>";
                    }

                });
                $('#sibiling_student_id').append(div_data);
            }
        });
    }

    $(document).on('click', '.add_sibling', function () {
        var student_id = $('#sibiling_student_id').val();
        var base_url = '<?php echo base_url() ?>';
        if (student_id.length > 0) {
            $.ajax({
                type: "GET",
                url: base_url + "student/getStudentRecordByID",
                data: {'student_id': student_id},
                dataType: "json",
                success: function (data) {
                    $('#sibling_name').text("<?php echo $this->lang->line('sibling'); ?> : " + data.full_name);
                    $('#sibling_name_next').val(data.firstname + " " + data.lastname);
                    $('#sibling_id').val(student_id);
                    $('#father_name').val(data.father_name);
                    $('#father_phone').val(data.father_phone);
                    $('#father_occupation').val(data.father_occupation);
                    $('#mother_name').val(data.mother_name);
                    $('#mother_phone').val(data.mother_phone);
                    $('#mother_occupation').val(data.mother_occupation);
                    $('#guardian_name').val(data.guardian_name);
                    $('#guardian_relation').val(data.guardian_relation);
                    $('#guardian_address').val(data.guardian_address);
                    $('#guardian_phone').val(data.guardian_phone);
                    $('#state').val(data.state);
                    $('#city').val(data.city);
                    $('#pincode').val(data.pincode);
                    $('#current_address').val(data.current_address);
                    $('#permanent_address').val(data.permanent_address);
                    $('#guardian_occupation').val(data.guardian_occupation);
                    $("input[name=guardian_is][value='" + data.guardian_is + "']").prop("checked", true);
                    $('#mySiblingModal').modal('hide');
                }
            });
        } else {
            $('.sibling_msg').html("<div class='alert alert-danger text-center'><?php echo $this->lang->line('no_student_selected') ?></div>");
        }
    });
</script>

<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/js/savemode.js"></script>

<script>

$('#transport_feemaster_id').multiselect({
    columns: 1,
    placeholder: '<?php echo $this->lang->line('select_month') ?>',
    search: true
});

$('#fee_session_group_id').multiselect({
    columns: 1,
    placeholder: '<?php echo $this->lang->line('select_fees') ?>',
    search: true
});

</script>
<script type="text/javascript">
    var total_fees_alloted= parseFloat($("input[name='total_post_fees']").val());
    $(document).ready(function(){
        $(document).on('change','.fee_group_chk',function(){

        if ($(this).prop("checked")) {
            total_fees_alloted +=parseFloat($(this).closest('div').find('span.fee_group_total').data('amount'));
        }
        else {
            total_fees_alloted -=parseFloat($(this).closest('div').find('span.fee_group_total').data('amount'));
        }
//==============
        $.ajax({
            type: "POST",
            url: base_url + "admin/currency/getAmountFormat",
            data: {'total_fees_alloted': total_fees_alloted},
            dataType: "json",
             beforeSend: function() {
         $('#fade').css("display", "block");
         $('#modal').css("display", "block");
             },
            success: function (data) {
                console.log(data);
                 $('.total_fees_alloted').text(data.amount);
               $("#fade").fadeOut(1000);
         $("#modal").fadeOut(1000);
            },
             error: function(xhr) { // if error occured
         $("#fade").fadeOut(1000);
         $("#modal").fadeOut(1000);
            },
            complete: function() {
              $("#fade").fadeOut(1000);
         $("#modal").fadeOut(1000);
            }
        });
//==============

    });
    });
</script>
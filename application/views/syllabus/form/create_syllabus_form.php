<?= $header; ?>

    <?= $navbar; ?>

    <div class="container">
        <div class="row no-gutter-xs">
            <div class="col-xs-12 col-sm-12 padding-content">
                
                <!-- breadcrumb -->
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url().'syllabus_manager'; ?>"><i class="fa fa-book" aria-hidden="true"></i> Syllabus Manager</a></li>
                        <li><a href="<?= base_url().'syllabus_manager/create_syllabus_form'; ?>"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Create New Syllabus</a></li>                        
                    </ol>
                </div>

                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text">Create New Syllabus</h2>
                    </div>
                </div>

                <?php if(isset($upload_error)): ?>
                    <div class="row">
                        <div class="alert alert-danger animated shake">
                            <?= $upload_error['error'] ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <div class="row">
                            <form id="create-syllabus-form" action="<?= base_url().'syllabus_manager/insert_syllabus'; ?>" method="post" autocomplete="off" enctype="multipart/form-data">
                                
                                <!-- syllabus_title -->
                                <div class="form-group <?php if(strlen(form_error('syllabus_title')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Syllabus Title</label>
                                    <input type="text" class="form-control" name="syllabus_title" value="<?= set_value('syllabus_title') ?>" placeholder="Enter syllabus title." minlength="6" maxlength="120" required>
                                    <?php echo form_error('syllabus_title', '<p class="text-danger">', '</p>'); ?>                                    
                                </div>

                                <!-- syllabus tags -->
                                <div class="form-group <?php if(strlen(form_error('syllabus_tags')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Syllabus Tags</label>
                                    <input type="text" class="form-control" name="syllabus_tags" value="<?= set_value('syllabus_tags') ?>" placeholder="Enter a syllabus tags" maxlength="255" required>
                                    <?php echo form_error('syllabus_tags', '<p class="text-danger">', '</p>'); ?>                                    
                                </div>

                                <!-- syllabus category -->
                                <?php /*
                                <div class="form-group <?php if(strlen(form_error('syllabus_category')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Syllabus Category</label>
                                    <input type="text" class="form-control" name="syllabus_category" value="<?= set_value('syllabus_category') ?>" placeholder="Enter a syllabus category." maxlength="255" required>
                                    <?php echo form_error('syllabus_category', '<p class="text-danger">', '</p>'); ?>                                    
                                </div>
                                */ ?>
                                <div class="form-group <?php if(strlen(form_error('syllabus_category')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Syllabus Category</label>    
                                    <select class="form-control" name="syllabus_category" required>
                                        <option value="" selected="selected">- Select Category -</option>
                                        
                                        <option disabled>─ Pre Syllabus ─ ─</option>
                                        <option value="paper_1">Paper I</option>
                                        <option value="paper_2">Paper II</option>
                                        <option value="sti_pre">STI (Pre)</option>
                                        <option value="psi_pre">PSI (Pre)</option>
                                        <option value="aso_pre">ASO (Pre)</option>
                                        <option value="cumbain_exam">Cumbain Exam</option>
                                        
                                        <option disabled>─ Mains Syllabus ─ ─</option>
                                        <option value="gs1">GS I</option>
                                        <option value="gs2">GS II</option>
                                        <option value="gs3">GS III</option>
                                        <option value="gs4">GS IV</option>
                                        <option value="sti_mains">STI (Mains)</option>
                                        <option value="psi_mains">PSI (Mains)</option>
                                        <option value="aso_mains">ASO (Mains)</option>
                                        
                                        <option disabled>─ Other Syllabus ─ ─</option>
                                        <option value="">Direct Recruitment</option>
                                    </select>
                                </div>

                                <!-- syllabus attachment -->
                                <div class="form-group <?php if(strlen(form_error('userfile')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Choose attachment</label>
                                    <input type="file" name="userfile" placeholder="Choose attachement" required>                                    
                                    <?php echo form_error('userfile', '<p class="text-danger">', '</p>'); ?>                                    
                                </div>

                                <!-- submit and clear buttons -->
                                <div class="from-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Create Syllabus</button>
                                    <button type="reset" class="btn btn-default"><i class="fa fa-trash" aria-hidden="true"></i> Clear</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?= $footer; ?>
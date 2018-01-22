<?= $header; ?>

    <?= $navbar; ?>

    <div class="container">
        <div class="row no-gutter-xs">
            <div class="col-xs-12 col-sm-12 padding-content">
                
                <!-- breadcrumb -->
                <div class="row">
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?= base_url().'job_manager'; ?>">
                                <i class="fa fa-black-tie" aria-hidden="true"></i> Job Manager
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url().'job_manager/create_job_form/'; ?>">
                                <i class="fa fa-plus-square-o"></i> Create New Job
                            </a>
                        </li>
                    </ol>
                </div>

                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text">Create New Job</h2>
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
                            <form id="create-job-form" action="<?= base_url().'job_manager/insert_job'; ?>" method="post" autocomplete="off" enctype="multipart/form-data">
                                
                                <!-- job_title -->
                                <div class="form-group <?php if(strlen(form_error('job_title')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Job Title</label>
                                    <input type="text" class="form-control" name="job_title" value="<?= set_value('job_title') ?>" placeholder="Enter job title." minlength="6" maxlength="120" required>
                                    <?php echo form_error('job_title', '<p class="text-danger">', '</p>'); ?>                                    
                                </div>

                                <!-- job tags -->
                                <div class="form-group <?php if(strlen(form_error('job_tags')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Job Tags</label>
                                    <input type="text" class="form-control" name="job_tags" value="<?= set_value('job_tags') ?>" placeholder="Enter a job tags" maxlength="255" required>
                                    <?php echo form_error('job_tags', '<p class="text-danger">', '</p>'); ?>                                    
                                </div>

                                <!-- job category -->
                                <?php /*
                                <div class="form-group <?php if(strlen(form_error('job_category')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Job Category</label>
                                    <input type="text" class="form-control" name="job_category" value="<?= set_value('job_category') ?>" placeholder="Enter a syllabus category." maxlength="255" required>
                                    <?php echo form_error('job_category', '<p class="text-danger">', '</p>'); ?>                                    

                                </div>
                                */ ?>
                                <?php $options = ['10th Pass', '12th Pass', 'Diploma', 'Graduate']; ?>
                                <div class="form-group <?php if(strlen(form_error('job_category')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Category</label>
                                    <select name="job_category" class="form-control" required>
                                        <option value="" selected="selected">- Select Category -</option>
                                        <?php foreach ($options as $key => $value): ?>
                                            <?php if(strtolower($value) == set_value('job_category')): ?>
                                                <option value="<?= str_replace(" ", "_", strtolower($value)) ?>" selected><?= $value ?></option>
                                            <?php else: ?>
                                                <option value="<?= str_replace(" ", "_", strtolower($value)) ?>"><?= $value ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>                                        
                                    </select>
                                    <?php echo form_error('job_category', '<p class="text-danger">', '</p>'); ?>
                                </div>

                                <!-- job attachment -->
                                <div class="form-group <?php if(strlen(form_error('userfile')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Choose attachment</label>
                                    <input type="file" name="userfile" placeholder="Choose attachement" required>                                    
                                    <?php echo form_error('userfile', '<p class="text-danger">', '</p>'); ?>                                    
                                </div>

                                <!-- submit and clear buttons -->
                                <div class="from-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Create Job</button>
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
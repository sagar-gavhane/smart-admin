<?= $header; ?>

    <?= $navbar; ?>

    <div class="container">
        <div class="row no-gutter-xs">
            <div class="col-xs-12 col-sm-12 padding-content">
                
                <!-- breadcrumb -->
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url().'question_manager'; ?>"><i class="fa fa-book" aria-hidden="true"></i> Question Manager</a></li>
                        <li><a href="<?= base_url().'question_manager/create_question_form'; ?>"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Create New Question</a></li>                        
                    </ol>
                </div>

                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text">Create New Question</h2>
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
                            <form id="create-question-form" action="<?= base_url().'question_manager/insert_question'; ?>" method="post" autocomplete="off" enctype="multipart/form-data">
                                
                                <!-- question_title -->
                                <div class="form-group <?php if(strlen(form_error('question_title')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Question Title</label>
                                    <input type="text" class="form-control" name="question_title" value="<?= set_value('question_title') ?>" placeholder="Enter question title." minlength="6" maxlength="120" required>
                                    <?php echo form_error('question_title', '<p class="text-danger">', '</p>'); ?>                                    
                                </div>

                                <!-- question tags -->
                                <div class="form-group <?php if(strlen(form_error('question_tags')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Question Tags</label>
                                    <input type="text" class="form-control" name="question_tags" value="<?= set_value('question_tags') ?>" placeholder="Enter a question tags" maxlength="255" required>
                                    <?php echo form_error('question_tags', '<p class="text-danger">', '</p>'); ?>                                    
                                </div>

                                <!-- question category -->
                                <?php /* <div class="form-group <?php if(strlen(form_error('question_category')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Question Category</label>
                                    <input type="text" class="form-control" name="question_category" value="<?= set_value('question_category') ?>" placeholder="Enter a syllabus category." maxlength="255" required>
                                    <?php echo form_error('question_category', '<p class="text-danger">', '</p>'); ?>                                    

                                </div>
                                */ ?>
                                <?php $options = ['GS1', 'GS2', 'GS3', 'GS4', 'English', 'Marathi']; ?>
                                <div class="form-group <?php if(strlen(form_error('question_category')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Category</label>
                                    <select name="question_category" class="form-control" required>
                                        <option value="" selected="selected">- Select Category -</option>
                                        <?php foreach ($options as $key => $value): ?>
                                            <?php if(strtolower($value) == set_value('question_category')): ?>
                                                <option value="<?= strtolower($value) ?>" selected><?= $value ?></option>
                                            <?php else: ?>
                                                <option value="<?= strtolower($value) ?>"><?= $value ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>                                        
                                    </select>
                                    <?php echo form_error('question_category', '<p class="text-danger">', '</p>'); ?>
                                </div>

                                <!-- question attachment -->
                                <div class="form-group <?php if(strlen(form_error('userfile')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Choose attachment</label>
                                    <input type="file" name="userfile" placeholder="Choose attachement" required>                                    
                                    <?php echo form_error('userfile', '<p class="text-danger">', '</p>'); ?>                                    
                                </div>

                                <!-- submit and clear buttons -->
                                <div class="from-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Create Question</button>
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
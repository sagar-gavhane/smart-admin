<?= $header; ?>

    <?= $navbar; ?>

    <div class="container">
        <div class="row no-gutter-xs">
            <div class="col-xs-12 col-sm-12 padding-content">

                <!-- breadcrumbs -->
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url().'notes_manager'; ?>"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> Notes Manager</a></li>
                        <li><a href="<?= base_url().'notes_manager/update_notes_form/'.$notes_data[0]['note_id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update Notes</a></li>
                    </ol>
                </div>

                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text">Update Notes</h2>
                    </div>
                </div>

                <!-- create new notes form -->
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <div class="row">
                            <form id="create-new-notes-form" action="<?= base_url().'notes_manager/update_notes/'.$notes_data[0]['note_id']; ?>" method="post" autocomplete="off">
                                
                                <!-- notes id -->
                                <input type="hidden" name="notes_id" value="<?= $notes_data[0]['note_id'] ?>">

                                <!-- notes title -->
                                <div class="form-group <?php if(strlen(form_error('notes_title')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Notes Title</label>
                                    <input type="text" class="form-control" name="notes_title" value="<?= set_value('notes_title', $notes_data[0]['note_title']) ?>" placeholder="Enter notes title" minlength="6" maxlength="120" required>
                                </div>

                                <!-- notes tags -->
                                <div class="form-group <?php if(strlen(form_error('notes_tags')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Notes Tags</label>
                                    <input type="text" class="form-control" name="notes_tags" value="<?= set_value('notes_tags', $notes_data[0]['note_tags']) ?>" placeholder="Enter notes tags" maxlength="255" required>
                                    <?php echo form_error('notes_tags', '<p class="text-danger">', '</p>'); ?>
                                </div>

                                <!-- notes category -->
                                <?php /*
                                <div class="form-group <?php if(strlen(form_error('notes_category')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Notes Category</label>
                                    <input type="text" class="form-control" name="notes_category" value="<?= set_value('notes_category', $notes_data[0]['note_category']) ?>" placeholder="Enter notes category" maxlength="255" required>
                                    <?php echo form_error('notes_category', '<p class="text-danger">', '</p>'); ?>
                                </div>
                                */ ?>

                                <?php $options = ['GS1', 'GS2', 'GS3', 'GS4', 'English', 'Marathi']; ?>
                                <div class="form-group <?php if(strlen(form_error('notes_category')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Notes Category</label>
                                    <select name="notes_category" class="form-control" required>
                                        <option value="" selected="selected">- Select Category -</option>
                                        <?php foreach ($options as $key => $value): ?>
                                            <?php if($value == set_value('notes_category', $notes_data[0]['note_category'])): ?>
                                                <option value="<?= strtolower($value) ?>" selected><?= $value ?></option>
                                            <?php else: ?>
                                                <option value="<?= strtolower($value) ?>"><?= $value ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('notes_category', '<p class="text-danger">', '</p>'); ?>
                                </div>

                                <!-- audio description -->
                                <div class="form-group <?php if(strlen(form_error('notes_desc')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Notes Description</label>
                                    <textarea row="5" class="form-control" name="notes_desc" placeholder="Enter notes description" minlength="15" maxlength="300" required><?= set_value('notes_desc', $notes_data[0]['note_desc']) ?></textarea>
                                    <?php echo form_error('notes_desc', '<p class="text-danger">', '</p>'); ?>
                                </div>

                                <!-- submit and clear buttons -->
                                <div class="from-group">
                                    <button type="submit" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update Notes</button>
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
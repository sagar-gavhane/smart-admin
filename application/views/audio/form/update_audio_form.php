<?= $header; ?>

    <?= $navbar; ?>

    <div class="container">
        <div class="row no-gutter-xs">
            <div class="col-xs-12 col-sm-12 padding-content">

                <!-- breadcrumbs -->
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url().'audio_manager'; ?>"><i class="fa fa-bullhorn" aria-hidden="true"></i> Audio Manager</a></li>
                        <li><a href="<?= base_url().'audio_manager/update_audio_form/'.$audio_data[0]['audio_id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update Audio</a></li>
                    </ol>
                </div>

                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text">Update Audio</h2>
                    </div>
                </div>                

                <!-- audio upload form -->
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <div class="row">
                            <form id="update-audio-form" action="<?= base_url().'audio_manager/update_audio/'.$audio_data[0]['audio_id']; ?>" method="post" autocomplete="off" enctype="multipart/form-data">

                                <!-- audio id -->
                                <input type="hidden" name="audio_id" value="<?= $audio_data[0]['audio_id'] ?>">

                                <!-- audio file -->
                                <div class="form-group <?php if(strlen(form_error('audio_file')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Audio File</label>
                                    <input type="file" class="form-contro" name="userfile" value="" placeholder="Upload audio file here" required>
                                    <?php echo form_error('audio_file', '<p class="text-danger">', '</p>'); ?>
                                </div>

                                <!-- audio title -->
                                <div class="form-group <?php if(strlen(form_error('audio_title')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Audio Title</label>
                                    <input type="text" class="form-control" name="audio_title" value="<?= set_value('audio_title', $audio_data[0]['audio_title']) ?>" placeholder="Enter audio title" minlength="6" maxlength="120" required>
                                    <?php echo form_error('audio_title', '<p class="text-danger">', '</p>'); ?>
                                </div>

                                <!-- audio tags -->
                                <div class="form-group <?php if(strlen(form_error('audio_tags')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Audio Tags</label>
                                    <input type="text" class="form-control" name="audio_tags" value="<?= set_value('audio_tags', $audio_data[0]['audio_tags']) ?>" placeholder="Enter audio tags" maxlength="255" required>
                                    <?php echo form_error('audio_tags', '<p class="text-danger">', '</p>'); ?>
                                </div>

                                <!-- audio category -->
                                <?php /*
                                <div class="form-group <?php if(strlen(form_error('audio_category')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Audio Category</label>
                                    <input type="text" class="form-control" name="audio_category" value="<?= set_value('audio_category', $audio_data[0]['audio_category']) ?>" placeholder="Enter audio category" maxlength="255" required>
                                    <?php echo form_error('audio_category', '<p class="text-danger">', '</p>'); ?>
                                </div>
                                */ ?>
                                <?php $options = ['GS1', 'GS2', 'GS3', 'GS4']; ?>
                                <div class="form-group <?php if(strlen(form_error('audio_category')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Category</label>
                                    <select name="audio_category" class="form-control" required>
                                        <option value="" selected="selected">- Select Category -</option>
                                        <?php foreach ($options as $key => $value): ?>
                                            <?php if(strtolower($value) == set_value('audio_category', $audio_data[0]['audio_category'])): ?>
                                                <option value="<?= strtolower($value) ?>" selected><?= $value ?></option>
                                            <?php else: ?>
                                                <option value="<?= strtolower($value) ?>"><?= $value ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>                                        
                                    </select>
                                    <?php echo form_error('audio_category', '<p class="text-danger">', '</p>'); ?>
                                </div>

                                <!-- audio description -->
                                <div class="form-group <?php if(strlen(form_error('audio_desc')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Audio Description</label>
                                    <textarea row="5" class="form-control" name="audio_desc" placeholder="Enter audio category" minlength="15" maxlength="300" required><?= set_value('audio_desc', $audio_data[0]['audio_desc']) ?></textarea>
                                    <?php echo form_error('audio_desc', '<p class="text-danger">', '</p>'); ?>
                                </div>

                                <!-- submit and clear buttons -->
                                <div class="from-group">
                                    <button type="submit" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update Audio</button>
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
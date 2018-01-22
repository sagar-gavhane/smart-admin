<?= $header; ?>

    <?= $navbar; ?>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 padding-content">
                <!-- breadcrumbs -->
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url().'video_manager'; ?>"><i class="fa fa-video-camera" aria-hidden="true"></i> Video Manager</a></li>
                        <li><a href="<?= base_url().'video_manager/upload_video_form/'; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload Video</a></li>
                    </ol>
                </div>
                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text">Upload Video</h2>
                    </div>
                </div>
                <?php if($this->session->feedback == 1): ?>
                    <?php if($this->session->feedback_msg == 'video_already_exist'): ?>
                        <div class="row">
                            <div class="alert alert-warning animated shake">
                                You have try to upload same video again.
                            </div>
                        </div>
                    <?php elseif($this->session->feedback_msg == 'video_uploading_failed'): ?>
                        <div class="row">
                            <div class="alert alert-danger animated shake">
                                Something went wrong. unable to upload video. please try again.
                            </div>
                        </div>
                    <?php   endif; ?>
                <?php   endif;
                        $array_items = array('feedback', 'feedback_msg'); 
                        $this->session->unset_userdata($array_items);
                ?>
                <!-- video upload form -->
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <div class="row">
                            <form id="upload-video-form" action="<?= base_url().'video_manager/insert_video'; ?>" method="post" autocomplete="off">

                                <!-- youtube video link -->
                                <div class="form-group <?php if(strlen(form_error('video_youtube_link')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Youtube Link</label>
                                    <input type="url" class="form-control" name="video_youtube_link" value="<?= set_value('video_youtube_link') ?>" placeholder="Enter a youtube link." pattern="/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/" required>
                                    <?php echo form_error('video_youtube_link', '<p class="text-danger">', '</p>'); ?>
                                    <!-- <span class="help-block">The youtube link field is required and should contain youtube.</span>                                     -->
                                </div>

                                <!-- video title -->
                                <div class="form-group <?php if(strlen(form_error('video_title')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Title</label>
                                    <input type="text" class="form-control" name="video_title" value="<?= set_value('video_title') ?>" placeholder="Enter a title for your video." minlength="6" maxlength="120" required>
                                    <?php echo form_error('video_title', '<p class="text-danger">', '</p>'); ?>
                                    <!-- <span class="help-block">The video title is required field and should contain 5 to 120 characters.</span> -->
                                </div>
                                
                                <!-- video tags -->
                                <div class="form-group <?php if(strlen(form_error('video_tags')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Tags</label>
                                    <input type="text" class="form-control" name="video_tags" value="<?= set_value('video_tags') ?>" placeholder="Choose tags for your video." maxlength="255" required>
                                    <?php echo form_error('video_tags', '<p class="text-danger">', '</p>'); ?>
                                    <!-- <span class="help-block">The video tag field is required field and should contain minimum 3 tags required separated by the comma.</span> -->
                                </div>

                                <?php /* 
                                <!-- video category -->
                                <div class="form-group <?php if(strlen(form_error('video_category')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Category</label>
                                    <input type="text" class="form-control" name="video_category" value="<?= set_value('video_category') ?>" placeholder="Enter a category for your video." maxlength="255" required>
                                    <?php echo form_error('video_category', '<p class="text-danger">', '</p>'); ?>
                                    <!-- <span class="help-block">The video category field is required field and minimum 1 category required and maximum 3 categories allowed to select and category are separated by the comma.</span> -->
                                </div>
                                */?>

                                <!-- video category select box -->
                                <?php $options = ['GS1', 'GS2', 'GS3', 'GS4']; ?>
                                <div class="form-group <?php if(strlen(form_error('video_category')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Category</label>
                                    <select name="video_category" class="form-control" required>
                                        <option value="" selected="selected">- Select Category -</option>
                                        <?php foreach ($options as $key => $value): ?>
                                            <?php if($value == set_value('video_category')): ?>
                                                <option value="<?= strtolower($value) ?>" selected><?= $value ?></option>
                                            <?php else: ?>
                                                <option value="<?= strtolower($value) ?>"><?= $value ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>                                        
                                    </select>
                                </div>

                                <!-- video description -->
                                <div class="form-group <?php if(strlen(form_error('video_desc')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Description</label>
                                    <textarea class="form-control" name="video_desc" placeholder="Enter video description" rows="5" minlength="15" maxlength="300" required><?= set_value('video_desc') ?></textarea>
                                    <?php echo form_error('video_desc', '<p class="text-danger">', '</p>'); ?>
                                    <!-- <span class="help-block">The video description field is required field and should contain 15 to 300 characters.</span> -->
                                </div>

                                <!-- submit buttons -->
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-upload" aria-hidden="true"></i> Upload Video</button>
                                    <button type="reset" class="btn btn-default" onclick="clearParsleyError()" ><i class="fa fa-trash-o" aria-hidden="true"></i> Clear</button>
                                </div>
                            </form>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $footer; ?>
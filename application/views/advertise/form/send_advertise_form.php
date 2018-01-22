<?= $header; ?>

    <?= $navbar; ?>

    <div class="container">
        <div class="row no-gutter-xs">
            <div class="col-xs-12 col-sm-12 padding-content">
                <!-- breadcrumb -->
                <div class="row">
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?= base_url().'advertise_manager'; ?>">
                                <i class="fa fa-address-card-o" aria-hidden="true"></i> Advertise Manager
                            </a>                            
                        </li>
                        <li>
                            <a href="<?= base_url().'advertise_manager/send_advertise_form/'; ?>">
                                <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Send Ads
                            </a>
                        </li>
                    </ol>
                </div>

                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text">Send Ads</h2>
                    </div>
                </div>

                <!-- file to import -->
                <div class="row">
                    <div class="col-sm-12 col-sm-4">
                        <div class="row">
                            <form action="<?= base_url().'advertise_manager/insert_send_ads'; ?>" method="post" autocomplete="off" enctype="multipart/form-data">

                                <!-- ads image -->
                                <div class="form-group <?php if(strlen(form_error('userfile')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Advertise Image</label>
                                    <input type="file" name="userfile" placeholder="Choose attachement" required>                                    
                                    <?php echo form_error('userfile', '<p class="text-danger">', '</p>'); ?>                                    
                                </div>
                                
                                <!-- send_ads_title -->
                                <div class="form-group <?php if(strlen(form_error('send_ads_title')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Title</label>
                                    <input type="text" class="form-control" name="send_ads_title" value="<?= set_value('send_ads_title') ?>" placeholder="Enter syllabus title." minlength="6" maxlength="120" required>
                                    <?php echo form_error('send_ads_title', '<p class="text-danger">', '</p>'); ?>                                    
                                </div>

                                <!-- send_ads_desc -->
                                <div class="form-group <?php if(strlen(form_error('send_ads_desc')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Description</label>                                    
                                    <textarea class="form-control" name="send_ads_desc" rows="5" placeholder="Enter send ads description" minlength="6" maxlength="120" required><?= set_value('send_ads_desc') ?></textarea>
                                    <?php echo form_error('send_ads_desc', '<p class="text-danger">', '</p>'); ?>                                    
                                </div>

                                <!-- send_ads_weblink -->
                                <div class="form-group <?php if(strlen(form_error('send_ads_weblink')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Website</label>
                                    <input type="url" class="form-control" name="send_ads_weblink" value="<?= set_value('send_ads_weblink') ?>" placeholder="Enter web link">
                                    <?php echo form_error('send_ads_weblink', '<p class="text-danger">', '</p>'); ?>                                    
                                </div>

                                <!-- send_ads_show_days -->
                                <div class="form-group <?php if(strlen(form_error('send_ads_show_days')) != 0) echo 'has-error'; ?>">
                                    <label class="control-label label-required">Ads Show Days</label>
                                    <input type="number" class="form-control" name="send_ads_show_days" value="<?= set_value('send_ads_show_days', 1) ?>" placeholder="Enter show day" min="1" max="365" required>
                                    <?php echo form_error('send_ads_show_days', '<p class="text-danger">', '</p>'); ?>                                    
                                </div>

                                <!-- submit and clear buttons -->
                                <div class="from-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Send Ad</button>
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
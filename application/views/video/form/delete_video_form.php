<?= $header; ?>

    <?= $navbar; ?>

    <div class="container">
        <div class="row no-gutter-xs">
            <div class="col-xs-12 col-sm-12 padding-content">

                <!-- breadcrumb -->
                <div class="row">
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?= base_url().'video_manager'; ?>">
                                <i class="fa fa-video-camera" aria-hidden="true"></i> Video Manager
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url().'video_manager/delete_video_form'; ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i> Delete Video
                            </a>
                        </li>
                    </ol>
                </div>

                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text">Delete Video</h2>
                    </div>
                </div>

                <!-- delete video form -->
                <div class="row">
                    <div class="col-xs-12 col-xs-4">
                        <div class="row">
                            <form action="<?= base_url().'video_manager/delete_video/'.$video_data[0]['video_id']; ?>" method="post" autocomplete="off">
                                
                                <!-- video id -->
                                <input type="hidden" name="video_id" value="<?= $video_data[0]['video_id']; ?>" required>

                                <!-- video title readonly -->
                                <div class="form-group">
                                    <label class="control-label label-required">Selected Video Title</label>
                                    <input type="text" class="form-control" name="video_title" value="<?= $video_data[0]['video_title']; ?>" disabled>
                                </div>

                                <!-- delete reason -->
                                <div class="form-group">
                                    <label class="control-label label-required">Reason</label>
                                    <select name="reason" class="form-control" required>
                                        <option value="" selected>- Select Reason -</option>
                                        <option value="Wrongly Created">Wrongly Created</option>
                                        <option value="Invalid Info">Invalid Info</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <!-- delete remark -->
                                <div class="form-group">
                                    <label class="control-label label-required">Remark</label>
                                    <textarea class="form-control" name="remark" rows="5" placeholder="Enter a remark (optional)" minlength="15" maxlength="300" required></textarea>
                                </div>

                                <!-- submit and clear buttons -->
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i> Delete Video
                                    </button>
                                    <button type="reset" class="btn btn-default">
                                        <i class="fa fa-eraser" aria-hidden="true"></i> Clear
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
                
<?= $footer; ?>
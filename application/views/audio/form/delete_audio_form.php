<?= $header; ?>

    <?= $navbar; ?>

    <div class="container">
        <div class="row no-gutter-xs">
            <div class="col-xs-12 col-sm-12 padding-content">

                <!-- breadcrumb -->
                <div class="row">
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?= base_url().'audio_manager'; ?>">
                                <i class="fa fa-bullhorn" aria-hidden="true"></i> Audio Manager
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url().'audio_manager/delete_audio_form'; ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i> Delete Audio
                            </a>
                        </li>
                    </ol>
                </div>

                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text">Delete Audio</h2>
                    </div>
                </div>

                <!-- delete audio form -->
                <div class="row">
                    <div class="col-xs-12 col-xs-4">
                        <div class="row">
                            <form action="<?= base_url().'audio_manager/delete_audio/'.$audio_data[0]['audio_id']; ?>" method="post" autocomplete="off">
                                
                                <!-- audio id -->
                                <input type="hidden" name="audio_id" value="<?= $audio_data[0]['audio_id']; ?>" required>

                                <!-- audio title readonly -->
                                <div class="form-group">
                                    <label class="control-label label-required">Selected Audio Title</label>
                                    <input type="text" class="form-control" name="audio_title" value="<?= $audio_data[0]['audio_title']; ?>" disabled>
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
                                        <i class="fa fa-trash-o" aria-hidden="true"></i> Delete Audio
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
<?=$header;?>

    <?=$navbar;?>

    <div class="container">
        <div class="row no-gutter-xs">
            <div class="col-xs-12 col-sm-12 padding-content">
                <!-- breadcrumb -->
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url() . 'audio_manager';?>"><i class="fa fa-bullhorn" aria-hidden="true"></i> Audio Manager</a></li>
                    </ol>
                </div>

                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text">Audio Manager</h2>
                    </div>
                </div>

                <!-- top buttons -->
                <div class="row">
                    <div class="top-buttons">
                        <a class="btn btn-primary" href="<?=base_url() . 'audio_manager/upload_audio_form/'?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload Audio</a>
                    </div>
                </div>

                <?=$feedback;?>

                <!-- video list table -->
                <div class="row audio-list-block">
                    <?php if ($audio_data): ?>
                        <div class="audio-list-table table-responsive">
                            <table class="table table-bordered table-striped">
                                <tr class="active">
                                    <th>Sr. NO</th>
                                    <th>Title</th>
                                    <th>Tags</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach ($audio_data as $key => $value): ?>
                                    <tr>
                                        <td><?=$key + 1;?></td>
                                        <td><?=$value['audio_title'];?></td>
                                        <td><?=$value['audio_tags'];?></td>
                                        <td><?=ucwords($value['audio_category']);?></td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="<?=base_url() . 'audio_manager/update_audio_form/' . $value['audio_id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update</a>
                                            <a class="btn btn-danger btn-sm" href="<?=base_url() . 'audio_manager/delete_audio_form/' . $value['audio_id'];?>"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning animated shake">
                            There is no any audio list. You have required to upload new audios.
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>

    <?=$footer;?>
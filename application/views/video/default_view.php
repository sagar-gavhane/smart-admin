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
                                    <i class="fa fa-video-camera" aria-hidden="true"></i> Video Manager</a>
                            </li>
                        </ol>
                    </div>

                    <!-- page heading -->
                    <div class="row">
                        <div class="page-heading">
                            <h2 class="page-heading__heading-text">Video Manager</h2>
                        </div>
                    </div>

                    <!-- top buttons -->
                    <div class="row">
                        <div class="top-buttons">
                            <a class="btn btn-primary" href="<?= base_url().'video_manager/upload_video_form/' ?>">
                                <i class="fa fa-upload" aria-hidden="true"></i> Upload Video</a>
                        </div>
                    </div>

                    <?= $feedback; ?>

                    <!-- video list table -->
                    <div class="row">
                        <div class="video-list-table table-responsive">
                            <table class="table">
                                <?php foreach($video_details as $key => $value): ?>
                                <tr>
                                    <td class="col-sm-4">
                                        <a href="<?= base_url().'video_manager/view_video/'.$value['video_id']; ?>">
                                            <img src="<?= 'https://img.youtube.com/vi/'. $value['video_youtube_id'] .'/mqdefault.jpg' ?>">
                                        </a>
                                    </td>
                                    <td class="col-sm-offset-8">
                                        <a href="<?= base_url().'video_manager/view_video/'.$value['video_id']; ?>">
                                            <h4>
                                                <?= $value['video_title'] ?>
                                            </h4>
                                        </a>
                                        <p>
                                            <i class="fa fa-globe" aria-hidden="true"></i>
                                            <strong>Added on</strong>
                                            <?= date('dS M Y', strtotime($value['video_published_date'])); ?>
                                        </p>
                                        <p>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <strong>Tags: </strong>
                                            <?= $value['video_tags']; ?>
                                        </p>
                                        <p>
                                            <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                                            <strong>Category: </strong>
                                            <?= $value['video_category'] ?>
                                        </p>
                                        <p>
                                            <!-- <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-globe" aria-hidden="true"></i> Publish</a> -->
                                            <a href="<?= base_url().'video_manager/update_video_form/'.$value['video_id'] ?>" class="btn btn-warning btn-sm">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update</a>
                                            <a href="<?= base_url().'video_manager/delete_video_form/'.$value['video_id'] ?>" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>
                                        </p>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?= $footer; ?>

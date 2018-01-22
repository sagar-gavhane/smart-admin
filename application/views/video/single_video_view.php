<?= $header; ?>

    <?= $navbar; ?>

    <div class="container">
        <div class="row no-gutter-xs">
            <div class="col-xs-12 col-sm-12 padding-content">
                <!-- breadcrumb -->
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url().'video_manager'; ?>"><i class="fa fa-video-camera" aria-hidden="true"></i> Video Manager</a></li>
                        <li><a href="<?= base_url().'video_manager/view_video/'.$video_details[0]['video_id']; ?>"><i class="fa fa-eye"></i> View Video</a></li>
                    </ol>
                </div>
                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text"><?= $video_details[0]['video_title'] ?></h2>
                    </div>
                </div>
                <!-- embed youtube video -->
                <div class="row">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="<?= 'https://www.youtube.com/embed/'.$video_details[0]['video_youtube_id']; ?>"></iframe>
                    </div>
                </div>
                <!-- video details show -->
                <div class="row">
                    <div class="video-details-block">
                        <h3 class="video-details-block__video-title">
                            <?= $video_details[0]['video_title']; ?>
                        </h3>
                        <div class="video-details-block__video-tags">
                            <strong>Tags: </strong> <?= $video_details[0]['video_tags'] ?>
                        </div>
                        <div class="video-details-block__video-category">
                            <strong>Category: </strong> <?= $video_details[0]['video_category'] ?>
                        </div>
                        <div class="video-details-block__video-desc">
                            <strong>Description: </strong> <?= $video_details[0]['video_desc'] ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $footer; ?>
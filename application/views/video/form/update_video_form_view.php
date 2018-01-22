<?= $header; ?>
	<?= $navbar; ?>

		<div class="container">
			<div class="row">
				<div class="col-sm-12 padding-content">
					
					<!-- breadcrumb -->
					<div class="row">
						<ol class="breadcrumb">
							<li>
								<a href="<?= base_url().'video_manager'; ?>">
									<i class="fa fa-video-camera" aria-hidden="true"></i> Video Manager
								</a>
							</li>
							<li>
								<a href="<?= base_url().'video_manager/update_video_form/'.$video_id; ?>">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update Video
								</a>
							</li>
						</ol>
					</div>

					<!-- page header -->
					<div class="row">
						<div class="page-heading">
							<h2 class="page-heading__heading-text">Update Video</h2>
						</div>
					</div>

					<!-- form -->
					<div class="row">
						<div class="col-sm-5">
							<div class="row">
								<form action="<?= base_url().'video_manager/update_video_process'; ?>" method="post">
									<!-- video id -->
									<input type="hidden" name="video_id" value="<?= $video_id ?>">
									<input type="hidden" name="video_youtube_id" value="<?= $video_data[0]['video_youtube_id']; ?>">

									<!-- video link -->
									<div class="form-group <?= form_error('youtube_link')?'has-error':'' ?>">
										<label class="control-label label-required" for="youtube_link">Youtube Link</label>
										<input class="form-control" type="url" name="youtube_link" value="<?= set_value('youtube_link', $video_data[0]['video_youtube_link']); ?>" id="youtube_link">
										<?= form_error('youtube_link', '<p class="text-danger">', '</p>') ?>
									</div>

									<!-- video title -->
									<div class="form-group <?= form_error('youtube_title')?'has-error':'' ?>">
										<label class="control-label label-required" for="youtube_title">Video Title</label>
										<input class="form-control" type="text" name="youtube_title" value="<?= set_value('youtube_title', $video_data[0]['video_title']); ?>" id="youtube_title">
										<?= form_error('youtube_title', '<p class="text-danger">', '</p>') ?>
									</div>

									<!-- video tags -->
									<div class="form-group <?= form_error('youtube_tags')?'has-error':'' ?>">
										<label class="control-label label-required" for="youtube_tags">Video Tags</label>
										<input class="form-control" type="text" name="youtube_tags" value="<?= set_value('youtube_tags', $video_data[0]['video_tags']); ?>" id="youtube_tags">
										<?= form_error('youtube_tags', '<p class="text-danger">', '</p>') ?>
									</div>

									<!-- video category -->
									<div class="form-group <?= form_error('video_category')?'has-error':'' ?>">
										<label class="control-label label-required" for="video_category">Video Category</label>
										<select class="form-control" name="video_category" id="video_category">
											<option value="" selected>- Select Category -</option>
											<?php $options = ['gs1', 'gs2', 'gs3', 'gs4']; ?>
											<?php foreach($options as $value): ?>
												<?php if($value === set_value('video_category', strtolower($video_data[0]['video_category']))): ?>
													<option value="<?= $value ?>" selected><?= strtoupper($value) ?></option>
												<?php else: ?>
													<option value="<?= $value ?>"><?= strtoupper($value) ?></option>
												<?php endif; ?>
											<?php endforeach; ?>
										</select>
										<?= form_error('video_category', '<p class="text-danger">', '</p>') ?>
									</div>

									<!-- description -->
									<div class="form-group <?= form_error('description')?'has-error':'' ?>">
										<label class="control-label label-required" for="description">Description</label>
										<textarea class="form-control" name="description" placeholder="Enter video description" id="description" rows="5"><?= set_value('description', $video_data[0]['video_desc']) ?></textarea>
										<?= form_error('description', '<p class="text-danger">', '</p>') ?>
									</div>

									<!-- submit and clear -->
									<div class="form-group">
										<button class="btn btn-warning btn-sm">
											<i class="fa fa-pencil-square-o"></i> Update Video
										</button>
										<button class="btn btn-default btn-sm">
											<i class="fa fa-eraser"></i> Clear
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?= $footer ?>

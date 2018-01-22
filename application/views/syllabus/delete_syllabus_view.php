<?= $header; ?>
	<?= $navbar; ?>

	<div class="container padding-content">
		<div class="row">
			<div class="col-xs-12 col-sm-12">
				<!-- breadcrumb -->
				<div class="row">
					<ol class="breadcrumb">
						<li>
							<a href="#">
								<i class="fa fa-book fa-breadcrumb"></i>Syllabus Manager
							</a>
						</li>
						<li>
							<a href="#">
								<i class="fa fa-remove fa-breadcrumb"></i>Delete Syllabus
							</a>
						</li>
					</ol>
				</div>

				<!-- page-heading -->
				<div class="row">
					<div class="page-heading">
                        <h2 class="page-heading__heading-text">Delete Syllabus</h2>
                    </div>
				</div>

				<div class="row">
					<form action="<?= base_url().'syllabus_manager/delete_syllabus_process'; ?>" method="post">						
						<div class="col-xs-12 col-sm-4">
							<div class="row">

								<!-- syllabus id -->
								<input type="hidden" name="syllabus_id" value="<?= $syllabus_data[0]['syllabus_id']; ?>">

								<!-- title -->
								<div class="form-group">
									<label class="control-label">Selected Syllabus Title</label>
									<input class="form-control" type="text" name="name" value="<?= $syllabus_data[0]['syllabus_title']; ?>" disabled="true">
								</div>

								<!-- reason -->
								<div class="form-group">
									<label class="control-label">Reason</label>
									<select class="form-control" name="reason" required>
										<option value="" selected>- Select Reason -</option>
										<option value="Wrongly Created">Wrongly Created</option>
										<option value="Invalid Info">Invalid Info</option>
										<option value="Other">Other</option>
									</select>
								</div>

								<!-- remark -->
								<div class="form-group">
									<label class="control-label">Remark</label>
									<textarea class="form-control" name="remark" rows="5" placeholder="Enter your remark" required></textarea>
								</div>

								<!-- submit -->
								<div class="form-group">
									<button class="btn btn-danger" type="submit">
										<i class="fa fa-trash"></i> Delete Syllabus
									</button>
									<button class="btn btn-default" type="reset">
										<i class="fa fa-eraser"></i> Clear
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
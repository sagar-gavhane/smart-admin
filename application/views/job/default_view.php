<?= $header; ?>

    <?= $navbar; ?>

    <div class="container">
        <div class="row no-gutter-xs">
            <div class="col-xs-12 col-sm-12 padding-content">

                <!-- breadcrumb -->
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url().'job_manager'; ?>"><i class="fa fa-black-tie" aria-hidden="true"></i> Job Manager</a></li>
                    </ol>
                </div>

                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text">Job Manager</h2>
                    </div>
                </div>

                <!-- top buttons -->
                <div class="row">
                    <div class="top-buttons">
                        <a class="btn btn-primary" href="<?= base_url().'job_manager/create_job_form/' ?>">
                            <i class="fa fa-plus-square-o" aria-hidden="true"></i> Create Job
                        </a>
                    </div>
                </div>

                <?= $feedback; ?>

                <!-- quetions table -->
                <div class="row">
                    <?php if($jobs_data): ?>
                        <div class="jobs-table table-responsive">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Title</th>
                                    <th>Tags</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach($jobs_data as $key => $value): ?>
                                    <tr>
                                        <td><?= $key+1; ?></td>
                                        <td><?= $value['job_title'] ?></td>
                                        <td><?= $value['job_tags'] ?></td>
                                        <td><?= $value['job_category'] ?></td>
                                        <td>
                                            <a class="btn btn-warning btn-sm" href="<?= base_url().'job_manager/update_job_form/'.$value['job_id'] ?>">
                                                <i class="fa fa-pencil-square" aria-hidden="true"></i> Update
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="<?= base_url().'job_manager/delete_job_form/'.$value['job_id'] ?>">
                                                <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning animated shake">
                            There is no any records listed for jobs.
                        </div>
                    <?php endif;?>
                </div>

            </div>
        </div>
    </div>

<?= $footer; ?>

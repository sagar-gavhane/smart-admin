<?= $header; ?>

    <?= $navbar; ?>

    <div class="container">
        <div class="row no-gutter-xs">
            <div class="col-xs-12 col-sm-12 padding-content">

                <!-- breadcrumb -->
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url().'syllabus_manager'; ?>"><i class="fa fa-book" aria-hidden="true"></i> Syllabus Manager</a></li>
                    </ol>
                </div>

                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text">Syllabus Manager</h2>
                    </div>
                </div>

                <!-- top buttons -->
                <div class="row">
                    <div class="top-buttons">
                        <a class="btn btn-primary" href="<?= base_url().'syllabus_manager/create_syllabus_form/' ?>"><i class="fa fa-book" aria-hidden="true"></i> Create Syllabus</a>
                    </div>
                </div>

                <?= $feedback; ?>

                <!-- syllabus table -->
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Tag</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                            <?php foreach($syllabus_data as $key => $value ): ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <td><?= $value['syllabus_title'] ?></td>
                                    <td><?= $value['syllabus_tags'] ?></td>
                                    <td><?= ucwords(str_replace('_', ' ', $value['syllabus_category'])) ?></td>
                                    <td>
                                        <a class="btn btn-warning btn-sm" href="<?= base_url().'syllabus_manager/update_syllabus_form/'.$value['syllabus_id'] ?>">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="<?= base_url().'syllabus_manager/delete_syllabus_form/'.$value['syllabus_id'] ?>">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                        </a>
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

<?= $header; ?>

    <?= $navbar; ?>

    <div class="container">
        <div class="row no-gutter-xs">
            <div class="col-xs-12 col-sm-12 padding-content">

                <!-- breadcrumb -->
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url().'question_manager'; ?>"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Question Manager</a></li>
                    </ol>
                </div>

                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text">Question Manager</h2>
                    </div>
                </div>

                <!-- top buttons -->
                <div class="row">
                    <div class="top-buttons">
                        <a class="btn btn-primary" href="<?= base_url().'question_manager/create_question_form/' ?>">
                            <i class="fa fa-plus-square-o" aria-hidden="true"></i> Create Question
                        </a>
                    </div>
                </div>

                <?php if($this->session->feedback == 1): ?>
                    <?php if($this->session->feedback_msg == 'question_successfully_created'): ?>
                        <div class="row">
                            <div class="alert alert-success animated shake">
                                Your question has been successfully created.
                            </div>
                        </div>
                    <?php elseif($this->session->feedback_msg == 'question_failed_created'): ?>
                        <div class="row">
                            <div class="alert alert-danger animated shake">
                                Something went wrong. unable to create question. please try again.
                            </div>
                        </div>
                    <?php elseif($this->session->feedback_msg == 'question_successfully_updated'): ?>
                        <div class="row">
                            <div class="alert alert-success animated shake">
                                Your question has been successfully updated.
                            </div>
                        </div>
                    <?php elseif($this->session->feedback_msg == 'question_failed_update'): ?>
                        <div class="row">
                            <div class="alert alert-danger animated shake">
                                Something went wrong. unable to update question. please try again.
                            </div>
                        </div>
                    <?php   endif; ?>
                <?php   endif;
                        $array_items = array('feedback', 'feedback_msg'); 
                        $this->session->unset_userdata($array_items);
                ?>

                <!-- quetions table -->
                <div class="row">
                    <?php if($questions_data): ?>
                        <div class="questions-table table-responsive">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Title</th>
                                    <th>Tags</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach($questions_data as $key => $value): ?>
                                    <tr>
                                        <td><?= $key+1; ?></td>
                                        <td><?= $value['question_title'] ?></td>
                                        <td><?= $value['question_tags'] ?></td>
                                        <td><?= $value['question_category'] ?></td>
                                        <td>
                                            <a class="btn btn-warning btn-sm" href="<?= base_url().'question_manager/update_question_form/'.$value['question_id'] ?>">
                                                <i class="fa fa-pencil-square" aria-hidden="true"></i> Update
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="<?= base_url().'question_manager/delete_question_form/'.$value['question_id'] ?>">
                                                <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning animated shake">
                            There is no any records listed for questions.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?= $footer; ?>

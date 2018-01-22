<?= $header; ?>

    <?= $navbar; ?>

    <div class="container">
        <div class="row no-gutter-xs">
            <div class="col-xs-12 col-sm-12 padding-content">
                
                <!-- breadcrumb -->
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url().'audio_manager'; ?>"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> Notes Manager</a></li>
                    </ol>
                </div>

                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text">Notes Manager</h2>
                    </div>
                </div>

                <!-- top buttons -->
                <div class="row">
                    <div class="top-buttons">
                        <a class="btn btn-primary" href="<?= base_url().'notes_manager/create_notes_form/' ?>"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> Create Notes</a>
                    </div>
                </div>

                <?php if($this->session->feedback == 1): ?>
                    <?php if($this->session->feedback_msg == 'notes_successfully_inserted'): ?>
                        <div class="row">
                            <div class="alert alert-success animated shake">
                                Notes has been successfully inserted.
                            </div>
                        </div>
                    <?php elseif($this->session->feedback_msg == 'notes_insertion_failed'): ?>
                        <div class="row">
                            <div class="alert alert-danger animated shake">
                                Something went wrong. unable to insert notes. please try again.
                            </div>
                        </div>
                    <?php elseif($this->session->feedback_msg == 'notes_successfully_updated'): ?>
                        <div class="row">
                            <div class="alert alert-success animated shake">
                                Notes has been successfully updated.
                            </div>
                        </div>
                    <?php elseif($this->session->feedback_msg == 'notes_updating_failed'): ?>
                        <div class="row">
                            <div class="alert alert-success animated shake">
                                Something went wrong. Unable to update notes. Please try again.
                            </div>
                        </div>
                    <?php   endif; ?>
                <?php   endif;
                        $array_items = array('feedback', 'feedback_msg'); 
                        $this->session->unset_userdata($array_items);
                ?>

                <div class="row">
                    <?php if($notes_data): ?>
                        <div class="notes-list-table table-responsive">
                            <table class="table table-bordered table-striped">
                                <tr class="active">
                                    <th>Sr. No</th>
                                    <th>Title</th>
                                    <th>Tags</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach($notes_data as $key => $value): ?>
                                    <tr>
                                        <td><?= $key+1; ?></td>
                                        <td><?= $value['note_title']; ?></td>
                                        <td><?= $value['note_tags']; ?></td>
                                        <td><?= $value['note_category']; ?></td>
                                        <td>
                                            <a href="<?= base_url().'notes_manager/update_notes_form/'.$value['note_id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i> Update</a>
                                            <a href="<?= base_url().'notes_manager/update_notes_form/'.$value['note_id'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning animated shake">
                            There is no any notes records listed.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?= $footer; ?>
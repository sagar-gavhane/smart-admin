<?= $header; ?>

    <?= $navbar; ?>

    <div class="container">
        <div class="row no-gutter-xs">
            <div class="col-xs-12 col-sm-12 padding-content">
                <!-- breadcrumb -->
                <div class="row">
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?= base_url().'advertise_manager'; ?>">
                                <i class="fa fa-address-card-o" aria-hidden="true"></i> Advertise Manager
                            </a>
                        </li>
                    </ol>
                </div>

                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text">Advertise Manager</h2>
                    </div>
                </div>

                <!-- top buttons -->
                <div class="row">
                    <div class="top-buttons">
                        <a class="btn btn-info" href="<?= base_url().'advertise_manager/send_advertise_form/' ?>">
                            <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Send Advertise
                        </a>
                        <a class="btn btn-warning" href="<?= base_url().'advertise_manager/received_advertise/' ?>">
                            <i class="fa fa-retweet" aria-hidden="true"></i> Received Advertise
                        </a>                        
                    </div>
                </div>

                <?php if($this->session->feedback == 1): ?>
                    <?php if($this->session->feedback_msg == 'advertise_created_successfully'): ?>
                        <div class="row">
                            <div class="alert alert-success animated shake">
                                Your advertise has been successfully created.
                            </div>
                        </div>
                    <?php elseif($this->session->feedback_msg == 'advertise_creating_failed'): ?>
                        <div class="row">
                            <div class="alert alert-danger animated shake">
                                Something went wrong. unable to create advertise. please try again.
                            </div>
                        </div>
                    <?php   endif; ?>
                <?php   endif;
                        $array_items = array('feedback', 'feedback_msg'); 
                        $this->session->unset_userdata($array_items);
                ?>

                <!-- sent ads table -->
                <div class="row">                    
                    <?php if($send_ads_data): // if send ads data has contain some values ?>
                        <div class="table-responsive">
                            <h4 class="text-bold">Recent 10 Send Ads Data</h4>
                            <table class="table table-bordered table-striped table-condensed">
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Weblink</th>
                                    <th>Show Days</th>
                                    <th>Start Date</th>
                                    <th>Last Date</th>
                                    <th>Ad Content</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach($send_ads_data as $key => $value): ?>
                                    <tr>
                                        <td><?= $key+1 ?></td>
                                        <td><?= $value['send_ad_title'] ?></td>
                                        <td><?= $value['send_ad_desc'] ?></td>
                                        <td><a href="<?= $value['send_ad_web_link'] ?>" target="_blank">Vist</a></td>
                                        <td><?= $value['send_ad_show_days'] ?></td>
                                        <td><?= $value['send_ad_start_date'] ?></td>
                                        <td><?= $value['send_ad_last_date'] ?></td>
                                        <td><a href="<?= 'http://smart-admin.000webhostapp.com/assets/resource/ads/image/'.$value['send_ad_file_name']; ?>" target="_blank">Open</a></td>
                                        <td>
                                            <a href="<?= base_url().'advertise_manager/update_advertise_form/'.$value['send_ad_id']; ?>" class="btn btn-warning btn-sm">Update</a>
                                            <a href="<?= base_url().'advertise_manager/delete_advertise_form/'.$value['send_ad_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning animated shake">
                            There is no any records listed for sent ads.
                        </div>
                    <?php endif; ?>
                </div>

                <!-- received ads table -->
                <div class="row">                    
                    <?php if($received_ads_data): // if send ads data has contain some values ?>
                        <div class="table-responsive">
                            <h4 class="text-bold">Recent 10 Received Ads Data</h4>
                            <table class="table table-bordered table-striped table-condensed">
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name of customer</th>
                                    <th>Contact Number</th>
                                    <th>Email Address</th>
                                    <th>Message</th>
                                </tr>
                                <?php foreach($received_ads_data as $key => $value): ?>
                                    <tr>
                                        <td><?= $key+1 ?></td>
                                        <td><?= $value['received_ad_full_name'] ?></td>
                                        <td><?= $value['received_ad_contact_number'] ?></td>
                                        <td><?= $value['received_ad_email_address'] ?></td>
                                        <td><?= $value['received_ad_message'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning animated shake">
                            There is no any records listed for received ads.
                        </div>
                    <?php endif; ?>
                </div>

                <!-- video list table -->
                <div class="row audio-list-block">
                    <?php /*if($audio_data): ?>
                        <div class="audio-list-table table-responsive">
                            <table class="table table-bordered table-striped">
                                <tr class="active">
                                    <th>Sr. NO</th>
                                    <th>Title</th>
                                    <th>Tags</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach($audio_data as $key=>$value): ?>
                                    <tr>
                                        <td><?= $key+1; ?></td>
                                        <td><?= $value['audio_title']; ?></td>
                                        <td><?= $value['audio_tags']; ?></td>
                                        <td><?= ucwords($value['audio_category']); ?></td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="<?= base_url().'audio_manager/update_audio_form/'.$value['audio_id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update</a>
                                            <a class="btn btn-danger btn-sm" href="<?= base_url().'audio_manager/delete_audio_form/'.$value['audio_id']; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning animated shake">
                            There is no any audio list. You have required to upload new audios.
                        </div>
                    <?php endif; */?>
                </div>

            </div>
        </div>
    </div>

    <?= $footer; ?>
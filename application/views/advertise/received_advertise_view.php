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
                        <li>
                            <a href="<?= base_url().'advertise_manager/received_advertise/'; ?>">
                                <i class="fa fa fa-retweet" aria-hidden="true"></i> Received Ads
                            </a>
                        </li>
                    </ol>
                </div>

                <!-- page heading -->
                <div class="row">
                    <div class="page-heading">
                        <h2 class="page-heading__heading-text">Received Ads</h2>
                    </div>
                </div>

                <!-- received ads table -->
                <div class="row">                    
                    <?php if($received_ads_data): // if send ads data has contain some values ?>
                        <div class="table-responsive">
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

            </div>
        </div>
    </div>

    <?= $footer; ?>
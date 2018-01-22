<?php if ($this->session->feedback): ?>
    <div class="row">
        <div class="alert alert-<?=$this->session->feedback_type?> animated shake">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?=$this->session->feedback_msg;?>
        </div>
    </div>
    <?php $sessionData = array('feedback', 'feedback_type', 'feedback_msg');
	$this->session->unset_userdata($sessionData);?>
<?php endif;?>
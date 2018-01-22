<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-primary" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Dashboard</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-primary">
            <ul class="nav navbar-nav navbar-right">
                <li class="<?= ($page_name == 'video')? 'active' : '' ; ?>">
                    <a href="<?= base_url().'video_manager'; ?>"><i class="fa fa-video-camera" aria-hidden="true"></i> Video</a>
                </li>
                <li class="<?= ($page_name == 'audio')? 'active' : '' ; ?>">
                    <a href="<?= base_url().'audio_manager'; ?>"><i class="fa fa-bullhorn" aria-hidden="true"></i> Audio</a>
                </li>
                <li class="<?= ($page_name == 'notes')? 'active' : '' ; ?>">
                    <a href="<?= base_url().'notes_manager'; ?>"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> Notes</a>
                </li>
                <li class="<?= ($page_name == 'syllabus')? 'active' : '' ; ?>">
                    <a href="<?= base_url().'syllabus_manager'; ?>"><i class="fa fa-book" aria-hidden="true"></i> Syllabus</a>
                </li>
                <li class="<?= ($page_name == 'question')? 'active' : '' ; ?>">
                    <a href="<?= base_url().'question_manager'; ?>"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Question</a>
                </li>
                <li class="<?= ($page_name == 'jobs')? 'active' : '' ; ?>">
                    <a href="<?= base_url().'job_manager'; ?>"><i class="fa fa-black-tie" aria-hidden="true"></i> Jobs</a>
                </li>
                <li class="<?= ($page_name == 'advertise')? 'active' : '' ; ?>">
                    <a href="<?= base_url().'advertise_manager'; ?>"><i class="fa fa-address-card-o" aria-hidden="true"></i> Advertise</a>
                </li>
                <li class="<?= ($page_name == 'logout')? 'active' : '' ; ?>">
                    <a href="<?= base_url().'logout'; ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
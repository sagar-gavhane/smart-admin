// parsley form validation

// parsley options
var parsleyOptions = {
        successClass: 'has-success',
        errorClass: 'has-error',
        classHandler: function (_el) {
            return _el.$element.closest('.form-group');
        }
};

// apply parsley js to every form
if($('form').length > 0){
    $('form').parsley(parsleyOptions);
}

function clearParsleyError(){
    $('form').parsley().reset();
}

/*
$('document').ready(function(){
    $('#upload-video-button').click(function(){
        var base_url = 'http://localhost/smart-admin/';

        // get video id from url
        $('#up-youtube-id').val(getVideoID($('#up-youtube-link').val()));

        // trim tags and effectivly separated by comma
        $('#up-video-tags').val(getVideoTags($('#up-video-tags').val()));

        // trim category and effectivly separated by comma
        $('#up-video-category').val(getVideoTags($('#up-video-category').val()));

        $.ajax({
            type: 'post',
            url: base_url +'video_manager/upload_video',
            data: $('#upload-video-form').serialize(),
            success: function(res){                
                res = jQuery.parseJSON(res);
                console.log(res);

                if(res.feedback == false){
                    switch (res.feedback_msg) {
                        case "validation_failed":
                            console.log('validation failed !! wow');
                            break;

                        case "video_already_exist":
                            console.log('May be video already exist into data, upload another');
                            break;

                        default:
                            console.log('default case');
                            break;
                    }
                }else{
                    console.log('positive signal...');
                }
            },
            error: function(){
                console.log('We have received error');
            }
        });  
    });
});*/

// get youtube video id
// function getVideoID(url){
//     var ID = '';
//     url = url.replace(/(>|<)/gi, '').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
//     if(url[2] !== undefined){
//         ID = url[2].split(/[^0-9a-z_\-]/i);
//         ID = ID[0];
//     }else{
//         ID = url;
//     }
//     return ID;
// }

// // get video tags
// function getVideoTags(tags){
//     copyArray = []; // copy into this array
//     data = tags.split(",");
//     data.forEach(function(e, index){
//         copyArray.push(e.trim());
//     });
//     return copyArray.join(', ');
// }
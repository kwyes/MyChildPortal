$(document).ready(function() {
// Gets the video src from the data-src on each button
var $videoSrc;
var $videoCaptionSrc;
var catpionSrcObj;
$('.videoLink').click(function() {
    $videoSrc = $(this).data( "src" );
    $videoCaptionSrc = $(this).data("caption");
    catpionSrcObj = JSON.parse(JSON.stringify($videoCaptionSrc));
    $("track").remove();
});
// when the modal is opened autoplay it
$('#videoModal').on('shown.bs.modal', function (e) {

// set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
$("#video").attr('src',$videoSrc);
// console.log(Object.keys(catpionSrcObj).length);
var subtitles = '';
for (var i = 0; i < Object.keys(catpionSrcObj).length; i++) {
  subtitles += '<track kind="subtitles" src="'+catpionSrcObj[i].path+'" label="'+catpionSrcObj[i].lang+'">';
  console.log(i);
}
console.log(subtitles);
$(subtitles).insertAfter("source");
});



// stop playing the youtube video when I close the modal
$('#videoModal').on('hide.bs.modal', function (e) {
    // a poor man's stop video
    $("#video").attr('src','');
})


// document ready
});

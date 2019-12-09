var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;



//ALTERNATE OPTION FOR AUTO PLAYING AUDIO
// class Audio {
//     constructor() {
//         this.currentlyPlaying;
//         this.audio = document.createElement('audio');
//         this.setTrack = function (src) {
//             this.audio.src = src;
//         };
//         this.play = function() {
//             this.audio.play();
//         }
//     } 
// }

function openPage(url) {

	if(url.indexOf("?") == -1) {
		url = url + "?";
	}

	var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
    $("#mainContent").load(encodedUrl);
    //when changing pages, scroll to top
    $("body").scrollTop(0);
    //puts album url into url without actually changing pages.
    history.pushState(null, null, url);
}

//convert time along progress bar
function formatTime(seconds){
    var time = Math.round(seconds);
    var minutes = Math.floor(time/60);
    var seconds = time - minutes * 60;

    //for times that need 0, add 0 to numbers less than 10.
    var extraZero;
    if(seconds<10) {
        extraZero = "0";
    } else {
        extraZero = "";
    }

    return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio){
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration-audio.currentTime));

    var progress = audio.currentTime / audio.duration * 100;
    $(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
}

function playFirstSong() {
    //set first song in array
    setTrack(tempPlaylist[0], tempPlaylist, true);
}

function Audio() {
    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("ended", function(){
        nextSong();
    });

    this.audio.addEventListener("canplay", function() {
        //"this is refering to object the event called on"
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    //if it has duration go false
    this.audio.addEventListener("timeupdate", function(){
        if(this.duration) {
            updateTimeProgressBar(this);
        }
    });

    this.audio.addEventListener("volumechange", function(){
        updateVolumeProgressBar(this);
    });

    this.setTrack = function(track){
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    }
    this.play = function(){
        this.audio.play();
    }
    this.pause = function() {
        this.audio.pause();
    }
    this.setTime = function(seconds) {
        this.audio.currentTime = seconds;
    }
}


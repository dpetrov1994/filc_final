

function getDashboardTV() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            $('#dashbaord_tv').html(this.responseText);
            timer(0);
        }
    };
    xmlhttp.open("GET", "../mod_inicio/tv_content.php", true);
    xmlhttp.send();
}
getDashboardTV();



function timer(duration) {
    var TotalSeconds = 60;
    var diff=TotalSeconds-duration;
    var progresBarWidth = (diff * 100 / TotalSeconds);

    $('#progress-to-reload').animate({
        width: progresBarWidth + '%',
    }, 1000, "linear");
    if (progresBarWidth <= 0) {
        getDashboardTV();
    }else{
        setTimeout(function () {
            timer(duration+1)
        },1000);
    }
}




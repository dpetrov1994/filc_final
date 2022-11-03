<!DOCTYPE html>
<html>
<body>
<div style="text-align:center">
    <p>Aguarde...</p>
    <img src="map-loading.gif">
</div>



<script>
    getLocation();
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        alert("&latitude="+ position.coords.latitude+"&longitude="+position.coords.longitude);
    }
</script>

</body>
</html>
function initMap() {
    var seattle = {lat: 47.608013, lng: -122.335167};
    var northSet = {lat: 47.699598, lng: -122.332292};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: seattle
    });
    var marker1 = new google.maps.Marker({
        position: seattle,
        map: map
    });

    var marker2 = new google.maps.Marker({
        position: northSet,
        map: map
    })

}
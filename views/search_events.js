//function initMap() {

  /**
     var seattle = {lat: 47.608013, lng: -122.335167};
     var northSet = {lat: 47.699598, lng: -122.332292};

     var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: seattle
    });

     var marker = new google.maps.Marker({
         position: seattle,
         map: map
     });
     var marker1 = new google.maps.Marker({
        position: northSet,
        map: map
    });

*/

  function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
          zoom:6,
          center: {lat: 47.608013, lng: -122.335167}
      });

      setMarkers(map);
  }

  //var cities = [[47.699598, -122.332292], [47.3209, -122.0194], [47.648824, -122.344072]];
  function setMarkers(map){
      /**
      var marker = new google.maps.Marker({
          position: {lat: 47.608013, lng: -122.335167},
          map: map
      });
*/
      for (var i = 0; i < locations.length; i++) {
          var city = locations[i];
          //document.getElementById('demo').innerHTML = locations.length.toString();
          var marker = new google.maps.Marker({
              position: {lat: parseInt(city[0]), lng: parseInt(city[1])},
              map: map
          });
      }
  }



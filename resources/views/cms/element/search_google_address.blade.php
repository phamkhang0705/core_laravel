<script type="text/javascript">
    searchGoogleAddress = function () {
        //event.preventDefault();
        var address = $('#search_address').val();
        var geo = new google.maps.Geocoder;
        geo.geocode({'address': address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var map_canvas = document.getElementById('gmap_markers'),
                    lat = results[0].geometry.location.lat(),
                    lng = results[0].geometry.location.lng();

                var myLatlng = new google.maps.LatLng(lat, lng);

                var map_options = {
                    center: myLatlng,
                    zoom: 16,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };

                var map = new google.maps.Map(map_canvas, map_options);

                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    draggable: true,
                    title: 'Hello World!'
                });

                $('input[name=latitude]').val(lat);
                $('input[name=longitude]').val(lng);

                google.maps.event.addListener(marker, 'dragend', function (a) {
                    console.log(this.getPosition().lat());
                    console.log(this.getPosition().lng());

                    $('input[name=latitude]').val(this.getPosition().lat());
                    $('input[name=longitude]').val(this.getPosition().lng());
                });
            } else {
                alert("Không thể tìm được địa chỉ nhập vào vì lý do : " + status);
            }
        });
    };
</script>
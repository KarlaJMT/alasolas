<div>
    <div id="map" style="height: 400px; width: 100%;"></div>
    <input type="hidden" wire:model="latitude">
    <input type="hidden" wire:model="longitude">

    <!-- ahora empezaremos a trabajar en javascript -->
    @push('scripts')
        <script
            src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&callback=initMap"
            async defer></script>
            <script>
                function initMap() {
                    const map = new google.maps.Map(document.getElementById("map"), {
                        center:{lat:{{$latitude}}, lng:{{ $longitude}} },
                        zoom:15
                    });
                    
                    const marker = new google.maps.Marker({
                        position:{lat:{{$latitude}}, lng:{{ $longitude}} },
                        map:map,
                        draggable:true
                    });

                    google.maps.event.addListener(marker, 'dragend',function(event)){
                        const lat = event.latLng.lat();
                        const lng = event.latLng.lng();
                        @this.call('updateCoordinates', lat, lng);
                    };

                    map.addListener('click',function(event){
                        marker.setPosition(event.latLng);
                        const lat = event.latLng.lat();
                        const lng = event.latLng.lng();
                        @this.call('updateCoordinates', lat, lng);
                    })
                }
            </script>
    @endpush
    // con esto se termina de trabajar con javascript
</div>
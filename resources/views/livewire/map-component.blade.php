<div>
    <div id="map" style="height: 400px;"></div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            var map = L.map('map').setView([51.505, -0.09], 13); // Set the initial center and zoom level
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
        });
    </script>
@endpush

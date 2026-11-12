@extends('layouts.app')

@section('title', 'Edit Member')

@section('content')
    <div class="topbar">
        <div>
            <h1>Edit Member</h1>
            <p>Update the member’s information.</p>
        </div>

        <a href="{{ route('members.index') }}" class="btn btn-secondary">
            Back to Members
        </a>
    </div>

    <div class="card">
        <form action="{{ route('members.update', $member) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Membership Number</label>

                <input
                    type="text"
                    value="{{ $member->membership_number }}"
                    readonly
                >
            </div>

            <div class="grid">
                <div class="form-group">
                    <label for="first_name">First Name</label>

                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        value="{{ old('first_name', $member->first_name) }}"
                        required
                    >

                    @error('first_name')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>

                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        value="{{ old('last_name', $member->last_name) }}"
                        required
                    >

                    @error('last_name')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="grid">
                <div class="form-group">
                    <label for="email">Email Address</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $member->email) }}"
                    >

                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>

                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="{{ old('phone', $member->phone) }}"
                    >

                    @error('phone')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="address">Address</label>

                <textarea
                    id="address"
                    name="address"
                >{{ old('address', $member->address) }}</textarea>

                @error('address')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group map-section">
                <label>Update Location on Map</label>

                <div id="map"></div>

                <input
                    type="hidden"
                    id="latitude"
                    name="latitude"
                    value="{{ old('latitude', $member->latitude ?? '14.5995') }}"
                >

                <input
                    type="hidden"
                    id="longitude"
                    name="longitude"
                    value="{{ old('longitude', $member->longitude ?? '120.9842') }}"
                >

                <p id="coordinates" class="map-help">
                    Click or drag the marker to update the location.
                </p>

                @error('latitude')
                    <div class="error-text">{{ $message }}</div>
                @enderror

                @error('longitude')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid">
                <div class="form-group">
                    <label for="birth_date">Birth Date</label>

                    <input
                        type="date"
                        id="birth_date"
                        name="birth_date"
                        value="{{ old(
                            'birth_date',
                            optional($member->birth_date)->format('Y-m-d')
                        ) }}"
                    >

                    @error('birth_date')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="registered_at">Registration Date</label>

                    <input
                        type="date"
                        id="registered_at"
                        name="registered_at"
                        value="{{ old(
                            'registered_at',
                            optional($member->registered_at)->format('Y-m-d')
                        ) }}"
                    >

                    @error('registered_at')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="grid">
                <div class="form-group">
                    <label for="membership_category_id">
                        Membership Category
                    </label>

                    <select
                        id="membership_category_id"
                        name="membership_category_id"
                        required
                    >
                        <option value="">Select a category</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    old(
                                        'membership_category_id',
                                        $member->membership_category_id
                                    ) == $category->id
                                )
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('membership_category_id')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="membership_level_id">
                        Membership Level
                    </label>

                    <select
                        id="membership_level_id"
                        name="membership_level_id"
                        required
                    >
                        <option value="">Select a level</option>

                        @foreach ($levels as $level)
                            <option
                                value="{{ $level->id }}"
                                @selected(
                                    old(
                                        'membership_level_id',
                                        $member->membership_level_id
                                    ) == $level->id
                                )
                            >
                                {{ $level->name }}
                                — ₱{{ number_format($level->fee, 2) }}
                            </option>
                        @endforeach
                    </select>

                    @error('membership_level_id')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status</label>

                <select id="status" name="status" required>
                    <option
                        value="Active"
                        @selected(
                            old('status', $member->status) === 'Active'
                        )
                    >
                        Active
                    </option>

                    <option
                        value="Inactive"
                        @selected(
                            old('status', $member->status) === 'Inactive'
                        )
                    >
                        Inactive
                    </option>
                </select>

                @error('status')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn">
                Update Member
            </button>
        </form>
    </div>

    <style>
        .map-section {
            margin-top: 20px;
        }

        #map {
            width: 100%;
            height: 330px;
            margin-top: 8px;
            border: 1px solid #dbe4ea;
            border-radius: 12px;
            overflow: hidden;
        }

        .map-help {
            margin: 8px 0 0;
            color: #64748b;
            font-size: 13px;
        }
    </style>

    <script>
        let map;
        let marker;

        function initMap() {
            const latitude = Number(
                document.getElementById('latitude').value
            );

            const longitude = Number(
                document.getElementById('longitude').value
            );

            const location = {
                lat: latitude,
                lng: longitude
            };

            map = new google.maps.Map(
                document.getElementById('map'),
                {
                    center: location,
                    zoom: 13,
                    mapTypeControl: false,
                    streetViewControl: false,
                    fullscreenControl: true
                }
            );

            marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable: true
            });

            map.addListener('click', function (event) {
                updateLocation(
                    event.latLng.lat(),
                    event.latLng.lng()
                );
            });

            marker.addListener('dragend', function (event) {
                updateLocation(
                    event.latLng.lat(),
                    event.latLng.lng()
                );
            });

            updateCoordinates(latitude, longitude);
        }

        function updateLocation(latitude, longitude) {
            marker.setPosition({
                lat: latitude,
                lng: longitude
            });

            document.getElementById('latitude').value =
                latitude.toFixed(7);

            document.getElementById('longitude').value =
                longitude.toFixed(7);

            updateCoordinates(latitude, longitude);
        }

        function updateCoordinates(latitude, longitude) {
            document.getElementById('coordinates').textContent =
                'Latitude: ' + latitude.toFixed(6) +
                ', Longitude: ' + longitude.toFixed(6);
        }

        window.initMap = initMap;
    </script>

    <script
        async
        defer
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap">
    </script>
@endsection
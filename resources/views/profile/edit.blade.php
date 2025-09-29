@extends('layouts.app')

@section('title', 'Profile')

@section('header')
    <h2 class="h5 mb-0">Profile</h2>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col">

            <!-- Update Profile Information -->
            <div class="card shadow-sm">
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User -->
            @if (Route::has('profile.destroy'))
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection

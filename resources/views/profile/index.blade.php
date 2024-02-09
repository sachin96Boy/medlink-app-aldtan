<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
    @include('header')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="bg-gray-100">
@extends('layouts.app')
    @section('content')
<div class="container">
    <div class="row">
       
        <div class="col-md-11">
            <div class="row">

                <div class="col-md-10">
                    <h1 class="text-center">{{ Auth::user()->name }}'s Profile</h1>
                </div>
                
                
            </div>
        <div class="row">
        <div class="container">
        @if(session('error'))
    <div id="errorAlert" class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div id="successAlert" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        var timeoutDuration = 1000;

        setTimeout(function() {
            $('#errorAlert').fadeOut('slow');
        }, timeoutDuration);

        setTimeout(function() {
            $('#successAlert').fadeOut('slow');
        }, timeoutDuration);
    });
</script>

        <form action="{{ route('updateProfilePicture') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateFileSize()">
    @csrf
    <div class="mb-3">
    @if(Auth::user()->profile_picture)
            <img src="{{ asset('storage/app/public/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="mt-3" style="max-width: 200px;">
        @endif
        <label for="profile_picture" class="form-label">Profile Picture</label>
        <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept=".jpg, .jpeg, .png, .gif">
        <small id="fileSizeError" class="text-danger"></small>
    </div>
    <button type="submit" class="btn btn-primary">Update Profile Picture</button>
</form>
<form action="{{ route('updateUser') }}" method="POST">
    @csrf
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}">
    <label for="email" class="form-label">Email</label>
    <input type="text" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" readonly>
    <label for="age" class="form-label">Age</label>
    <input type="number" class="form-control" id="age" name="age" value="{{ Auth::user()->age }}">
    <label for="nic" class="form-label">NIC number</label>
    <input type="text" class="form-control" id="nic" name="nic" value="{{ Auth::user()->nic }}">
    <label for="id" class="form-label">Doctor Registration ID</label>
    <input type="text" class="form-control" id="mid" name="mid" value="{{ Auth::user()->mid }}">
    <input type="hidden" class="form-control" id="id" name="id" value="{{ Auth::user()->id }}">
    <label for="number" class="form-label">Mobile Number</label>
    <input type="number" class="form-control" id="number" name="number" value="{{ Auth::user()->number }}">
    <button type="submit" class="btn btn-primary" style="margin-top:8px;">Update</button>
</form>
<script>
    function validateFileSize() {
        var inputFile = document.getElementById('profile_picture');
        var fileSizeError = document.getElementById('fileSizeError');

        if (inputFile.files.length > 0) {
            var fileSize = inputFile.files[0].size; // in bytes

            // Check if the file size exceeds the limit (e.g., 2MB)
            var maxSize = 2 * 1024 * 1024; // 2 megabytes
            if (fileSize > maxSize) {
                fileSizeError.textContent = 'File size exceeds the limit (2MB)';
                return false; // Prevent form submission
            }
        }

        // Clear any previous error message
        fileSizeError.textContent = '';
        return true; // Allow form submission
    }
</script>


       
    </div>
        </div>
        </div>
    </div>
</div>
    @endsection
    @include('footer')
</body>
</html>
@extends('layout.masternsb')
@section('profile')

<!-- Profile Information -->
<div class="card text-start mb-4">
    <div class="card-body">
        <h4 class="card-title fw-semibold">Profile Information</h4>
        <br>
        <p class="fs-6">View your account information and update your email</p>
        <div class="mb-3">
            <label for="" class="form-label">Username</label>
            <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId" />
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Email</label>
            <input type="email" class="form-control" name="" id="" aria-describedby="emailHelpId" />

        </div>
        <button type="submit" class="btn btn-secondary">
            Save
        </button>

    </div>
</div>

<!-- Update Password -->
<div class="card text-start mb-4">
    <div class="card-body">
        <h4 class="card-title fw-semibold">Update Password</h4>
        <br>
        <p class="fs-6">Change you password to ensure the security of your account</p>
        <div class="mb-3">
            <label for="" class="form-label">Current Password</label>
            <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId" />
            <small>Forgot your password? </small><a class="text-reset" href=""><small>Forgot Password</small></a>
        </div>

        <div class="mb-3">
            <label for="" class="form-label">New Password</label>
            <input type="email" class="form-control" name="" id="" aria-describedby="emailHelpId" />

        </div>

        <div class="mb-3">
            <label for="" class="form-label">Confirm New Password</label>
            <input type="email" class="form-control" name="" id="" aria-describedby="emailHelpId" />

        </div>
        <button type="submit" class="btn btn-secondary">
            Save
        </button>

    </div>
</div>

<!-- Delete Account -->
<div class="card text-start mb-4">
    <div class="card-body">
        <h4 class="card-title fw-semibold">Delete Account</h4>
        <br>
        <p>Once you delete your account, all of it's resources and data will be wiped out from our database (including your posts)</p>
        <button type="submit" class="btn btn-danger">
            Delete
        </button>

    </div>
</div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Memastikan jQuery dimuat -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#example1').DataTable(); // Menginisialisasi DataTable
});
</script>
@endpush

@push('tableStyle')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endpush
@extends('layout.masternsb')
@section('profile')

<!-- Profile Information -->
<div class="card text-start mb-4">
    <div class="card-body">
        <h4 class="card-title fw-semibold">Profile Information</h4>
        <br>
        <p class="fs-6">View your account information and update your email</p>
        <form id='profileForm' action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('patch')
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}" placeholder="" aria-describedby="helpId" />
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelpId" />
            </div>
            <button type="submit" class="btn btn-secondary">
                Save
            </button>
        </form>
    </div>
</div>

<!-- Update Password -->
<div class="card text-start mb-4">
    <div class="card-body">
        <h4 class="card-title fw-semibold">Update Password</h4>
        <br>
        <p class="fs-6">Change you password to ensure the security of your account</p>
        <form id="passwordForm" action="{{ route('password.update') }}" method="POST">
        @csrf
        @method('put')
            <div class="mb-3">
                <label for="update_password_current_password" class="form-label">Current Password</label>
                <input type="password" name="current_password" id="update_password_current_password" class="form-control" placeholder="" aria-describedby="helpId" />
                <small>Forgot your password? </small><a class="text-reset" href="{{ route('password.request') }}"><small>Forgot Password</small></a>
            </div>

            <div class="mb-3">
                <label for="update_password_password" class="form-label">New Password</label>
                <input type="password" class="form-control" name="password" id="update_password_password" aria-describedby="HelpId" />

            </div>

            <div class="mb-3">
                <label for="update_password_password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" name="password_confirmation" id="update_password_password_confirmation" aria-describedby="HelpId" />

            </div>
            <button type="submit" class="btn btn-secondary">
                Save
            </button>
        </form>
    </div>
</div>

<!-- Delete Account -->
<div class="card text-start mb-4">
    <div class="card-body">
        <h4 class="card-title fw-semibold">Delete Account</h4>
        <br>
        <p>Once you delete your account, all of it's resources and data will be wiped out from our database (including your posts)</p>
        <form id="deleteForm" action="{{ route('profile.destroy') }}" method="POST">
        @csrf
        @method('delete')
            <button type="button" class="btn btn-danger" id="deleteButton">
                Delete
            </button>
        </form>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
document.querySelector('#profileForm').addEventListener('submit', function(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to save changes to your profile?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, save it!'
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.submit();
        }
    });
});

// SweetAlert Success Notification for Profile Update
@if (session('status') === 'profile-updated')
    Swal.fire({
        icon: 'success',
        title: 'Profile Updated',
        text: 'Your profile information has been successfully updated.'
    });
@endif

document.querySelector('#passwordForm').addEventListener('submit', function(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to change your password?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!'
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.submit();
        }
    });
});

// SweetAlert Success Notification for Profile Update
@if (session('status') === 'password-updated')
    Swal.fire({
        icon: 'success',
        title: 'Password Updated',
        text: 'Your Password has been successfully updated.'
    });
@endif

document.getElementById('deleteButton').onclick = function() {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover your account!",
            content: {
                element: "input",
                attributes: {
                    placeholder: "Enter your password",
                    type: "password"
                },
            },
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((inputValue) => {
            if (inputValue) {
                // Menambahkan input password ke dalam form sebelum disubmit
                const passwordInput = document.createElement("input");
                passwordInput.type = "hidden";
                passwordInput.name = "password"; // Sesuaikan dengan nama field di controller
                passwordInput.value = inputValue; // Mengambil password dari SweetAlert input
                
                // Menambahkan input ke dalam form
                document.getElementById('deleteForm').appendChild(passwordInput);
                
                // Submit form
                document.getElementById('deleteForm').submit();
            }
        });
    };
</script>
@endpush
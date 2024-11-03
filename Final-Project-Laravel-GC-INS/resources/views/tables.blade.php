@extends('layout.master')
@section('content')

<!-- Card Postingan -->
<div class="col-md-9 mx-auto card border-secondary">
    <div class="card">
        <div class="card-header pb-1">
            <div class="row">
                <h1 class="card-title fs-4 mb-1">Post Title</h1>
            </div>
            <div class="row">
                <small class="d-block text-muted" style="font-size:small">Post Topic</small>
            </div>
        </div>
        <div class="card-body">
            <p class="card-text">Isi Post</p>
        </div>
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
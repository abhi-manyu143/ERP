@extends('layouts.app')

@section('content')
    {{-- <div class="d-flex justify-content-center"> --}}
    <div class="card border p-4">
        <div class="card-header">Add User</div>
        <div class="card-body">
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <form id="user_Editform" class="row g-3">
                @csrf
                <div class="col-3">
                    <label for="designation" class="visually">User Name</label>
                    <input type="text" value="{{ $edit_user->name }}" class="form-control" id="user_name" name="user_nmae" value="" placeholder="Enter Name">
                </div>
                <div class="col-3">
                    <label for="designation" class="visually">Email</label>
                    <input type="email" value="{{ $edit_user->email }}" class="form-control" id="email" name="email" value="" placeholder="Enter email">
                </div>
                <div class="col-3">
                    <label for="designation" class="visually">Address</label>
                    <input type="text" value="{{ $edit_user->address }}" class="form-control" id="address" name="address" value="" placeholder="Enter address">
                </div>
                <div class="col-3">
                    <label for="status" class="visually">Active Status</label>
                    <select class="form-control" id="status" name="status" aria-label="Default select example">
                        <option {{ $edit_user->status == 1 ? 'selected' : '' }} value="1">Active</option>
                        <option {{ $edit_user->status == 2 ? 'selected' : '' }} value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-3">
                    <label for="designation" class="visually">Designation</label>
                    <select class="form-control" id="designation" name="designation" aria-label="Default select example">
                        @foreach ($designation as $option)
                        <option {{ $edit_user->status == $option->id ? 'selected' : '' }} value="{{ $option->id }}">{{ $option->designation }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" id="user_id" value="{{ $edit_user->id }}">

                <div class="col-3">
                    <label for="password" class="visually">Password</label>
                    <input type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Password" id="password">
                </div>

                <div class="col-3">
                    <label for="designation" class="visually">Confirm Passowrd</label>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Retype password">
                </div>
                <div class="col-4 mt-5">
                    <button type="submit" class="btn btn-primary mb-3">Add</button>
                </div>
            </form>
        </div>
    </div>
    {{-- </div> --}}
    <script>


    $(document).ready(function() {
    $('#user_Editform').submit(function(event) {
        event.preventDefault();
        var designation = $("#designation").val();
        var status = $("#status").val();
        var email = $("#email").val();
        var user_name = $("#user_name").val();
        var address = $("#address").val();
        var token = $("input[name='_token']").val();
        var user_id = $('#user_id').val();


        $.ajax({
            type: 'POST',
            url: "{{ route('store.edituser') }}",
            data: {
                designation: designation,
                status: status,
                email: email,
                user_name: user_name,
                address: address,
                user_id: user_id
            },
            headers: {
                'X-CSRF-TOKEN': token
            },
            success: function(data) {
                console.log(data);
                if ($.isEmptyObject(data.error)) {
                    // alert(data.success);
                    window.location.href =  "{{ route('list.user') }}";
                } else {
                    printErrorMsg(data.error);
                }
            }
        });
    });
});
    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }
//     </script>
@endsection

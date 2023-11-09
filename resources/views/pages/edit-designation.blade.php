@extends('layouts.app')

@section('content')
    {{-- <div class="d-flex justify-content-center"> --}}
    <div class="card border p-4">
        <div class="card-header">Add Designation</div>
        <div class="card-body">
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <form id="designationForm" class="row g-3">
                @csrf
                <div class="col-4">
                    <label for="designation" class="visually-hidden">Designation</label>
                    <input type="text" class="form-control" id="designation" name="designation" value="{{$data->designation}}" placeholder="Enter designation">
                </div>
                <div class="col-4">
                    <label for="status" class="visually-hidden">Active Status</label>
                    <select class="form-control" id="status" name="status" aria-label="Default select example">
                        {{-- <option selected>-- select ---</option> --}}
                        <option {{ $data->status == 1 ? 'selected' : '' }} value="1">Active</option>
                        <option {{ $data->status == 2 ? 'selected' : '' }} value="0">Inactive</option>
                    </select>
                </div>
                <input type="hidden" value="{{ $data->id }}" id="id">
                <div class="col-4 mt-4">
                    <button type="submit" class="btn btn-primary mb-3">Add</button>
                </div>
            </form>
        </div>
    </div>
    {{-- </div> --}}
    <script>


    $(document).ready(function() {
    $('#designationForm').submit(function(event) {
        event.preventDefault();
        var designation = $("#designation").val();
        var status = $("#status").val();
        var token = $("input[name='_token']").val();
        var id = $('#id').val();

        $.ajax({
            type: 'POST',
            url: "{{ route('designation.edit') }}",
            data: {
                designation: designation,
                status: status,
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': token
            },
            success: function(data) {
                console.log(data);
                if ($.isEmptyObject(data.error)) {
                    // alert(data.success);
                    window.location.href =  "{{ route('designation.index') }}";
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
    </script>
@endsection

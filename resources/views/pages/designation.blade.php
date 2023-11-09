@extends('layouts.app')

@section('content')
    <div class="card p-3">
        <div class="d-flex justify-content-end">
            <a href="{{ route('designation.create') }}"><button class="btn btn-primary">Add Designation</button></a>
        </div>

        <div class="p-2">
            <table class="table border">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Designation</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->designation }}</td>
                            <td>
                                <div class="d-flex justify-content-space-between">
                                    <div id="active" class="m-2">Active</div>
                                    <div onclick="changestatus('{{ $item->status }}', '{{ $item->id }}');"
                                        class="m-2"><ion-toggle {{ $item->status == 1 ? 'checked' : '' }}></ion-toggle>
                                    </div>
                                    <div id="inactive" class="m-2">inactive</div>
                                    <input type="hidden" value="{{ $item->status }}" id="statusvalue">
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('designation.show',['id' => $item->id]) }}"><button class="btn btn-warning">edit</button></a>  <a href=""><button class="btn btn-danger">delete</button></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <script>
        function changestatus(status, id) {
            var val = $('#statusvalue').val();
            $.ajax({
                type: 'POST',
                url: "{{ route('change.status') }}",
                data: {
                    status: val,
                    id: id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log(data);
                    $('#statusvalue').val(data.status);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: data.message
                    });
                }
            });
        }
    </script>
@endsection

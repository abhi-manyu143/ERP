@extends('layouts.app')

@section('content')
    <div class="card p-3">
        <div class="d-flex justify-content-end">
            <div class="dropdown m-2">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown button
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @foreach ($designation as $item)
                        <li onclick="designation_filter('{{ $item->id }}')"><a class="dropdown-item"
                                href="#">{{ $item->designation }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="dropdown m-2">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown button
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li onclick="price_filter(1)"><a class="dropdown-item"
                        href="#">Active</a></li>
                    <li onclick="price_filter(0)"><a class="dropdown-item"
                        href="#">Inactive</a></li>
                </ul>
            </div>
            <a class="m-2" href="{{ route('user.create') }}"><button class="btn btn-primary">Add User</button></a>
        </div>

        <div class="p-2">
            <table class="table border">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Email ID</th>
                        <th scope="col">Designation</th>
                        <th status="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="att_here">
                    {{-- <div id="att_here" > --}}
                    @foreach ($user_arr as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['email'] }}</td>
                            <td>{{ $item['designation'] }}</td>
                            <td>{{ $item['status'] }}</td>
                            <td>
                                <a href="{{ route('user.edit', ['id' => $item['id']]) }}">
                                    <button class="btn btn-warning">edit</button></a> <a href=""><button
                                        class="btn btn-danger">delete</button></a>
                            </td>
                        </tr>
                    @endforeach
                    {{-- </div> --}}
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function designation_filter(id) {
            $('#att_here').html('');
            var string = '';
            $.ajax({
                type: 'GET',
                url: "{{ route('get.designation') }}",
                data: {
                    filter: 'Designation',
                    id: id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log(data);
                    data.forEach(element => {
                        string += `<tr>
                                <th scope="row"></th>
                                <td>${element.name}</td>
                                <td>${element.email}</td>
                                <td>${element.designation}</td>
                                <td>${element.status}</td>
                                <td>
                                    <a href="{{ route('user.edit', ['id' => $item['id']]) }}">
                                        <button class="btn btn-warning">edit</button></a> <a href=""><button
                                            class="btn btn-danger">delete</button></a>
                                </td>
                            </tr>`;
                    });
                    $('#att_here').html(string);
                }
            });
        }



        function price_filter(id) {
            console.log(id);
            $('#att_here').html('');
            var string = '';
            $.ajax({
                type: 'GET',
                url: "{{ route('get.designation') }}",
                data: {
                    filter: 'Price',
                    id: id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log(data);
                    data.forEach(element => {
                        string += `<tr>
                                <th scope="row"></th>
                                <td>${element.name}</td>
                                <td>${element.email}</td>
                                <td>${element.designation}</td>
                                <td>${element.status}</td>
                                <td>
                                    <a href="{{ route('user.edit', ['id' => $item['id']]) }}">
                                        <button class="btn btn-warning">edit</button></a> <a href=""><button
                                            class="btn btn-danger">delete</button></a>
                                </td>
                            </tr>`;
                    });
                    $('#att_here').html(string);
                }
            });
        }
    </script>

    {{-- <script>
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
    </script> --}}
@endsection

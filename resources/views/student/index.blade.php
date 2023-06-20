<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel crud with bootstrap modal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        {{-- showing message --}}
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-2 me-2 position-absolute top-0 end-0 w-25" role="alert">
                <strong>{{ Session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#createModal">
            Add new student
        </button>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Studnets Information</h5>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Roll</th>
                            <th scope="col">Name</th>
                            <th scope="col">Batch</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $student->student_roll }}</td>
                            <td>{{ $student->student_name }}</td>
                            <td>{{ $student->student_batch }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm editBtn" value="{{ $student->id }}" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                                <a href="{{ route('student.destroy', $student->id) }}" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Add new student</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('student.store') }}" method="POST">
                        @csrf
                        <div class="my-2">
                            <label>Student Roll</label>
                            <input type="text" name="student_roll" class="form-control">
                            @error('student_roll')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="my-2">
                            <label>Student Name</label>
                            <input type="text" name="student_name" class="form-control">
                            @error('student_name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="my-2">
                            <label>Student Batch</label>
                            <input type="text" name="student_batch" class="form-control">
                            @error('student_batch')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit studnet information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('student.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        {{-- this input is used to put the data of the clicked row --}}
                        <input type="hidden" name="id" id="student_id">

                        <div class="my-2">
                            <label>Student Roll</label>
                            <input type="text" name="student_roll" id="student_roll" class="form-control">
                            @error('student_roll')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="my-2">
                            <label>Student Name</label>
                            <input type="text" name="student_name" id="student_name" class="form-control">
                            @error('student_name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="my-2">
                            <label>Student Batch</label>
                            <input type="text" name="student_batch" id="student_batch" class="form-control">
                            @error('student_batch')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    {{-- edit modal --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '.editBtn', function(){
                var id = $(this).val()
                $('#editModal').modal('show')
                $.ajax({
                    type: "GET",
                    url: "/student/edit/" + id,
                    success: function(data){
                        //$('#student_id').val(id);-----> we can also put the id like this: this the variable id
                        // $('#student_id').val(data.student_info.id);
                        // $('#student_roll').val(data.student_info.student_roll);
                        // $('#student_name').val(data.student_info.student_name);
                        // $('#student_batch').val(data.student_info.student_batch);

                        $('#student_id').val(id);
                        $('#student_roll').val(data.student_roll);
                        $('#student_name').val(data.student_name);
                        $('#student_batch').val(data.student_batch);

                    }
                })
            });
        });
    </script>
</body>

</html>

@extends('layouts.master')

@section('title', 'Todos')

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Todos</li>
</ol>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-primary mb-2" href="{{ route('todos.create') }}" role="button"><i class="fa fa-plus-circle" aria-hidden="true"></i> Create </a>

                        
                        <table class="table table-striped table-bordered" id="todosTable">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection

@include('layouts.inc.datatable-dist')

@push('scripts')
    <script>
        $(function () {
            createTable();

        });

        function createTable(){
            $('#todosTable').DataTable({
                'bDestroy': true,
                processing: true,
                serverSide: true,
                'bSort': false,
                "aLengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
                "iDisplayLength": 10,
                ajax: "{{ route('todos.index') }}",
                columns: [
                    { data: 'status', name: 'status', width: '20%' },
                    { data: 'title', name: 'title'},
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
            });
        }
    </script>
@endpush
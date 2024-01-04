@extends('layouts.master')

@section('title', 'Create Todos')

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="/">Todos</a></li>
    <li class="breadcrumb-item active">Create</li>
</ol>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('todos.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                              <label for="title">Title</label>
                              <input
                                  type="text"
                                  class="form-control @error('title') is-invalid  @enderror"
                                  name="title"
                                  id="title"
                                  placeholder="Enter title of todo"
                                  maxlength="255"
                                  value="{{ old('title') }}"
                              >
                              @error('title')
                                  <span class="font-weight-bold text-danger">{{ $message }}</span>
                              @enderror
                            </div>

                            <div class="form-group">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" value="1" name="status" id="status">
                                    <label for="status">Is Completed ?</label>
                                </div>
                                @error('status')
                                    <span class="font-weight-bold text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <hr>

                            <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection

@push('scripts')
    <script>

    </script>
@endpush
@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Products</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin/home">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              <table class="table table-bordered" id="productstable" cellspacing="0" width="100%">
                  <thead>
                  <th class="th-sm">Image</th>
                  <th class="th-sm">Title</th>
                  <th class="th-sm">Vendor</th>
                  <th class="th-sm">Action</th>
                  </thead>
              </table>
          </div>
      </div>
      </div>
@endsection
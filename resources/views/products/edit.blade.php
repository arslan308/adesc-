@extends('layouts.admin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Edit Products</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin/home">Home</a></li>
            <li class="breadcrumb-item"><a href="/admin/products">Products</a></li>

            <li class="breadcrumb-item active">Edit Variant</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>  
  
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
        <form method="post" action="{{ url('/admin/product/update') }}">
            @csrf
            <div class="form-group">
            <label>Title</label>
            <input class="form-control" type="text" value="{{$product['title']}}" readonly>
            </div>
        <input type="hidden" name="variant_id" value="{{$vid}}">
        <input type="hidden" name="product_id" value="{{$product['id']}}">

            <div class="form-group">
                <label>Description</label>
            <textarea name="description" class="form-control">@if(@$description){!! $description->description !!}@endif</textarea>
             </div>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-success" value="submit">
            </div>
            </form>
         </div>
         <div class="col-md-3">
            <div class="card">
                @foreach($product['variants'] as $variant)
                @if($variant['id'] == $vid)
                   @php $imgid = $variant['image_id']; $vtitle = $variant['title'];@endphp

                @endif
                @endforeach
                @foreach($product['images'] as $image)
                @if($image['id'] == $imgid)
                   @php $imgsrc = $image['src']; @endphp
                   @endif
                @endforeach
               
                <?php 
                 if(@$imgsrc === NULL){
                $imgsrc = $product['image']['src'];
                  }
                ?>
             
                <img src="<?php echo $imgsrc ?>" class="card-img-top" style="width:200px;margin: 0px auto;padding-top: 22px;">
                <div class="card-body">
                  <h5 class="card-title">Variant title</h5>
                  <p class="card-text">@php echo $product['title']." (". $vtitle.")" @endphp</p>
                </div>
              </div>
         </div>
     </div>
  </div>
@endsection

@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<style>
    .pl-100 {
        padding-left: 100px;
    }

    .navbar span {
        color:white !important; 
    }

    .navbar {
        background-color: #bf2424 !important;
    }

    .navbar-light .navbar-text a {
        color: rgb(230 203 203) !important;
        font-weight: bold !important;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5 align-self-end">
            <nav class="navbar navbar-light bg-light text-right">
               
                <span class="navbar-text float-right">
                   <a href="{{route('portfolios')}}"> Portfolio List </a>    
                </span>

            </nav>
        </div>
    </div>
  <div class="row justify-content-center">
    
    <div class="col-md-6 mt-5 ">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{route('portfolio.store')}}" enctype="multipart/form-data" files="true">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title"   name="title" aria-describedby="emailHelp" placeholder="Enter title">
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" id="category" name="category" aria-describedby="emailHelp" placeholder="Enter category">
            </div>
            <div class="form-group">
                <label for="description">Descriptipn</label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
            </div>
            <div class="form-group image-div">
                <label for="image-upload">Image Upload</label>
                <input type="file" name="images[]" class="form-control-file image-upload mb-2" id="image-upload">
            </div>
            <button type="button" id ="add_more" class="btn btn-outline-secondary btn-sm">Add more image</button>

            <div class=" text-right"><button type="submit" class="btn btn-primary text-right">Submit</button><div>
        </form>    
    </div>
  </div>
</div>




<!-- script for cloning image -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>
   $(document).ready(function(){
    $("#add_more").click(function(){
        $(".image-upload:first").clone().val(null).appendTo(".image-div");

    });
});

</script>


@endsection
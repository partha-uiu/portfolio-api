
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">




<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5 ">
            <nav class="navbar navbar-light bg-light text-center">
               
                <span class="navbar-text text-left">
                   <a href="{{route('portfolios')}}"> Portfolio List </a>    
                </span>
            </nav>
        </div>
    </div>
  <div class="row justify-content-center">
    
    <div class="col-md-6 mt-5 ">
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Category</th>
                <th scope="col">Descriptiom</th>
                <th scope="col">Thumbnail</th>
                </tr>
            </thead>
            <tbody>
            @php $i = 1; @endphp    
            @foreach($portfolios as $portfolio )
                <tr>
                    <th scope="row">{{$i++}}</th>
                    <td> {{$portfolio->title}}</td>
                    <td> {{$portfolio->category}}</td>
                    <td> {{$portfolio->description}}</td>
                    <td> <img src="{{ asset('storage/'.$portfolio->thumbnail) }}"></td>
                </tr>
            @endforeach  
            </tbody>
        </table>
    </div>
  </div>
</div>







<x-dashboard>
    @section('page_title',$title)


    <div class="mb-5 d-flex flex-column   gap-2 flex-wrap ">
       <form action="{{route('users.search')}}" method="POST">
        @csrf
        <div class="d-flex mb-3">
            <input class="form-control me-2 " type="search" placeholder="Search" aria-label="Search"
                name="searchterm">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
       </form>
        @foreach($admins as $admin)
        <div class="card mb-3 text-wrap">
            <div class=" d-flex overflow-hidden">
               
                <div class="col-4 d-flex  align-items-center  " >
                    @if($admin->image)  
                    <img src="{{ asset('upload_images/' . $admin->image) }}" class="img-fluid rounded-start h-100"
                        alt="admin image">
                        @endif
                </div>
               

                <div class="col-8 d-flex flex-column  ">
                    <div class="card-body">
                        <div class=" mt-3 d-flex justify-content-between align-content-center ">
                            <h5 class="card-title ">{{$admin->name}}</h5>
                            <div class="d-flex gap-2 ">
                                @if (Auth::user()->role === 'super_admin')
                                <form action="{{ route('admins.destroy', $admin->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; cursor: pointer;">
                                        <i class=" fa-regular fa-trash-can  text-danger "></i>
                                    </button>
                                </form>
                                @endif
                                @if (Auth::user()->id===$admin->id||Auth::user()->role === 'super_admin')
                                <form action="{{ route('admins.edit', $admin->id) }}" method="GET">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; cursor: pointer;">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                </form>
                                @endif

                            </div>
                        </div>

                        <p class="card-text">{{$admin->email}}</p>
                        <p class="card-text">{{$admin->role}}</p>
                        

                    </div>





                </div>
            </div>
        </div>
        @endforeach
        @if ($admins ->count()==0)
        <div class="alert alert-warning mt-5 text-center" role="alert">
            No Admins !
        </div>
        @endif
    </div>

</x-dashboard>
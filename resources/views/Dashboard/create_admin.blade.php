<x-dashboard>
    @section('page_title','Add Admin')
    <form action="{{route('admins.store')}}" method="POST" enctype="multipart/form-data"
        class=" container text-center mt-5 bg-white p-5 rounded-2">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Enter Your Name "
                value="{{ old('name') }}">
            </>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Enter Your Email "
                    value="{{ old('email') }}">
             
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter Your Password  ">
              
            </div>
            <div class="mb-3">
                <label class="form-label">Profile picture</label>
                <input type="file" class="form-control" name="image" value="{{ old('image') }}">
            
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role" id="inlineRadio2" value="user" checked>
                <label class="form-check-label" for="inlineRadio2">User</label>
            </div>
            <div class="form-check form-check-inline me-5">
                <input class="form-check-input" type="radio" name="role" id="inlineRadio1" value="admin">
                <label class="form-check-label" for="inlineRadio1">Admin</label>
            </div>
         
          

            <button type="submit" class="btn btn-primary mt-3 form-control">ADD</button>
    </form>

</x-dashboard>
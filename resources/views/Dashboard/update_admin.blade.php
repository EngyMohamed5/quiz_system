<x-dashboard>
    @section('page_title','Update Admin')
    <form action="{{route('admins.update',$admin->id)}}" method="POST" enctype="multipart/form-data"
        class=" container text-center mt-5">
        @csrf
        @method('put')
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{$admin->name}}">
         
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{$admin->email}}">
        </div>
        <div class="mb-3">
            <label class="form-label">Profile picture</label>
            <input type="file" class="form-control" name="image">
        </div>
        @if (Auth::user()->role === 'super_admin')
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="role" id="inlineRadio2" value="user" {{$admin->role === 'user' ? 'checked' : ''}}>
            <label class="form-check-label" for="inlineRadio2">User</label>
        </div>
        <div class="form-check form-check-inline me-5">
            <input class="form-check-input" type="radio" name="role" id="inlineRadio1" value="admin" {{$admin->role === 'admin' ? 'checked' : ''}}>
            <label class="form-check-label" for="inlineRadio1">Admin</label>
        </div>
       
        @endif
        <button type="submit" class="btn btn-primary mt-3 form-control">Update</button>
    </form>

</x-dashboard>

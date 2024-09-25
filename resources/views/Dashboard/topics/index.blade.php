<x-dashboard>
  @section('page_title', 'Topics')
  <form action="{{route('topics.create')}}" method="GET" class=" w-75 container text-center mt-5">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope=" col ">Title</th>
          <th scope=" col "></th>
          <th scope=" col "></th>
        </tr>
      </thead>
      <tbody>
      @php
      $countTopics=1;
      @endphp
        @foreach($topics as $topic)
        <tr>
          <th scope="row">{{$countTopics++}}</th>
          <td>{{$topic->name}}</td>
          <td>
            <form action="{{ route('topics.destroy', $topic->id) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" style="background: none; border: none; cursor: pointer;">
                <i class=" fa-regular fa-trash-can  text-danger "></i>
              </button>
            </form>

          </td>
          <td>
            <form action="{{ route('topics.edit', $topic->id) }}" method="GET">
              <button type="submit" style="background: none; border: none; cursor: pointer;">
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
            </form>


          </td>
        </tr>
        @endforeach
        @if ($topics->count()==0)
        <div class="alert alert-warning mt-5" role="alert">
          No Topics !
        </div>
        @endif
      </tbody>
    </table>
    <button type="submit" class="btn btn-primary mt-3 form-control">ADD</button>
  </form>

</x-dashboard>

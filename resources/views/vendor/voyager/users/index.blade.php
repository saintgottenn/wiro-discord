
@extends('voyager::master')

@section('page_title', 'Users')

@section('content')
    <h1>Users</h1>

    <div class="row">
        <div class="col-md-12">
            <form action="{{route('admin.users.search')}}" method="POST" style="display: flex; align-items: center;">
                @csrf
                <input type="text" class="form-control" name="id" placeholder="User's ID or Name">
                <button class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Balance</th>
                <th>Registered</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><a href="{{route('admin.users.show', $user->id)}}">{{ $user->name }}</a></td>
                    <td><a href="{{route('admin.users.show', $user->id)}}">{{ $user->email }}</a></td>
                    <td>{{ $user->created_at->format('d-m-Y') }}</td>
                    <td>{{$user->balance}}</td>
                    <td>
                        <div style="display: flex;">
                            <a style="margin: 0 20px;" href="{{route('admin.users.edit', $user->id)}}" class="btn btn-primary">Edit</a>
                            <form action="{{route('admin.users.destroy', $user->id)}}" method="POST">
                                  @csrf
                                <button class="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row text-center">
      @if ($users->lastPage() > 1)
          <ul class="pagination justify-content-center mt-4">
              @if ($users->currentPage() > 1)
                  <li class="page-item">
                      <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                      </a>
                  </li>
              @endif

              @php
                  $maxPages = 5;
                  $halfMaxPages = floor($maxPages / 2);
                  $startPage = max(1, $users->currentPage() - $halfMaxPages);
                  $endPage = min($users->lastPage(), $users->currentPage() + $halfMaxPages);
              @endphp

              @for ($i = $startPage; $i <= $endPage; $i++)
                  <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                      <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                  </li>
              @endfor

              @if ($users->currentPage() < $users->lastPage())
                  <li class="page-item">
                      <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                      </a>
                  </li>
              @endif
          </ul>
      @endif
    </div>
@endsection

@extends('voyager::master')

@section('page_title', 'Withdrawals')

@section('content')
    <h1>Withdrawals</h1>

    <div class="row">
        <div class="col-md-12">
            <form action="{{route('admin.withdrawals.search')}}" method="POST" style="display: flex; align-items: center;">
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
                <th>User</th>
                <th>Amount</th>
                <th>Address</th>
                <th>Registered</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($wds as $wd)
                <tr>
                    <td>{{ $wd->id }}</td>
                    <td><a href="{{route('admin.users.show', $wd->user->id)}}">{{ $wd->user->name }}</a></td>
                    <td>{{ $wd->amount }}</td>
                    <td>{{ $wd->address }}</td>
                    <td>{{ $wd->created_at->format('d-m-Y') }}</td>
                    <td>
                        <div style="display: flex;">
                            <form action="{{route('admin.withdrawals.approve', $wd->id)}}" method="POST">
                                  @csrf
                                <button class="btn btn-success">Approve</button>
                            </form>
                            <form action="{{route('admin.withdrawals.reject', $wd->id)}}" method="POST">
                                  @csrf
                                <button class="btn btn-danger">Reject</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row text-center">
      @if ($wds->lastPage() > 1)
          <ul class="pagination justify-content-center mt-4">
              @if ($wds->currentPage() > 1)
                  <li class="page-item">
                      <a class="page-link" href="{{ $wds->previousPageUrl() }}" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                      </a>
                  </li>
              @endif

              @php
                  $maxPages = 5;
                  $halfMaxPages = floor($maxPages / 2);
                  $startPage = max(1, $wds->currentPage() - $halfMaxPages);
                  $endPage = min($wds->lastPage(), $wds->currentPage() + $halfMaxPages);
              @endphp

              @for ($i = $startPage; $i <= $endPage; $i++)
                  <li class="page-item {{ $i == $wds->currentPage() ? 'active' : '' }}">
                      <a class="page-link" href="{{ $wds->url($i) }}">{{ $i }}</a>
                  </li>
              @endfor

              @if ($wds->currentPage() < $wds->lastPage())
                  <li class="page-item">
                      <a class="page-link" href="{{ $wds->nextPageUrl() }}" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                      </a>
                  </li>
              @endif
          </ul>
      @endif
    </div>
@endsection
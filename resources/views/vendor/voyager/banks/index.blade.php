
@extends('voyager::master')

@section('page_title', 'Banks')

@section('content')
    <h1>Banks</h1>

    <div class="row">
        <div class="col-md-12">
            <form action="{{route('admin.banks.search')}}" method="POST" style="display: flex; align-items: center;">
                @csrf
                <input type="text" class="form-control" name="id" placeholder="Bank's ID">
                <button class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Seller</th>
                <th>Balance</th>
                <th>Bank link</th>
                <th>Amount</th>
                <th>Archive</th>
                <th>Image</th>
                <th>Registered</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($banks as $bank)
                <tr>
                    <td>{{ $bank->id }}</td>
                    <td><a href="{{route('admin.users.show', $bank->seller->id)}}">{{ $bank->seller->name }}</a></td>
                    <td>{{ $bank->balance }}$</td>
                    <td>{{ $bank->bank_link }}</td>
                    <td>{{ $bank->amount }}$</td>
                    <td><a href={{"/admin/download?path={$bank->archive_link}"}}>Archive</a></td>
                    <td><a href={{asset($bank->image_link)}} target="_blank">Image</a></td>
                    <td>{{ $bank->created_at }}</td>

                    <td>
                        <div style="display: flex;">
                            <a style="margin: 0 20px;" href="{{route('admin.banks.edit', $bank->id)}}" class="btn btn-primary">Edit</a>
                            <form action="{{route('admin.banks.destroy', $bank->id)}}" method="POST">
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
      @if ($banks->lastPage() > 1)
          <ul class="pagination justify-content-center mt-4">
              @if ($banks->currentPage() > 1)
                  <li class="page-item">
                      <a class="page-link" href="{{ $banks->previousPageUrl() }}" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                      </a>
                  </li>
              @endif

              @php
                  $maxPages = 5;
                  $halfMaxPages = floor($maxPages / 2);
                  $startPage = max(1, $banks->currentPage() - $halfMaxPages);
                  $endPage = min($banks->lastPage(), $banks->currentPage() + $halfMaxPages);
              @endphp

              @for ($i = $startPage; $i <= $endPage; $i++)
                  <li class="page-item {{ $i == $banks->currentPage() ? 'active' : '' }}">
                      <a class="page-link" href="{{ $banks->url($i) }}">{{ $i }}</a>
                  </li>
              @endfor

              @if ($banks->currentPage() < $banks->lastPage())
                  <li class="page-item">
                      <a class="page-link" href="{{ $banks->nextPageUrl() }}" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                      </a>
                  </li>
              @endif
          </ul>
      @endif
    </div>
@endsection

@extends('voyager::master')

@section('page_title', 'Offers')

@section('content')
    <h1>Offers</h1>

    <div class="row">
        <div class="col-md-12">
            <form action="{{route('admin.product-logs.search')}}" method="POST" style="display: flex; align-items: center;">
                @csrf
                <input type="text" class="form-control" name="id" placeholder="Offer's ID">
                <button class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Seller</th>
                <th>Country</th>
                <th>Amount</th>
                <th>Archive</th>
                <th>Registered</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($offers as $offer)
                <tr>
                    <td>{{ $offer->id }}</td>
                    <td><a href="{{route('admin.users.show', $offer->seller->id)}}">{{ $offer->seller->name }}</a></td>
                    <td>{{ $offer->country }}</td>
                    <td>{{ $offer->amount }}$</td>
                    <td><a href={{"/admin/download?path={$offer->archive_link}"}}>Archive</a></td>
                    <td>{{ $offer->created_at }}</td>

                    <td>
                        <div style="display: flex;">
                            <a style="margin: 0 20px;" href="{{route('admin.product-logs.edit', $offer->id)}}" class="btn btn-primary">Edit</a>
                            <form action="{{route('admin.product-logs.destroy', $offer->id)}}" method="POST">
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
      @if ($offers->lastPage() > 1)
          <ul class="pagination justify-content-center mt-4">
              @if ($offers->currentPage() > 1)
                  <li class="page-item">
                      <a class="page-link" href="{{ $offers->previousPageUrl() }}" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                      </a>
                  </li>
              @endif

              @php
                  $maxPages = 5;
                  $halfMaxPages = floor($maxPages / 2);
                  $startPage = max(1, $offers->currentPage() - $halfMaxPages);
                  $endPage = min($offers->lastPage(), $offers->currentPage() + $halfMaxPages);
              @endphp

              @for ($i = $startPage; $i <= $endPage; $i++)
                  <li class="page-item {{ $i == $offers->currentPage() ? 'active' : '' }}">
                      <a class="page-link" href="{{ $offers->url($i) }}">{{ $i }}</a>
                  </li>
              @endfor

              @if ($offers->currentPage() < $offers->lastPage())
                  <li class="page-item">
                      <a class="page-link" href="{{ $offers->nextPageUrl() }}" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                      </a>
                  </li>
              @endif
          </ul>
      @endif
    </div>
@endsection
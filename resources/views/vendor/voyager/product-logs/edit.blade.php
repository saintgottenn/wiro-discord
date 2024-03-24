
@extends('voyager::master')

@section('page_title', $offer->id)

@section('content')
  <div class="row">
        <div class="col-md-12 offset-md-2">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <h2>Редактирование Offer #{{ $offer->id }}</h2>

                    {{-- Отображение ошибок валидации --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Форма редактирования --}}
                    
                    <form action="{{ route('admin.product-logs.update', $offer->id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount', $offer->amount) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $offer->country) }}" required>
                        </div>
                

                        {{-- Кнопка отправки формы --}}
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                    <form action="{{route('admin.product-logs.destroy', $offer->id)}}" method="POST">
                                  @csrf
                                <button class="btn btn-danger">Remove</button>
                            </form>
                </div>
            </div>
        </div>
        </div>
@endsection
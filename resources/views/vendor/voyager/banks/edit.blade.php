
@extends('voyager::master')

@section('page_title', $bank->id)

@section('content')
  <div class="row">
        <div class="col-md-12 offset-md-2">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <h2>Редактирование Bank #{{ $bank->id }}</h2>

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
                    
                    <form action="{{ route('admin.banks.update', $bank->id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount', $bank->amount) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="balance">Balance</label>
                            <input type="text" class="form-control" id="balance" name="balance" value="{{ old('balance', $bank->balance) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="bank_link">Bank link</label>
                            <input type="text" class="form-control" id="bank_link" name="bank_link" value="{{ old('bank_link', $bank->bank_link) }}" required>
                        </div>
                

                        {{-- Кнопка отправки формы --}}
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                    <form action="{{route('admin.banks.destroy', $bank->id)}}" method="POST">
                                  @csrf
                                <button class="btn btn-danger">Remove</button>
                            </form>
                </div>
            </div>
        </div>
        </div>
@endsection
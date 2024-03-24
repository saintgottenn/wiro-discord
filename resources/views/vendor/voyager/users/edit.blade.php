
@extends('voyager::master')

@section('page_title', $user->name)

@section('content')
  <div class="row">
        <div class="col-md-12 offset-md-2">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <h2>Редактирование пользователя - {{ $user->name }}</h2>

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
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Поле для Email --}}
                        <div class="form-group">
                            <label for="login">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Telegram</label>
                            <input type="text" class="form-control" id="telegram" name="telegram" value="{{ old('telegram', $user->telegram) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="balance">Balance (USDT)</label>
                            <input type="text" class="form-control" id="balance" name="balance" value="{{ old('balance', $user->balance) }}" required>
                        </div>
                

                        {{-- Поле для пароля --}}
                        <div class="form-group">
                            <label for="password">Password (оставьте пустым, чтобы не менять)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <div class="form-group">
                            <label for="userrole">Role</label>
                            <select name="user_role" id="userrole" class="form-control">
                                @foreach ($roles as $role)
                                    <option value="{{$role->id}}" {{$role->id === $user->role_id ? "selected" : ''}}>{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>


                        {{-- Кнопка отправки формы --}}
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
@endsection
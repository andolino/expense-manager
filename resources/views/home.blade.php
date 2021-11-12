@extends('layouts.app')

@section('content')
<div class="h-100">
    <div class="row">
        <div class="col-md-2 pr-0">
            <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark vh-100" style="width: 100%;">
                <h5 class="text-center">{{ ucwords(Auth::user()->name) }} (Admin)</h5>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link text-white" aria-current="page">
                            User Management
                        </a>
                        @if ($my_roles->roles_id == 1)
                        <a href="{{ url('') }}/home" class="nav-link text-white" aria-current="page">
                            Dashboard
                        </a>
                        @endif
                        <ul class="nav nav-pills flex-column ml-3">
                            @if ($my_roles->roles_id == 2)
                            <li class="nav-item">
                                <a href="{{ url('') }}/roles" class="nav-link text-white" aria-current="page">
                                    Roles
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('') }}/userslist" class="nav-link text-white" aria-current="page">
                                    Users
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-white" aria-current="page">
                            Expense Management
                        </a>
                        <ul class="nav nav-pills flex-column ml-3">
                            @if ($my_roles->roles_id == 2)
                            <li class="nav-item">
                                <a href="{{ url('') }}/expense-category" class="nav-link text-white" aria-current="page">
                                    Expense Categories
                                </a>
                            </li>
                            @endif
                            @if ($my_roles->roles_id == 1)
                            <li class="nav-item">
                                <a href="{{ url('') }}/expenses" class="nav-link text-white" aria-current="page">
                                    Expenses
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-10 pl-0">
            <div class="card">
                <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                    <div class="container">
                        {{-- <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a> --}}
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>
        
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav mr-auto">
        
                            </ul>
        
                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->
                                @guest
                                    @if (Route::has('login'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                        </li>
                                    @endif
        
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                        </li>
                                    @endif
                                @else
                                    <li class="nav-item" style="line-height: 2.2">
                                        Welcome to Expense Manager
                                        {{-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }}
                                        </a> --}}
                                        
                                        {{-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ url('reset-password') }}">
                                                {{ __('Reset Password') }}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                        </div> --}}
                                    </li>
                                    <li class="nav-item">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                @endguest
                            </ul>
                        </div>
                    </div>
                </nav>
                {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    {{-- {{ __('You are logged in!') }} --}}

                    @switch($link)
                        @case('home')
                            <expense-chart :myroles="{{ $my_roles }}" :myreports="{{ $report }}"></expense-chart> 
                            @break
                        @case('roles')
                            <roles-module :dataroles="{{ $roles }}" :myroles="{{ $my_roles }}" ></roles-module> 
                            @break
                        @case('userslist')
                            <user-module :datausers="{{ $users }}" :dataroles="{{ $roles }}" :myroles="{{ $my_roles }}"></user-module> 
                            @break
                        @case('expense-category')
                            <expense-category :dataec="{{ $expense_category }}" :myroles="{{ $my_roles }}"></expense-category> 
                            @break
                        @case('expenses')
                            <expenses :dataexpenses="{{ $expenses }}" :datacategory="{{ $expense_category }}" :myroles="{{ $my_roles }}"></expenses> 
                            @break
                        @default
                            
                    @endswitch
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

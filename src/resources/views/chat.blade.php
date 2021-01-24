@extends('layouts.app')

@section('content')

<section class="container">
    <div class="row">
        @auth()
        @else
        <p class="alert alert-danger col-12 p-4 shadow text-center h3 text-white">Please Login. <a href="/login" class="btn btn-sm btn-outline-info">Login</a></p>
        @endauth

           <chat-component></chat-component>
    </div>
</section>

@stop

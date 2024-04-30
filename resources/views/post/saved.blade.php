@extends('layouts.app')


@section('content')


<div class="container py-2">
    <div class="row">
    @foreach ($postsaves as $post)
        <div class="col-md-4 my-2">
            <div class="card">
                @if ($post->post->image != null)
                    <img src="{{ asset('/storage/images/posts/'.$post->post->image) }}" class="card-img-top img-fluid" style="max-height: 230px">
                @else
                    <img src="{{ asset('assets/images/bg.jpg') }}" class="card-img-top img-fluid" style="max-height: 230px">
                @endif
                <div class="card-body">
                    <h4 class="card-title text-truncate w-50">
                        {{ $post->post->title }}
                    </h4>
                    <p class="card-text text-truncate mt-5">
                        {!! $post->post->content !!}
                    </p>
                    <p class="card-text">by: {{ $post->post->created_by }}</p>
                    <small class="text-muted float-end"><i class="bi bi-eye-fill"></i> {{ $post->post->views }}</small>
                </div>
                    <a href="/news/{{$post->post->slug }}" class="card-footer text-center">Read More</a>
            </div>
        </div>
    @endforeach



@endsection

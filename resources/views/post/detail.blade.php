<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">

</head>


{{-- navbar --}}

<nav class="bg-slate-900 border-gray-200 px-2 sm:px-4 py-2.5 ">
    <div class="container flex flex-wrap items-center justify-between mx-auto">
        <a class="flex items-center">
            <img src="https://w7.pngwing.com/pngs/406/94/png-transparent-newspaper-breaking-news-others-television-text-logo.png"
                class="h-6 mr-3 sm:h-9" alt="Flowbite Logo" />
            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Detail Berita</span>
        </a>

        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul
                class="flex flex-col p-4 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="/"
                        class="animate-bounce block py-2 pl-3 pr-4 text-white bg-slate-900 md:bg-transparent font-semibold md:p-0 dark:text-white"
                        aria-current="page">Back</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@if (Session::has('message'))
    <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path
                d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" />
        </svg>
        <p>{{ Session::get('message') }}</p>
    </div>
@endif



{{-- detail Content --}}
<div class="container ">
    <div class="flex justify-center items-center mt-10">
        <img class="shadow-lg shadow-cyan-500/50 w-2/5 rounded-lg hover:opacity-50 hover:transition"
            src="{{ asset('images/' . $data->image) }}" alt="" srcset="">
    </div>
    {{-- content --}}
    <div class="content flex justify-center items-center mt-14">
        <h2 class="font-semibold text-slate-900 text-2xl">{{ $data->title }}</h2>

    </div>
    <p class="ml-80 relative -mb-5 mt-8 font-mono ">{{ $data->created_at }}</p>
    <hr class="bg-gray-800 mt-5 w-2/4 h-1 mx-auto">

    <div class="social flex ml-80 mt-1">

        {{-- like --}}
        <a class="mr-2" href="{{ route('like', $data->id) }}"><i
                class="bi bi-hand-thumbs-up"></i>{{ $like->count() }}</a>
        <a class="mr-2" href="{{ route('unlike', $data->id) }}"><i class="bi bi-hand-thumbs-down"></i></a>
        {{-- end unlike --}}


        {{-- Boomark  --}}

        <form action="{{ route('news.store', $data) }}" method="POST" class="mb-2">
            @csrf
            <button type="submit" class="btn btn-primary hover:text-green-500 mr-2"><i
                    class="bi bi-bookmark-plus-fill"></i></button>
        </form>

        <form action="{{ route('news.destroy', $data) }}" method="POST" class="mb-2">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mr-2 hover:text-red-600"><i
                    class="bi bi-bookmark-dash-fill"></i></button>
        </form>
        {{-- end boomark --}}


        <p class="hover:text-sky-600">{!! $share !!}</p>
    </div>

    <div class="paragraf mt-10">
        <p class="w-4/5 p-16 font-serif mx-auto">{{ $data->content }}</p>
    </div>
</div>
{{-- Coments Form --}}


@if (session('success'))
    <div class="container-fluid">
        <div class="row">
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif


<br><br><br>
<h5 class="-mb-36 ml-8 font-mono">Jumlah pengunjung: {{ $data->views }}</h5>
<hr class="w-2/5 p-0.5 ml-3 mt-40 bg-slate-600 ">
<div class="comments p-14 w-2/4 -mt-5  rounded-sm">

@if (auth()->check())


<section class="bg-white">
    <div class="max-w-2xl mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-lg lg:text-2xl font-bold text-gray-900 ">Jumlah Comment ({{$comment->count()}})</h2>
        </div>
        <form class="mb-6" action="{{ route('comments') }}" method="post">
            @csrf
            <span id="characterCount" class="font-semibold">255 characters left</span>

          <div class="py-2 px-4 mb-4 bg-sky-800 rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
              <label for="comment" class="sr-only">Your comment</label>

              <input type="hidden" name="post_id" value="{{ $data->id }}">
              <input name="user_id" type="hidden" value="{{ Auth::user()->id }}">
              <input name="post_id" type="hidden" value="{{ $data->id }}">
              <input name="parent_id" type="hidden" value="">

              <textarea name="content" id="comment" rows="6"
                  class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                  placeholder="Write a comment..." required></textarea>
          </div>
          <button type="submit"
              class="inline-flex items-center bg-sky-700 py-2.5 px-4 text-xs font-semibold text-center  text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 shadow-lg hover:bg-primary-800">
              Post comment
          </button>
      </form>
    </div>
  @endif

      @foreach ($comment as $item)
      @if ($item->parent_id == null)

      <article class="p-6 mb-6 text-base bg-white rounded-lg dark:bg-gray-900 ">
          <footer class="flex justify-between items-center mb-2">
              <div class="flex items-center">

                @if ($item->user->images)
                <p class="inline-flex items-center mr-2 text-sm text-gray-900 dark:text-white">
                    <img
                          class="mr-2 w-6 h-6 rounded-full"
                          src="{{ asset('images/' . $item->user->images) }}"
                          alt="Michael Gough">{{$item->user->name}}</p>
            @else
                    <p class="inline-flex items-center mr-2 text-sm text-gray-900 dark:text-white">
                        <img
                              class="mr-2 w-6 h-6 rounded-full"
                              src="{{ asset('images/default-122313121.jpg') }}"
                              alt="Michael Gough">{{$item->user->name}}</p>
            @endif

                  <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-02-08"
                          title="February 8th, 2022">{{$item->created_at->diffForHumans()}}</time></p>
              </div>

          </footer>
          <p class="text-gray-500 dark:text-gray-400">{{$item->content}}</p>
          <div class="flex items-center mt-4 space-x-4">
              <button id="replyButton" type="submit"
                  class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
                  <svg aria-hidden="true" class="mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                  Reply
              </button>
              {{-- edit --}}
              <button id="EditButtons" type="button"
              class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
              <i class="bi bi-pen"></i>
                 Edit
          </button>
          {{-- delete --}}
          <form action="{{route("delete.comment",$item->id)}}"  method="post">
            @method("DELETE")
            @csrf
              <button type="submit" type="button"
              class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
              <i class="bi bi-trash"></i>
              <a href=""></a>
              Delete
            </button>
        </form>
          </div>
      </article>
</section>
<br><br>

      @endif
      @endforeach

      {{-- untuk reply  --}}
      @foreach ($comment as $item)
      @if ($item->childComments != null)
      @foreach ($item->childComments as $key => $item)

      <section class="bg-white mr-80 ">
        <div class="max-w-2xl mx-auto px-4">
      <article class="p-6 mb-6 w-80  {{$key <=  1? 'ml-28' : '-ml-5'}} text-base bg-white rounded-lg dark:bg-gray-900 ">
          <footer class="flex justify-between items-center mb-2 ">
              <div class="flex items-center mt-5">
                @if ($item->user->images)
                <p class="inline-flex items-center mr-2 text-sm text-gray-900 dark:text-white">
                    <img
                          class="mr-2 w-6 h-6 rounded-full"
                          src="{{ asset('images/' . $item->user->images) }}"
                          alt="Michael Gough">{{$item->user->name}}</p>
            @else
                    <p class="inline-flex items-center mr-2 text-sm text-gray-900 dark:text-white">
                        <img
                              class="mr-2 w-6 h-6 rounded-full"
                              src="{{ asset('images/default-122313121.jpg') }}"
                              alt="Michael Gough">{{$item->user->name}}</p>
            @endif

                  <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-02-12"
                          title="February 12th, 2022">{{$item->created_at->diffForHumans()}}</time></p>
              </div>
              <!-- Dropdown menu -->

          </footer>
          <p class="text-gray-500 dark:text-gray-400">{{$item->content}}</p>

          <div class="flex items-center mt-8 space-x-4">
              <button id="replyButton" type="button"
                  class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400  {{$item->parent_id ==  2 ? '' : 'hidden'}}">
                  <svg aria-hidden="true" class="mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                  Reply
              </button>

                {{-- edit --}}
                <button id="EditButtons" type="button"
                class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
                <i class="bi bi-pen"></i>
                   Edit
            </button>
            {{-- delete --}}
            <form action="{{route("delete.comment",$item->id)}}"  method="post">
              @method("DELETE")
              @csrf
                <button type="submit" type="button"
                class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
                <i class="bi bi-trash"></i>
                <a href=""></a>
                Delete
              </button>
          </form>
          </div>
      </article>

    </div>
</section>
</div>
@endforeach

  @endif

@if (auth()->check())

{{-- reply comment --}}


<section class="bg-white py-8 lg:py-16 hidden" id="reply" >
    <div class="max-w-2xl mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg lg:text-2xl font-bold text-gray-900 ">Reply Comment </h2>
        </div>
      <form class="mb-6" action="{{ route('reply.comment',$item->id) }}" method="post">
        @csrf
          <div class="py-2 px-4 mb-4 bg-sky-800 rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
              <label for="comment" class="sr-only">Your comment</label>
              <input type="hidden" name="post_id" value="{{ $data->id }}">
              <input name="user_id" type="hidden" value="{{ Auth::user()->id }}">
              <input type="hidden" name="parent_id" value="{{ $item->id }}">

              <textarea name="content" id="comment" rows="6"
                  class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                  placeholder="Write a comment..." required>{{ __('@:username ',['username' => $item->user->name]) }}</textarea>


          </div>
          <button type="submit"
              class="inline-flex items-center bg-sky-700 py-2.5 px-4 text-xs font-semibold text-center  text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 shadow-lg hover:bg-primary-800">
              Post comment
            </button>
      </form>
    </div>
</section>


@endif

@endforeach

{{-- edit comment --}}

@if (auth()->check())


<section class="bg-white py-8 lg:py-16 hidden" id="edit"  >
    <div class="max-w-2xl mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-lg lg:text-2xl font-bold text-gray-900 ">Edit Comment </h2>
      </div>
      <form class="mb-6" action="{{ route('comments') }}" method="post">
        @csrf
          <div class="py-2 px-4 mb-4 bg-sky-800 rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
              <label for="comment" class="sr-only">Your comment</label>
              <input type="hidden" name="post_id" value="{{ $data->id }}">
              <input name="user_id" type="hidden" value="{{ Auth::user()->id }}">
              <input name="post_id" type="hidden" value="{{ $data->id }}">

              <textarea name="content" id="comment" rows="6"
                  class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                  placeholder="Write a comment..." required></textarea>
          </div>
          <button type="submit"
              class="inline-flex items-center bg-sky-700 py-2.5 px-4 text-xs font-semibold text-center  text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 shadow-lg hover:bg-primary-800">
              Post comment
          </button>
      </form>
    </div>
</section>


@endif



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>

<script src="{{ asset('assets/js/user/update.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>


<br><br><br><br><br><br>
</body>

</html>

@extends('layouts.index')

@section('content')
<h1 class="text-center py-5">Files | storage</h1>
<!-- Button trigger modal -->

  

<div class="container mb-5">
    <div class="mb-3 w-50 mx-auto">
        <form class="d-flex py-3" action="{{ route('file.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="img" class="form-control" id="img" >
            <button class="btn btn-outline-secondary" type="submit" id="img">Button</button>
        </form>
        <form class="d-flex" action="{{ route('file-url.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="filename" class="form-control" id="img" placeholder="url ?">
            <button class="btn btn-outline-secondary" type="submit" id="img">Button</button>
        </form>
    </div>

    <div class="container row my-5">
        @forelse ($files as $item)
        <div class="col-6 text-center">
            <img height="250" src="{{ asset('img/auto/' . $item->url) }}" alt="img">
            <div class="d-flex justify-content-between py-3">
                <form action="{{ route('file.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method("DELETE")
                    <button class="btn btn-danger">X</button>
                </form>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#file{{ $item->id }}">
                    edit
                  </button>
                  <a class="btn btn-success" href="{{ route('file.download', $item->id) }}">Download</a>
            </div>
        </div>
            <!-- Modal -->
        <div class="modal fade" id="file{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">edit image</h5>
                    </div>
                    <div class="modal-body">
                        <p>{{ $item->url }}</p>
                        <form class="d-flex" action="{{ route('file.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="file" name="img" class="form-control" id="img" >
                            <button class="btn btn-outline-secondary" type="submit" id="img">Button</button>
                        </form>
                    </div>
                
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">vide</p>
        @endforelse
    </div>






    @endsection

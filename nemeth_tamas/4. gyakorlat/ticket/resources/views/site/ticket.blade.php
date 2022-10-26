@extends('layouts.layout')

@section('title', $ticket->title)

@section('content')
    <div class="d-flex">
        <h1 class="ps-3 me-auto">{{ $ticket->title }}
            @switch($ticket->priority)
                @case(0)
                    <span class="badge bg-info">Alacsony</span>
                    @break
                @case(1)
                    <span class="badge bg-success">Normál</span>
                    @break
                @case(2)
                    <span class="badge bg-warning">Magas</span>
                    @break
                @case(3)
                    <span class="badge bg-danger">Azonnal</span>
                    @break
            @endswitch
        </h1>
        <a href="{{ route('tickets.edit', ['ticket' => $ticket->id]) }}" class="btn btn-primary mx-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Szerkesztés">
            <i class="fa-solid fa-pen-to-square fa-fw fa-xl"></i>
        </a>
        <a href="{{ route('tickets.getUsers', ['ticket' => $ticket->id]) }}" class="btn btn-primary mx-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Felhasználók">
            <i class="fa-solid fa-users fa-fw fa-xl"></i>
        </a>
        <a class="btn btn-success mx-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Lezárás">
            <i class="fa-solid fa-check fa-fw fa-xl"></i>
        </a>
        <form action="{{ route('tickets.destroy', ['ticket' => $ticket->id]) }}" method="post">
            @csrf
            @method('delete')
            <button class="btn btn-danger mx-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Törlés" type="submit">
                <i class="fa-solid fa-trash fa-fw fa-xl"></i>
            </button>
        </form>
    </div>
    <hr />
    @foreach ($ticket->comments->sortBy('created_at') as $comment)
        <div class="card mb-3">
            <div class="card-header d-flex">
                <div class="me-auto"><span class="badge bg-secondary">#{{ $loop->index }}</span> | <strong>{{ $comment->user->name }}</strong> | {{ $comment->created_at }}</div>
                @if ($comment->filename)
                    <div><a href="{{ Illuminate\Support\Facades\Storage::url($comment->filename_hash) }}" download="{{ $comment->filename }}"><i class="fa-solid fa-download"></i></a></div>
                @endif
            </div>
            <div class="card-body">
                {{ $comment->text }}
            </div>
        </div>
    @endforeach
    <hr>
    <h2>Új hozzászólás írása</h2>
    <form action="{{ route('tickets.newComment', ['ticket' => $ticket->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <textarea class="form-control @error('text') is-invalid @enderror" name="text" id="text" cols="30" rows="10" placeholder="Hozzászólás...">{{ old('text') }}</textarea>
            @error('text')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <input type="file" class="form-control @error('attachment') is-invalid @enderror" id="file" name="attachment">
            @error('attachment')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="row">
            <button type="submit" class="btn btn-primary">Küldés</button>
        </div>
    </form>
@endsection

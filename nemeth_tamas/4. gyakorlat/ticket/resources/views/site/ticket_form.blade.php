@extends('layouts.layout')

@section('title', isset($ticket) ? 'Szerkesztés: ' . $ticket->title : 'Új feladat')

@section('content')
<h1 class="ps-3">{{ isset($ticket) ? 'Szerkesztés: ' . $ticket->title : 'Új feladat' }}</h1>
<hr />
<form method="post" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
    @csrf
    @isset($ticket)
        @method('put')
    @endisset
    <div class="row mb-3">
        <div class="col">
            <input
                type="text"
                class="form-control @error('title') is-invalid @enderror"
                placeholder="Tárgy"
                name="title"
                id="title"
                value="{{ old('title', $ticket->title ?? '') }}"
            />
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col">
            <select class="form-select @error('priority') is-invalid @enderror" name="priority" id="priority">
                <option value="x" disabled>Priorítás</option>
                <option value="0" {{ old('priority', $ticket->priority ?? '') == 0 ? 'selected' : '' }}>Alacsony</option>
                <option value="1" {{ old('priority', $ticket->priority ?? '') == 1 ? 'selected' : '' }}>Normál</option>
                <option value="2" {{ old('priority', $ticket->priority ?? '') == 2 ? 'selected' : '' }}>Magas</option>
                <option value="3" {{ old('priority', $ticket->priority ?? '') == 3 ? 'selected' : '' }}>Azonnal</option>
            </select>
        </div>
    </div>
    @if (!isset($ticket))
        <div class="mb-3">
            <textarea class="form-control @error('text') is-invalid @enderror" name="text" id="text" cols="30" rows="10" placeholder="Hiba leírása...">{{ old('text') }}</textarea>
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
    @endif
    <div class="row">
        <button type="submit" class="btn btn-primary">Mentés</button>
    </div>
</form>
@endsection

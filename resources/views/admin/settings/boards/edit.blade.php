@extends('admin.layouts.master', ['title' => 'Edit Board'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.boards.index') }}">Boards</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Board</div>
            <div class="pst">{{ $board->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.boards.update', $board) }}">
        @csrf
        @method('PUT')
        @include('admin.settings.boards._form')
    </form>
</div>
@endsection

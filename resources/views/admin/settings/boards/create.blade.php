@extends('admin.layouts.master', ['title' => 'New Board'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.boards.index') }}">Boards</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Board</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.boards.store') }}">
        @csrf
        @include('admin.settings.boards._form')
    </form>
</div>
@endsection

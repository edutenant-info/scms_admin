@extends('admin.layouts.master', ['title' => 'Edit Stream'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.streams.index') }}">Streams</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Stream</div>
            <div class="pst">{{ $item->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.streams.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.academic.streams._form')
    </form>
</div>
@endsection

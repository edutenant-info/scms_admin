@extends('admin.layouts.master', ['title' => 'New Stream'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.streams.index') }}">Streams</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Stream</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.streams.store') }}">
        @csrf
        @include('admin.masters.academic.streams._form')
    </form>
</div>
@endsection

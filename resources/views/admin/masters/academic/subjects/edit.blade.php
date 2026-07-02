@extends('admin.layouts.master', ['title' => 'Edit Subject'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.subjects.index') }}">Subjects</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Subject</div>
            <div class="pst">{{ $item->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.subjects.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.academic.subjects._form')
    </form>
</div>
@endsection

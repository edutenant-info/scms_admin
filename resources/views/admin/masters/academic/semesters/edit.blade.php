@extends('admin.layouts.master', ['title' => 'Edit Semester'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.semesters.index') }}">Semesters</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Semester</div>
            <div class="pst">{{ $item->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.semesters.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.academic.semesters._form')
    </form>
</div>
@endsection

@extends('admin.layouts.master', ['title' => 'Edit Academic Year'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.academic-years.index') }}">Academic Years</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Academic Year</div>
            <div class="pst">{{ $item->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.academic-years.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.academic.academic-years._form')
    </form>
</div>
@endsection

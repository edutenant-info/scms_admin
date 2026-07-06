@extends('admin.layouts.master', ['title' => 'Edit Academic Year Mapping'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.institution-academic-years.index') }}">Academic Year Mappings</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Academic Year Mapping</div>
            <div class="pst">{{ $item->institution->name }} → {{ $item->academicYear->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.institution-academic-years.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.mappings.institution-academic-years._form')
    </form>
</div>
@endsection

@extends('admin.layouts.master', ['title' => 'New Academic Year Mapping'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.institution-academic-years.index') }}">Academic Year Mappings</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Academic Year Mapping</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.institution-academic-years.store') }}">
        @csrf
        @include('admin.masters.mappings.institution-academic-years._form')
    </form>
</div>
@endsection

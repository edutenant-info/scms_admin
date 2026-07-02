@extends('admin.layouts.master', ['title' => 'New Academic Year'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.academic-years.index') }}">Academic Years</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Academic Year</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.academic-years.store') }}">
        @csrf
        @include('admin.masters.academic.academic-years._form')
    </form>
</div>
@endsection

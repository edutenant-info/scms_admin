@extends('admin.layouts.master', ['title' => 'New Semester'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.semesters.index') }}">Semesters</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Semester</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.semesters.store') }}">
        @csrf
        @include('admin.masters.academic.semesters._form')
    </form>
</div>
@endsection

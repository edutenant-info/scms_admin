@extends('admin.layouts.master', ['title' => 'New Subject'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.subjects.index') }}">Subjects</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Subject</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.subjects.store') }}">
        @csrf
        @include('admin.masters.academic.subjects._form')
    </form>
</div>
@endsection

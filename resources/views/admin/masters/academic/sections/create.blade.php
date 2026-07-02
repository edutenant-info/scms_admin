@extends('admin.layouts.master', ['title' => 'New Section'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.sections.index') }}">Sections</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Section</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.sections.store') }}">
        @csrf
        @include('admin.masters.academic.sections._form')
    </form>
</div>
@endsection

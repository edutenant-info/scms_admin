@extends('admin.layouts.master', ['title' => 'New Elective'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.electives.index') }}">Electives</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Elective</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.electives.store') }}">
        @csrf
        @include('admin.masters.academic.electives._form')
    </form>
</div>
@endsection

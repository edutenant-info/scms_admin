@extends('admin.layouts.master', ['title' => 'New Religion'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.religions.index') }}">Religions</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Religion</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.religions.store') }}">
        @csrf
        @include('admin.masters.demographic.religions._form')
    </form>
</div>
@endsection

@extends('admin.layouts.master', ['title' => 'New Dashboard Template'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.dashboard-templates.index') }}">Dashboard Templates</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Dashboard Template</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.dashboard-templates.store') }}">
        @csrf
        @include('admin.settings.dashboard-templates._form')
    </form>
</div>
@endsection

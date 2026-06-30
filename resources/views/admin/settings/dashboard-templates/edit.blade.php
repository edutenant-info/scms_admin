@extends('admin.layouts.master', ['title' => 'Edit Dashboard Template'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.dashboard-templates.index') }}">Dashboard Templates</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Dashboard Template</div>
            <div class="pst">{{ $template->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.dashboard-templates.update', $template) }}">
        @csrf
        @method('PUT')
        @include('admin.settings.dashboard-templates._form')
    </form>
</div>
@endsection

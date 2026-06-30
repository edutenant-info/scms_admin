@extends('admin.layouts.master', ['title' => 'Edit Login Template'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.login-templates.index') }}">Login Templates</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Login Template</div>
            <div class="pst">{{ $template->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.login-templates.update', $template) }}">
        @csrf
        @method('PUT')
        @include('admin.settings.login-templates._form')
    </form>
</div>
@endsection

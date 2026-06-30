@extends('admin.layouts.master', ['title' => 'New Login Template'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.login-templates.index') }}">Login Templates</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Login Template</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.login-templates.store') }}">
        @csrf
        @include('admin.settings.login-templates._form')
    </form>
</div>
@endsection

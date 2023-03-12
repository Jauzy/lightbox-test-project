@extends('layouts.layout1')

@section('css_section')
@endsection

@section('page_title')
    Tender Form
@endsection

@section('sidebar-size', 'collapsed')
@section('url_back', url('/projects'))

@section('content')
<div class="py-2">
    <div class="d-flex justify-content-between flex-wrap mb-2">
        <h1 style="font-weight: 900" class="fw-bolder display-4">Tender Form</h1>
        <img src="{{ asset('lightbox.png') }}" style="max-width: 300px;object-fit:contain" />
    </div>
    <div class="text-success text-center h1 fw-bolder">
        Thank you for filling the form.
    </div>
    <div class="text-center h1 fw-bolder">
        We hope our cooperation will last.
    </div>
</div>
@endsection

@section('js_section')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

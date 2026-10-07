@extends('admin-pages.layout')

@section('before-admin-page-content')
    @include('admin-pages.wpsp_lite.navigation')
@endsection

@section('content')
    @if(isset($requestParams['tab']) && $requestParams['tab'] == 'license')
        @include('admin-pages.wpsp_lite.license')
    @elseif(isset($requestParams['tab']) && $requestParams['tab'] == 'database')
        @include('admin-pages.wpsp_lite.database')
    @elseif(isset($requestParams['tab']) && $requestParams['tab'] == 'settings')
        @include('admin-pages.wpsp_lite.settings')
    @elseif(isset($requestParams['tab']) && $requestParams['tab'] == 'tools')
        @include('admin-pages.wpsp_lite.tools')
    @elseif(isset($requestParams['tab']) && $requestParams['tab'] == 'table')
        @include('admin-pages.wpsp_lite.table')
    @elseif(isset($requestParams['tab']) && $requestParams['tab'] == 'roles')
        @include('admin-pages.wpsp_lite.roles')
    @elseif(isset($requestParams['tab']) && $requestParams['tab'] == 'permissions')
        @include('admin-pages.wpsp_lite.permissions')
    @elseif(isset($requestParams['tab']) && $requestParams['tab'] == 'users')
        @include('admin-pages.wpsp_lite.users')
    @elseif(isset($requestParams['tab']) && $requestParams['tab'] == 'activity_log')
        @include('admin-pages.wpsp_lite.activity_log')
    @else
        @include('admin-pages.wpsp_lite.dashboard')
    @endif
@endsection
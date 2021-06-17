@extends('layouts.app')
@section('content')
    <div class="flex bg-gray-100 border-b border-gray-300 py-4">
        <div class="container mx-auto flex justify-between">
            <div class="flex">
                <router-link class="ml-14" to='/' exact>Home</router-link>
            </div>
            <div class="flex">
                <router-link class="mr-4" to='/login'>Login</router-link>
                <router-link class="mr-14" to='/register'>Register</router-link>
            </div>
        </div>
    </div>
    <div class="container mx-auto py-2 ml-14">
        <router-view></router-view>
    </div>
@endsection

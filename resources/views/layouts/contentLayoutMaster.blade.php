@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
@php
$configData = Helper::applClasses();
@endphp

<html class="loading {{ ($configData['theme'] === 'light') ? '' : $configData['layoutTheme']}}"
lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif"
data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}"
@if($configData['theme'] === 'dark') data-layout="dark-layout" @endif>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  {{-- <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
  <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="PIXINVENT">
  <title>@yield('title') - Vuexy - Bootstrap HTML & Laravel admin template</title> --}}
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="Ericson Weah">
  <link rel="apple-touch-icon" href="/src/images/icons/apple-icon-57x57.png" sizes="57x57">
  <link rel="apple-touch-icon" href="/src/images/icons/apple-icon-60x60.png" sizes="60x60">
  <link rel="apple-touch-icon" href="/src/images/icons/apple-icon-72x72.png" sizes="72x72">
  <link rel="apple-touch-icon" href="/src/images/icons/apple-icon-76x76.png" sizes="76x76">
  <link rel="apple-touch-icon" href="/src/images/icons/apple-icon-114x114.png" sizes="114x114">
  <link rel="apple-touch-icon" href="/src/images/icons/apple-icon-120x120.png" sizes="120x120">
  <link rel="apple-touch-icon" href="/src/images/icons/apple-icon-144x144.png" sizes="144x144">
  <link rel="apple-touch-icon" href="/src/images/icons/apple-icon-152x152.png" sizes="152x152">
  <link rel="apple-touch-icon" href="/src/images/icons/apple-icon-180x180.png" sizes="180x180">
  <meta name="msapplication-TileImage" content="/src/images/icons/app-icon-144x144.png">
  <meta name="msapplication-TileColor" content="#fff">
  <meta name="theme-color" content="#3f51b5">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="Ericson Weah">
  <link rel="apple-touch-icon" href="/src/images/icons/app-icon-144x144.png" size="144x144">
  <meta name="keywords" content="Ericson Weah">
  <meta name="author" content="Ericson Weah">
  <title>@yield('title') - Ericson Weah</title>
  <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/logo/favicon.ico')}}">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

  {{-- Include core + vendor Styles --}}
  @include('panels/styles')

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
@isset($configData["mainLayoutType"])
@extends((( $configData["mainLayoutType"] === 'horizontal') ? 'layouts.horizontalLayoutMaster' :
'layouts.verticalLayoutMaster' ))
@endisset

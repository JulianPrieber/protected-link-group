<?php use App\Models\UserData; ?>

@php
$showGroup = false;

if(auth()->check()) {

  $ids = $link->userids;
  $user = Auth::user();
  $owner = $link->user_id;

  if (in_array($owner, $ids) || in_array($user->id, $ids) || $user->role == 'admin') {
      $showGroup = true;
  }

}
@endphp

@if($showGroup)
  <div style="outline: 2px solid #fff; border-radius: 10px; padding: 20px; margin-bottom: .9rem;">
  
    <div class="fadein"><h2>{{ $link->title }}</h2></div>
  
    @foreach($link->link_groups as $link_group)
      @switch($link->name)
      @case('custom')
        @if($link->custom_css === "" or $link->custom_css === "NULL" or (theme('allow_custom_buttons') == "false"))
         <div style="--delay: {{ $initial++ }}s" class="button-entrance"><a id="{{ $link->id }}" class="button button-custom button-click button-hover icon-hover" rel="noopener noreferrer nofollow noindex" href="{{ $link_group['link'] }}" @if((UserData::getData($userinfo->id, 'links-new-tab') != false))target="_blank"@endif ><i style="color: {{$link->custom_icon}}" class="icon hvr-icon fa {{$link->custom_icon}}"></i>{{ $link_group['title'] }}</a></div>
            @break
         @elseif($link->custom_css != "")
         <div style="--delay: {{ $initial++ }}s" class="button-entrance"><a id="{{ $link->id }}" class="button button-custom button-click button-hover icon-hover" style="{{ $link->custom_css }}" rel="noopener noreferrer nofollow noindex" href="{{ $link_group['link'] }}" @if((UserData::getData($userinfo->id, 'links-new-tab') != false))target="_blank"@endif ><i style="color: {{$link->custom_icon}}" class="icon hvr-icon fa {{$link->custom_icon}}"></i>{{ $link_group['title'] }}</a></div>
            @break
          @endif
      @case('custom_website')
         @if($link->custom_css === "" or $link->custom_css === "NULL" or (theme('allow_custom_buttons') == "false"))
           <div style="--delay: {{ $initial++ }}s" class="button-entrance"><a id="{{ $link->id }}" class="button button-custom_website button-click button-hover icon-hover" rel="noopener noreferrer nofollow noindex" href="{{ $link_group['link'] }}" @if((UserData::getData($userinfo->id, 'links-new-tab') != false))target="_blank"@endif ><img alt="{{ $link->name }}" class="icon hvr-icon" src="@if(file_exists(base_path("assets/favicon/icons/").localIcon($link->id))){{url('assets/favicon/icons/'.localIcon($link->id))}}@else{{getFavIcon($link->id)}}@endif" onerror="this.onerror=null; this.src='{{asset('assets/linkstack/icons/website.svg')}}';">{{ $link_group['title'] }}</a></div>
             @break
         @elseif($link->custom_css != "")
          <div style="--delay: {{ $initial++ }}s" class="button-entrance"><a id="{{ $link->id }}" class="button button-custom_website button-click button-hover icon-hover" style="{{ $link->custom_css }}" rel="noopener noreferrer nofollow noindex" href="{{ $link_group['link'] }}" @if((UserData::getData($userinfo->id, 'links-new-tab') != false))target="_blank"@endif ><img alt="{{ $link->name }}" class="icon hvr-icon" src="@if(file_exists(base_path("assets/favicon/icons/").localIcon($link->id))){{url('assets/favicon/icons/'.localIcon($link->id))}}@else{{getFavIcon($link->id)}}@endif" onerror="this.onerror=null; this.src='{{asset('assets/linkstack/icons/website.svg')}}';">{{ $link_group['title'] }}</a></div>
           @break
         @endif
      @endswitch
    @endforeach
  
  </div>
@endif
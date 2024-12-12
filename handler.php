<?php
use App\Models\User;

/**
 * Handles the logic for "link" link type.
 * 
 * @param \Illuminate\Http\Request $request The incoming request.
 * @param mixed $linkType The link type information.
 * @return array The prepared link data.
 */
function handleLinkType($request, $linkType) {

    $rules = [
        'usernames' => 'sometimes|nullable|array',
        'usernames.*' => 'sometimes|nullable|string'
    ];

    $usernames = $request->usernames ?? [];
    $users = User::whereIn('littlelink_name', $usernames)->pluck('id')->toArray();

    // Prepare the link data
    $linkData = [
        'title' => $request->group_title ?? 'Protected Link Group',
        'link' => null,
        'link_groups' => $request->links,
        'userids' => $users,
        'button_id' => "1",
        'custom_icon' => 'fa-lock',
    ];

    return ['rules' => $rules, 'linkData' => $linkData];
}
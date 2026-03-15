<?php

use App\Models\MasterBackend\SettingUser\Position;



if (!function_exists('getChildPositions')) {

    function getChildPositions($parentId)
    {
        $all = collect();

        $children = Position::where('parent_id', $parentId)->get();

        foreach ($children as $child) {

            $all->push($child->id);

            $all = $all->merge(getChildPositions($child->id));
        }

        return $all->unique();
    }
}

if (!function_exists('hasRole')) {
    function hasRole($roles)
    {
        return count(array_intersect(session('roles', []), (array)$roles)) > 0;
    }
}

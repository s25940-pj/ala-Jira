<?php

function getPriorityName(int $priorityValue): string
{
    return match ($priorityValue) {
        0 => "Low",
        1 => "Medium",
        2 => "High",
        default => "None",
    };
}

function getDepartmentName(int $departmentValue): string
{
    return match ($departmentValue) {
        0 => "Development",
        1 => "Marketing",
        2 => "Finance",
        3 => "Basic Deparment",
        default => "None",
    };
}

function getRoleName(int $roleValue): string
{
    return match ($roleValue) {
        0 => "Admin",
        1 => "Head of Department",
        2 => "User",
        default => "None",
    };
}
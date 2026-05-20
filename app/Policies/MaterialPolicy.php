<?php

namespace App\Policies;

use App\Models\Material;
use App\Models\User;

class MaterialPolicy
{
    /**
     * Determine if the user can view the material.
     */
    public function view(User $user, Material $material): bool
    {
        // Only members of the same class can view
        if ($user->role === 'member') {
            return $user->class_id === $material->class_id;
        }

        // Mentors can view materials from their own class
        if ($user->role === 'mentor') {
            return $user->class_id === $material->class_id;
        }

        return false;
    }

    /**
     * Determine if the user can create a material.
     */
    public function create(User $user): bool
    {
        return $user->role === 'mentor';
    }

    /**
     * Determine if the user can update the material.
     */
    public function update(User $user, Material $material): bool
    {
        // Only the mentor from the same class can update
        return $user->role === 'mentor' && $user->class_id === $material->class_id;
    }

    /**
     * Determine if the user can delete the material.
     */
    public function delete(User $user, Material $material): bool
    {
        // Only the mentor from the same class can delete
        return $user->role === 'mentor' && $user->class_id === $material->class_id;
    }

    /**
     * Determine if the user can download the material.
     */
    public function download(User $user, Material $material): bool
    {
        // Members and mentors from the same class can download
        return $user->class_id === $material->class_id;
    }
}

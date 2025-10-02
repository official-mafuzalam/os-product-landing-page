<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can block another user
     */
    public function block(User $currentUser, User $targetUser): Response
    {
        return $currentUser->hasAnyRole(['super_admin', 'admin'])
            ? $this->authorizeBlockAction($currentUser, $targetUser)
            : Response::deny('You do not have permission to block users.');
    }

    /**
     * Determine if the user can unblock another user
     */
    public function unblock(User $currentUser, User $targetUser): Response
    {
        return $this->block($currentUser, $targetUser);
    }

    /**
     * Additional policy methods
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin']);
    }

    public function view(User $currentUser, User $targetUser): bool
    {
        return $currentUser->hasRole('super_admin') ||
            $currentUser->id === $targetUser->id ||
            ($currentUser->hasRole('admin') && !$targetUser->hasRole('super_admin'));
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    public function update(User $currentUser, User $targetUser): bool
    {
        return $currentUser->hasRole('super_admin') ||
            ($currentUser->hasRole('admin') && !$targetUser->hasRole('super_admin')) ||
            $currentUser->id === $targetUser->id;
    }

    public function delete(User $currentUser, User $targetUser): bool
    {
        return $currentUser->hasRole('super_admin') &&
            $currentUser->id !== $targetUser->id &&
            !$targetUser->hasRole('super_admin');
    }

    /**
     * Helper method for block/unblock authorization
     */
    protected function authorizeBlockAction(User $currentUser, User $targetUser): Response
    {
        if ($currentUser->id === $targetUser->id) {
            return Response::deny('You cannot block your own account.');
        }

        if ($targetUser->hasRole('super_admin')) {
            return Response::deny('Super admin accounts cannot be blocked.');
        }

        return Response::allow();
    }
}
<?php

namespace App\Policies;

use App\Models\AdoptionRequest;
use App\Models\User;

class AdoptionRequestPolicy
{
    // REQUIREMENT: Admin can do EVERYTHING
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    // REQUIREMENT: User A can only view their own request
    public function view(User $user, AdoptionRequest $adoptionRequest)
    {
        return $user->id === $adoptionRequest->user_id;
    }

    // REQUIREMENT: User A can only delete their own request
    public function delete(User $user, AdoptionRequest $adoptionRequest)
    {
        return $user->id === $adoptionRequest->user_id;
    }

    // REQUIREMENT: Only admins can update the status (handled by 'before' method)
    public function update(User $user, AdoptionRequest $adoptionRequest)
    {
        return false;
    }
}

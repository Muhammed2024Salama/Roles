<?php

namespace App\Models\Concerns;

trait Blockable
{
    /**
     * Block the user.
     *
     * @return bool
     */
    public function block(): bool
    {
        $this->blocked = true;
        return $this->save();
    }

    /**
     * Unblock the user.
     *
     * @return bool
     */
    public function unblock(): bool
    {
        $this->blocked = false;
        return $this->save();
    }

    /**
     * Check if the user is blocked.
     *
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->blocked;
    }
}

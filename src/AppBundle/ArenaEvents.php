<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle;

/**
 * Class ArenaEvents.
 */
class ArenaEvents
{
    /**
     * User.
     */
    const CREATED_USER = 'arena.user.created';
    const UPDATED_USER = 'arena.user.updated';
    const DELETED_USER = 'arena.user.deleted';

    /**
     * Sport.
     */
    const CREATED_SPORT = 'arena.sport.created';
    const UPDATED_SPORT = 'arena.sport.updated';
    const DELETED_SPORT = 'arena.sport.deleted';

    /**
     * Activity.
     */
    const CREATED_ACTIVITY = 'arena.activity.created';
    const UPDATED_ACTIVITY = 'arena.activity.updated';
    const DELETED_ACTIVITY = 'arena.activity.deleted';

    /**
     * Application.
     */
    const CREATED_APPLICATION = 'arena.application.created';
    const ACCEPTED_APPLICATION = 'arena.application.accepted';
    const REFUSED_APPLICATION = 'arena.application.refused';

    /**
     * Invitation.
     */
    const CREATED_INVITATION = 'arena.invitation.created';
    const ACCEPTED_INVITATION = 'arena.invitation.accepted';
    const REFUSED_INVITATION = 'arena.invitation.refused';

    /**
     * Registration.
     */
    const DELETED_REGISTRATION = 'arena.registration.deleted';

    /**
     * Notification.
     */
    const CREATED_NOTIFICATION = 'arena.notification.created';

    /**
     * Communication.
     */
    const CREATED_COMMUNICATION = 'arena.communication.created';
}
